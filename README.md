# Shortlist — Job Portal Management System (Laravel 11/12)

Three roles, one portal:

| Role | Can do |
|---|---|
| **Candidate** | Search & filter jobs, apply with resume + cover letter, track status, withdraw pending applications |
| **Employer** | Company profile, post/edit/close jobs, review applicants, download resumes, move applicants through the pipeline (pending → reviewed → shortlisted → hired/rejected) |
| **Admin** | Stats dashboard, manage users (deactivate/delete), moderate jobs (feature/close/delete), manage categories |

## Install (5 steps)

```bash
# 1. Create a fresh Laravel app
composer create-project laravel/laravel job-portal
cd job-portal

# 2. Copy this package's files over it (overwrite when asked: bootstrap/app.php, routes/web.php, DatabaseSeeder.php)
cp -R /path/to/this-package/* .

# 3. Configure DB in .env (SQLite works out of the box on Laravel 11+; for MySQL set DB_* values)

# 4. Migrate + seed demo data
php artisan migrate --seed

# 5. Run
php artisan serve
```

Open http://127.0.0.1:8000

No npm build is needed: the UI uses the Tailwind CDN script (swap to Vite + Tailwind for production).

## Demo logins (password: `password`)

- Admin — admin@example.com
- Employer — employer@example.com
- Candidate — candidate@example.com

## Structure

- `app/Models` — User, Company, Category, JobListing, Application
- `app/Http/Middleware/EnsureRole.php` — `role:admin|employer|candidate` route guard
- `app/Http/Controllers/{Admin,Employer}` — role-specific controllers
- `database/migrations` — users role columns, categories, companies, job_listings, applications
- `resources/views` — Blade UI

## Notes

- The jobs table is named `job_listings` to avoid clashing with Laravel's built-in queue `jobs` table.
- Resumes are stored on the private `local` disk (`storage/app/private/resumes`) and only downloadable by the employer who owns the job.
- Each candidate can apply once per job (DB unique constraint + check).

## Ideas for next steps

Email notifications (Mailables on apply / status change), saved jobs, candidate profiles & skills, company logos, job alerts, Laravel Policies in place of inline checks, feature tests with Pest.
