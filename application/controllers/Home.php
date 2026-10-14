<?php

class Home extends CI_Controller
{
    public function index()
    {
    $data['name'] = 'Megha';
    $data['course'] = 'Data Science';

    $this->load->view('home', $data);
    }
      public function about()
    {
        echo "This is the About page.";
    }
}