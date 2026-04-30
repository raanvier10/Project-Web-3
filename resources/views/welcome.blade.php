@extends('layouts.app')

@section('content')
  @include('partials.navbar')
  @include('partials.hero')
  @include('partials.packages')
  @include('partials.placement')
  @include('partials.facilities')
  @include('partials.testimonials')
  @include('partials.community')
  @include('partials.footer')
@endsection

@section('scripts')
<script>
// ========== LANGUAGE SYSTEM ==========
const translations = {
  en: {
    nav_packages: "Packages", nav_placement: "Placement Test", nav_facilities: "Facilities",
    nav_testimonials: "Testimonials", nav_community: "Community", nav_contact: "Contact",
    nav_login: "Login",
    lang_switch: "Ganti ke Indonesia",
    hero_badge: "English Course Exclusively for Akhwat",
    hero_title1: "Pioneer of", hero_title2: "English Courses", hero_title3: "For Muslim Families",
    hero_desc: "English for Akhwat is an English course exclusively for Muslimah with a comfortable, safe, and supportive learning environment. Learning is easier, more guided, and applicable in daily life.",
    hero_cta1: "View Packages", hero_cta2: "Placement Test",
    hero_stat1: "Alumni", hero_stat2: "Rating", hero_stat3: "Programs",
    hero_float1: "Certified", hero_float2: "Recognized Institution",
    pkg_badge: "Package Options", pkg_title: "Choose the Right Package for You",
    pkg_subtitle: "We offer various packages that can be tailored to your needs and skill level.",
    pkg1_name: "Basic to Advanced English", pkg1_desc: "A structured program from basic to advanced levels, covering grammar, vocabulary, and active communication.",
    pkg2_name: "Speaking Confidence Class", pkg2_desc: "Focuses on real-life conversation to help Muslimahs speak more fluently and confidently.",
    pkg3_name: "English for Muslimah Moms", pkg3_desc: "A special program for mothers and mothers-to-be with practical materials for parenting and daily activities.",
    pkg4_name: "English for Students", pkg4_desc: "Supports academic needs: grammar, conversation, and exam preparation (Middle School to University).",
    pkg5_name: "English for Kids", pkg5_desc: "A fun program for early childhood with interactive methods so children love English.",
    pkg6_name: "English for Specific Purposes", pkg6_desc: "Materials tailored to specific needs such as Business, Academic, and Work Communication.",
    pkg_period: "/month", pkg_cta: "Register Now", pkg_popular: "Most Popular",
    pt_badge: "Placement Test", pt_title: "Discover Your English Level",
    pt_desc: "Take our free placement test to find out your current English proficiency. Results will help us place you in the right class.",
    pt_f1: "Easy-to-access online test", pt_f2: "Instant results", pt_f3: "Suitable class recommendation", pt_f4: "100% free of charge",
    pt_cta: "Start Placement Test", pt_card_title: "Placement Test",
    pt_c1: "Grammar", pt_c2: "Vocabulary", pt_c3: "Reading", pt_c4: "Listening",
    fac_badge: "Learning Environment", fac_title: "Facilities & Learning Environment",
    fac_subtitle: "We provide a comfortable learning environment that supports your English learning process.",
    fac1_title: "Exclusive Classes for Muslimah", fac1_desc: "An exclusive and comfortable learning environment for akhwat.",
    fac2_title: "Online & Flexible", fac2_desc: "Learn from anywhere, anytime according to your schedule.",
    fac3_title: "Structured Modules", fac3_desc: "A well-organized curriculum for optimal learning results.",
    fac4_title: "Experienced Tutors", fac4_desc: "Guided by professional and certified instructors.",
    fac5_title: "Supportive Learning Atmosphere", fac5_desc: "A supportive and motivating community.",
    testi_badge: "Testimonials", testi_title: "What They Say About EFA",
    testi_subtitle: "Hear inspiring stories from EFA alumni who have benefited from our programs.",
    testi1_text: "\"Alhamdulillah, Nasya is very happy to join this class. The learning system is enjoyable and not boring because it is mixed with games, so the material doesn’t feel monotonous. The teacher is also kind, friendly, and easy to understand. If possible, please don’t replace her, because Nasya is already comfortable with Miss Rahmi.\"",
    testi1_role: "Bandung",
    testi2_text: "\"I really like Ms. Igna’s teaching method—gentle yet clear, and the material is well delivered to the participants. I’ve become better at writing mini essays in English. There are still things I need to improve, but so far it has been enjoyable learning English at English for Akhwat, even though sometimes my brain has to work hard to understand.\"",
    testi2_role: "Purwakarta",
    testi3_text: "\"After almost one year of studying at English For Akhwat, I started again from the basics because I hadn’t used English for a long time and had forgotten many vocabularies. The material is delivered fully in English, which helps me get used to understanding it. The explanations are also easy to follow. I hope to become more confident in speaking English.\"",
    testi3_role: "Pekanbaru",
    comm_badge: "EFA Community", comm_title: "Join the EFA Community",
    comm_desc: "Be part of an akhwat community that supports each other in learning English. Get study tips, event info, and networking with fellow learners.",
    comm_f1_title: "Daily Discussion", comm_f1_desc: "Practice English daily in the WhatsApp group",
    comm_f2_title: "Regular Events", comm_f2_desc: "Webinars, English Camp, and other exciting activities",
    comm_f3_title: "Networking", comm_f3_desc: "Build connections with akhwat from various backgrounds",
    comm_cta: "Join WhatsApp Group", comm_card_title: "EFA Community", comm_card_sub: "WhatsApp Group",
    comm_members: "Members", comm_active: "Daily Active",
    contact_badge: "Contact Us", contact_title: "Information & Contact",
    contact_subtitle: "Have questions? Don't hesitate to reach out through our channels.",
    contact_loc_title: "Address", contact_loc_desc: "Jl. Pendidikan No. 45, South Jakarta, Indonesia 12345",
    contact_phone_title: "Phone",
    footer_desc: "English For Akhwat - The best English course program designed exclusively for akhwat with enjoyable learning methods.",
    footer_links: "Quick Links", footer_programs: "Programs",
    footer_rights: "All rights reserved.", footer_privacy: "Privacy Policy", footer_terms: "Terms & Conditions"
  },
  id: {
    nav_packages: "Paket Kursus", nav_placement: "Placement Test", nav_facilities: "Fasilitas",
    nav_testimonials: "Testimoni", nav_community: "Komunitas", nav_contact: "Kontak",
    nav_login: "Masuk",
    lang_switch: "Switch to English",
    hero_badge: "Kursus Bahasa Inggris Khusus Akhwat",
    hero_title1: "Pelopor Kursus", hero_title2: "Bahasa Inggris", hero_title3: "Keluarga Muslim",
    hero_desc: "English for Akhwat adalah kursus bahasa Inggris khusus Muslimah dengan suasana belajar yang nyaman, aman, dan suportif. Belajar lebih mudah, terarah, dan aplikatif dalam kehidupan sehari-hari.",
    hero_cta1: "Lihat Paket", hero_cta2: "Placement Test",
    hero_stat1: "Alumni", hero_stat2: "Rating", hero_stat3: "Program",
    hero_float1: "Bersertifikat", hero_float2: "Diakui Lembaga",
    pkg_badge: "Pilihan Paket", pkg_title: "Pilih Paket yang Tepat Untukmu",
    pkg_subtitle: "Kami menyediakan berbagai pilihan paket yang bisa disesuaikan dengan kebutuhan dan level kemampuanmu.",
    pkg1_name: "Basic to Advanced English", pkg1_desc: "Program terstruktur dari level dasar hingga mahir, mencakup grammar, vocabulary, dan komunikasi aktif.",
    pkg2_name: "Speaking Confidence Class", pkg2_desc: "Fokus pada real-life conversation untuk membantu Muslimah berbicara lebih lancar dan percaya diri.",
    pkg3_name: "English for Muslimah Moms", pkg3_desc: "Program khusus ibu & calon ibu dengan materi praktis untuk parenting dan aktivitas harian.",
    pkg4_name: "English for Students", pkg4_desc: "Mendukung kebutuhan akademik: grammar, conversation, hingga persiapan ujian (SMP-Mahasiswa).",
    pkg5_name: "English for Kids", pkg5_desc: "Program menyenangkan untuk anak usia dini dengan metode interaktif agar anak mencintai bahasa Inggris.",
    pkg6_name: "English for Specific Purposes", pkg6_desc: "Materi yang disesuaikan untuk kebutuhan spesifik seperti Business, Academic, hingga Work Communication.",
    pkg_period: "/bulan", pkg_cta: "Daftar Sekarang", pkg_popular: "Terpopuler",
    pt_badge: "Placement Test", pt_title: "Ketahui Level Bahasa Inggrismu",
    pt_desc: "Ikuti placement test gratis untuk mengetahui level kemampuan bahasa Inggrismu saat ini. Hasil tes akan membantu kami menempatkanmu di kelas yang sesuai.",
    pt_f1: "Tes online yang mudah diakses", pt_f2: "Hasil langsung setelah mengerjakan", pt_f3: "Rekomendasi kelas yang sesuai", pt_f4: "100% gratis tanpa biaya",
    pt_cta: "Mulai Placement Test", pt_card_title: "Placement Test",
    pt_c1: "Grammar", pt_c2: "Vocabulary", pt_c3: "Reading", pt_c4: "Listening",
    fac_badge: "Lingkungan Belajar", fac_title: "Fasilitas & Lingkungan Belajar",
    fac_subtitle: "Kami menyediakan lingkungan belajar yang nyaman dan mendukung proses pembelajaran bahasa Inggrismu.",
    fac1_title: "Kelas Khusus Muslimah", fac1_desc: "Lingkungan belajar eksklusif dan nyaman untuk para akhwat.",
    fac2_title: "Online & Fleksibel", fac2_desc: "Belajar dari mana saja, kapan saja sesuai jadwalmu.",
    fac3_title: "Modul Terstruktur", fac3_desc: "Kurikulum tersusun rapi untuk hasil belajar yang optimal.",
    fac4_title: "Tutor Berpengalaman", fac4_desc: "Dibimbing oleh pengajar profesional dan bersertifikat.",
    fac5_title: "Suasana Belajar Suportif", fac5_desc: "Komunitas yang saling mendukung dan memotivasi.",
    testi_badge: "Testimoni", testi_title: "Kata Mereka Tentang EFA",
    testi_subtitle: "Dengarkan cerita inspiratif dari alumni EFA yang telah merasakan manfaat program kami.",
    testi1_text: "\"Alhamdulillah Nasya sangat senang ikut kelas ini. Sistem belajarnya enak dan tidak membosankankarena diselingi game, jadi materi tidak terasa monoton. Pengajarnya juga baik, ramah, dan mudah dipahami. Kalau bisa, jangan diganti ya kak, karena Nasya sudah cocok dengan Miss Rahmi.\"",
    testi1_role: "Bandung",
    testi2_text: "\"Suka sekali dengan metode penjelasan Ms. Igna, lembut namun tetap lugas dan isi materi tersampaikan dengan baik kepada peserta. Aku jadi lebih mengasah membuat mini essay dalam bahasa Inggris. Masih ada yang harus di perbaiki tapi sejauh ini menyenangkan rasanya belajar bahasa Inggris di English for Akhwat meskipun kadang otak ini harus berpikiran keras untuk bisa memahami.\"",
    testi2_role: "Purwakarta",
    testi3_text: "\"Hampir 1 tahun belajar di English For Akhwat, saya mulai lagi dari dasar karena sudah lama tidak menggunakan bahasa Inggris dan banyak kosakata yang lupa. Materi disampaikan full English sehingga membantu saya terbiasa memahami. Penjelasannya juga mudah dipahami. Saya berharap bisa lebih percaya diri saat berbicara bahasa Inggris.\"",
    testi3_role: "Pekanbaru",
    comm_badge: "Komunitas EFA", comm_title: "Bergabung dengan Komunitas EFA",
    comm_desc: "Jadilah bagian dari komunitas akhwat yang saling mendukung dalam belajar bahasa Inggris. Dapatkan tips belajar, info event, dan networking dengan sesama learners.",
    comm_f1_title: "Diskusi Harian", comm_f1_desc: "Praktik bahasa Inggris setiap hari di grup WhatsApp",
    comm_f2_title: "Event Rutin", comm_f2_desc: "Webinar, English Camp, dan kegiatan menarik lainnya",
    comm_f3_title: "Networking", comm_f3_desc: "Bangun koneksi dengan akhwat dari berbagai latar belakang",
    comm_cta: "Gabung Grup WhatsApp", comm_card_title: "EFA Community", comm_card_sub: "WhatsApp Group",
    comm_members: "Anggota", comm_active: "Aktif Harian",
    contact_badge: "Hubungi Kami", contact_title: "Informasi & Kontak",
    contact_subtitle: "Punya pertanyaan? Jangan ragu untuk menghubungi kami melalui berbagai channel berikut.",
    contact_loc_title: "Alamat", contact_loc_desc: "Jl. Pendidikan No. 45, Jakarta Selatan, Indonesia 12345",
    contact_phone_title: "Telepon",
    footer_desc: "English For Akhwat - Program kursus bahasa Inggris terbaik yang dirancang khusus untuk akhwat dengan metode pembelajaran yang menyenangkan.",
    footer_links: "Tautan Cepat", footer_programs: "Program",
    footer_rights: "All rights reserved.", footer_privacy: "Kebijakan Privasi", footer_terms: "Syarat & Ketentuan"
  }
};

