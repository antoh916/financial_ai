<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller
    {
        // Load database
	public function __construct()
        {
            parent::__construct();
            $this->load->model('barang_model');
            $this->load->model('kategori_barang_model');
            $this->load->model('cabang_model');
        }

        // Main page galeri
        public function index()	
            {
                $site 		= $this->konfigurasi_model->listing();

                $kategori_barang 	= $this->kategori_barang_model->get_kategori_barang()->order_by('nama_kategori','ASC')->get()->result();

                // Galeri dan paginasi
                $this->load->library('pagination');
                $config['base_url'] 		= base_url().'cart/index/';
                // $config['total_rows'] 		= count($this->galeri_model->total_galeri());
                $config['use_page_numbers'] = TRUE;
                $config['num_links'] 		= 5;
                $config['uri_segment'] 		= 3;
                $config['per_page'] 		= 12;
                $config['first_url'] 		= base_url().'cart/';
                $this->pagination->initialize($config); 
                $page 		= ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;
                // $galeri 	= $this->galeri_model->galeri($config['per_page'], $page);
                // End paginasi

                $data = array(	'title'		=> 'Galeri - '.$site->namaweb,
                                'deskripsi'	=> 'Galeri - '.$site->namaweb,
                                'keywords'	=> 'Galeri - '.$site->namaweb,
                                'pagin' 	=> $this->pagination->create_links(),
                                // 'galeri'	=> $galeri,
                                'cabang'    => $this->cabang_model->get_cabang()->order_by('nama_cabang','asc')->get()->result(),
                                // 'kategori'	=> $kategori,
                                'kategori_barang'	=> $kategori_barang,
                                'isi'		=> 'cart/index');
                $this->load->view('layout/wrapper', $data, FALSE);
            }

        public function get_cart()
            {
                $cart = $this->session->userdata('cart');
                

                $list_cart  = array();

                if($cart != NULL)
                    {
                        foreach($cart['product'] as $k => $v)
                            {
                                // echo"<pre>";
                                // print_r($v);
                                // echo"</pre>";
                                // exit();
                                // var_dump($v);
                                $barang = $this->barang_model->get_barang_detail()
                                            ->where(array(
                                                'a.id_barang'   => $v['id_product'],
                                            ))->get()->row();

                                $list_cart[] = array(
                                    'id_product'    => $v['id_product'],
                                    'nama_product'  => $barang->nama_barang,
                                    'kategori'      => $barang->nama_kategori,
                                    'harga_satuan'  => $barang->harga,
                                    'gambar'        => $barang->gambar,
                                    'jumlah'        => $v['jumlah'],
                                    'harga_total'   => $v['harga'],
                                );
                            }
                    }
                
                $table = "";

                $table .= "<table class='table table-bordered table-striped'>";

                $table .= "<thead>";

                $table .= "<tr>";

                $table .= "<td align='center'>Foto Gambar</td>";
                $table .= "<td align='center'>Nama Barang</td>";
                $table .= "<td align='center'>Kuantitas</td>";
                $table .= "<td align='center'>Jumlah Harga</td>";
                $table .= "<td align='center'>Aksi</td>";
                
                $table .= "</tr>";
                $table .= "</thead>";

                $table .= "<tbody>";

                $total_item     = 0;
                $total_harga    = 0 ;
                
                foreach($list_cart as $k => $v)
                    {
                        $table .= "<tr>";

                        $table .= '<td align="center" width="10%"><img src="'.base_url('assets/upload/barang/'.$v['gambar']).'" width="100px" height="100px" ></td>';
                        $table .= '<td>'.$v['nama_product'].'</td>';

                        $table .= '<td align="center" width="15%">';
                        $table .= '<div class="input-group mb-3 col-md-6">';
                        $table .= '<button class="input-group-text cart-button col-md-2" style="font-size:16px;font-weight:bold;height:50px;" onclick="tambah_kuantitas(\''.$v['id_product'].'\')">+</button>';
                        $table .= '<input type="number" class="form-control p-2 col-md-4 text-center" style="height:50px;" value="'.$v['jumlah'].'">';
                        $table .= '<button class="input-group-tex cart-button col-md-2" style="font-size:16px;font-weight:bold;height:50px;" onclick="kurang_kuantitas(\''.$v['id_product'].'\')">-</button>';
                        $table .= '</div>';
                        $table .= '</td>';


                        $table .= '<td align="center"> Rp.'. number_format($v['harga_total'],0,",",".").'</td>';
                        $table .= '<td align="center"><button class="cart-button" style="font-size:16px;font-weight:bold;height:50px;" onclick="hapus_cart(\''.$v['id_product'].'\')"><i class="fa fa-trash"></i></button></td>';
                        
                        $table .= "</tr>";

                        $total_item += 1;
                        $total_harga += $v['harga_total'];
        
                    }
                $table .= "</tbody>";

                
                
                $table .= "</table>";

                $res = array(
                    'data_cart'     => $table,
                    'total_item'    => $total_item,
                    'total_harga'   => $total_harga,
                );

                // echo $table;exit();
                echo json_encode($res);

            }

        public function tambah_jumlah()
            {
                $id_barang = $this->input->post('id_barang');

                $barang = $this->barang_model->get_barang_detail()
                                            ->where(array(
                                                'a.id_barang'   => $id_barang,
                                            ))->get()->row();

                $cart =  $this->session->userdata('cart');

                $cart['product'][$id_barang]['jumlah'] += 1;
                $cart['product'][$id_barang]['harga'] += $barang->harga;
                $cart['total_product'] += 1;
                $cart['total_harga'] += $barang->harga;

                $this->session->set_userdata('cart', $cart);

                $res['status'] = "ok";

                echo json_encode($res);
            }

        public function kurang_jumlah()
            {
                $id_barang = $this->input->post('id_barang');

                $barang = $this->barang_model->get_barang_detail()
                                            ->where(array(
                                                'a.id_barang'   => $id_barang,
                                            ))->get()->row();

                $cart =  $this->session->userdata('cart');

                if( $cart['product'][$id_barang]['jumlah'] > 1)
                    {

                        $cart['product'][$id_barang]['jumlah'] -= 1;
                        $cart['product'][$id_barang]['harga'] -= $barang->harga;
                        $cart['total_product'] -= 1;
                        $cart['total_harga'] -= $barang->harga;
        
                        $this->session->set_userdata('cart', $cart);
                    }
                else 
                    {
                        $cart['total_product'] -= 1;
                        $cart['total_harga'] -= $barang->harga;
                        unset( $cart['product'][$id_barang]);
                        $this->session->set_userdata('cart', $cart);
                    }


                $res['status'] = "ok";

                echo json_encode($res);
            }

        public function hapus_cart()
            {
                $id_barang = $this->input->post('id_barang');

                $barang = $this->barang_model->get_barang_detail()
                                            ->where(array(
                                                'a.id_barang'   => $id_barang,
                                            ))->get()->row();

                $cart =  $this->session->userdata('cart');

                $cart['total_product'] -= $cart['product'][$id_barang]['jumlah'];
                $cart['total_harga'] -= $cart['product'][$id_barang]['harga'];
                unset( $cart['product'][$id_barang]);
                $this->session->set_userdata('cart', $cart);


                $res['status'] = "ok";

                echo json_encode($res);
            }

        public function checkout()
            {
                // echo json_encode($this->input->post());exit();
                $res = array(
                    'status'    => 'not-ok',
                );

                $valid = $this->form_validation;
        
                $valid->set_rules('nama_user','User','required',
                    array(	'required'	=> 'Nama User harus diisi'));

                $valid->set_rules('nama_event','Nama Event','required',
                    array(	'required'	=> 'Nama Program / Nama Event harus diisi'));

                $valid->set_rules('tgl_masuk','Tanggal Masuk','required',
                    array(	'required'	=> 'Tanggal masuk harus diisi'));

                $valid->set_rules('tgl_kembali','Tanggal Kembali','required',
                    array(	'required'	=> 'Tanggal Kembali harus diisi'));

                $valid->set_rules('cabang','Cabang','required',
                    array(	'required'	=> 'Cabang Colony harus diisi'));
        
                if($valid->run())
                    {
                        $split_tgl_masuk    = explode("-",$this->input->post('tgl_masuk'));
                        $split_tgl_kembali  = explode("-",$this->input->post('tgl_kembali'));


                        $tgl_awal   = $split_tgl_masuk[2]."-".$split_tgl_masuk[1]."-".$split_tgl_masuk[0];
                        $tgl_akhir  = $split_tgl_kembali[2]."-".$split_tgl_kembali[1]."-".$split_tgl_kembali[0];
                         // or your date as well
                        $awal   = strtotime($tgl_awal);
                        $akhir  = strtotime($tgl_akhir);
                        $datediff = $akhir - $awal;

                        $total_hari =  ceil(($datediff / (60 * 60 * 24)) + 1);


                        $message = "";
                        $message .= "Nama : ".$this->input->post('nama_user')."\n";
                        $message .= "Nama Program / Nama Event : ".$this->input->post('nama_event')."\n";
                        $message .= "Tanggal Masuk : ".$this->input->post('tgl_masuk')."\n";
                        $message .= "Tanggal Kembali : ".$this->input->post('tgl_kembali')."\n";
                        $message .= "Cabang Colony : ".$this->input->post('cabang')."\n";

                        $message .= "Product :\n";

                        $cart = $this->session->userdata('cart');

                        foreach($cart['product'] as $k => $v)
                            {
                                $message .= " -  ".$v['nama_barang']." : ".$v['jumlah']." item , Rp.".number_format($v['harga'],0,",",".")."  \n";

                                
                            }

                            $message .= "\n";
                            $message .= "\n";
                            $message .= "\n";

                            $message .= "Total Item :  ".number_format($cart['total_product'],0,",",".")."  \n";

                            $message .= "Total Harga Per Hari :  Rp.".number_format($cart['total_harga'],0,",",".")." / day  \n";
                            $message .= "Lama Sewa : ".$total_hari." Hari  \n";

                            $harga_keseluruhan = $cart['total_harga'] * $total_hari;
                            $message .= "Total Harga Keseluruhan :  Rp.".number_format($harga_keseluruhan,0,",",".")."  \n";


                            $encode_message = urlencode($message);
                            
                            $no_wa = "+6285880245785";
                            $url = "https://wa.me/".$no_wa."?text=".$encode_message;

                            $res['status']  = "ok";
                            $res['url']     = $url;

                            


                    }
                else 
                    {
                        $res['status'] = "error";
                        $res['error'] = validation_errors();
                    }

                echo json_encode($res);
            }

        
    }
