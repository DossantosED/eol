<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        echo "API REST en CodeIgniter 2.2";
    }

    protected function response($data, $status = 200)
    {
        // Establecer el código de estado HTTP
        $this->output->set_status_header($status);
        
        // Establecer el contenido como JSON
        $this->output->set_content_type('application/json; charset=utf-8');
        
        // Codificar los datos a JSON y enviar la respuesta
        $this->output->set_output(json_encode($data));
    }

}
