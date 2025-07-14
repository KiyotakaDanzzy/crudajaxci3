<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

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
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(2px);
            z-index: 0;
        }

        .login-card {
            position: relative;
            z-index: 1;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.35);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2.5rem;
            max-width: 400px;
            width: 100%;
            backdrop-filter: blur(20px);
            color: white;
            transition: all 0.3s ease-in-out;
        }

        .login-card:hover {
            box-shadow: 0 0 50px rgba(255, 255, 255, 0.15);
        }

        .form-label {
            font-weight: 600;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #fff;
            box-shadow: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }

        .btn-outline-secondary {
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 12px;
        }

        .btn-outline-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .text-center h3 {
            font-weight: 700;
            letter-spacing: 1px;
            color: white;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="text-center mb-4">
            <h3>Selamat Datang</h3>
            <p class="mb-0" style="font-size: 14px; color: rgba(255,255,255,0.7)">Silakan login terlebih dulu</p>
        </div>
        <form id="login-form">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required />
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const base = "<?= base_url() ?>";

        $(document).ready(function() {
            $('#togglePassword').click(function() {
                const password = $('#password');
                const type = password.attr('type') === 'password' ? 'text' : 'password';
                password.attr('type', type);
                $(this).find('i').toggleClass('bi-eye bi-eye-slash');
            });

            $('#login-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: base + "users/auth",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            window.location.href = res.role === 'admin' ?
                                base + "products" :
                                base + "products/tampil";
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal login',
                                draggable: true,
                                confirmButtonText: 'Coba lagi',
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