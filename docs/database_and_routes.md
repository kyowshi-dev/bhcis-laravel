# Database Tables & Columns

## sessions
- `id`: string, primary key
- `user_id`: foreignId, nullable, indexed
- `ip_address`: string(45), nullable
- `user_agent`: text, nullable
- `payload`: longText
- `last_activity`: integer, indexed

Source: [database/migrations/2026_02_17_055654_create_sessions_table.php](database/migrations/2026_02_17_055654_create_sessions_table.php#L1-L44)

## consultations (migration update)
- `complaint_text`: text, nullable (added via migration)

Note: the migration adds `complaint_text` after `chief_complaint_id`.
Source: [database/migrations/2026_02_15_122320_fix_consultation_columns.php](database/migrations/2026_02_15_122320_fix_consultation_columns.php#L1-L44)

## prescriptions (migration update)
- `frequency`: string, nullable (changed to nullable)

Source: [database/migrations/2026_02_15_122320_fix_consultation_columns.php](database/migrations/2026_02_15_122320_fix_consultation_columns.php#L1-L44)

# Routes (routes/web.php)

-- PUBLIC ROUTES --
- `GET /` -> `AuthController@showLogin` (name: `login`)
- `POST /login` -> `AuthController@processLogin` (name: `login.process`)
- `POST /logout` -> `AuthController@logout` (name: `logout`)

-- PROTECTED ROUTES (middleware `auth`) --
- `GET /dashboard` -> `DashboardController@index` (name: `dashboard`)
- `GET /search/patients` -> `SearchController@patients` (name: `search.patients`)
- `GET /search/diagnoses` -> `SearchController@diagnoses` (name: `search.diagnoses`)
- `GET /search/medicines` -> `SearchController@medicines` (name: `search.medicines`)
- `GET /patients` -> `PatientController@index` (name: `patients.index`)
- `GET /patients/create` -> `PatientController@create` (name: `patients.create`)
- `POST /patients` -> `PatientController@store` (name: `patients.store`)
- `GET /patients/{id}` -> `PatientController@show` (name: `patients.show`)
- `GET /patients/{id}/consultations/create` -> `ConsultationController@create` (name: `consultations.create`)
- `POST /patients/{id}/consultations` -> `ConsultationController@store` (name: `consultations.store`)
- `GET /consultations/{id}` -> `ConsultationController@show` (name: `consultations.show`)
- `POST /consultations/{id}/diagnosis` -> `ConsultationController@addDiagnosis` (name: `consultations.diagnosis`)
- `POST /consultations/{id}/prescription` -> `ConsultationController@addPrescription` (name: `consultations.prescription`)

Source: [routes/web.php](routes/web.php#L1-L56)
