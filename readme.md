Recruitment & Job Application Portal

a full-stack recruitment portal built with PHP CodeIgniter and MySQL featuring a multi-step candidate application form, public tracking timeline, bot security, and an admin hiring dashboard.

## features

### 1. candidate application form
* multi-step form with basic info, academic details, and experience[cite: 5, 6].
* client-side and server-side validation on all required inputs[cite: 6].
* automatic hide and show for fresher and experienced candidates.
* live 300-character counter for skills summary.
* secure resume upload for PDF and DOC files up to 5 MB[cite: 6].
* Google reCAPTCHA v2 bot protection on step 3.

### 2. candidate status tracker
* applicants check their progress using Reference ID and registered email.
* visual progress stepper showing Application Submitted, In Review, and Shortlisted.
* smooth reloads without form resubmission warnings.

### 3. admin dashboard
* secure admin login and session management[cite: 2].
* live summary counters for total candidates, freshers, and experienced applicants[cite: 2].
* candidate search bar and experience filters[cite: 2].
* descending table order showing the newest applications at the top.
* candidate details view modal[cite: 2].
* direct resume download[cite: 2].
* status updater for submitted, under review, shortlisted, and rejected[cite: 2].
* instant CSV export for HR reporting[cite: 2].

## tech stack
* backend: PHP with CodeIgniter 3[cite: 7]
* database: MySQL[cite: 7]
* frontend: HTML5, CSS3, JavaScript[cite: 7]
* environment: Apache via XAMPP[cite: 7]

## how to run this project

1. copy the `job-portal` folder into your `htdocs` directory:
   `D:/PHP/htdocs/job-portal` or `C:/xampp/htdocs/job-portal`
2. open phpMyAdmin at `http://localhost/phpmyadmin`.
3. create a database named `job_portal`[cite: 7].
4. click import and select your `database.sql` file.
5. open `application/config/database.php` and set your username and password.
6. open `application/config/config.php` and set base URL to `http://localhost/job-portal/`.

## project URLs
* apply page: `http://localhost/job-portal/index.php/apply`[cite: 4]
* tracking page: `http://localhost/job-portal/index.php/track`
* admin dashboard: `http://localhost/job-portal/index.php/admin/dashboard`[cite: 3]
