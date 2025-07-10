<?php
?>

<?php if (!empty($products)): ?>
    <?php foreach ($products as $product): ?>
        <?php
            $priceFormatted = 'Rp ' . number_format($product->price, 0, ',', '.');

            $imageUrl = base_url('uploads/products/' . $product->image);
            
            $imageElement = $product->image 
                ? '<img src="' . $imageUrl . '" class="card-img-top" alt="' . html_escape($product->name) . '">'
                : '<div class="card-img-placeholder d-flex align-items-center justify-content-center" style="height: 200px;"><span>Tidak ada gambar</span></div>';
        ?>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
            <div class="card h-100">
                <?php echo $imageElement; ?>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-1"><?php echo html_escape($product->name); ?></h5>
                    <p class="card-text text-muted small flex-grow-1"><?php echo html_escape($product->description); ?></p>
                    <p class="card-price mb-3"><?php echo $priceFormatted; ?></p>
                    <div class="mt-auto pt-2">
                        <button class="btn btn-outline-primary btn-sm" onclick="editProduct(<?php echo $product->id; ?>)"><i class="bi bi-pencil-square"></i> Edit</button>
                        <button class="btn btn-outline-danger btn-sm" onclick="deleteProduct(<?php echo $product->id; ?>)"><i class="bi bi-trash3"></i> Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <?php ?>
    <div class="col-12">
        <div class="placeholder-card">
            <i class="bi bi-search display-4 text-muted"></i>
            <h5 class="mt-3">Produk tidak ditemukan</h5>
            <p class="text-muted">Tidak ada produk yang cocok</p>
        </div>
    </div>
<?php endif; ?>