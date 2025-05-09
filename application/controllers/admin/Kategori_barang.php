<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_barang extends CI_Controller
    {
        public function __construct()
            {
                parent::__construct();
                $this->load->model('kategori_barang_model');
                $this->log_user->add_log();
                // Tambahkan proteksi halaman
                $url_pengalihan = str_replace('index.php/', '', current_url());
                $pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
                // Ambil check login dari simple_login
                $this->simple_login->check_login($pengalihan);
            }


        // public function index()
        //     {
        //         $data = array(	
        //                 'title'		=> 'Kategori Barang/Kategori',
		// 				'kategori_barang'   => $this->kategori_barang_model->get_kategori_barang()->order_by('id_kategori','DESC')->get()->result(),
		// 				'isi'		        => 'admin/kategori_barang/index');
        //         $this->load->view('admin/layout/wrapper', $data, FALSE);
        //     }
        public function index()
            {
                // Validasi
                $valid = $this->form_validation;

                $valid->set_rules('nama_kategori','Nama kategori','required|is_unique[kategori_barang.nama_kategori]',
                    array(	'required'		=> 'Nama kategori harus diisi',
                            'is_unique'		=> 'Nama kategori sudah ada. Buat Nama kategori baru!'));

               

                if($valid->run()===FALSE) {
                // End validasi

                $data = array(	'title'		=> 'Kategori Barang/Kategori',
                                'kategori_barang'   => $this->kategori_barang_model->get_kategori_barang()->order_by('id_kategori','DESC')->get()->result(),
                                'isi'		        => 'admin/kategori_barang/index');
                $this->load->view('admin/layout/wrapper', $data, FALSE);
                // Proses masuk ke database
                }else{
                    $i 	= $this->input;
                    $slug 	= url_title($i->post('nama_kategori'),'dash',TRUE);

                    $data = array(	
                                    
                                    'nama_kategori'	=> $i->post('nama_kategori'),
                                
                                );
                    $this->kategori_barang_model->add_kategori_barang($data);
                    $this->session->set_flashdata('sukses', 'Data telah ditambah');
                    redirect(base_url('admin/kategori_barang'),'refresh');
                }
                // End proses masuk database
            }

        public function edit($id_kategori)	
            {

                // Validasi
                $valid = $this->form_validation;
        
                $valid->set_rules('nama_kategori','Nama kategori','required',
                    array(	'required'		=> 'Nama kategori harus diisi'));
        
            
        
                if($valid->run()===FALSE) {
                // End validasi
        
                $data = array(	'title'		=> 'Edit Kategori Barang/Kategori',
                                'kategori'	=> $this->kategori_barang_model->get_kategori_barang()->where(array('id_kategori' => $id_kategori))->get()->row(),
                                'isi'		=> 'admin/kategori_barang/edit');
                $this->load->view('admin/layout/wrapper', $data, FALSE);
                // Proses masuk ke database
                }else{
                    $i 	= $this->input;
                    $slug 	= url_title($i->post('nama_kategori'),'dash',TRUE);
        
                    $data = array(	

                                    'nama_kategori'	=> $i->post('nama_kategori'),
                                );
                    $this->kategori_barang_model->update_kategori_barang($id_kategori,$data);
                    $this->session->set_flashdata('sukses', 'Data telah diedit');
                    redirect(base_url('admin/kategori_barang'),'refresh');
                }
                // End proses masuk database
            }

        // Delete user
        public function delete($id_kategori) 
            {
                // Proteksi proses delete harus login
                // Tambahkan proteksi halaman
                $url_pengalihan = str_replace('index.php/', '', current_url());
                $pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
                // Ambil check login dari simple_login
                $this->simple_login->check_login($pengalihan);


                $data = array('id_kategori'	=> $id_kategori);
                $this->kategori_barang_model->delete_kategori_barang($id_kategori);
                $this->session->set_flashdata('sukses', 'Data telah dihapus');
                redirect(base_url('admin/kategori_barang'),'refresh');
            }
        
    
    }