<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_barang_model extends CI_Model 
    {
        private $tbl_kategori = "kategori_barang";


        # add kategori barang 
        public function add_kategori_barang($data = [])
            {
                return $this->db->insert($this->tbl_kategori, $data);
            }

        # get kategori barang
        public function get_kategori_barang()
            {
                return $this->db->select('*')
                    ->from($this->tbl_kategori);
            }

        # update kategori barang
        public function update_kategori_barang($id, $data = array())
            {
                return $this->db->where(array(
                    'id_kategori'   => $id,
                ))->update($this->tbl_kategori, $data);
            }

        # delete kategori barang
        public function delete_kategori_barang($id)
            {
                return $this->db->where(array(
                    'id_kategori'   => $id,
                ))->delete($this->tbl_kategori);
            }

        
    }