<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - CRUD ProdukKu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

    :root {
      --primary: #4e73df;
      --primary-hover: #2e59d9;
    }

    * {
      font-family: 'Inter', sans-serif;
    }

    body {
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background-image: url('<?= base_url('style/bg/background-lgn.jpg') ?>');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      inset: 0;
      background-color: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(2px);
      z-index: 0;
    }

    .login-container {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 420px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 0.75rem;
      box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
      padding: 2.5rem;
      animation: fadeIn 0.5s ease-in-out;
    }

    .login-title {
      font-weight: 700;
      color: var(--primary);
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .form-label {
      font-weight: 600;
      color: #343a40;
    }

    .form-control {
      border-radius: 0.5rem;
      font-size: 0.95rem;
    }

    .btn-primary {
      background-color: var(--primary);
      border: none;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: 0.3s ease-in-out;
    }

    .btn-primary:hover {
      background-color: var(--primary-hover);
    }

    .btn-outline-secondary {
      border-radius: 0.5rem;
    }

    .footer-note {
      font-size: 0.85rem;
      color: #888;
      text-align: center;
      margin-top: 2rem;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(15px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <h4 class="login-title">Login</h4>
    <form id="login-form">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required placeholder="Masukkan username">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan password">
          <button class="btn btn-outline-secondary" type="button" id="togglePassword">
            <i class="bi bi-eye"></i>
          </button>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
    </form>
    <p class="footer-note">&copy; Manajemen Produk</p>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const base = "<?= base_url() ?>";

    $(document).ready(function () {
      $('#togglePassword').click(function () {
        const password = $('#password');
        const type = password.attr('type') === 'password' ? 'text' : 'password';
        password.attr('type', type);
        $(this).find('i').toggleClass('bi-eye bi-eye-slash');
      });

      $('#login-form').submit(function (e) {
        e.preventDefault();
        $.ajax({
          url: base + "users/auth",
          type: "POST",
          data: $(this).serialize(),
          dataType: "JSON",
          success: function (res) {
            if (res.status) {
              window.location.href = res.role === 'admin'
                ? base + "products"
                : base + "products/tampil";
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal login',
                text: res.message
              });
            }
          }
        });
      });
    });
  </script>
</body>

</html>