<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account Created</title>
</head>
<body>
    <p>Hello {{ $user->first_name }},</p>
    <p>Your user account has been successfully created by the admin.</p>
    <p>Here are your account details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $user->first_name }} {{ $user->last_name }} </li>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>User name:</strong> {{ $user->user_name }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
        <!-- Add any additional user details as needed -->
    </ul>
    <p>Thank you for joining our platform! Please contact admin for password.</p>
    <p>Sincerely,<br/>{{ config('app.name') }}</p>
</body>
</html>
