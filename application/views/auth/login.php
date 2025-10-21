<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - DOMPETKITA</title>
  <link rel="stylesheet" href="<?= base_url('assets/bootstrap-5.3.6-dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .login-container {
      background: #fff;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      width: 100%;
      max-width: 400px;
      animation: zoomIn 0.6s ease;
    }

    @keyframes zoomIn {
      from {
        transform: scale(0.95);
        opacity: 0;
      }
      to {
        transform: scale(1);
        opacity: 1;
      }
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #0a1a35;
      font-weight: bold;
    }

    .form-control {
      border-radius: 12px;
    }

    .btn-navy {
      background-color: #0a1a35;
      color: white;
      border-radius: 12px;
      transition: 0.3s ease;
    }

    .btn-navy:hover {
      background-color: #0d2346;
    }

    .input-group-text {
      background: #0a1a35;
      color: #fff;
      border: none;
      border-top-left-radius: 12px;
      border-bottom-left-radius: 12px;
    }

    .alert {
      margin-bottom: 20px;
    }

    .register-link {
      text-align: center;
      margin-top: 20px;
      color: #0a1a35;
    }

    .register-link a {
      color: #0a1a35;
      font-weight: 600;
      text-decoration: none;
    }

    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2><i class="fas fa-wallet me-2"></i>Login</h2>

  <?php if ($this->session->flashdata('msg')): ?>
    <div class="alert alert-success text-center">
      <?= $this->session->flashdata('msg') ?>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <div class="input-group">
        <span class="input-group-text"><i class="fas fa-lock"></i></span>
        <input type="password" class="form-control" id="password" name="password" required>
        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()" tabindex="-1">
          <i class="fas fa-eye"></i>
        </button>
      </div>
    </div>

    <button type="submit" class="btn btn-navy w-100">Login</button>
  </form>

  <div class="register-link">
    Belum punya akun? <a href="<?= site_url('auth/register') ?>">Registrasi</a>
  </div>
</div>

<script>
  function togglePassword() {
    const password = document.getElementById('password');
    const icon = event.currentTarget.querySelector('i');
    if (password.type === 'password') {
      password.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      password.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
