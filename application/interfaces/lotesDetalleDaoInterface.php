<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

interface lotesDetalleDaoInterface {
    public function get($lote_id);
    public function create($lote);
    public function getCantCobrosYmontoTotal($lote_id);
    public function generarCobros($lote_id);
}