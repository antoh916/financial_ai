<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cabang extends CI_Controller
    {
        public function __construct()
            {
                parent::__construct();
                $this->load->model('cabang_model');
                $this->log_user->add_log();
                // Tambahkan proteksi halaman
                $url_pengalihan = str_replace('index.php/', '', current_url());
                $pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
                // Ambil check login dari simple_login
                $this->simple_login->check_login($pengalihan);
            }


        public function index()
            {
                // Validasi
                $valid = $this->form_validation;

                $valid->set_rules('nama_cabang','Nama Cabang','required|is_unique[cabang.nama_cabang]',
                    array(	'required'		=> 'Nama cabang harus diisi',
                            'is_unique'		=> 'Nama cabang sudah ada. Buat Nama kategori baru!'));

               

                if($valid->run()===FALSE) {
                // End validasi

                $data = array(	'title'		=> 'Cabang/Cabang',
                                'cabang'   => $this->cabang_model->get_cabang()->order_by('id_cabang','DESC')->get()->result(),
                                'isi'		        => 'admin/cabang/index');
                $this->load->view('admin/layout/wrapper', $data, FALSE);
                // Proses masuk ke database
                }else{
                    $i 	= $this->input;
                    $slug 	= url_title($i->post('nama_cabang'),'dash',TRUE);

                    $data = array(	
                                    
                                    'nama_cabang'	=> $i->post('nama_cabang'),
                                
                                );
                    $this->cabang_model->add_cabang($data);
                    $this->session->set_flashdata('sukses', 'Data telah ditambah');
                    redirect(base_url('admin/cabang'),'refresh');
                }
                // End proses masuk database
            }

        public function edit($id_cabang)	
            {

                // Validasi
                $valid = $this->form_validation;
        
                $valid->set_rules('nama_cabang','Nama Cabang','required',
                    array(	'required'		=> 'Nama cabang harus diisi'));
        
            
        
                if($valid->run()===FALSE) {
                // End validasi
        
                $data = array(	'title'		=> 'Edit Cabang/Cabang',
                                'cabang'	=> $this->cabang_model->get_cabang()->where(array('id_cabang' => $id_cabang))->get()->row(),
                                'isi'		=> 'admin/cabang/edit');
                $this->load->view('admin/layout/wrapper', $data, FALSE);
                // Proses masuk ke database
                }else{
                    $i 	= $this->input;
                    $slug 	= url_title($i->post('nama_cabang'),'dash',TRUE);
        
                    $data = array(	

                                    'nama_cabang'	=> $i->post('nama_cabang'),
                                );
                    $this->cabang_model->update_cabang($id_cabang,$data);
                    $this->session->set_flashdata('sukses', 'Data telah diedit');
                    redirect(base_url('admin/cabang'),'refresh');
                }
                // End proses masuk database
            }

        // Delete user
        public function delete($id_cabang) 
            {
                // Proteksi proses delete harus login
                // Tambahkan proteksi halaman
                $url_pengalihan = str_replace('index.php/', '', current_url());
                $pengalihan 	= $this->session->set_userdata('pengalihan',$url_pengalihan);
                // Ambil check login dari simple_login
                $this->simple_login->check_login($pengalihan);


                $data = array('id_cabang'	=> $id_cabang);
                $this->cabang_model->delete_cabang($id_cabang);
                $this->session->set_flashdata('sukses', 'Data telah dihapus');
                redirect(base_url('admin/cabang'),'refresh');
            }
        
    
    }