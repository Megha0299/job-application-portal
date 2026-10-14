<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Application_model');
        $this->load->library('session');
        $this->load->helper(array('url', 'download'));
    }

    /**
     * Session protection guard
     */
    private function _check_auth() {
        if (!$this->session->userdata('admin_logged_in')) {
            redirect('admin/login');
        }
    }

    /**
     * Admin login page and auth handler
     */
    public function login() {
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
        }

        $data = array();

        if ($this->input->method() === 'post') {
            $username = trim($this->input->post('username', TRUE));
            $password = trim($this->input->post('password', TRUE));

            $admin = $this->Admin_model->authenticate($username, $password);

            if ($admin) {
                $this->session->set_userdata(array(
                    'admin_id'        => $admin['id'],
                    'admin_username'  => $admin['username'],
                    'admin_logged_in' => TRUE
                ));
                redirect('admin/dashboard');
            } else {
                $data['error'] = 'Invalid username or password.';
            }
        }

        $this->load->view('admin/login_view', $data);
    }

    /**
     * Admin Dashboard with dynamic counters, filters, and status workflow
     */
    public function dashboard() {
        $this->_check_auth();

        $search = $this->input->get('search', TRUE);
        $experience = $this->input->get('experience', TRUE);

        // Fetch applications based on active search/filter
        $data['applications'] = $this->Application_model->get_applications($search, $experience);
        $data['search'] = $search;
        $data['experience'] = $experience;

        // Accurate Dynamic Counters
        $data['total_count'] = $this->db->count_all('job_applications');

        $this->db->where('total_experience', 'Fresher');
        $data['fresher_count'] = $this->db->count_all_results('job_applications');

        $this->db->where('total_experience !=', 'Fresher');
        $data['experienced_count'] = $this->db->count_all_results('job_applications');

        $this->load->view('admin/dashboard_view', $data);
    }

    /**
     * Update candidate status
     */
    public function update_status($id) {
        $this->_check_auth();

        $new_status = $this->input->post('status', TRUE);
        if ($this->Application_model->update_status($id, $new_status)) {
            $this->session->set_flashdata('success', "Application #{$id} status updated to '{$new_status}'.");
        } else {
            $this->session->set_flashdata('error', 'Failed to update application status.');
        }

        redirect('admin/dashboard');
    }

    /**
     * Download applicant resume
     */
    public function download_resume($id = NULL) {
        $this->_check_auth();

        if (!$id) {
            $this->session->set_flashdata('error', 'Invalid application ID.');
            redirect('admin/dashboard');
            return;
        }

        // change 'applications' to 'job_applications'
        $query = $this->db->get_where('job_applications', array('id' => $id));
        $application = $query->row_array();

        if (!$application) {
            $this->session->set_flashdata('error', 'Resume file record not found.');
            redirect('admin/dashboard');
            return;
        }

        $stored_path = !empty($application['resume_file_path']) ? $application['resume_file_path'] : (isset($application['resume_path']) ? $application['resume_path'] : '');

        if (empty($stored_path)) {
            $this->session->set_flashdata('error', 'Resume file record not found.');
            redirect('admin/dashboard');
            return;
        }

        $relative_path = ltrim($stored_path, '/\\');
        $full_path = FCPATH . $relative_path;

        if (!file_exists($full_path) || is_dir($full_path)) {
            $this->session->set_flashdata('error', 'Resume file not found on server.');
            redirect('admin/dashboard');
            return;
        }

        $this->load->helper('download');
        force_download($full_path, NULL);
    }

    /**
     * Delete application record and physical resume file
     */
    public function delete_application($id) {
        $this->_check_auth();

        $application = $this->Application_model->get_application_by_id($id);

        if ($application) {
            if (!empty($application['resume_path'])) {
                $file_path = FCPATH . $application['resume_path'];
                if (file_exists($file_path)) {
                    @unlink($file_path);
                }
            }

            $this->Application_model->delete_application($id);
            $this->session->set_flashdata('success', "Application #{$id} deleted successfully.");
        } else {
            $this->session->set_flashdata('error', 'Application record not found.');
        }

        redirect('admin/dashboard');
    }

    /**
     * Export applicant records to CSV
     */
    public function export_csv() {
        $this->_check_auth();

        $applications = $this->Application_model->get_all_applications();
        $filename = 'candidate_applications_' . date('Ymd_His') . '.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // CSV Header row
        fputcsv($output, array(
            'Ref ID',
            'Full Name',
            'Email',
            'Mobile Number',
            'Date of Birth',
            'Gender',
            'Nationality',
            'Address',
            'Willing to Relocate',
            'Highest Qualification',
            'Institution',
            'Graduation Year',
            'CGPA / %',
            'Technical Skills',
            'Certifications',
            'Total Experience',
            'Employment Status',
            'Previous Organization',
            'Job Title',
            'Skills Summary',
            'Status',
            'Submitted At'
        ));

        // Data rows
        if (!empty($applications)) {
            foreach ($applications as $app) {
                fputcsv($output, array(
                    $app['id'],
                    $app['full_name'],
                    $app['email'],
                    $app['mobile_number'],
                    $app['date_of_birth'],
                    $app['gender'],
                    $app['nationality'],
                    $app['address'],
                    $app['willing_to_relocate'],
                    $app['highest_qualification'],
                    $app['institution_name'],
                    $app['graduation_year'],
                    $app['cgpa_percentage'],
                    $app['technical_skills'],
                    $app['certifications'],
                    $app['total_experience'],
                    $app['employment_status'],
                    $app['previous_organization'],
                    $app['job_title'],
                    $app['skills_summary'],
                    !empty($app['application_status']) ? $app['application_status'] : 'Submitted',
                    $app['created_at']
                ));
            }
        }

        fclose($output);
        exit;
    }

    /**
     * Logout handler
     */
    public function logout() {
        $this->session->unset_userdata(array('admin_id', 'admin_username', 'admin_logged_in'));
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}