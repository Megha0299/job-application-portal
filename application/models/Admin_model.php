<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Authenticate admin username and password
     */
    public function authenticate($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('admins');

        if ($query->num_rows() === 1) {
            $admin = $query->row_array();

            // supports both plain text or password_hash
            if ($password === $admin['password'] || password_verify($password, $admin['password'])) {
                return $admin;
            }
        }

        return FALSE;
    }
}