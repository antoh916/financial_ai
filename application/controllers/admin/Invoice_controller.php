<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load necessary libraries and helpers
        $this->load->helper('url');
        $this->load->library('session');
    }

    /**
     * Process the JSON response from the API
     */
    public function process_data() {
        // This would be your JSON response from the API
        $json_response = '{
            "responseCode": "00",
            "responseMessage": "Success",
            "data": [
                {
                    "id": 1,
                    "invoiceNumber": "INV-V-2023",
                    "orderDate": "2025-03-05",
                    "uploadedAt": "2025-05-08T07:19:28.009432",
                    "status": "WAITING",
                    "uploadedBy": {
                        "username": null
                    },
                    "invoiceDetails": [
                        {
                            "profession": "Application Developer",
                            "salary": "5.400.ooo"
                        },
                        {
                            "profession": "Data Analyst",
                            "salary": "3.745.ooo"
                        },
                        {
                            "profession": "Database Administrator",
                            "salary": "4,900.000"
                        }
                    ]
                }
            ]
        }';
        
        // In a real scenario, you'd get this from your API call
        // $json_response = $this->make_api_call('http://your-api-url', 'GET', [], $token);
        
        // Decode the JSON response
        $response = json_decode($json_response);
        
        // Check if the response was successful
        if ($response && $response->responseCode === "00") {
            // Get the data array
            $invoices = $response->data;
            
            // Process the data - example display code
            $this->display_invoices($invoices);
            
            // Alternatively, you could load a view and pass this data
            // $data['invoices'] = $invoices;
            // $this->load->view('invoices/list', $data);
        } else {
            // Handle error case
            echo "Error processing data: " . ($response ? $response->responseMessage : "Invalid response");
        }
    }
    
    /**
     * Example function to display the invoice data
     */
    private function display_invoices($invoices) {
        echo "<h1>Invoice Data</h1>";
        
        foreach ($invoices as $invoice) {
            echo "<div style='margin-bottom: 30px; border: 1px solid #ccc; padding: 15px;'>";
            echo "<h2>Invoice #" . htmlspecialchars($invoice->invoiceNumber) . "</h2>";
            echo "<p><strong>ID:</strong> " . $invoice->id . "</p>";
            echo "<p><strong>Order Date:</strong> " . $invoice->orderDate . "</p>";
            echo "<p><strong>Uploaded At:</strong> " . $invoice->uploadedAt . "</p>";
            echo "<p><strong>Status:</strong> " . $invoice->status . "</p>";
            echo "<p><strong>Uploaded By:</strong> " . ($invoice->uploadedBy->username ?? 'N/A') . "</p>";
            
            // Display invoice details
            echo "<h3>Invoice Details:</h3>";
            echo "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>";
            echo "<tr><th>Profession</th><th>Salary</th></tr>";
            
            foreach ($invoice->invoiceDetails as $detail) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($detail->profession) . "</td>";
                echo "<td>" . htmlspecialchars($detail->salary) . "</td>";
                echo "</tr>";
            }
            
            echo "</table>";
            echo "</div>";
        }
    }
    
    /**
     * Store the invoice data in session and redirect
     */
    public function store_and_redirect() {
        // This would be your JSON response from the API
        $json_response = '{"responseCode":"00","responseMessage":"Success","data":[{"id":1,"invoiceNumber":"INV-V-2023","orderDate":"2025-03-05","uploadedAt":"2025-05-08T07:19:28.009432","status":"WAITING","uploadedBy":{"username":null},"invoiceDetails":[{"profession":"Application Developer","salary":"5.400.ooo"},{"profession":"Data Analyst","salary":"3.745.ooo"},{"profession":"Database Administrator","salary":"4,900.000"}]}]}';
        
        // Decode the JSON response
        $response = json_decode($json_response);
        
        if ($response && $response->responseCode === "00") {
            // Store the invoice data in session
            $this->session->set_userdata('invoice_data', $response->data);
            
            // Redirect to another page to display the data
            redirect('invoice/display');
        } else {
            // Handle error
            echo "Error processing data";
        }
    }
    
    /**
     * Display invoice data from session
     */
    public function display() {
        // Get invoice data from session
        $invoices = $this->session->userdata('invoice_data');
        
        if ($invoices) {
            // Pass data to view
            $data = array(	'title'			=> 'Payment',
						'invoices'		=> $invoices,
						'isi'			=> 'admin/transaction/list2');
		    $this->load->view('admin/layout/wrapper', $data, FALSE);
        } else {
            echo "No invoice data found";
        }
    }
    
    /**
     * Example of saving invoice data to database
     */
    public function save_to_database() {
        // Load models
        $this->load->model('invoice_model');
        $this->load->model('invoice_detail_model');
        
        // This would be your JSON response from the API
        $json_response = '{"responseCode":"00","responseMessage":"Success","data":[{"id":1,"invoiceNumber":"INV-V-2023","orderDate":"2025-03-05","uploadedAt":"2025-05-08T07:19:28.009432","status":"WAITING","uploadedBy":{"username":null},"invoiceDetails":[{"profession":"Application Developer","salary":"5.400.ooo"},{"profession":"Data Analyst","salary":"3.745.ooo"},{"profession":"Database Administrator","salary":"4,900.000"}]}]}';
        
        // Decode the JSON response
        $response = json_decode($json_response);
        
        if ($response && $response->responseCode === "00") {
            // Begin transaction
            $this->db->trans_begin();
            
            try {
                foreach ($response->data as $invoice_data) {
                    // Format the date from the API
                    $order_date = date('Y-m-d', strtotime($invoice_data->orderDate));
                    $uploaded_at = date('Y-m-d H:i:s', strtotime($invoice_data->uploadedAt));
                    
                    // Prepare invoice data for database
                    $invoice = [
                        'external_id' => $invoice_data->id,
                        'invoice_number' => $invoice_data->invoiceNumber,
                        'order_date' => $order_date,
                        'uploaded_at' => $uploaded_at,
                        'status' => $invoice_data->status,
                        'username' => $invoice_data->uploadedBy->username
                    ];
                    
                    // Insert invoice and get the inserted ID
                    $invoice_id = $this->invoice_model->insert($invoice);
                    
                    // Insert invoice details
                    foreach ($invoice_data->invoiceDetails as $detail) {
                        $detail_data = [
                            'invoice_id' => $invoice_id,
                            'profession' => $detail->profession,
                            'salary' => $detail->salary
                        ];
                        
                        $this->invoice_detail_model->insert($detail_data);
                    }
                }
                
                // Commit the transaction
                $this->db->trans_commit();
                echo "Data saved successfully";
                
            } catch (Exception $e) {
                // Rollback the transaction in case of error
                $this->db->trans_rollback();
                echo "Error saving data: " . $e->getMessage();
            }
        } else {
            echo "Invalid response or error code";
        }
    }
}