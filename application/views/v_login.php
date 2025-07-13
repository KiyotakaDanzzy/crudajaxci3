<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: url('<?= base_url('style/bg/background-lgn.jpg') ?>');
            background-size: cover;
            background-position: center;
        }

        .login-card {
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            max-width: 400px;
            width: 100%;
            background-color: white;
        }

        .form-control {
            border-radius: 0.5rem;
        }

        .btn-primary {
            border-radius: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="card login-card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Login</h3>
            </div>
            <form id="login-form">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
            </form>
        </div>
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
                            window.location.href = res.role === 'admin' ?
                                base + "products" :
                                base + "products/tampil";
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Login',
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
