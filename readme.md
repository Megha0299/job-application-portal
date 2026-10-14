# Recruitment & Job Application Portal 

A full-stack web-based recruitment portal built using PHP (CodeIgniter) and MySQL that supports multi-step candidate applications, document management, and administrative tracking.

## Features

### Candidate Portal
- **3-Step Application Process:**
  - Step 1: Basic Information & Personal Details.
  - Step 2: Academic Background & Technical Skills (hybrid checklist + custom inputs).
  - Step 3: Experience Level, Declarations, and Resume File Upload (PDF/DOC/DOCX).
- **Validation:** Client-side JavaScript and server-side PHP validation on required fields.

### Admin Dashboard (Out-of-Scope Enhancements Delivered)
- **Authentication:** Protected admin login with session verification.
- **Analytics Cards:** Real-time counters for Total Applications, Freshers, and Experienced candidates.
- **Search & Filter:** Keyword search by candidate name/email/skills and dropdown filter by experience.
- **Candidate Detail Modal:** View complete profile submissions in an overlay.
- **Document Management:** Direct download link for resumes and safe record deletion with physical file cleanup.
- **Data Portability:** One-click CSV/Excel export for HR reporting.

---

## Tech Stack
- **Frontend:** HTML5, CSS3, JavaScript, SVG Icons
- **Backend:** PHP (CodeIgniter Framework)
- **Database:** MySQL
- **Server:** Apache (XAMPP)

---

## Installation & Setup

1. **Clone / Copy Project:**
   Place the `job-portal` folder inside your Apache root directory:
   `C:/xampp/htdocs/job-portal` or `D:/PHP/htdocs/job-portal`

2. **Database Setup:**
   - Open phpMyAdmin (`http://localhost/phpmyadmin`).
   - Create a database named `job_portal`.
   - Import the database script located at `database/job_portal.sql`.

3. **Verify Configuration:**
   - Database credentials in `application/config/database.php` (default: `localhost`, user `root`, no password).
   - Base URL in `application/config/config.php` set to `http://localhost/job-portal/`.

4. **Uploads Directory:**
   Ensure `uploads/resumes/` exists and has write permissions.

---

## Access URLs
- **Candidate Application Form:** `http://localhost/job-portal/index.php/apply`
- **Admin Management Login:** `http://localhost/job-portal/index.php/admin/login`
- **Admin Dashboard:** `http://localhost/job-portal/index.php/admin/dashboard`
