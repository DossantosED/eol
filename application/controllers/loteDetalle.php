<?php defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . 'controllers/api.php';

class LoteDetalle extends Api
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('lotesDetalle');
        $this->load->model('Clientes');
        $this->load->model('Lotes');
    }

    public function getDetalle($detalle_id)
    {
        $detalle = $this->lotesDetalle->get($detalle_id);
        if (count($detalle) == 0) {
            $this->response('El detalle no existe', 404);
            return;
        }
        $this->response($detalle);
    }

    public function create()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);
        $_POST = $data;

        $this->form_validation->set_rules('lote_id', 'Lote', 'required');
        $this->form_validation->set_rules('cliente_id', 'Cliente', 'required');
        $this->form_validation->set_rules('monto', 'Monto', 'required');

        $this->form_validation->set_message('required', 'El %s es requerido.');

        if ($this->form_validation->run() == false) {
            $this->response(validation_errors(), 500);
            return;
        }

        // Validar si el cliente existe
        $cliente = $this->Clientes->get($data['cliente_id']);
        if (count($cliente) == 0) {
            $this->response(["error" => 'El Cliente no existe'], 404);
            return;
        }

        // Validar si el lote existe
        $lote = $this->Lotes->get($data['cliente_id']);
        if (count($lote) == 0) {
            $this->response(["error" =>'El Lote no existe'], 404);
            return;
        }

        $result = $this->lotesDetalle->create($data);
        if ($result) {
            $this->response(["message" => 'Detalle de cobro creada exitosamente'], 201);
        } else {
            $this->response(["error" =>'Error al crear la suscripción'], 500);
        }
    }

    public function getCantCobrosYmontoTotal($lote_id)
    {
        $lote = $this->lotesDetalle->getCantCobrosYmontoTotal($lote_id);
        $monto_total = $lote['monto_total'];
        $cant_lotes = $lote['cant_lotes'];
        if ($cant_lotes == 0) {
            $this->response(["error" =>'No se encontaron cobros para el lote dado'], 200);
            return;
        }
        $this->response(["cantidad de cobros" => $cant_lotes, "monto total" => $monto_total]);
    }

    function generarCobros($lote_id)
    {
        $generado = $this->lotesDetalle->generarCobros($lote_id);
        if (!$generado) {
            $this->response(["error" =>'No se pudo generar los cobros para el lote seleccionado'], 200);
            return;
        }
        $this->response(["message" =>"Cobros generados con éxito"]);
    }
}
