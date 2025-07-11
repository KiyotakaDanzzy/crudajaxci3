<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --bs-primary-rgb: 78, 115, 223;
            --bs-secondary-rgb: 133, 135, 150;
        }

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
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 2rem rgba(200, 204, 210, 0.12);
        }

        .card-img-top,
        .card-img-placeholder {
            width: 100%;
            height: auto;
            object-fit: contain;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
            display: block;
            margin-right: auto;
            margin-left: auto;
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

        .modal-header {
            background-color: #4e73df;
            color: white;
        }

        .btn-primary {
            background-color: #4e73df;
            border: none;
        }

        .invalid-feedback {
            display: block;
        }

        #preview-gambar {
            width: 100%;
            max-width: 200px;
            height: auto;
            margin-top: 10px;
            border-radius: 0.5rem;
        }

        .placeholder-card {
            text-align: center;
            padding: 5rem 1rem;
            border: 2px dashed #e0e0e0;
            background-color: #fafafa;
            border-radius: 0.75rem;
        }

        .pagination .page-item.active a {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
        }

        .pagination .page-link {
            color: #4e73df;
        }

        .pagination .page-link:hover {
            color: #224abe;
        }

        .pagination .page-item.disabled .page-link {
            color: #858796;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="#"><i class="bi bi-box-seam-fill"></i> CRUD ProdukKu</a>
            <div class="d-flex ms-auto" style="width: 100%; max-width: 500px;">
                <div class="input-group"><span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span><input type="text" id="search-input" class="form-control bg-light border-0" placeholder="Cari nama produk..."></div>
            </div>
            <button class="btn btn-primary ms-3 d-flex align-items-center btn-add"><i class="bi bi-plus-circle-fill me-2"></i><span>Tambah produk</span></button>
        </div>
    </nav>

    <main class="container py-4">
        <div id="product-list" class="row g-4"></div>
        <div id="pagination-container" class="mt-4 d-flex justify-content-center"></div>
    </main>

    <div class="modal fade" id="product-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Form tambah produk</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="product-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3"><label for="name" class="form-label fw-bold">Nama produk</label><input type="text" id="name" name="name" class="form-control">
                                    <div class="invalid-feedback" id="name-error"></div>
                                </div>
                                <div class="mb-3"><label for="price" class="form-label fw-bold">Harga (Rp)</label><input type="number" id="price" name="price" class="form-control">
                                    <div class="invalid-feedback" id="price-error"></div>
                                </div>
                                <div class="mb-3"><label for="description" class="form-label fw-bold">Deskripsi</label><textarea id="description" name="description" class="form-control" rows="5"></textarea></div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3"><label for="image" class="form-label fw-bold">Gambar produk</label><input type="file" id="image" name="image" class="form-control" onchange="previewGambar()"><img id="preview-gambar" src="#" alt="Image Preview" class="img-fluid d-none"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btn-save">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('style/js/pagination.js'); ?>"></script>

    <script>
        const base = "<?= base_url() ?>";
        const folderGambar = base + "uploads/products/";
        const perHalaman = 8;
        let halaman = 1;
        let kata = "";

        $(document).ready(function() {
            produk();
            $('#btn-save').click(function() {
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');

                let nama = $('[name="name"]').val().trim();
                let harga = $('[name="price"]').val().trim();
                let error = false;

                if (nama == '') {
                    $('#name-error').text('Nama produk tidak boleh kosong');
                    $('[name="name"]').addClass('is-invalid');
                    error = true;
                }

                if (harga == '' || isNaN(harga) || parseFloat(harga) <= 0) {
                    $('#price-error').text('Harga harus lebih dari 0');
                    $('[name="price"]').addClass('is-invalid');
                    error = true;
                }

                if (error) return;

                let url = $('[name="id"]').val() == '' ? base + "products/tambah" : base + "products/edit";
                let data = new FormData($('#product-form')[0]);

                $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(res) {
                        if (res.status) {
                            $('#product-modal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Data berhasil disimpan',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            halaman = 1;
                            window.pagin = null;
                            produk();
                        }
                    },
                    error: function(jqXHR) {
                        if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                            let x = jqXHR.responseJSON.errors;
                            for (let k in x) {
                                $('[name="' + k + '"]').addClass('is-invalid');
                                $('#' + k + '-error').text(x[k]);
                            }
                        }
                    }
                });
            });

            $('#search-input').on('keyup', function() {
                kata = $(this).val();
                halaman = 1;
                window.pagin = null;
                produk();
            });

            $('.btn-add').click(function() {
                $('#product-form')[0].reset();
                $('[name="id"]').val('');
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#preview-gambar').addClass('d-none').attr('src', '#');
                $('#modal-title').text('Tambah Produk Baru');
                $('#product-modal').modal('show');
            });

            $('#product-list').on('click', '.btn-edit', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: base + "products/get",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(x) {
                        $('#product-modal').modal('show');
                        $('#modal-title').text("Edit Produk");
                        $('[name="id"]').val(x.id);
                        $('[name="name"]').val(x.name);
                        $('[name="description"]').val(x.description);
                        $('[name="price"]').val(x.price);
                        if (x.image) {
                            $('#preview-gambar').attr('src', folderGambar + x.image).removeClass('d-none');
                        }
                    }
                });
            });

            $('#product-list').on('click', '.btn-hapus', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin?',
                    text: 'Data produk ini akan dihapus',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Hapus',
                    cancelButtonText: 'Batal'
                }).then(function(r) {
                    if (r.isConfirmed) {
                        $.ajax({
                            url: base + "products/hapus",
                            type: "POST",
                            data: {
                                id: id
                            },
                            dataType: "JSON",
                            success: function(res) {
                                if (res.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: 'Data berhasil dihapus',
                                        timer: 1500,
                                        showConfirmButton: false
                                    });
                                    produk();
                                }
                            }
                        });
                    }
                });
            });

            $('#image').change(function() {
                if (this.files && this.files[0]) {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-gambar').attr('src', e.target.result).removeClass('d-none');
                    };
                    reader.readAsDataURL(this.files[0]);
                }
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
                    } else {
                        for (let i = 0; i < list.length; i++) {
                            let x = list[i];
                            let img = x.image ? `<img src="${folderGambar + x.image}" class="card-img-top">` : `<div class="card-img-placeholder"><span>Tidak ada gambar</span></div>`;
                            html += `
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="card h-100">
                            ${img}
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">${x.name}</h5>
                                <p class="card-text text-muted small flex-grow-1">${x.description}</p>
                                <p class="card-price mb-3">Rp ${parseInt(x.price).toLocaleString('id-ID')}</p>
                                <div class="mt-auto pt-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm btn-edit" data-id="${x.id}"><i class="bi bi-pencil-square"></i> Edit</button>
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-hapus" data-id="${x.id}"><i class="bi bi-trash3"></i> Hapus</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
                        }
                    }
                    $('#product-list').html(html);
                    if (!window.pagin) {
                        window.pagin = new Pagination('#pagination-container', {
                            itemsCount: res.total_items,
                            pageSize: perHalaman,
                            currentPage: halaman,
                            onPageChange: function(data) {
                                halaman = data.currentPage;
                                produk();
                            }
                        });
                    }
                }
            });
        }
    </script>

</body>

</html>