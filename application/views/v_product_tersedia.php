<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: "Inter", sans-serif;
        }

        .navbar {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.1);
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.25rem 1.5rem rgba(33, 40, 50, 0.08);
        }

        .card-img-top,
        .card-img-placeholder {
            width: 100%;
            height: auto;
            object-fit: contain;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            max-height: 200px;
        }

        .card-img-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            color: #6c757d;
        }

        .card-title {
            font-weight: 600;
            color: #333;
        }

        .card-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #4e73df;
        }

        .placeholder-card {
            text-align: center;
            padding: 5rem 1rem;
            border: 2px dashed #e0e0e0;
            background-color: #fafafa;
            border-radius: 0.75rem;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="#"><i class="bi bi-box-seam-fill"></i> CRUD ProdukKu</a>
            <div class="d-flex ms-auto" style="width: 100%; max-width: 500px;">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="search-input" class="form-control bg-light border-0" placeholder="Cari nama produk...">
                </div>
            </div>
            <button class="btn btn-outline-danger ms-3" id="btn-logout"><i class="bi bi-box-arrow-right"></i> Logout</button>
        </div>
    </nav>

    <main class="container py-4">
        <div id="product-list" class="row g-4"></div>
        <div id="pagination-container" class="mt-4 d-flex justify-content-center"></div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('style/js/pagination.js'); ?>"></script>

    <script>
        const base = "<?= base_url() ?>";
        const folderGambar = base + "uploads/products/";
        const perHalaman = 8;
        let halaman = 1;
        let kata = "";

        $(document).ready(function() {
            produk();

            $('#search-input').on('keyup', function() {
                kata = $(this).val();
                halaman = 1;
                window.pagin = null;
                produk();
            });

            $('#btn-logout').click(function() {
                window.location.href = base + "users/logout";
            });
        });

        function produk() {
            $.ajax({
                url: base + "products/list",
                type: "GET",
                data: {
                    kataKunci: kata,
                    page: halaman,
                    limit: perHalaman
                },
                dataType: "JSON",
                success: function(res) {
                    let html = '';
                    let list = res.products;

                    if (list.length == 0) {
                        html = `<div class="col-12"><div class="placeholder-card"><i class="bi bi-search display-4 text-muted"></i><h5 class="mt-3">Produk tidak ada</h5><p class="text-muted">Tidak ada produk yang cocok</p></div></div>`;
                        $('#product-list').html(html);
                        $('#pagination-container').empty();
                    } else {
                        for (let i = 0; i < list.length; i++) {
                            let x = list[i];
                            let img = x.image ? `<img src="${folderGambar + x.image}" class="card-img-top">` : `<div class="card-img-placeholder"><span>Tidak ada gambar</span></div>`;
                            html += `
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 product-item">
                            <div class="card h-100">
                                ${img}
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1">${x.name}</h5>
                                    <p class="card-text text-muted small flex-grow-1">${x.description}</p>
                                    <p class="card-price mb-3">Rp ${parseInt(x.price).toLocaleString('id-ID')}</p>
                                </div>
                            </div>
                        </div>`;
                        }
                        $('#product-list').html(html);
                        hasilPaginasi(res.total_items);
                    }
                }
            });
        }

        function hasilPaginasi(totalItems) {
            const totalPages = Math.ceil(totalItems / perHalaman);

            $('#pagination-container').empty();

            if (totalPages > 1) {
                let paginationHtml = `
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item ${halaman === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Previous" data-page="${halaman - 1}">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>`;

                for (let i = 1; i <= totalPages; i++) {
                    paginationHtml += `
                <li class="page-item ${i === halaman ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>`;
                }

                paginationHtml += `
                    <li class="page-item ${halaman === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" aria-label="Next" data-page="${halaman + 1}">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>`;

                $('#pagination-container').html(paginationHtml);
            }
        }

        $(document).on('click', '.page-link', function(e) {
            e.preventDefault();
            halaman = parseInt($(this).data('page'));
            produk();
        });
    </script>
</body>

</html>