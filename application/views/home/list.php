

<!-- About  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo base_url('assets/css/home.css') ?>">
<div class="container my-5">
    <div class="row">

        <div class="col-md-12">


            <ul class="nav nav-pills nav-fill">
                <li class="nav-item mx-2">
                    <a href="<?= base_url(); ?>" class="nav-link btn" style="background-color:#0d3c3f;color:white;font-size: 1rem;font-weight:bold;" aria-current="page" >Home</a>
                </li>

                <?php foreach($kategori_barang as $kb): ?>
                    <li class="nav-item mx-2">
                        <a class="nav-link non-active" aria-current="page" href="<?= base_url('kategori_barang/kategori/'.$kb->id_kategori); ?>" style="background-color:#e7e5e5;color:black;font-size: 1rem;font-weight:bold;"><?= $kb->nama_kategori ?></a>
                    </li>
                    
                <?php endforeach; ?>
            
            </ul>
        </div>
        <br><br><br><br>
      
        <!-- slider -->
        <?php include('slider.php'); ?>
        <!-- slider -->
        
        <!-- Produk -->
        <div class="col-md-12 mt-4">
            <div class="row">

                    
                <?php 
                    $rekap_barang   = array();
                    $list_kategori    = array();
                ?>
                <?php foreach($barang as $product): ?>

                    <?php 
                        if(!in_array($product->id_kategori, $list_kategori))
                            {
                                array_push( $list_kategori,$product->id_kategori);

                                $rekap_barang[$product->id_kategori]['jumlah'] = 0;
                    ?>
                                <div class="col-md-12">
                                    <div class="col-md-6 text-left">
                                        <span style="font-size: 16px; color:black; font-weight:bold;"><?= $product->nama_kategori; ?></span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <a href="<?= base_url('kategori_barang/kategori/'.$product->id_kategori); ?>" style="font-size: 16px; color:#0d3c3f; font-weight:bold;" >view all <span style="color:#0d3c3f;"> > </span></a>
                                    </div>
                                    
                                </div>

                                <div class="col-md-3 mb-4 mt-4 card-product card-product-<?= $product->id_kategori; ?>">
                                    <div class="card product-card h-100" >
                                        <a href="<?= base_url('product/detail/'.$product->id_barang); ?>">

                                            <img src="<?php echo base_url('assets/upload/barang/' . $product->gambar) ?>" class="card-img-top" alt="<?= $product->nama_barang ?>">
                                        </a>
                                        <div class="card-body">
                                            <a href="<?= base_url('product/detail/'.$product->id_barang); ?>" style="color:black;">

                                                <h5 class="card-title"><?= $product->nama_barang; ?></h5>
                                                <p class="card-text"><?= $product->deskripsi; ?></p>
                                                <p class="product-price">Rp. <?= number_format($product->harga,0,",","."); ?> / day</p>
                                            </a>
                                        </div>
                                        <div class="card-footer text-center" style="padding:0px !important; height:40px !important;">
                                            <button class="btn btn-add-to-cart" style="height:40px;" onclick="add_to_cart('<?= $product->id_barang; ?>')"><i class="bi bi-cart-fill"></i> Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                    <?php
                                 $rekap_barang[$product->id_kategori]['jumlah'] += 1;

                            }
                        else 
                            {
                                if($rekap_barang[$product->id_kategori]['jumlah'] < 4)
                                    {
                    ?>

                                        <div class="col-md-3 mb-4 mt-4 card-product card-product-<?= $product->id_kategori; ?>">
                                            <div class="card product-card h-100">
                                                <a href="<?= base_url('product/detail/'.$product->id_barang); ?>">

                                                <img src="<?php echo base_url('assets/upload/barang/' . $product->gambar) ?>" class="card-img-top" alt="<?= $product->nama_barang ?>">
                                                </a>
                                                <div class="card-body">
                                                    <a href="<?= base_url('product/detail/'.$product->id_barang); ?>" style="color:black;">

                                                        <h5 class="card-title"><?= $product->nama_barang; ?></h5>
                                                        <p class="card-text"><?= $product->deskripsi; ?></p>
                                                        <p class="product-price">Rp. <?= number_format($product->harga,0,",","."); ?> / day</p>
                                                    </a>
                                                </div>
                                                <div class="card-footer text-center" style="padding:0px !important; height:40px !important;">
                                                    <button class="btn btn-add-to-cart" style="height:40px;" onclick="add_to_cart('<?= $product->id_barang; ?>')"><i class="bi bi-cart-fill"></i> Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                    <?php
                                        $rekap_barang[$product->id_kategori]['jumlah'] += 1;
                                    }
                            }
                    ?>
                    
                <?php endforeach; ?>
                <?php 
                    include('testimonial.php');
                    include('berita.php');
                    include('layanan.php');
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    function filter_kategori(id_kategori){
        
        $(".card-product").hide();


        $(".card-product-"+id_kategori).show();
    }

    function add_to_cart(id_barang){
        $.ajax({
            url:"<?= base_url('barang/add_cart') ?>",
            type:"POST",
            data:{id_barang: id_barang},
            dataType:"JSON",
            success:function(res){
                // console.log(res);

                $("#cart-info").html(res.total_item+" Items - Rp. "+res.total_harga.toLocaleString().replace(",", ".").replace(",", ".")+" /days");
            }
        });
    }


    $(document).ready(function(){
    
    });
</script>

<script src="<?= base_url('assets/js/slider.js') ?>"></script>
<!-- end About -->