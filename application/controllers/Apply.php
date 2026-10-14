<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apply extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Application_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
    }

    public function index() {
        $data['title'] = 'Job Application Portal';
        $data['upload_error'] = '';
        $data['open_step'] = 1;

        if ($this->input->method() === 'post') {

            // step 1: basic information rules
            $this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|min_length[3]|max_length[150]');
            $this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email|max_length[150]');
            $this->form_validation->set_rules('mobile_number', 'Mobile Number', 'trim|required|numeric|exact_length[10]');
            $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
            $this->form_validation->set_rules('gender', 'Gender', 'trim|required|in_list[Male,Female,Other]');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('nationality', 'Nationality', 'trim|required');
            $this->form_validation->set_rules('willing_to_relocate', 'Willingness to Relocate', 'trim|required|in_list[Yes,No]');

            // step 2: academic information rules
            $this->form_validation->set_rules('highest_qualification', 'Highest Qualification', 'trim|required');
            $this->form_validation->set_rules('institution_name', 'Institution Name', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('graduation_year', 'Year of Graduation', 'trim|required|numeric|exact_length[4]');
            $this->form_validation->set_rules('cgpa_percentage', 'CGPA / Percentage', 'trim|required|max_length[10]');

            // skills validation: checks checkboxes or other skills input
            $checked_skills = $this->input->post('technical_skills');
            if (empty($checked_skills)) {
                $checked_skills = $this->input->post('skills');
            }
            $other_skills = trim((string)$this->input->post('other_skills'));

            if (empty($checked_skills) && empty($other_skills)) {
                $this->form_validation->set_rules('technical_skills[]', 'Technical Skills', 'required');
            }

            // step 3: experience & declaration rules
            $this->form_validation->set_rules('total_experience', 'Total Work Experience', 'trim|required');
            $this->form_validation->set_rules('employment_status', 'Employment Status', 'trim|required|in_list[Employed,Unemployed,Notice Period,Student/Fresher]');
            $this->form_validation->set_rules('skills_summary', 'Skills Summary', 'trim|required');
            $this->form_validation->set_rules('declaration_acceptance', 'Declaration Acceptance', 'required');

            // check resume file presence
            $resume_field = isset($_FILES['resume']) ? 'resume' : 'resume_file';
            $resume_missing = empty($_FILES[$resume_field]['name']);

            $validation_success = $this->form_validation->run();

            // if validation or resume check fails, stay on the relevant step
            if ($validation_success === FALSE || $resume_missing) {
                if (form_error('total_experience') || form_error('employment_status') || form_error('skills_summary') || form_error('declaration_acceptance') || $resume_missing) {
                    $data['open_step'] = 3;
                } elseif (form_error('highest_qualification') || form_error('institution_name') || form_error('graduation_year') || form_error('cgpa_percentage') || (empty($checked_skills) && empty($other_skills))) {
                    $data['open_step'] = 2;
                } else {
                    $data['open_step'] = 1;
                }

                if ($resume_missing) {
                    $data['upload_error'] = 'Please upload your resume file.';
                }

                $this->load->view('apply_view', $data);
                return;
            }

            // configure file upload preferences
            $config['upload_path']   = './uploads/resumes/';
            $config['allowed_types'] = 'pdf|doc|docx';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = TRUE;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload($resume_field)) {
                $data['open_step'] = 3;
                $data['upload_error'] = $this->upload->display_errors('', '');
                $this->load->view('apply_view', $data);
                return;
            }

            // file upload succeeded
            $upload_data = $this->upload->data();
            $saved_file_path = 'uploads/resumes/' . $upload_data['file_name'];

            // combine checkbox skills and additional text skills
            $all_skills = is_array($checked_skills) ? $checked_skills : array();
            if (!empty($other_skills)) {
                $all_skills[] = $other_skills;
            }
            $skills_string = implode(', ', $all_skills);

            // prepare payload
            $application_data = array(
                'full_name'             => $this->input->post('full_name', TRUE),
                'email'                 => $this->input->post('email', TRUE),
                'mobile_number'         => $this->input->post('mobile_number', TRUE),
                'date_of_birth'         => $this->input->post('date_of_birth', TRUE),
                'gender'                => $this->input->post('gender', TRUE),
                'address'               => $this->input->post('address', TRUE),
                'nationality'           => $this->input->post('nationality', TRUE),
                'willing_to_relocate'   => $this->input->post('willing_to_relocate', TRUE),
                
                'highest_qualification' => $this->input->post('highest_qualification', TRUE),
                'institution_name'      => $this->input->post('institution_name', TRUE),
                'graduation_year'       => $this->input->post('graduation_year', TRUE),
                'cgpa_percentage'       => $this->input->post('cgpa_percentage', TRUE),
                'technical_skills'      => $skills_string,
                'certifications'        => $this->input->post('certifications', TRUE),
                
                'total_experience'      => $this->input->post('total_experience', TRUE),
                'employment_status'     => $this->input->post('employment_status', TRUE),
                'previous_organization' => $this->input->post('previous_organization', TRUE),
                'job_title'             => $this->input->post('job_title', TRUE),
                'skills_summary'        => $this->input->post('skills_summary', TRUE),
                'resume_file_path'      => $saved_file_path,
                'declaration_accepted'  => 1
            );
            $recaptcha_response = $this->input->post('g-recaptcha-response');
$recaptcha_secret   = '6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe';

if (empty($recaptcha_response)) {
    $data['captcha_error'] = 'Please check the I am not a robot box before submitting.';
    $data['open_step'] = 3;
    $this->load->view('apply_view', $data);
    return;
}

$verify_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . urlencode($recaptcha_response);
$response_json = @file_get_contents($verify_url);
$response_data = json_decode($response_json, TRUE);

if (empty($response_data['success']) || $response_data['success'] !== true) {
    $data['captcha_error'] = 'Verification failed. Please try again.';
    $data['open_step'] = 3;
    $this->load->view('apply_view', $data);
    return;
}

            // insert into database
            $insert_id = $this->Application_model->insert_application($application_data);

            if ($insert_id) {
                $this->session->set_flashdata('success', 'Your application has been submitted successfully! Reference ID: #' . $insert_id);
                redirect('apply', 'refresh');
            } else {
                $data['open_step'] = 3;
                $data['server_error'] = 'An error occurred while saving your application. Please try again.';
            }
        }

        $this->load->view('apply_view', $data);
    }
}