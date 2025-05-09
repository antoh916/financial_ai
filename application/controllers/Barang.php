<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller
    {
        // Load database
	public function __construct()
        {
            parent::__construct();
            $this->load->model('barang_model');
            $this->load->model('kategori_barang_model');
        }

        // Main page galeri
        public function index()	
            {
                $site 		= $this->konfigurasi_model->listing();
                $kategori 	= $this->galeri_model->kategori();

                // Galeri dan paginasi
                $this->load->library('pagination');
                $config['base_url'] 		= base_url().'barang/index/';
                $config['total_rows'] 		= count($this->galeri_model->total_galeri());
                $config['use_page_numbers'] = TRUE;
                $config['num_links'] 		= 5;
                $config['uri_segment'] 		= 3;
                $config['per_page'] 		= 12;
                $config['first_url'] 		= base_url().'barang/';
                $this->pagination->initialize($config); 
                $page 		= ($this->uri->segment(3)) ? ($this->uri->segment(3) - 1) * $config['per_page'] : 0;
                $galeri 	= $this->galeri_model->galeri($config['per_page'], $page);
                // End paginasi

                $data = array(	'title'		=> 'Galeri - '.$site->namaweb,
                                'deskripsi'	=> 'Galeri - '.$site->namaweb,
                                'keywords'	=> 'Galeri - '.$site->namaweb,
                                'pagin' 	=> $this->pagination->create_links(),
                                'galeri'	=> $galeri,
                                'kategori'	=> $kategori,
                                'isi'		=> 'barang/index');
                $this->load->view('layout/wrapper', $data, FALSE);
            }

        public function add_cart()
            {
                // echo json_encode($this->input->post());exit();

                $id_barang = $this->input->post('id_barang');

                $barang = $this->barang_model->get_barang_detail()
                            ->where(array('a.id_barang' => $id_barang))
                            ->get()->row();

                $cart = $this->session->userdata('cart');

                if($cart == NULL)
                    {
                        $new_cart = array(
                            'product'       => array(),
                            'total_harga'   => 0,
                            'total_product' => 0,
                        
                        );

                        $new_cart['product'][$barang->id_barang] = array(
                            'id_product'    => $barang->id_barang,
                            'nama_barang'   => $barang->nama_barang,
                            'kategori'      => $barang->nama_kategori,
                            'harga'         => $barang->harga,
                            'harga_satuan'  => $barang->harga,
                            'jumlah'        => 1,
                            
                        );

                        $new_cart['total_harga'] += $barang->harga;
                        $new_cart['total_product'] += 1;

                        $this->session->set_userdata('cart', $new_cart);
                    }
                else 
                    {
                        $new_cart = $this->session->userdata('cart');

                        // echo json_encode($new_cart);exit();

                        if(isset($new_cart['product'][$barang->id_barang]))
                            {
                                // echo $new_cart['product'][$barang->id_barang]['harga'];exit();
                                $new_cart['product'][$barang->id_barang]['harga'] += $barang->harga;
                                $new_cart['product'][$barang->id_barang]['jumlah'] += 1;
                                $new_cart['total_harga'] += $barang->harga;
                                $new_cart['total_product'] += 1;
                                $this->session->set_userdata('cart', $new_cart);
                            }
                        else 
                            {

                                $new_cart['product'][$barang->id_barang] = array(
                                    'id_product'    => $barang->id_barang,
                                    'nama_barang'   => $barang->nama_barang,
                                    'kategori'      => $barang->nama_kategori,
                                    'harga'         => $barang->harga,
                                    'jumlah'        => 1,
                                    
                                );
                                $new_cart['total_harga'] += $barang->harga;
                                $new_cart['total_product'] += 1;
                                $this->session->set_userdata('cart', $new_cart);
                            }

                       
                    }

                echo json_encode($this->session->userdata('cart'));
            }
    }
