/* Admin UI helpers: modals, AJAX placeholders, actions (Accept/Reject/Toggle/Delete), report export helpers */
(function(){
  const meta = document.querySelector('meta[name="csrf-token"]');
  const csrf = meta ? meta.getAttribute('content') : '';

  function openModal(id){
    const m = document.getElementById(id); if(!m) return; m.classList.remove('hidden'); document.body.classList.add('overflow-hidden');
  }
  function closeModal(id){
    const m = document.getElementById(id); if(!m) return; m.classList.add('hidden'); document.body.classList.remove('overflow-hidden');
  }

  document.addEventListener('click', (e)=>{
    const openBtn = e.target.closest('[data-modal-open]');
    if(openBtn){
      const id = openBtn.getAttribute('data-modal-open');
      const paymentData = openBtn.getAttribute('data-payment');
      const regData = openBtn.getAttribute('data-registration');
      if(paymentData){ try{ populatePaymentModal(JSON.parse(paymentData)); }catch(err){} }
      if(regData){ try{ populateRegistrationModal(JSON.parse(regData)); }catch(err){} }
      openModal(id); return;
    }

    const closeBtn = e.target.closest('[data-modal-close]');
    if(closeBtn){ const id = closeBtn.getAttribute('data-modal-close'); closeModal(id); return; }

    const act = e.target.closest('[data-action]');
    if(act){
      const action = act.getAttribute('data-action');
      if(action === 'toggle-active'){
        const url = act.getAttribute('data-url'); toggleActive(url, act); return;
      }
      if(action === 'delete'){
        const url = act.getAttribute('data-url'); if(confirm('Hapus data ini? Aksi ini tidak dapat dibatalkan.')){ sendDelete(url).then(()=> location.reload()); } return;
      }
      if(action === 'accept-payment'){
        const url = act.getAttribute('data-url'); if(confirm('Terima pembayaran ini? Ini akan mengubah status pendaftaran menjadi aktif.')){ postJSON(url,{}).then(()=>{ showAlert('success','Pembayaran diterima'); setTimeout(()=>location.reload(),700); }).catch(()=>showAlert('error','Gagal')) } return;
      }
      if(action === 'reject-payment'){
        const url = act.getAttribute('data-url'); const modal = document.getElementById('paymentDetailModal'); if(modal){ modal.querySelector('#pd_reject_area').classList.remove('hidden'); modal.dataset.rejectUrl = url; openModal('paymentDetailModal'); } return;
      }
    }

    const exportBtn = e.target.closest('#btnExportPdf, #btnExportExcel, #btnPrint');
    if(exportBtn){
      const id = exportBtn.id; const form = document.getElementById('reportFilters'); const params = new URLSearchParams(new FormData(form)).toString();
      if(id === 'btnExportPdf') window.open('/admin/reports/export?format=pdf&'+params,'_blank');
      else if(id === 'btnExportExcel') window.open('/admin/reports/export?format=xlsx&'+params,'_blank');
      else window.open('/admin/reports/print?'+params,'_blank');
    }
  });

  function populatePaymentModal(p){
    const modal = document.getElementById('paymentDetailModal'); if(!modal) return;
    modal.querySelector('#pd_invoice_no').textContent = p.invoice_no || '-';
    modal.querySelector('#pd_name').textContent = (p.registration && p.registration.name) || p.payer_name || '-';
    modal.querySelector('#pd_package').textContent = (p.registration && p.registration.course_package && p.registration.course_package.title) || '-';
    modal.querySelector('#pd_amount').textContent = p.amount ? ('Rp ' + numberWithCommas(p.amount)) : '-';
    const img = modal.querySelector('#pd_proof_image'); img.src = p.proof_url || '/images/placeholder-image.png';
    const acceptBtn = modal.querySelector('#pd_accept_btn'); const rejectBtn = modal.querySelector('#pd_reject_btn');
    acceptBtn.onclick = ()=>{ if(!p.id) return showAlert('error','Tidak ada data pembayaran'); if(confirm('Terima pembayaran ini?')) postJSON('/admin/payments/'+p.id+'/accept',{}).then(()=>{ showAlert('success','Pembayaran diterima'); closeModal('paymentDetailModal'); setTimeout(()=>location.reload(),500); }).catch(()=>showAlert('error','Gagal')); };
    rejectBtn.onclick = ()=>{ modal.querySelector('#pd_reject_area').classList.toggle('hidden'); modal.dataset.rejectUrl = '/admin/payments/'+p.id+'/reject'; };
    modal.dataset.paymentId = p.id || '';
  }

  function populateRegistrationModal(r){
    const modal = document.getElementById('registrationDetailModal'); if(!modal) return;
    modal.querySelector('#rd_name').textContent = r.name || '-';
    modal.querySelector('#rd_email').textContent = r.email || '-';
    modal.querySelector('#rd_institution').textContent = r.institution || '-';
    modal.querySelector('#rd_package').textContent = (r.course_package && r.course_package.title) || '-';
    modal.querySelector('#rd_payment_status').textContent = (r.payment_status || '-');
  }

  document.addEventListener('submit', (e)=>{
    const form = e.target;
    if(form.getAttribute('data-ajax') === 'true'){
      e.preventDefault(); const action = form.action || window.location.href; const method = (form.querySelector('[name=_method]')||{value:'POST'}).value || form.method || 'POST'; const fd = new FormData(form);
      postForm(action, fd, method).then(()=>{ showAlert('success','Berhasil'); location.reload(); }).catch(()=> showAlert('error','Terjadi kesalahan'));
    }
    if(form.id === 'pd_reject_form'){
      e.preventDefault(); const modal = document.getElementById('paymentDetailModal'); const url = modal.dataset.rejectUrl; const data = new FormData(form); postForm(url, data, 'POST').then(()=>{ showAlert('success','Pembayaran ditolak'); closeModal('paymentDetailModal'); setTimeout(()=>location.reload(),600); }).catch(()=> showAlert('error','Gagal mengirim alasan'));
    }
  });

  async function postJSON(url, bodyObj){
    const res = await fetch(url, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrf, 'Accept':'application/json','Content-Type':'application/json' }, body: JSON.stringify(bodyObj) }); if(!res.ok) throw new Error('Request failed'); return res.json();
  }

  async function postForm(url, formData, method='POST'){
    const opts = { method: (method||'POST').toUpperCase() === 'GET' ? 'GET' : 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrf, 'Accept':'application/json' } };
    if(opts.method !== 'GET') opts.body = formData; const res = await fetch(url, opts); if(!res.ok) throw new Error('Request failed'); return res.json().catch(()=>{});
  }

  async function sendDelete(url){ const form = new FormData(); form.append('_method','DELETE'); const res = await fetch(url, { method: 'POST', credentials: 'same-origin', headers: { 'X-CSRF-TOKEN': csrf }, body: form }); if(!res.ok) throw new Error('Delete failed'); return res.json().catch(()=>{}); }

  async function toggleActive(url, btn){ try{ const res = await postJSON(url,{}); showAlert('success', res.message || 'Status diperbarui'); setTimeout(()=> location.reload(),700); }catch(err){ showAlert('error','Gagal memperbarui status'); } }

  function numberWithCommas(x){ if(!x && x!==0) return x; return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.'); }

  function showAlert(type, message){ const container = document.createElement('div'); container.className = 'fixed right-6 bottom-6 z-50 p-4 rounded-lg shadow-lg'; container.style.background = type === 'success' ? 'linear-gradient(135deg,#D1FAE5,#6EE7B7)' : 'linear-gradient(135deg,#FEE2E2,#FCA5A5)'; container.innerHTML = `<div class="font-semibold text-sm">${message}</div>`; document.body.appendChild(container); setTimeout(()=> container.remove(), 3000); }

  document.addEventListener('keydown', (e)=>{ if(e.key === 'Escape'){ document.querySelectorAll('[id$="Modal"]').forEach(m => m.classList.add('hidden')); document.body.classList.remove('overflow-hidden'); } });

})();
