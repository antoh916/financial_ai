<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->table = 'faqs';
    }
    
    // Get all active FAQs
    public function get_all_faqs() {
        $this->db->where('is_active', 1);
        $this->db->order_by('order_number', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    // Get FAQs by category
    public function get_faqs_by_category($category) {
        $this->db->where('category', $category);
        $this->db->where('is_active', 1);
        $this->db->order_by('order_number', 'ASC');
        $query = $this->db->get($this->table);
        return $query->result();
    }
    
    // Get a single FAQ by ID
    public function get_faq_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);
        return $query->row();
    }
    
    // Add new FAQ
    public function add_faq($data) {
        return $this->db->insert($this->table, $data);
    }
    
    // Update FAQ
    public function update_faq($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }
    
    // Delete FAQ
    public function delete_faq($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    
    // Get categories for dropdown
    public function get_categories() {
        $this->db->select('DISTINCT(category)');
        $this->db->where('is_active', 1);
        $query = $this->db->get($this->table);
        return $query->result();
    }
}