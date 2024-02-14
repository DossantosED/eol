<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/api.php';

class Plan extends Api
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Planes');
        $this->load->library('form_validation');
    }

    public function get($plan_id)
    {
        $plan = $this->Planes->get($plan_id);
        if (count($plan) == 0) {
            $this->response(["error" =>'El plan no existe'], 404);
            return;
        }
        $this->response($plan);
    }
}
