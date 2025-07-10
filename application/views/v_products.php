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
        :root { --bs-primary-rgb: 78, 115, 223; --bs-secondary-rgb: 133, 135, 150; }
        body { background-color: #f0f2f5; font-family: "Inter", sans-serif; }
        .navbar { box-shadow: 0 0.15rem 1.75rem 0 rgba(33, 40, 50, 0.1); }
        .card { border: none; border-radius: 0.75rem; box-shadow: 0 0.25rem 1.5rem rgba(33, 40, 50, 0.08); transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 2rem rgba(200, 204, 210, 0.12); }
        .card-img-top, .card-img-placeholder { width: 100%; height: auto; object-fit: contain; border-top-left-radius: 0.75rem; border-top-right-radius: 0.75rem; display: block; margin-right: auto; margin-left: auto; max-height: 200px; }
        .card-img-placeholder { display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; color: #6c757d; }
        .card-title { font-weight: 600; color: #333; }
        .card-price { font-size: 1.2rem; font-weight: 700; color: #4e73df; }
        .modal-header { background-color: #4e73df; color: white; }
        .btn-primary { background-color: #4e73df; border: none; }
        .invalid-feedback { display: block; }
        #image-preview { width: 100%; max-width: 200px; height: auto; margin-top: 10px; border-radius: 0.5rem; }
        .placeholder-card { text-align: center; padding: 5rem 1rem; border: 2px dashed #e0e0e0; background-color: #fafafa; border-radius: 0.75rem; }
        .pagination .page-item.active a { background-color: #4e73df; border-color: #4e73df; }
        .pagination .page-link { color: #4e73df; }
        .pagination .page-link:hover { color: #224abe; }
        .pagination .page-item.disabled .page-link { color: #858796; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="#"><i class="bi bi-box-seam-fill"></i> CRUD ProdukKu</a>
            <div class="d-flex ms-auto" style="width: 100%; max-width: 500px;">
                <div class="input-group"><span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span><input type="text" id="search-input" class="form-control bg-light border-0" placeholder="Cari nama produk..."></div>
            </div>
            <button class="btn btn-primary ms-3 d-flex align-items-center" onclick="addProduct()"><i class="bi bi-plus-circle-fill me-2"></i><span>Tambah Produk</span></button>
        </div>
    </nav>

    <main class="container py-4">
        <div id="product-list" class="row g-4"></div>
        <div id="pagination-container" class="mt-4 d-flex justify-content-center"></div>
    </main>

    <div class="modal fade" id="product-modal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title" id="modal-title">Form Produk</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <form id="product-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="mb-3"><label for="name" class="form-label fw-bold">Nama Produk</label><input type="text" id="name" name="name" class="form-control"><div class="invalid-feedback" id="name-error"></div></div>
                                <div class="mb-3"><label for="price" class="form-label fw-bold">Harga (Rp)</label><input type="number" id="price" name="price" class="form-control"><div class="invalid-feedback" id="price-error"></div></div>
                                <div class="mb-3"><label for="description" class="form-label fw-bold">Deskripsi</label><textarea id="description" name="description" class="form-control" rows="5"></textarea></div>
                            </div>
                            <div class="col-md-5">
                                <div class="mb-3"><label for="image" class="form-label fw-bold">Gambar Produk</label><input type="file" id="image" name="image" class="form-control" onchange="previewImage()"><img id="image-preview" src="#" alt="Image Preview" class="img-fluid d-none"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button><button type="button" class="btn btn-primary" onclick="saveProduct()">Simpan</button></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo base_url('style/js/pagination.js'); ?>"></script>

    <script>
        const BASE_URL = "<?php echo base_url(); ?>";
        const UPLOADS_URL = `${BASE_URL}uploads/products/`;
        const ITEMS_PER_PAGE = 8;
        
        let searchTimer;
        let paginationInstance = null;
        let currentKeyword = '';
        let activePage = 1;

        $(document).ready(function() {
            loadProducts(1); 
            $('#search-input').on('input', function() {
                clearTimeout(searchTimer);
                currentKeyword = $(this).val();
                searchTimer = setTimeout(() => {
                    loadProducts(1);
                }, 300);
            });
        });
        
        function loadProducts(page) {
            activePage = page;
            $('#product-list').html('<div class="col-12 text-center p-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            
            $.ajax({
                url: `${BASE_URL}products/ajax_list`,
                type: "GET",
                dataType: "JSON",
                data: { keyword: currentKeyword, page: page, limit: ITEMS_PER_PAGE },
                success: function(response) {
                    renderProductCards(response.products);
                    if (!paginationInstance || page === 1) {
                         initializePagination(response.total_items, page);
                    }
                },
                error: (jqXHR) => showAlert('error', `Error: ${jqXHR.status}`, 'Gagal memuat produk')
            });
        }
        
        function initializePagination(totalItems, currentPage) {
            $('#pagination-container').empty();
            paginationInstance = null;
            if (totalItems > ITEMS_PER_PAGE) {
                 paginationInstance = new Pagination('#pagination-container', {
                    itemsCount: totalItems,
                    pageSize: ITEMS_PER_PAGE,
                    currentPage: currentPage,
                    labels: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        previous: '<i class="fas fa-angle-left"></i>'
                    },
                    onPageChange: function(pageData) {
                        if(pageData.currentPage !== activePage) {
                           loadProducts(pageData.currentPage);
                        }
                    }
                });
            }
        }
        
        function renderProductCards(products) {
            const productList = $('#product-list');
            productList.empty(); 
            if (products && products.length > 0) {
                products.forEach(product => {
                    const priceFormatted = 'Rp ' + new Intl.NumberFormat('id-ID').format(product.price);
                    const imageUrl = product.image ? UPLOADS_URL + product.image : '';
                    const imageElement = product.image
                        ? `<img src="${imageUrl}" class="card-img-top" alt="${product.name}">`
                        : `<div class="card-img-placeholder d-flex align-items-center justify-content-center" style="height: 200px;"><span>Tidak ada gambar</span></div>`;

                    const cardHtml = `
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                            <div class="card h-100">
                                ${imageElement}
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1">${escapeHtml(product.name)}</h5>
                                    <p class="card-text text-muted small flex-grow-1">${escapeHtml(product.description)}</p>
                                    <p class="card-price mb-3">${priceFormatted}</p>
                                    <div class="mt-auto pt-2">
                                        <button class="btn btn-outline-primary btn-sm" onclick="editProduct(${product.id})"><i class="bi bi-pencil-square"></i> Edit</button>
                                        <button class="btn btn-outline-danger btn-sm" onclick="deleteProduct(${product.id})"><i class="bi bi-trash3"></i> Hapus</button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    productList.append(cardHtml);
                });
            } else {
                productList.html(`<div class="col-12"><div class="placeholder-card"><i class="bi bi-search display-4 text-muted"></i><h5 class="mt-3">Produk tidak ditemukan</h5><p class="text-muted">Tidak ada produk yang cocok dengan pencarian.</p></div></div>`);
            }
        }
        
        function reloadCurrentPage() {
            loadProducts(activePage);
        }

        function saveProduct() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            const id = $('[name="id"]').val();
            const url = (id === '') ? `${BASE_URL}products/ajax_add` : `${BASE_URL}products/ajax_update`;
            const formData = new FormData($('#product-form')[0]);
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.status) {
                        $('#product-modal').modal('hide');
                        showAlert('success', 'Berhasil', 'Data produk berhasil disimpan.');
                        loadProducts(id ? activePage : 1);
                    }
                },
                error: function(jqXHR) {
                    if (jqXHR.responseJSON && jqXHR.responseJSON.errors) {
                        const errors = jqXHR.responseJSON.errors;
                        for (const key in errors) {
                            if (errors[key]) {
                                $(`[name="${key}"]`).addClass('is-invalid');
                                $(`#${key}-error`).text(errors[key]);
                            }
                        }
                    } else {
                        showAlert('error', `Error: ${jqXHR.status}`, 'Gagal menyimpan produk.');
                    }
                }
            });
        }

        function deleteProduct(id) {
            Swal.fire({
                title: 'Yakin?',
                text: "Data produk ini akan dihapus secara permanen.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${BASE_URL}products/ajax_delete/${id}`, type: "POST", dataType: "JSON",
                        success: function(data) {
                            if (data.status) {
                                showAlert('success', 'Dihapus', 'Data produk telah dihapus.');
                                reloadCurrentPage();
                            } else { showAlert('error', 'Gagal', data.message || 'Gagal menghapus data.'); }
                        },
                        error: () => showAlert('error', 'Error', 'Terjadi kesalahan.')
                    });
                }
            });
        }
        
        function editProduct(id) {
            clearForm();
            $.ajax({
                url: `${BASE_URL}products/ajax_get/${id}`, type: "GET", dataType: "JSON",
                success: function(data) {
                    $('[name="id"]').val(data.id);
                    $('[name="name"]').val(data.name);
                    $('[name="description"]').val(data.description);
                    $('[name="price"]').val(data.price);
                    if (data.image) { $('#image-preview').attr('src', UPLOADS_URL + data.image).removeClass('d-none'); }
                    $('#modal-title').text('Edit Produk');
                    $('#product-modal').modal('show');
                },
                error: () => showAlert('error', 'Error', 'Gagal mengambil data produk.')
            });
        }
        
        function addProduct() { clearForm(); $('#modal-title').text('Tambah Produk Baru'); $('#product-modal').modal('show'); }
        function clearForm() { $('#product-form')[0].reset(); $('[name="id"]').val(''); $('.is-invalid').removeClass('is-invalid'); $('.invalid-feedback').text(''); $('#image-preview').addClass('d-none').attr('src', '#'); }
        function previewImage() { const input = document.getElementById('image'); if (input.files && input.files[0]) { const reader = new FileReader(); reader.onload = (e) => { $('#image-preview').attr('src', e.target.result).removeClass('d-none'); }; reader.readAsDataURL(input.files[0]); } }
        function escapeHtml(text) { if (!text) return ''; var map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }; return text.replace(/[&<>"']/g, function(m) { return map[m]; }); }
        function showAlert(icon, title, text) { Swal.fire({ icon, title, text, timer: 2000, showConfirmButton: false }); }
    </script>

</body>
</html>