<?php
require_once APPPATH . 'interfaces/ClientesDaoInterface.php';

class Clientes extends CI_Model implements ClientesDaoInterface {

    private $nombre_barrio_edificio;
    private $email_contacto;
    private $tipo_cobro;
    private $plan_id;
    private $estado_suscripcion;
    private $fecha_creacion;

    function __construct()
    {
        parent::__construct();
    }

    function get($cliente_id)
    {
        $this->db->select('clientes.*, planes.nombre as nombre_plan, planes.costo_mensual as plan_costo');
        $this->db->from('clientes');
        $this->db->join('planes', 'clientes.plan_id = planes.id', 'left');
        $this->db->where('clientes.id', $cliente_id);
        $query = $this->db->get();
        
        return $query->row();
    }
    
    function findAll()
    {
        $this->db->select('clientes.*, planes.nombre as nombre_plan, planes.costo_mensual as plan_costo');
        $this->db->from('clientes');
        $this->db->join('planes', 'clientes.plan_id = planes.id', 'left');
        $query = $this->db->get();
        
        return $query->result();
    }

    function findAllActive()
    {
        $this->db->select('clientes.*, planes.nombre as nombre_plan, planes.costo_mensual as plan_costo');
        $this->db->from('clientes');
        $this->db->join('planes', 'clientes.plan_id = planes.id', 'left');
        $this->db->where('clientes.estado_suscripcion', 'activa');
        $query = $this->db->get();
        
        return $query->result();
    }

    function create($data)
    {
        try {
            // Validar y limpiar los datos antes de insertarlos
            $this->nombre_barrio_edificio = $this->security->xss_clean($data['nombre_barrio_edificio']);
            $this->email_contacto = $this->security->xss_clean($data['email_contacto']);
            $this->tipo_cobro = $this->security->xss_clean($data['tipo_cobro']);
            $this->plan_id = $this->security->xss_clean($data['plan_id']);
            $this->estado_suscripcion = 'activa';
            $this->fecha_creacion = date('Y-m-d H:i:s');

            // Preparar el array de datos
            $insert_data = array(
                'nombre_barrio_edificio' => $this->nombre_barrio_edificio,
                'email_contacto' => $this->email_contacto,
                'tipo_cobro' => $this->tipo_cobro,
                'plan_id' => $this->plan_id,
                'estado_suscripcion' => $this->estado_suscripcion,
                'fecha_creacion' => $this->fecha_creacion,
            );

            return $this->db->insert('clientes', $insert_data);
        } catch (\Throwable $th) {
            log_message('error', 'Excepción al crear cliente: ' . $e->getMessage());
            return false;
        }

    }

}