<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registrasi - DOMPETKITA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .register-container {
      display: flex;
      flex-direction: row;
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      max-width: 900px;
      width: 100%;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
      animation: slideIn 0.7s ease;
    }

    @keyframes slideIn {
      from { transform: translateY(30px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    .left-panel {
       background: linear-gradient(135deg, #1f2e4d, #2c5364);
      width: 45%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
    }

    .left-panel img {
      max-width: 220px;
      filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.1));
    }

    .right-panel {
      width: 55%;
      padding: 40px;
      background-color: #fff;
    }

    .right-panel h4 {
      color: #17193f;
      font-weight: 700;
    }

    .form-control {
      border-radius: 10px;
      padding: 12px;
    }

    .btn-register {
      background-color: #17193f;
      color: white;
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 12px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-register:hover {
      background-color: #0f112c;
    }

    .input-group-text {
      background-color: #17193f;
      color: #fff;
      border: none;
    }

    .toggle-btn {
      border-top-right-radius: 10px;
      border-bottom-right-radius: 10px;
    }

    .text-muted a {
      color: #17193f;
      text-decoration: none;
      font-weight: 600;
    }

    .text-muted a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .register-container {
        flex-direction: column;
      }
      .left-panel, .right-panel {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="register-container">
  <!-- Left Logo Panel -->
  <div class="left-panel">
    <img src="<?= base_url('uploads/logo2.svg') ?>" alt="DOMPETKITA">
  </div>

  <!-- Right Form Panel -->
  <div class="right-panel">
    <h4 class="text-center mb-3">REGISTRASI AKUN</h4>
    <p class="text-center text-muted mb-4">
      Silakan daftar untuk membuat akun baru.<br>
      Sudah punya akun? <a href="<?= site_url('auth/login') ?>">Login</a>
    </p>

    <?php if ($this->session->flashdata('msg')): ?>
      <div class="alert alert-info text-center">
        <?= $this->session->flashdata('msg') ?>
      </div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama lengkap" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" name="email" class="form-control" id="email" placeholder="nama@email.com" required>
        </div>
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" name="password" class="form-control" id="password" required>
          <button type="button" class="btn btn-outline-secondary toggle-btn" onclick="togglePassword()" tabindex="-1">
            <i class="fas fa-eye"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-register">DAFTAR</button>
    </form>
  </div>
</div>

<script>
  function togglePassword() {
    const input = document.getElementById('password');
    const icon = event.currentTarget.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    } else {
      input.type = 'password';
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
</script>

</body>
</html>
