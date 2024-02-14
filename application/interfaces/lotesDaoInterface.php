<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

interface LotesDaoInterface {
    public function get($cliente_id);
    public function create();
}