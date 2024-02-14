<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/api.php';

class Lote extends Api
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Lotes');
    }

    public function create()
    {
        $result = $this->Lotes->create();
        if ($result) {
            $this->response(["message" => 'Lote creado exitosamente'], 201);
        } else {
            $this->response(["error" => 'Error al crear la suscripción'], 500);
        }
    }
}
