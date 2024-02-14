<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/api.php';

class Cliente extends Api
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('validation');
        $this->load->model('Clientes');
        $this->load->model('Planes');
        $this->load->library('TipoCobro');
    }

    public function all()
    {
        $suscripciones = $this->Clientes->findAll();
        $suscripcionesResource = $this->setResource($suscripciones);
        $this->response($suscripcionesResource);
    }

    public function active()
    {
        $suscripciones = $this->Clientes->findAllActive();
        if (count($suscripciones) == 0) {
            $this->response(["message" =>'No hay suscripciones activas'], 200);
            return;
        }
        $suscripcionesResource = $this->setResource($suscripciones);
        $this->response($suscripcionesResource);
    }

    public function create()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $_POST = $data;

        $this->form_validation->set_rules('nombre_barrio_edificio', 'Nombre del Edificio', 'required');
        $this->form_validation->set_rules('email_contacto', 'Email de Contacto', 'required|valid_email');
        $this->form_validation->set_rules('tipo_cobro', 'Tipo de Cobro', 'required');
        $this->form_validation->set_rules('plan_id', 'Plan', 'required');
        $this->form_validation->set_message('required', 'El %s es requerido.');
        $this->form_validation->set_message('valid_email', 'El %s debe contener una dirección de email válida.');

        if ($this->form_validation->run() == false) {
            $errors = getFormValidationErrors(['nombre_barrio_edificio','email_contacto','tipo_cobro','plan_id']);
            $this->response(['error' => 'Corrija los errores:', 'detalles' => $errors], 400);
            return;
        }

        // Validar si el plan existe
        $plan = $this->Planes->get($data['plan_id']);
        if (count($plan) == 0) {
            $this->response(["error" => 'El plan no existe'], 404);
            return;
        }

        if (!TipoCobro::isValid($data['tipo_cobro'])) {
            $this->response(["error" =>'Tipo de cobro inválido'], 400);
            return;
        }
        // Si el plan existe, proceder con la creación
        $result = $this->Clientes->create($data);
        if ($result) {
            $this->response(["message" => 'Suscripción creada exitosamente'], 201);
        } else {
            $this->response(["error" => 'Error al crear la suscripción'], 500);
        }
    }

    private function setResource($data)
    {
        $final = array();
        foreach ($data as $d) {
            $final[] = array(
                'id' => $d->id,
                'nombre_barrio_edificio' => $d->nombre_barrio_edificio,
                'email_contacto' => $d->email_contacto,
                'tipo_cobro' => $d->tipo_cobro,
                'plan' => array(
                    'nombre' => $d->nombre_plan,
                    'costo_mensual' => $d->plan_costo
                ),
                'estado_suscripcion' => $d->estado_suscripcion,
                'fecha_creacion' => $d->fecha_creacion
            );
        }
        return $final;
    }
}
