<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <style>
        * { box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .login-card { background: #ffffff; padding: 35px 30px; border-radius: 8px; box-shadow: 0 4px 14px rgba(0,0,0,0.08); width: 100%; max-width: 400px; }
        h2 { margin-top: 0; color: #1e293b; text-align: center; font-size: 24px; }
        p.subtitle { text-align: center; color: #64748b; font-size: 14px; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        input[type="text"], input[type="password"] {
            width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;
        }
        input:focus { outline: none; border-color: #2563eb; }
        .btn-login { width: 100%; background: #2563eb; color: #ffffff; padding: 11px; border: none; border-radius: 6px; font-size: 15px; font-weight: 600; cursor: pointer; margin-top: 8px; }
        .btn-login:hover { background: #1d4ed8; }
        .alert-error { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; padding: 10px 12px; border-radius: 6px; margin-bottom: 18px; font-size: 13px; }
        .back-link { display: block; text-align: center; margin-top: 20px; font-size: 13px; color: #64748b; text-decoration: none; }
        .back-link:hover { color: #2563eb; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>Admin Portal</h2>
    <p class="subtitle">Please sign in with your administrator credentials</p>

    <?php if (!empty($error) || validation_errors()): ?>
        <div class="alert-error">
            <?php echo !empty($error) ? $error : validation_errors(); ?>
        </div>
    <?php endif; ?>

    <?php echo form_open('admin/login'); ?>
        <div class="form-group">
            <label for="username">Username or Email</label>
            <input type="text" name="username" id="username" value="<?php echo set_value('username'); ?>" autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <button type="submit" class="btn-login">Sign In</button>
    <?php echo form_close(); ?>

    <a href="<?php echo base_url('index.php/apply'); ?>" class="back-link">&larr; Back to Job Application Form</a>
</div>

</body>
</html>