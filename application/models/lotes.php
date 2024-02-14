<?php
require_once APPPATH . 'interfaces/LotesDaoInterface.php';

class Lotes extends CI_Model implements LotesDaoInterface {

    private $fecha_generacion;
    private $fecha_envio;
    private $estado;

    function __construct()
    {
        parent::__construct();
    }

    function get($lote_id)
    {
        $this->db->where('id', $lote_id);
        return $this->db->get('lotes_cobro')->result();
    }

    function create()
    {
        try {
            $timestamp = time();
            $fecha_generacion = date('Y-m-d H:i:s', $timestamp);
            $this->fecha_generacion = $fecha_generacion;
            $this->estado = "generado";
            $insert_data = array(
                'fecha_generacion' => date($this->fecha_generacion),
                'estado' => $this->estado
            );
            return $this->db->insert('lotes_cobro', $insert_data);
        } catch (\Throwable $th) {
            log_message('error', 'Excepción al crear lote: ' . $e->getMessage());
            return false;
        }
        
    }

}