<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; background-color: #f5f5f5; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
        <p>Hi,</p>
        <p>You requested to reset your password. Click the link below to reset it:</p>
        <p style="text-align: center; margin-top: 20px;">
            <a href="{{ $resetLink }}" style="display: inline-block; background-color: #007bff; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Reset Password</a>
        </p>
        <p>If you did not request this, please ignore this email.</p>
    </div>
</body>
</html>
