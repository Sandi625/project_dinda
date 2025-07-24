<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | Evaluasi Kinerja Guru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #3B82F6; /* Warna latar belakang diubah */
    }

    .login-box {
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      width: 360px;
    }

    .login-box img {
      width: 70px;
      display: block;
      margin: 0 auto 10px;
    }

    .login-box h4 {
      text-align: center;
      margin-bottom: 10px;
      color: #1e3a8a;
    }

    .login-box p.subtext {
      text-align: center;
      font-size: 13px;
      color: #555;
      margin-bottom: 20px;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #2575fc;
    }

    .btn-primary {
      background-color: #2563eb;
      border: none;
    }

    .btn-primary:hover {
      background-color: #1d4ed8;
    }

    .register {
      text-align: center;
      margin-top: 15px;
      font-size: 13px;
    }

    .register a {
      color: #2563eb;
      text-decoration: none;
    }

    .register a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="login-box">
      <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah">
      <h4>Silakan Login</h4>
      <p class="subtext">Sistem Evaluasi Kinerja Guru<br>SMK Muhammadiyah 9 Gambiran</p>

      <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Masuk</button>

        <div class="register">
          Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
