<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Make_hash extends CI_Controller {
    public function index() {
        $plain = 'admin123';
        $hash = password_hash($plain, PASSWORD_BCRYPT);
        
        $this->db->where('username', 'admin');
        $this->db->update('admins', array('password' => $hash));
        
        echo "Password updated successfully using your local PHP engine! Hash: " . htmlspecialchars($hash);
    }
}