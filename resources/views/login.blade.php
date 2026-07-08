@php
    $role = session('role');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LOGIN SANDRA</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
      background: #e0f0ff;
    }

    body::before {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(to bottom, rgba(255,255,255,0.95) 10%, rgba(200,225,255,0.9) 100%);
      z-index: 0;
    }

    body::after {
      content: "";
      position: absolute;
      inset: 0;
      background: url('{{ asset("images/berlian1.jpg") }}') center center / cover no-repeat;
      filter: brightness(1.05) contrast(1.15) saturate(1.1);
      z-index: 1;
    }

    .login-container {
      position: relative;
      z-index: 2;
      text-align: center;
      width: 100%;
      max-width: 420px;
      background: rgba(255,255,255,0.75);
      border-radius: 18px;
      backdrop-filter: blur(20px);
      padding: 60px 40px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.1);
      animation: fadeIn 1.2s ease;
    }

    .login-logo img {
      width: 300px;
      margin-bottom: 40px;
    }

    .form-control {
      border-radius: 10px;
      height: 46px;
      background: rgba(255,255,255,0.88);
      border: 1px solid rgba(0,0,0,0.05);
      margin-bottom: 18px;
      text-align: center;
      font-size: 18px;
      color: #333;
    }

    .btn-login {
      width: 100%;
      background-color: #2da8e1;
      border: none;
      border-radius: 8px;
      padding: 12px;
      color: #fff;
      font-weight: 600;
      font-size: 18px;
      transition: all .3s;
    }

    .btn-login:hover {
      background-color: #1b91cd;
    }

    /* Tombol ikon mata */
    .toggle-password-btn {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      font-size: 20px;
      color: #777;
      cursor: pointer;
    }

    .toggle-password-btn:hover {
      color: #2da8e1;
    }
  </style>
</head>

<body>
  <div class="login-container">

    <div class="login-logo">
      <img src="{{ asset('images/fix-logo.png') }}" alt="PELINDO Logo">
    </div>

    @if(session('error'))
      <div class="alert alert-danger py-2">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('authenticate') }}">
      @csrf

      <input type="text" class="form-control" name="username" placeholder="Username" required>

      <div class="position-relative">
        <input type="password"
               class="form-control"
               name="password"
               id="passwordField"
               placeholder="Password"
               required>

        <button type="button" id="togglePassword" class="toggle-password-btn">
          <i class="bi bi-eye-fill"></i>
        </button>
      </div>

      <button type="submit" class="btn-login">Login</button>
    </form>
  </div>

  <script>
    const passField = document.getElementById('passwordField');
    const toggleBtn = document.getElementById('togglePassword');
    let isShown = false;

    toggleBtn.addEventListener('click', () => {
      isShown = !isShown;
      passField.type = isShown ? "text" : "password";
      toggleBtn.innerHTML = isShown
        ? '<i class="bi bi-eye-slash-fill"></i>'
        : '<i class="bi bi-eye-fill"></i>';
    });
  </script>

</body>
</html>
