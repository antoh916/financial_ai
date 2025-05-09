<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="<?= base_url('asset/css/sweetalert2.min.css'); ?>">

<style>
    .swal2-confirm{
        background-color: blue !important;
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
        <br><br>
    </div>
</div>
<div class="row">

   
    <form action="#" id="form-cart">

        <div class="col-md-12" style="margin-top: 1rem;">
            <div class="col-md-6">
    
                <div class="form-group form-group-lg">
                    <label>Nama User</label>
                    <input type="text" name="nama_user" id="nama_user" class="form-control" placeholder="Nama User">
                </div>
            </div>
            <div class="col-md-6">
    
                <div class="form-group form-group-lg">
                    <label>Nama Program / Nama Event</label>
                    <input type="text" name="nama_event"  id="nama_event" class="form-control" placeholder="Nama Program / Nama Event">
                </div>
            </div>
        </div>
    
        <div class="col-md-12">
            <div class="col-md-3">
    
                <div class="form-group form-group-lg">
                    <label>Tanggal masuk</label>
                    <input type="text" name="tgl_masuk" class="form-control datepicker" readonly>
                </div>
            </div>
            <div class="col-md-3">
    
                <div class="form-group form-group-lg">
                    <label>Tanggal kembali</label>
                    <input type="text" name="tgl_kembali" class="form-control datepicker" readonly>
                </div>
            </div>
            <div class="col-md-6">
    
                <div class="form-group form-group-lg">
                    <label>Pilih Cabang Colony</label>
                    <select name="cabang" id="cabang" class="form-control" style="padding-top:0px !important;">
                        <option value="" selected>-- Pilih Cabang Colony --</option>
                        <?php foreach($cabang as $cbg): ?>
                            <option value="<?= $cbg->nama_cabang; ?>"><?= $cbg->nama_cabang;?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        
        </div>
    </form>

</div>



<div class="row">

        <div class="col-md-12">
            <div id="row-table" class="col-md-12">
        
            </div>
        
            <br><br><br><br>
        
            <div class="col-md-12 mt-5 mb-10">
                <div class="col-md-4 text-right align-middle">
                   <span style="font-size:16px; font-weight:bold;"> Total</span>
                </div>
                <div class="col-md-4">
                    <input type="text" id="total-harga-cart" class="form-control p-3" style="font-weight: bold; color:black;" readonly>
                </div> 
                <div class="col-md-4">
                   <button class="cart-button" id="btn-checkout-cart">Checkout</button>
                </div>
            </div>
        
           <div class="col-md-12">
            <br><br><br><br><br>
           </div>
        </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


<script>

    function get_cart(){
        $.ajax({
            url:"<?= base_url('cart/get_cart') ?>",
            type:"GET",
            dataType:"JSON",
            success:function(res){
                $("#row-table").html(res.data_cart);

                $("#total-harga-cart").val(res.total_harga.toLocaleString().replace(",", ".").replace(",", "."));

                $("#cart-info").html(res.total_item+" Items - Rp. "+res.total_harga.toLocaleString().replace(",", ".").replace(",", ".")+" /days");
            }
        });
    }

    function tambah_kuantitas(id_barang){
        $.ajax({
            url:"<?= base_url('cart/tambah_jumlah'); ?>",
            type:"POST",
            data:{id_barang:id_barang},
            dataType:"JSON",
            success:function(res){
                get_cart();
            }
        });
    }

    function kurang_kuantitas(id_barang){
        
        $.ajax({
            url:"<?= base_url('cart/kurang_jumlah'); ?>",
            type:"POST",
            data:{id_barang:id_barang},
            dataType:"JSON",
            success:function(res){
                get_cart();
            }
        });
    
    }


    function hapus_cart(id_barang){
        
        $.ajax({
            url:"<?= base_url('cart/hapus_cart'); ?>",
            type:"POST",
            data:{id_barang:id_barang},
            dataType:"JSON",
            success:function(res){
                get_cart();
            }
        });
    
    }
    $(document).ready(function(){

        
        $(".datepicker").datepicker({format:"dd-mm-yyyy"});
        get_cart();

        $("#btn-checkout-cart").click(function(){
            var data = $("#form-cart").serialize();

            $.ajax({
            url:"<?= base_url('cart/checkout'); ?>",
            type:"POST",
            data:data,
            dataType:"JSON",
            success:function(res){
                console.log(res);

                if(res.status == 'ok'){
                    window.open(res.url, '_blank');
                }
                else if(res.status =='error'){
                    var mesage =    '';
                    // swal("Oops...", "tes","warning")
                    Swal.fire({
                        title: "Oops...",
                        html: res.error,
                        icon: "warning"
                    });
                   
                    
                }
            }
        });
        });
    });
</script>