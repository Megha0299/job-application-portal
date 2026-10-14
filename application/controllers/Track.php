<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Track extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index() {
        $data['title'] = 'Track Application Status';
        $data['application'] = NULL;
        $data['error'] = '';

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('ref_id', 'Reference ID', 'trim|required|numeric');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

            if ($this->form_validation->run() === TRUE) {
                $ref_id = $this->input->post('ref_id', TRUE);
                $email = $this->input->post('email', TRUE);

                // fetch applicant by reference id and email
                $query = $this->db->get_where('job_applications', array(
                    'id' => $ref_id,
                    'email' => $email
                ));
                $result = $query->row_array();

                if ($result) {
                    $data['application'] = $result;
                } else {
                    $data['error'] = 'No matching application found for the provided Reference ID and Email.';
                }
            } else {
                $data['error'] = validation_errors();
            }
        }

        $this->load->view('track_view', $data);
    }
}