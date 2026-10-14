<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Track Application Status'; ?></title>
    <style>
        * {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        body {
            background-color: #f1f5f9;
            margin: 0;
            padding: 40px 15px;
            color: #1e293b;
        }
        .container {
            max-width: 580px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 35px 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            margin: 0 0 20px 0;
            color: #0f172a;
            font-size: 22px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }
        .form-control:focus-visible, button:focus-visible {
            outline: 3px solid #1d4ed8;
            outline-offset: 2px;
        }
        .btn-track {
            width: 100%;
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-track:hover {
            background: #1d4ed8;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .status-card {
            margin-top: 30px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .status-submitted { background: #e0f2fe; color: #0369a1; }
        .status-reviewed { background: #fef3c7; color: #92400e; }
        .status-shortlisted { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .nav-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #2563eb;
            text-decoration: none;
        }
        .nav-link:hover {
            text-decoration: underline;
        }
        /* modern timeline tracker styles */
.tracker-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 24px;
    margin-top: 25px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}

.tracker-header h3 {
    margin: 0 0 6px 0;
    font-size: 18px;
    color: #0f172a;
    font-weight: 700;
}

.tracker-meta {
    font-size: 13px;
    color: #64748b;
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}

/* progress stepper */
.stepper-track {
    display: flex;
    align-items: center;
    position: relative;
    margin: 30px 10px 40px 10px;
}

.stepper-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    flex: 1;
}

.step-node {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #ffffff;
    border: 2px solid #cbd5e1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    color: #64748b;
    transition: all 0.2s ease;
}

.stepper-step.completed .step-node {
    background: #16a34a;
    border-color: #16a34a;
    color: #ffffff;
}

.stepper-step.active .step-node {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
}

.step-label {
    position: absolute;
    top: 34px;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    white-space: nowrap;
    text-align: center;
}

.stepper-step.active .step-label {
    color: #2563eb;
}

.stepper-step.completed .step-label {
    color: #0f172a;
}

.step-line {
    position: absolute;
    top: 14px;
    left: 10%;
    right: 10%;
    height: 3px;
    background: #e2e8f0;
    z-index: 1;
}

.step-line-fill {
    height: 100%;
    background: #16a34a;
    transition: width 0.3s ease;
}

.rejection-notice {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    margin-top: 15px;
}
    </style>
</head>
<body>

<div class="container">
    <h2>Track Application Status</h2>

    <?php if (!empty($error)): ?>
        <div class="alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo base_url('index.php/track'); ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <div class="form-group">
            <label for="ref_id">Application Reference ID</label>
            <input type="text" name="ref_id" id="ref_id" class="form-control" value="<?php echo set_value('ref_id'); ?>" placeholder="e.g. 7" required>
        </div>

        <div class="form-group">
            <label for="email">Registered Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="Enter email used when applying" required>
        </div>

        <button type="submit" class="btn-track">Check Status</button>
    </form>

    <?php if (!empty($application)): ?>
        <?php 
            $raw_status = !empty($application['application_status']) ? $application['application_status'] : (!empty($application['status']) ? $application['status'] : 'Submitted');
            $status_lower = strtolower(str_replace(' ', '-', trim($raw_status)));

            // calculate step levels: 1 = Submitted, 2 = Under Review, 3 = Shortlisted
            $step_num = 1;
            $line_pct = '0%';

            if ($status_lower === 'under-review' || $status_lower === 'reviewed') {
                $step_num = 2;
                $line_pct = '50%';
            } elseif ($status_lower === 'shortlisted') {
                $step_num = 3;
                $line_pct = '100%';
            }
        ?>

        <div class="tracker-card">
            <div class="tracker-header">
                <h3><?php echo html_escape($application['full_name']); ?></h3>
                <div class="tracker-meta">
                    <span><strong>Ref ID:</strong> #<?php echo html_escape($application['id']); ?></span>
                    <span><strong>Applied:</strong> <?php echo date('d M Y', strtotime($application['created_at'])); ?></span>
                    <span><strong>Qualification:</strong> <?php echo html_escape($application['highest_qualification']); ?></span>
                </div>
            </div>

            <?php if ($status_lower === 'rejected'): ?>
                <div class="rejection-notice">
                    <strong>Status: Not Selected</strong><br>
                    Thank you for taking the time to apply. At this stage, we have decided to proceed with other candidates.
                </div>
            <?php else: ?>
                <!-- visual progress bar -->
                <div class="stepper-track">
                    <div class="step-line">
                        <div class="step-line-fill" style="width: <?php echo $line_pct; ?>;"></div>
                    </div>

                    <!-- Step 1: Applied -->
                    <div class="stepper-step <?php echo ($step_num > 1) ? 'completed' : 'active'; ?>">
                        <div class="step-node"><?php echo ($step_num > 1) ? '&#10003;' : '1'; ?></div>
                        <div class="step-label">Application Submitted</div>
                    </div>

                    <!-- Step 2: Under Review -->
                    <div class="stepper-step <?php echo ($step_num > 2) ? 'completed' : (($step_num == 2) ? 'active' : ''); ?>">
                        <div class="step-node"><?php echo ($step_num > 2) ? '&#10003;' : '2'; ?></div>
                        <div class="step-label">In Review</div>
                    </div>

                    <!-- Step 3: Decision -->
                    <div class="stepper-step <?php echo ($step_num == 3) ? 'completed' : ''; ?>">
                        <div class="step-node"><?php echo ($step_num == 3) ? '&#10003;' : '3'; ?></div>
                        <div class="step-label">Shortlisted</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <a href="<?php echo base_url('index.php/apply'); ?>" class="nav-link">&larr; Back to Application Form</a>
</div>

</body>
</html>