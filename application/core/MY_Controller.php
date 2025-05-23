<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    // Controladores exsentos de timeout
    protected $excluded_controllers = ['controlador1', 'controlador2'];

    protected $timeout = 600; //10 minutos de inactividad

    public function __construct() {
        parent::__construct();

        // Obtén el controlador actual
        $current_controller = $this->router->fetch_class();

        // Si el controlador está en la lista de excluidos, no aplicar timeout
        if (in_array($current_controller, $this->excluded_controllers)) {
            return;
        }

        // Control de sesión para timeout
        if ($this->session->userdata('last_activity')) {
            $inactive_time = time() - $this->session->userdata('last_activity');

            if ($inactive_time > $this->timeout) {
                // Timeout excedido: destruir sesión y redirigir al login (o donde quieras)
                $this->session->sess_destroy();
                redirect('login');  // Cambia 'login' por la ruta de tu login
                exit;
            }
        }

        // Actualiza el último tiempo de actividad
        $this->session->set_userdata('last_activity', time());
    }
}
