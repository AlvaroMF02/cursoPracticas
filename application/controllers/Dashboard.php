<?php
defined('BASEPATH') or exit('No direct script access allowed');

// Dentro de la clase se ponen las funciones
class Dashboard extends CI_Controller
{

	// Carga toda la página principal ejecutando las vistas
	public function index()
	{
		$this->loadViews("home");
	}

	// Funcionamiento de todo el login
	public function login()
	{
		// Si se han creado los post del login
		if (isset($_POST["username"]) && isset($_POST["password"])) {
			// guarda los datos del usuario que se logea ( tanto profesor como alumno )
			$login = $this->ejemplo_model->loginUser($_POST);	// llamada al modelo en el que compruebo el login

			// si existe el login guarda los datos
			if ($login) {
				$usuario["id"] = $login[0]->id;
				$usuario["nombre"] = $login[0]->nombre;
				$usuario["apellidos"] = $login[0]->apellidos;
				$usuario["username"] = $login[0]->username;
				$usuario["password"] = $login[0]->password;

				// Poner el tipo del usuario
				if (isset($login[0]->es_profesor)) {
					$usuario["tipo"] = "profesor";
				} else if (isset($login[0]->es_alumno)) {
					$usuario["tipo"] = "alumnmo";
				}

				// Crear la seison con los datos guardados
				$this->session->set_userdata($usuario);
				print_r($_SESSION);
			}
		}
		$this->loadViews("login");
	}

	public function loadViews($view,$data=null)
	{
		// Si la sesión esta iniciada
		if (isset($_SESSION["username"])) {

			// Para dejar de estar en la funcion login ( lo quita de la url, te manda a dashboard )
			if($view == "login"){
				redirect(base_url()."Dashboard","location");
			}

			// cargar vistas index
			$this->load->view("includes/header");
			$this->load->view("includes/sidebar");
			$this->load->view("home");
			$this->load->view("includes/footer");

		}else{
			if($view=="login"){
				$this->load->view($view);
			}else{
				redirect(base_url()."Dashboard/login","location");
			}
		}
	}
}