let currentLang = localStorage.getItem('efa_lang') || 'id';

function applyLang() {
  document.getElementById('langLabel').textContent = currentLang === 'id' ? 'EN' : 'ID';
  document.getElementById('htmlRoot').lang = currentLang;
  document.querySelectorAll('[data-i18n]').forEach(el => {
    const key = el.getAttribute('data-i18n');
    if (translations[currentLang][key]) {
      el.textContent = translations[currentLang][key];
    }
  });
}

function toggleLang() {
  currentLang = currentLang === 'id' ? 'en' : 'id';
  localStorage.setItem('efa_lang', currentLang);
  applyLang();
}

// Apply saved language on page load
applyLang();

// ========== SIDEBAR ==========
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebarOverlay');
  const isOpen = !sidebar.classList.contains('translate-x-full');
  if (isOpen) {
    sidebar.classList.add('translate-x-full');
    overlay.classList.add('opacity-0');
    setTimeout(() => overlay.classList.add('hidden'), 300);
    document.body.style.overflow = '';
  } else {
    overlay.classList.remove('hidden');
    setTimeout(() => overlay.classList.remove('opacity-0'), 10);
    sidebar.classList.remove('translate-x-full');
    document.body.style.overflow = 'hidden';
  }
}

// ========== NAVBAR SCROLL ==========
window.addEventListener('scroll', () => {
  const navbar = document.getElementById('navbar');
  if (window.scrollY > 50) {
    navbar.classList.add('bg-white/95', 'backdrop-blur-lg', 'shadow-lg');
    navbar.classList.remove('bg-white/0');
  } else {
    navbar.classList.remove('bg-white/95', 'backdrop-blur-lg', 'shadow-lg');
    navbar.classList.add('bg-white/0');
  }
});

// ========== SCROLL REVEAL ==========
const revealElements = document.querySelectorAll('.reveal');
const revealOnScroll = () => {
  revealElements.forEach(el => {
    const top = el.getBoundingClientRect().top;
    if (top < window.innerHeight - 100) {
      el.classList.add('active');
    }
  });
};
window.addEventListener('scroll', revealOnScroll);
window.addEventListener('load', revealOnScroll);
</script>
@endsection
