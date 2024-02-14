<?php
require_once APPPATH . 'interfaces/LotesDetalleDaoInterface.php';

class LotesDetalle extends CI_Model implements LotesDetalleDaoInterface {

    private $lote_id;
    private $cliente_id;
    private $monto;
    private $estado_periodo_cobro;

    function __construct()
    {
        parent::__construct();
    }

    function get($detalle_id)
    {
        $this->db->where('id', $detalle_id);
        
        $query = $this->db->get('lotes_detalle');
        
        return $query->result();
    }
    

    function create($data)
    {
        try {
            $this->lote_id = $this->security->xss_clean($data['lote_id']);
            $this->cliente_id = $this->security->xss_clean($data['cliente_id']);
            $this->monto = $this->security->xss_clean($data['monto']);
            $this->estado_periodo_cobro = 'generado';
    
            $insert_data = array(
                'lote_id' => $this->lote_id,
                'cliente_id' => $this->cliente_id,
                'monto' => $this->monto,
                'estado_periodo_cobro' => $this->estado_periodo_cobro
            );
    
            return $this->db->insert('lotes_detalle', $insert_data);
        } catch (\Throwable $th) {
            log_message('error', 'Excepción al crear detalle de cobro: ' . $e->getMessage());
            return false;
        }

    }

    function getCantCobrosYmontoTotal($lote_id)
    {
        $monto_total = 0;

        $this->db->where('lote_id', $lote_id);
        $lotes = $this->db->get('lotes_detalle')->result();
        $cant_lotes = count($lotes);
        foreach ($lotes as $l) {
            $monto_total+= $l->monto;
        }
        return ["cant_lotes" => $cant_lotes, "monto_total" => $monto_total];
    }

    function generarCobros($lote_id)
    {
        try {
            $data = array(
                'estado_periodo_cobro' => 'enviado_a_cobrar'
            );
            $this->db->where('lote_id', $lote_id);
            $this->db->update('lotes_detalle', $data);
        
            if ($this->db->affected_rows() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            log_message('error', 'Excepción al generar cobros: ' . $e->getMessage());
            return false;
        }

    }

}