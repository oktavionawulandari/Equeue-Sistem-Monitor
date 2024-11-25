<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      background-color: #f8f9fa;
    }
    .login-card {
      padding: 2rem;
      border-radius: 8px;
      background: #fff;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .logo {
      display: block;
      margin: 0 auto 1rem;
      width: 80px;
      height: 80px;
    }
    .btn-login {
      width: 100%;
    }
  </style>
</head>
<body>
  <div class="login-card text-center">
    <img src="logo.png" alt="Logo" class="logo">
    <form>
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" placeholder="Enter your username">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" placeholder="Enter your password">
      </div>
      <button type="submit" class="btn btn-dark btn-login">Log In</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
