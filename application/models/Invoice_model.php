<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_model extends CI_Model {

    protected $table = 'invoices';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * Insert a new invoice record
     * 
     * @param array $data Invoice data
     * @return int Inserted ID
     */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    /**
     * Get invoice by ID
     * 
     * @param int $id Invoice ID
     * @return object Invoice data
     */
    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }
    
    /**
     * Get all invoices with their details
     * 
     * @return array Invoice data with details
     */
    public function get_all_with_details() {
        $this->db->select('i.*, id.profession, id.salary');
        $this->db->from($this->table . ' AS i');
        $this->db->join('invoice_details AS id', 'i.id = id.invoice_id', 'left');
        $query = $this->db->get();
        
        // Group results by invoice
        $result = [];
        foreach ($query->result() as $row) {
            if (!isset($result[$row->id])) {
                $result[$row->id] = [
                    'id' => $row->id,
                    'external_id' => $row->external_id,
                    'invoice_number' => $row->invoice_number,
                    'order_date' => $row->order_date,
                    'uploaded_at' => $row->uploaded_at,
                    'status' => $row->status,
                    'username' => $row->username,
                    'details' => []
                ];
            }
            
            $result[$row->id]['details'][] = [
                'profession' => $row->profession,
                'salary' => $row->salary
            ];
        }
        
        return array_values($result);
    }
}