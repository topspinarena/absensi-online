<!DOCTYPE html>
<html>
<head>
    <title>Login Absensi</title>
</head>
<body>

<h2>Login Absensi Online</h2>

<form method="POST" action="/login">
    @csrf

    <p>Email</p>
    <input type="email" name="email">

    <p>Password</p>
    <input type="password" name="password">

    <br><br>

    <button type="submit">Login</button>

</form>

</body>
</html>