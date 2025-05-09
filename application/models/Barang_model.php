<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang_model extends CI_Model 
    {
        private $tbl_barang     = "barang";
        private $tbl_kategori   = "kategori_barang";


        # add kategori barang 
        public function add_barang($data = [])
            {
                return $this->db->insert($this->tbl_barang, $data);
            }

        # get kategori barang
        public function get_barang()
            {
                return $this->db->select('*')
                    ->from($this->tbl_barang);
            }
        # get kategori barang detail
        public function get_barang_detail()
            {
                return $this->db->select('*')
                    ->from($this->tbl_barang." a")
                    ->join($this->tbl_kategori." b","a.id_kategori = b.id_kategori","left");
            }

        # update kategori barang
        public function update_barang($id, $data = array())
            {
                return $this->db->where(array(
                    'id_barang'   => $id,
                ))->update($this->tbl_barang, $data);
            }

        # delete kategori barang
        public function delete_barang($id)
            {
                return $this->db->where(array(
                    'id_barang'   => $id,
                ))->delete($this->tbl_barang);
            }

        
    }