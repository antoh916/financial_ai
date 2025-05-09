

<!-- About  -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/css/about.css') ?>">
<style>
    #btn-checkout{
        background-color: #0d3c3f;
        color: white;
        padding: 10px 20px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    #btn-checkout:hover{
        background-color: #16666b;
    }

</style>


<div class="container my-5">
    <div class="row">


        <div class="col-md-12">


            <ul class="nav nav-pills nav-fill">
                <li class="nav-item mx-2">
                    <a href="<?= base_url(); ?>" class="nav-link btn" style="background-color:#e7e5e5;color:black;font-size: 1rem;font-weight:bold;" aria-current="page" >Home</a>
                </li>

                <?php foreach($kategori_barang as $kb): ?>
                    <li class="nav-item mx-2">
                        <a class="nav-link non-active" aria-current="page" href="<?= base_url('kategori_barang/kategori/'.$kb->id_kategori); ?>" style="background-color:#e7e5e5;color:black;font-size: 1rem;font-weight:bold;"><?= $kb->nama_kategori ?></a>
                    </li>
                    
                <?php endforeach; ?>
               
            </ul>
        </div>
        <br><br><br><br>
        <!-- Sidebar Kategori -->
        <div class="col-md-7">
            <div class="col-12 p-4">

                <img src="<?php echo base_url('assets/upload/barang/' . $barang->gambar) ?>" class="card-img-top" alt="<?= $barang->nama_barang ?>" style="height: 600px" >
            </div>
        </div>

        <!-- Produk -->
        <div class="col-md-5">
            <div class="row">

                    <div class="col-12">
 
                        <div class="col-12" style="margin-top: 4rem;">
                            <h1><?= $barang->nama_barang; ?></h1>
                        </div>

                        <div class="col-12" style="margin-top: 3rem;">
                            <p><?= $barang->deskripsi; ?></p>
                        </div>
                        <div class="col-12" style="margin-top: 4rem;">
                            <h2>
                                Rp. <?= number_format($barang->harga,0,",","."); ?> / day
                            </h2>
                        </div>
                        <div class="col-md-12 d-flex justify-content-center p-0" style="margin-top: 5rem;">
                            <button id="btn-checkout"  style="width:100% !important;"  onclick="add_to_cart('<?= $barang->id_barang; ?>')">
                                <span class="col-md-12 text-center" style="font-weight: bold; font-size:18px;">
                                    <i class="fas fa-shopping-cart"></i>&nbsp;&nbsp; Checkout
                                </span>
                            </button>
                        </div>
                    </div>

                
            </div>
        </div>
    </div>
</div>

<script>
    

    function add_to_cart(id_barang){
        $.ajax({
            url:"<?= base_url('barang/add_cart') ?>",
            type:"POST",
            data:{id_barang: id_barang},
            dataType:"JSON",
            success:function(res){
                // console.log(res);

                $("#cart-info").html(res.total_product+" Items - Rp. "+res.total_harga.toLocaleString().replace(",", ".").replace(",", ".")+" /days");
            }
        });
    }


    $(document).ready(function(){
    
    });
</script>

