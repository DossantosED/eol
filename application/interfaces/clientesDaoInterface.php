<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

interface ClientesDaoInterface {
    public function get($cliente_id);
    public function findAll();
    public function findAllActive();
    public function create($cliente);
}
