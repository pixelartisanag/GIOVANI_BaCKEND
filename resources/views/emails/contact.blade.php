<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Submission</title>
</head>
<body>
<h2>Contact Form Submission</h2>
<p>Name: {{ $data['name'] }}</p>
<p>Email: {{ $data['email'] }}</p>
<p>Subject: {{ $data['subject'] }}</p>
<p>Message:</p>
<p>{{ $data['message'] }}</p>
</body>
</html>
