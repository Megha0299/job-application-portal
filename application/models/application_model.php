<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Insert a complete job application record into MySQL
     */
    public function insert_application($data) {
        $insert = $this->db->insert('job_applications', $data);
        if ($insert) {
            return $this->db->insert_id();
        }
        return FALSE;
    }

    /**
     * Retrieve all applications with optional search and experience filter
     */
    public function get_applications($search = '', $experience_filter = '') {
        $this->db->order_by('created_at', 'DESC');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('full_name', $search);
            $this->db->or_like('email', $search);
            $this->db->or_like('highest_qualification', $search);
            $this->db->or_like('technical_skills', $search);
            $this->db->group_end();
        }

        if (!empty($experience_filter)) {
            $this->db->where('total_experience', $experience_filter);
        }

        $query = $this->db->get('job_applications');
        return $query->result_array();
    }

    /**
     * Get a single application by its primary key ID
     */
    public function get_application_by_id($id) {
        $query = $this->db->get_where('job_applications', array('id' => (int)$id));
        return $query->row_array();
    }

    /**
     * Metrics for Dashboard Top Cards
     */
    public function get_metrics() {
        $total = $this->db->count_all('job_applications');

        $this->db->where('total_experience', 'Fresher');
        $freshers = $this->db->count_all_results('job_applications');

        $experienced = $total - $freshers;

        return array(
            'total'       => $total,
            'freshers'    => $freshers,
            'experienced' => $experienced
        );
    }

    /**
     * Delete an application and clean up its resume file
     */
    public function delete_application($id) {
        // Fetch candidate data to find the resume path
        $app = $this->get_application_by_id($id);

        if ($app) {
            // Delete the physical file from uploads folder if it exists
            if (!empty($app['resume_file_path'])) {
                $file_path = FCPATH . $app['resume_file_path'];
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }

            // Delete the record from MySQL database
            $this->db->where('id', (int)$id);
            return $this->db->delete('job_applications');
        }

        return FALSE;
    }
    /**
     * Retrieve all applications ordered from newest to oldest for CSV export
     */
    public function get_all_applications() {
        $this->db->order_by('created_at', 'DESC');
        $query = $this->db->get('job_applications');
        return $query->result_array();
    }

    /**
     * Update candidate application status
     */
    public function update_status($id, $status) {
        $allowed = array('Submitted', 'Under Review', 'Shortlisted', 'Rejected');
        if (!in_array($status, $allowed)) {
            return FALSE;
        }
        $this->db->where('id', $id);
        return $this->db->update('job_applications', array('application_status' => $status));
    }

    /**
     * Get summary counts by status for badges & Chart.js
     */
    public function get_status_counts() {
        $query = $this->db->select('application_status, COUNT(*) as count')
                          ->group_by('application_status')
                          ->get('job_applications');
        return $query->result_array();
    }
}