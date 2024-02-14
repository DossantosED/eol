<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

interface PlanesDaoInterface {
    public function get($plan_id);
}