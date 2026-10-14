<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Application_form extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Application_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->helper(array('form', 'url'));
    }

    /**
     * Default landing: Redirects to Step 1
     */
    public function index() {
        redirect('application_form/step1');
    }

    /**
     * Step 1: Personal & Contact Information
     */
    public function step1() {
        $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('email', 'Email Address', 'required|trim|valid_email|max_length[100]');
        $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'required|trim|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required|trim');
        $this->form_validation->set_rules('nationality', 'Nationality', 'required|trim');
        $this->form_validation->set_rules('address', 'Current Residential Address', 'required|trim|min_length[10]');
        $this->form_validation->set_rules('willing_to_relocate', 'Willingness to Relocate', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = "Step 1: Personal Details - Job Portal";
            $data['step1_data'] = $this->session->userdata('step1_data');
            $this->load->view('candidate/step1_view', $data);
        } else {
            $step1_data = array(
                'full_name'           => $this->input->post('full_name', TRUE),
                'email'               => $this->input->post('email', TRUE),
                'mobile_number'       => $this->input->post('mobile_number', TRUE),
                'date_of_birth'       => $this->input->post('date_of_birth', TRUE),
                'gender'              => $this->input->post('gender', TRUE),
                'nationality'         => $this->input->post('nationality', TRUE),
                'address'             => $this->input->post('address', TRUE),
                'willing_to_relocate' => $this->input->post('willing_to_relocate', TRUE)
            );
            $this->session->set_userdata('step1_data', $step1_data);
            redirect('application_form/step2');
        }
    }

    /**
     * Step 2: Educational & Professional Qualifications
     */
    public function step2() {
        // Guard: Step 1 must be completed first
        if (!$this->session->userdata('step1_data')) {
            redirect('application_form/step1');
        }

        $this->form_validation->set_rules('highest_qualification', 'Highest Qualification', 'required|trim');
        $this->form_validation->set_rules('institution_name', 'Institution / University', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('graduation_year', 'Year of Graduation', 'required|numeric|exact_length[4]');
        $this->form_validation->set_rules('cgpa_percentage', 'CGPA or Percentage', 'required|trim');
        $this->form_validation->set_rules('technical_skills', 'Technical Skills', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('certifications', 'Certifications', 'trim');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = "Step 2: Educational Qualifications - Job Portal";
            $data['step2_data'] = $this->session->userdata('step2_data');
            $this->load->view('candidate/step2_view', $data);
        } else {
            $step2_data = array(
                'highest_qualification' => $this->input->post('highest_qualification', TRUE),
                'institution_name'      => $this->input->post('institution_name', TRUE),
                'graduation_year'       => $this->input->post('graduation_year', TRUE),
                'cgpa_percentage'       => $this->input->post('cgpa_percentage', TRUE),
                'technical_skills'      => $this->input->post('technical_skills', TRUE),
                'certifications'        => $this->input->post('certifications', TRUE)
            );
            $this->session->set_userdata('step2_data', $step2_data);
            redirect('application_form/step3');
        }
    }

    /**
     * Step 3: Work Experience, Resume Upload, and Final Submission
     */
    public function step3() {
        // Guard: Steps 1 & 2 must be completed
        if (!$this->session->userdata('step1_data')) {
            redirect('application_form/step1');
        }
        if (!$this->session->userdata('step2_data')) {
            redirect('application_form/step2');
        }

        $data['title'] = "Step 3: Work Experience & Resume - Job Portal";
        $data['upload_error'] = '';

        $this->form_validation->set_rules('total_experience', 'Total Experience', 'required|trim');
        $this->form_validation->set_rules('employment_status', 'Employment Status', 'required|trim');
        $this->form_validation->set_rules('previous_organization', 'Previous Organization', 'trim');
        $this->form_validation->set_rules('job_title', 'Job Title', 'trim');
        $this->form_validation->set_rules('skills_summary', 'Skills Summary', 'required|trim|min_length[10]');

        if ($this->input->method() === 'post') {
            if ($this->form_validation->run() === TRUE) {

                // Configure file upload parameters
                $upload_path = FCPATH . 'uploads/resumes/';
                if (!is_dir($upload_path)) {
                    mkdir($upload_path, 0777, TRUE);
                }

                $config['upload_path']   = './uploads/resumes/';
                $config['allowed_types'] = 'pdf|doc|docx';
                $config['max_size']      = 5120; // 5MB max
                $config['encrypt_name']  = TRUE;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('resume')) {
                    $data['upload_error'] = $this->upload->display_errors('<p class="text-danger">', '</p>');
                    $this->load->view('candidate/step3_view', $data);
                    return;
                } else {
                    $upload_data = $this->upload->data();
                    $resume_path = 'uploads/resumes/' . $upload_data['file_name'];

                    // Combine all session and post data for storage
                    $step1 = $this->session->userdata('step1_data');
                    $step2 = $this->session->userdata('step2_data');

                    $final_application = array(
                        // Step 1
                        'full_name'             => $step1['full_name'],
                        'email'                 => $step1['email'],
                        'mobile_number'         => $step1['mobile_number'],
                        'date_of_birth'         => $step1['date_of_birth'],
                        'gender'                => $step1['gender'],
                        'nationality'           => $step1['nationality'],
                        'address'               => $step1['address'],
                        'willing_to_relocate'   => $step1['willing_to_relocate'],
                        // Step 2
                        'highest_qualification' => $step2['highest_qualification'],
                        'institution_name'      => $step2['institution_name'],
                        'graduation_year'       => $step2['graduation_year'],
                        'cgpa_percentage'       => $step2['cgpa_percentage'],
                        'technical_skills'      => $step2['technical_skills'],
                        'certifications'        => $step2['certifications'],
                        // Step 3
                        'total_experience'      => $this->input->post('total_experience', TRUE),
                        'employment_status'     => $this->input->post('employment_status', TRUE),
                        'previous_organization' => $this->input->post('previous_organization', TRUE),
                        'job_title'             => $this->input->post('job_title', TRUE),
                        'skills_summary'        => $this->input->post('skills_summary', TRUE),
                        'resume_file_path'      => $resume_path,
                        'created_at'            => date('Y-m-d H:i:s')
                    );

                    $inserted_id = $this->Application_model->insert_application($final_application);

                    if ($inserted_id) {
                        // Dispatch automated notifications
                        $this->_send_notification_emails($inserted_id, $final_application);

                        // Clear temporary form session variables
                        $this->session->unset_userdata('step1_data');
                        $this->session->unset_userdata('step2_data');

                        $this->session->set_flashdata('success', 'Your application has been submitted successfully! Application ID: #' . $inserted_id);
                        $this->session->set_flashdata('app_id', $inserted_id);
                        redirect('application_form/success');
                    } else {
                        $data['upload_error'] = 'An error occurred while saving your record to the database.';
                    }
                }
            }
        }

        $this->load->view('candidate/step3_view', $data);
    }

    /**
     * Application Success Confirmation Page
     */
    public function success() {
        $data['title'] = "Application Submitted Successfully - Job Portal";
        $data['app_id'] = $this->session->flashdata('app_id');
        $this->load->view('candidate/success_view', $data);
    }

    /**
     * Private helper: Sends automated notification emails
     */
    private function _send_notification_emails($application_id, $application_data) {
        // 1. Send Confirmation Email to Candidate
        $candidate_data = array(
            'application_id' => $application_id,
            'applicant_name' => $application_data['full_name']
        );
        $candidate_html = $this->load->view('emails/applicant_confirmation', $candidate_data, TRUE);

        $this->email->from('noreply@jobportal.com', 'Job Application Portal');
        $this->email->to($application_data['email']);
        $this->email->subject('Application Received - Ref #' . $application_id);
        $this->email->message($candidate_html);
        $this->email->send();

        // Clear headers between dispatches
        $this->email->clear();

        // 2. Send Alert Email to HR Team
        $hr_data = array(
            'application_id'  => $application_id,
            'applicant_name'  => $application_data['full_name'],
            'applicant_email' => $application_data['email'],
            'mobile_number'   => $application_data['mobile_number'],
            'experience'      => $application_data['total_experience'],
            'qualification'   => $application_data['highest_qualification'],
            'skills'          => $application_data['technical_skills']
        );
        $hr_html = $this->load->view('emails/hr_notification', $hr_data, TRUE);

        $this->email->from('noreply@jobportal.com', 'Job Application Portal');
        $this->email->to('hr@jobportal.com');
        $this->email->subject('New Application: ' . $application_data['full_name'] . ' (#' . $application_id . ')');
        $this->email->message($hr_html);
        $this->email->send();
    }
}