<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Recruitment Portal</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        body {
            background-color: #f8fafc;
            color: #1e293b;
        }
        /* Top Navigation */
        .top-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .top-nav h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }
        .top-nav .user-info {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .btn-logout {
            background: #f1f5f9;
            color: #475569;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .btn-logout:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Container */
        .main-container {
            max-width: 1400px;
            margin: 30px auto;
            padding: 0 24px;
        }

        /* Metric Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .stat-card h3 {
            font-size: 13px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }

        /* Filter Controls */
        .controls-card {
            background: #ffffff;
            padding: 18px 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }
        .filter-form {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }
        .filter-input {
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            color: #334155;
            outline: none;
        }
        .filter-input:focus {
            border-color: #2563eb;
        }
        .search-field {
            flex: 1;
            min-width: 240px;
        }
        .btn-filter {
            background: #2563eb;
            color: #ffffff;
            padding: 9px 18px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-filter:hover {
            background: #1d4ed8;
        }
        .btn-reset {
            background: #f1f5f9;
            color: #475569;
            text-decoration: none;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
        }
        .btn-export {
            background: #0f766e;
            color: #ffffff;
            text-decoration: none;
            padding: 9px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.15s;
            margin-left: auto;
        }
        .btn-export:hover {
            background: #115e59;
        }

        /* Applications Data Table */
        .table-card {
            background: #ffffff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }
        thead th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
            padding: 12px 16px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }
        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Status Badges & Dropdown */
        .status-select-badge option {
            background-color: #ffffff !important;
            color: #1e293b !important;
            font-weight: 500;
            padding: 6px 10px;
        }

        .status-select-badge {
            padding: 5px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            outline: none;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 10px 10px;
            padding-right: 26px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        }

        .status-select-badge.badge-submitted {
            background-color: #f1f5f9;
            color: #475569;
            border-color: #cbd5e1;
        }

        .status-select-badge.badge-under-review {
            background-color: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }

        .status-select-badge.badge-shortlisted {
            background-color: #dcfce7;
            color: #166534;
            border-color: #bbf7d0;
        }

        .status-select-badge.badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            border-color: #fecaca;
        }

        /* Action Buttons */
        .action-cell {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .btn-action {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.15s;
        }
        .btn-view {
            background: #eff6ff;
            color: #1d4ed8;
        }
        .btn-view:hover {
            background: #dbeafe;
        }
        .btn-download {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            color: #334155;
        }
        .btn-download:hover {
            background: #e2e8f0;
        }
        .btn-delete {
            background: #f1f5f9;
            color: #64748b;
            padding: 7px 9px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-delete:hover {
            background: #fee2e2;
            color: #dc2626;
        }
        .btn-delete svg {
            width: 15px;
            height: 15px;
            stroke-width: 2;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(2px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .modal-card {
            background: #ffffff;
            width: 100%;
            max-width: 760px;
            max-height: 90vh;
            border-radius: 10px;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .modal-header {
            padding: 18px 24px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: #ffffff;
        }
        .modal-header h2 {
            font-size: 18px;
            color: #0f172a;
        }
        .btn-close {
            background: transparent;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #64748b;
            line-height: 1;
        }
        .modal-body {
            padding: 24px;
        }
        .modal-section {
            margin-bottom: 20px;
        }
        .modal-section h4 {
            font-size: 14px;
            text-transform: uppercase;
            color: #2563eb;
            margin-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 4px;
        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px 16px;
            font-size: 14px;
        }
        .detail-item strong {
            display: block;
            color: #64748b;
            font-size: 12px;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

    <!-- Header Navigation -->
    <header class="top-nav">
        <h1>Recruitment Management Portal</h1>
        <div class="user-info">
            <span>Welcome, <strong><?php echo htmlspecialchars($this->session->userdata('admin_username') ?? 'Admin'); ?></strong></span>
            <a href="<?php echo base_url('index.php/admin/logout'); ?>" class="btn-logout">Logout</a>
        </div>
    </header>

    <div class="main-container">

        <!-- Flash Message Alerts -->
        <?php if ($this->session->flashdata('success')): ?>
            <div style="background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
            <div style="background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 12px 16px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;">
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php endif; ?>

        <!-- Stats Overview Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Applicants</h3>
                <div class="stat-number"><?php echo !empty($total_count) ? $total_count : count($applications); ?></div>
            </div>
            <div class="stat-card">
                <h3>Freshers</h3>
                <div class="stat-number"><?php echo $fresher_count ?? 0; ?></div>
            </div>
            <div class="stat-card">
                <h3>Experienced</h3>
                <div class="stat-number"><?php echo $experienced_count ?? 0; ?></div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="controls-card">
            <form method="GET" action="<?php echo base_url('index.php/admin/dashboard'); ?>" class="filter-form">
                <input type="text" 
                       name="search" 
                       class="filter-input search-field" 
                       placeholder="Search candidate name, email, or skills..." 
                       value="<?php echo htmlspecialchars($search ?? ''); ?>">

                <select name="experience" class="filter-input">
                    <option value="">All Experience Levels</option>
                    <option value="Fresher" <?php echo (($experience ?? '') == 'Fresher') ? 'selected' : ''; ?>>Fresher</option>
                    <option value="1-2 Years" <?php echo (($experience ?? '') == '1-2 Years') ? 'selected' : ''; ?>>1-2 Years</option>
                    <option value="1-3 Years" <?php echo (($experience ?? '') == '1-3 Years') ? 'selected' : ''; ?>>1-3 Years</option>
                    <option value="3-5 Years" <?php echo (($experience ?? '') == '3-5 Years') ? 'selected' : ''; ?>>3-5 Years</option>
                    <option value="5+ Years" <?php echo (($experience ?? '') == '5+ Years') ? 'selected' : ''; ?>>5+ Years</option>
                </select>

                <button type="submit" class="btn-filter">Apply Filter</button>

                <?php if (!empty($search) || !empty($experience)): ?>
                    <a href="<?php echo base_url('index.php/admin/dashboard'); ?>" class="btn-reset">Reset</a>
                <?php endif; ?>

                <a href="<?php echo base_url('index.php/admin/export_csv'); ?>" class="btn-export">
                    Export to CSV &darr;
                </a>
            </form>
        </div>

        <!-- Applications Data Table -->
        <div class="table-card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 60px;">S.No</th>
                            <th>Candidate</th>
                            <th>Contact</th>
                            <th>Qualification</th>
                            <th>Experience</th>
                            <th>Skills</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($applications)): ?>
                            <?php 
                                $serial_no = 1;
                                foreach ($applications as $app): 
                            ?>
                                <tr>
                                    <!-- Continuous Sequential Serial Number -->
                                    <td style="font-weight: 600; color: #64748b;"><?php echo $serial_no++; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($app['full_name']); ?></strong><br>
                                        <small style="color: #64748b;">Ref #<?php echo $app['id']; ?> &bull; <?php echo date('d M Y', strtotime($app['created_at'])); ?></small>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($app['email']); ?><br>
                                        <small style="color: #64748b;"><?php echo htmlspecialchars($app['mobile_number']); ?></small>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($app['highest_qualification']); ?><br>
                                        <small style="color: #64748b;"><?php echo htmlspecialchars($app['institution_name']); ?></small>
                                    </td>
                                    <td>
                                        <?php echo htmlspecialchars($app['total_experience']); ?>
                                    </td>
                                    <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?php echo htmlspecialchars($app['technical_skills']); ?>">
                                        <?php echo htmlspecialchars($app['technical_skills']); ?>
                                    </td>
                                    <td>
                                        <?php 
                                            $current_status = !empty($app['application_status']) ? trim($app['application_status']) : 'Submitted';
                                            $badge_class = 'badge-' . strtolower(str_replace(' ', '-', $current_status));
                                        ?>
                                        <form method="POST" action="<?php echo base_url('index.php/admin/update_status/' . $app['id']); ?>" style="margin: 0;">
                                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                            <select name="status" class="status-select-badge <?php echo $badge_class; ?>" onchange="this.form.submit()">
                                                <option value="Submitted" <?php echo ($current_status === 'Submitted') ? 'selected' : ''; ?>>Submitted</option>
                                                <option value="Under Review" <?php echo ($current_status === 'Under Review') ? 'selected' : ''; ?>>Under Review</option>
                                                <option value="Shortlisted" <?php echo ($current_status === 'Shortlisted') ? 'selected' : ''; ?>>Shortlisted</option>
                                                <option value="Rejected" <?php echo ($current_status === 'Rejected') ? 'selected' : ''; ?>>Rejected</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="action-cell">
                                            <button type="button" class="btn-action btn-view" data-app="<?php echo htmlspecialchars(json_encode($app), ENT_QUOTES, 'UTF-8'); ?>" onclick="openDetails(this)">View</button>
                                            
                                            <a href="<?php echo base_url('index.php/admin/download_resume/' . $app['id']); ?>" class="btn-action btn-download">Resume &darr;</a>
                                            
                                            <a href="<?php echo base_url('index.php/admin/delete_application/' . $app['id']); ?>" 
                                               class="btn-delete" 
                                               title="Delete Application"
                                               onclick="return confirm('Are you sure you want to permanently delete this application?');">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px; color: #64748b;">
                                    No candidate applications found matching your criteria.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Applicant Detail Modal -->
    <div id="applicantModal" class="modal-overlay" onclick="closeDetails(event)">
        <div class="modal-card" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 id="m_name">Candidate Details</h2>
                <button type="button" class="btn-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="modal-section">
                    <h4>Personal Information</h4>
                    <div class="details-grid">
                        <div class="detail-item"><strong>Email:</strong> <span id="m_email"></span></div>
                        <div class="detail-item"><strong>Phone:</strong> <span id="m_phone"></span></div>
                        <div class="detail-item"><strong>DOB:</strong> <span id="m_dob"></span></div>
                        <div class="detail-item"><strong>Gender:</strong> <span id="m_gender"></span></div>
                        <div class="detail-item"><strong>Nationality:</strong> <span id="m_nationality"></span></div>
                        <div class="detail-item"><strong>Willing to Relocate:</strong> <span id="m_relocate"></span></div>
                        <div class="detail-item" style="grid-column: span 2;"><strong>Address:</strong> <span id="m_address"></span></div>
                    </div>
                </div>

                <div class="modal-section">
                    <h4>Education & Skills</h4>
                    <div class="details-grid">
                        <div class="detail-item"><strong>Highest Qualification:</strong> <span id="m_qualification"></span></div>
                        <div class="detail-item"><strong>Institution:</strong> <span id="m_institution"></span></div>
                        <div class="detail-item"><strong>Year of Graduation:</strong> <span id="m_grad_year"></span></div>
                        <div class="detail-item"><strong>CGPA / Percentage:</strong> <span id="m_cgpa"></span></div>
                        <div class="detail-item" style="grid-column: span 2;"><strong>Technical Skills:</strong> <span id="m_skills"></span></div>
                        <div class="detail-item" style="grid-column: span 2;"><strong>Certifications:</strong> <span id="m_certifications"></span></div>
                    </div>
                </div>

                <div class="modal-section">
                    <h4>Professional Experience</h4>
                    <div class="details-grid">
                        <div class="detail-item"><strong>Total Experience:</strong> <span id="m_exp"></span></div>
                        <div class="detail-item"><strong>Current Status:</strong> <span id="m_status"></span></div>
                        <div class="detail-item"><strong>Previous Organization:</strong> <span id="m_org"></span></div>
                        <div class="detail-item"><strong>Job Title:</strong> <span id="m_title"></span></div>
                        <div class="detail-item" style="grid-column: span 2;"><strong>Skills Summary:</strong> <span id="m_summary"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openDetails(button) {
            const app = JSON.parse(button.getAttribute('data-app'));
            
            document.getElementById('m_name').innerText = app.full_name + ' (Application #' + app.id + ')';
            document.getElementById('m_email').innerText = app.email || '-';
            document.getElementById('m_phone').innerText = app.mobile_number || '-';
            document.getElementById('m_dob').innerText = app.date_of_birth || '-';
            document.getElementById('m_gender').innerText = app.gender || '-';
            document.getElementById('m_nationality').innerText = app.nationality || '-';
            document.getElementById('m_relocate').innerText = app.willing_to_relocate || '-';
            document.getElementById('m_address').innerText = app.address || '-';
            
            document.getElementById('m_qualification').innerText = app.highest_qualification || '-';
            document.getElementById('m_institution').innerText = app.institution_name || '-';
            document.getElementById('m_grad_year').innerText = app.graduation_year || '-';
            document.getElementById('m_cgpa').innerText = app.cgpa_percentage || '-';
            document.getElementById('m_skills').innerText = app.technical_skills || '-';
            document.getElementById('m_certifications').innerText = app.certifications || '-';
            
            document.getElementById('m_exp').innerText = app.total_experience || '-';
            document.getElementById('m_status').innerText = app.employment_status || '-';
            document.getElementById('m_org').innerText = app.previous_organization || '-';
            document.getElementById('m_title').innerText = app.job_title || '-';
            document.getElementById('m_summary').innerText = app.skills_summary || '-';

            document.getElementById('applicantModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('applicantModal').style.display = 'none';
        }

        function closeDetails(event) {
            if (event.target.id === 'applicantModal') {
                closeModal();
            }
        }
    </script>
</body>
</html>