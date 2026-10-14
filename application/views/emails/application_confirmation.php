<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8fafc; margin: 0; padding: 20px; color: #334155; }
        .container { max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; overflow: hidden; }
        .header { background: #2563eb; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 25px; line-height: 1.6; }
        .info-box { background: #f1f5f9; padding: 15px; border-radius: 6px; margin: 18px 0; }
        .footer { font-size: 12px; color: #94a3b8; text-align: center; padding: 15px; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Application Received</h2>
        </div>
        <div class="content">
            <p>Dear <strong><?php echo htmlspecialchars($applicant_name); ?></strong>,</p>
            <p>Thank you for submitting your job application. We have received your profile and our recruitment team is reviewing your credentials.</p>
            <div class="info-box">
                <p style="margin: 0;"><strong>Application Reference:</strong> #<?php echo $application_id; ?></p>
                <p style="margin: 6px 0 0 0;"><strong>Position Applied:</strong> Software Engineer / Web Developer</p>
                <p style="margin: 6px 0 0 0;"><strong>Submission Date:</strong> <?php echo date('d M Y, h:i A'); ?></p>
            </div>
            <p>If your profile matches our requirements, our HR team will reach out to you directly for the interview schedule.</p>
            <p>Best regards,<br><strong>Talent Acquisition Team</strong></p>
        </div>
        <div class="footer">
            Job Application Portal &copy; <?php echo date('Y'); ?>. All rights reserved.
        </div>
    </div>
</body>
</html>