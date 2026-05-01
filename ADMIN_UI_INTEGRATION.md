# Admin UI Integration Notes

This file documents expected routes, data shapes, and backend tips to integrate the newly added admin UI views and `resources/js/admin.js`.

## Routes (suggested)
- Dashboard
  - `GET /admin` -> route name: `admin.dashboard`

- Course Packages (table `course_packages`)
  - `GET /admin/course-packages` -> `admin.packages.index`
  - `POST /admin/course-packages` -> `admin.packages.store` (form data)
  - `PUT /admin/course-packages/{id}` -> `admin.packages.update`
  - `POST /admin/course-packages/{id}/toggle` -> `admin.packages.toggle` (toggle active)
  - `DELETE /admin/course-packages/{id}` (or `POST` with `_method=DELETE`) -> `admin.packages.destroy`

- Payments (table `payments`)
  - `GET /admin/payments` -> `admin.payments.index`
  - `POST /admin/payments/{id}/accept` -> `admin.payments.accept` (accept payment; activate registration)
  - `POST /admin/payments/{id}/reject` -> `admin.payments.reject` (body: `reason`)

- Registrations (table `registrations`)
  - `GET /admin/registrations` -> `admin.registrations.index`

- Reports
  - `GET /admin/reports` -> `admin.reports.index`
  - `GET /admin/reports/export` -> `admin.reports.export` (query params: `format=pdf|xlsx`, `from`, `to`, `package_id`)
  - `GET /admin/reports/print` -> `admin.reports.print` (same query params; returns printable HTML)

## Data shape expectations (JSON used by admin.js)
- `payments` objects used in the view should include:
  - `id`, `invoice_no`, `amount`, `proof_url` (absolute or relative URL to image), optional `payer_name`
  - `registration` relation containing `name` and nested `course_package` (`title`)

- `registrations` objects should include `id`, `name`, `email`, `institution`, `payment_status`, and `course_package` relation

- `course_packages` should include `id`, `title`, `price`, `category`, `description`, `is_active`

## Backend responses
- AJAX endpoints used by `admin.js` expect JSON responses on success/failure. Return HTTP 2xx on success and appropriate messages in the JSON payload.

Example success response:
```
{ "success": true, "message": "Updated" }
```

Example error response (non-2xx):
```
{ "error": true, "message": "Reason" }
```

## CSRF and Vite
- `admin.js` reads the CSRF token from `<meta name="csrf-token">` which is available in `resources/views/layouts/app.blade.php`.
- `admin.layout` already includes `@vite('resources/js/admin.js')` in the `@section('scripts')` so Vite will bundle the admin script.

## Integration tips
- Implement controller methods to return the collections used in the views (`$packages`, `$payments`, `$registrations`, `$counts`, etc.).
- For toggles (`/toggle`) and accept/reject endpoints, accept `POST` and return JSON. For delete, accept standard Laravel resource delete (form `_method=DELETE`).
- Ensure `payments` include a public URL for the uploaded proof image (`proof_url`).

## Next steps (suggested)
- Create controllers: `Admin\\PackageController`, `Admin\\PaymentController`, `Admin\\RegistrationController`, `Admin\\ReportController`.
- Register routes in `routes/web.php` inside an `admin` group with `middleware('auth','is_admin')` as appropriate.
- Wire controllers to use Eloquent relations: `Registration->course_package`, `Payment->registration`.
