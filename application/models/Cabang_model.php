<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Cabang_model extends CI_Model 
        {
            private $tbl_cabang = "cabang";


            # add cabang 
            public function add_cabang($data = [])
                {
                    return $this->db->insert($this->tbl_cabang, $data);
                }

            # get cabang
            public function get_cabang()
                {
                    return $this->db->select('*')
                        ->from($this->tbl_cabang);
                }

            # update cabang
            public function update_cabang($id, $data = array())
                {
                    return $this->db->where(array(
                        'id_cabang'   => $id,
                    ))->update($this->tbl_cabang, $data);
                }

            # delete cabang
            public function delete_cabang($id)
                {
                    return $this->db->where(array(
                        'id_cabang'   => $id,
                    ))->delete($this->tbl_cabang);
                }
        }