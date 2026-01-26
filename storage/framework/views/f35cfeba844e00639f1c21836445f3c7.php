<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Created</title>
</head>
<body>
    <p>Hello <?php echo e($user->first_name); ?>,</p>
    <p>You are receiving this email because admin reset password for your account.</p>
    <p>Here are your account details:</p>
    <ul>
        <li><strong>Name:</strong> <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?>  </li>
        <li><strong>Email:</strong> <?php echo e($user->email); ?></li>
        <li><strong>User name:</strong> <?php echo e($user->user_name); ?></li>
        <li><strong>Password:</strong> <?php echo e($password); ?></li>
        <!-- Add any additional user details as needed -->
    </ul>
    <p>Please contact admin for password.</p>
    <p>Sincerely,<br/><?php echo e(config('app.name')); ?></p>
</body>
</html>

<?php /**PATH /Users/gihan.finsbury/Downloads/Vet-APP/Glowup/resources/views/emails/user_reset_pw.blade.php ENDPATH**/ ?>