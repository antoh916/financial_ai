<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller
    {
        public function __construct()
            {
                parent::__construct();
                $this->load->model('barang_model');
                $this->load->model('kategori_barang_model');
                $this->log_user->add_log();
                // Tambahkan proteksi halaman
                $url_pengalihan = str_replace('index.php/', '', current_url());
                $pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
                // Ambil check login dari simple_login
                $this->simple_login->check_login($pengalihan);
            }

        public function index()	
            {
                $barang = $this->barang_model->get_barang_detail()->order_by('a.id_barang','desc')->get()->result();
                $data = array(	'title'			=> 'Barang',
                                'barang'		=> $barang,
                                'isi'			=> 'admin/barang/index');
                $this->load->view('admin/layout/wrapper', $data, FALSE);		
            }

        public function proses()
            {
                
                $site = $this->konfigurasi_model->listing();
                // PROSES HAPUS MULTIPLE
                if(isset($_POST['hapus'])) {
                    $inp 				= $this->input;
                    $id_barang		    = $inp->post('id_barang');
        
                        for($i=0; $i < sizeof($id_barang);$i++) {
                            $galeri 	= $this->barang_model->get_barang_detail()->where(array('id_barang' => $id_barang[$i]))->get()->row();
                            if($galeri->gambar !='') {
                                unlink('./assets/upload/barang/'.$galeri->gambar);
                                // unlink('./assets/upload/barang/'.$galeri->gambar);
                            }
                            // $data = array('id_barang'	=> $id_barang[$i]);
                            $this->barang_model->delete_barang($id_barang[$i]);
                        }
            
                        $this->session->set_flashdata('sukses', 'Data telah dihapus');
                        redirect(base_url('admin/barang'),'refresh');
                    // PROSES SETTING DRAFT
                    }
            }

        // Tambah galeri
        public function tambah()	{
            $kategori_barang = $this->kategori_barang_model->get_kategori_barang()->order_by('id_kategori','DESC')->get()->result();

            // Validasi
            $valid = $this->form_validation;

            $valid->set_rules('nama_barang','Judul','required',
                array(	'required'	=> 'Nama Barang harus diisi'));

            $valid->set_rules('deskripsi','Deskripsi','required',
                array(	'required'	=> 'Deskripsi harus diisi'));

            $valid->set_rules('id_kategori_barang','Kategori','required',
                array(	'required'	=> 'Kategori Barang harus diisi'));

            $valid->set_rules('harga','Harga','required',
                array(	'required'	=> 'Harga harus diisi'));

            if($valid->run()) {
                $config['upload_path']   = './assets/upload/barang/';
                $config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
                $config['max_size']      = '12000'; // KB  
                $this->load->library('upload', $config);
                if(! $this->upload->do_upload('gambar')) {
            // End validasi

                $data = array(	'title'				=> 'Tambah Galeri',
                            'kategori_barang'	=> $kategori_barang,
                            'error'    			=> $this->upload->display_errors(),
                            'isi'				=> 'admin/barang/tambah');

            $this->load->view('admin/layout/wrapper', $data, FALSE);
            // Masuk database
            }else{
                $upload_data        		= array('uploads' =>$this->upload->data());
                // Image Editor
                $config['image_library']  	= 'gd2';
                $config['source_image']   	= './assets/upload/barang'.$upload_data['uploads']['file_name']; 
                $config['new_image']     	= './assets/upload/barang/thumbs/';
                $config['create_thumb']   	= TRUE;
                $config['quality']       	= "100%";
                $config['maintain_ratio']   = TRUE;
                $config['width']       		= 500; // Pixel
                $config['height']       	= 500; // Pixel
                $config['x_axis']       	= 0;
                $config['y_axis']       	= 0;
                $config['thumb_marker']   	= '';
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $i 		= $this->input;

                $data = array(	
                                'id_kategori'       => $i->post('id_kategori_barang'),
                                'add_by'			=> $this->session->userdata('id_user'),
                                'nama_barang'		=> $i->post('nama_barang'),
                                'deskripsi'		    => $i->post('deskripsi'),
                                'harga'		        => $i->post('harga'),
                                'gambar'			=> $upload_data['uploads']['file_name'],
                                );
                $this->barang_model->add_barang($data);
                $this->session->set_flashdata('sukses', 'Data telah ditambah');
                redirect(base_url('admin/barang'),'refresh');
            }}
            // End masuk database
            $data = array(	'title'				=> 'Tambah Barang',
                            'kategori_barang'	=> $kategori_barang,
                            'isi'				=> 'admin/barang/tambah');
            $this->load->view('admin/layout/wrapper', $data, FALSE);		
        }

        public function edit($id_barang)	
            {
                $kategori_barang 	= $this->kategori_barang_model->get_kategori_barang()->order_by('id_kategori','DESC')->get()->result();
                $barang 	        = $this->barang_model->get_barang_detail()->where(array('id_barang' => $id_barang))->order_by('a.id_barang','desc')->get()->row();
        
                // Validasi
                $valid = $this->form_validation;
        
                $valid->set_rules('nama_barang','Judul','required',
                    array(	'required'	=> 'Nama Barang harus diisi'));

                $valid->set_rules('deskripsi','Deskripsi','required',
                    array(	'required'	=> 'Deskripsi harus diisi'));

                $valid->set_rules('id_kategori_barang','Kategori','required',
                    array(	'required'	=> 'Kategori Barang harus diisi'));

                $valid->set_rules('harga','Harga','required',
                    array(	'required'	=> 'Harga harus diisi'));
        
                if($valid->run()) {
        
                    if(!empty($_FILES['gambar']['name'])) {
        
                    $config['upload_path']   = './assets/upload/barang/';
                    $config['allowed_types'] = 'gif|jpg|png|svg|jpeg';
                    $config['max_size']      = '12000'; // KB  
                    $this->load->library('upload', $config);
                    if(! $this->upload->do_upload('gambar')) {
                // End validasi
        
                $data = array(	'title'				=> 'Edit Barang',
                                'kategori_barang'	=> $kategori_barang,
                                'barang'			=> $barang,
                                'error'    			=> $this->upload->display_errors(),
                                'isi'				=> 'admin/barang/edit');
                $this->load->view('admin/layout/wrapper', $data, FALSE);
                // Masuk database
                }else{
                    $upload_data        		= array('uploads' =>$this->upload->data());
                    // Image Editor
                    $config['image_library']  	= 'gd2';
                    $config['source_image']   	= './assets/upload/barang/'.$upload_data['uploads']['file_name']; 
                    $config['new_image']     	= './assets/upload/barang/thumbs/';
                    $config['create_thumb']   	= TRUE;
                    $config['quality']       	= "100%";
                    $config['maintain_ratio']   = TRUE;
                    $config['width']       		= 360; // Pixel
                    $config['height']       	= 360; // Pixel
                    $config['x_axis']       	= 0;
                    $config['y_axis']       	= 0;
                    $config['thumb_marker']   	= '';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();
        
                    // Proses hapus gambar
                    if($barang->gambar != "") {
                        unlink('./assets/upload/barang/'.$barang->gambar);
                        // unlink('./assets/upload/barang/thumbs/'.$galeri->gambar);
                    }
                    // End hapus gambar
        
                    $i 		= $this->input;
        
                    $data = array(	
                        'id_kategori'       => $i->post('id_kategori_barang'),
                        'add_by'			=> $this->session->userdata('id_user'),
                        'nama_barang'		=> $i->post('nama_barang'),
                        'deskripsi'		    => $i->post('deskripsi'),
                        'harga'		        => $i->post('harga'),
                        'gambar'			=> $upload_data['uploads']['file_name'],
                        );
                    $this->barang_model->update_barang($id_barang,$data);
                    
                    $this->session->set_flashdata('sukses', 'Data telah diedit');
                    redirect(base_url('admin/barang'),'refresh');
                }}else{
                    $i 		= $this->input;
        
                    $data = array(	
                        'id_kategori'       => $i->post('id_kategori_barang'),
                        'add_by'			=> $this->session->userdata('id_user'),
                        'nama_barang'		=> $i->post('nama_barang'),
                        'deskripsi'		    => $i->post('deskripsi'),
                        'harga'		        => $i->post('harga'),
                        'gambar'			=> $upload_data['uploads']['file_name'],
                        );
                    $this->barang_model->update_barang($id_barang,$data);
                    $this->session->set_flashdata('sukses', 'Data telah diedit');
                    redirect(base_url('admin/barang'),'refresh');
                }}
                // End masuk database
                $data = array(	'title'				=> 'Edit Barang',
                                'kategori_barang'	=> $kategori_barang,
                                'barang'			=> $barang,
                                'isi'				=> 'admin/barang/edit');
                $this->load->view('admin/layout/wrapper', $data, FALSE);		
            }
        // Delete
	public function delete($id_barang) 
        {
            // Tambahkan proteksi halaman
            $url_pengalihan = str_replace('index.php/', '', current_url());
            $pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
            // Ambil check login dari simple_login
            $this->simple_login->check_login($pengalihan);

            $barang = $this->barang_model->get_barang_detail()->where(array('id_barang' => $id_barang))->order_by('a.id_barang','desc')->get()->row();
            // Proses hapus gambar
            if($barang->gambar=="") {
            }else{
                unlink('./assets/upload/barang/'.$galeri->gambar);
                unlink('./assets/upload/barang/thumbs/'.$galeri->gambar);
            }
            // End hapus gambar
            $data = array('id_barang'	=> $id_barang);
            $this->barang_model->delete_barang($id_barang);
            $this->session->set_flashdata('sukses', 'Data telah dihapus');
            redirect(base_url('admin/barang'),'refresh');
        }

    }