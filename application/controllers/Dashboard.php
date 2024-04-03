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
				$usuario["curso"] = $login[0]->curso;
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

	public function loadViews($view, $data = null)
	{
		// Si la sesión esta iniciada
		if (isset($_SESSION["username"])) {

			// Para dejar de estar en la funcion login ( lo quita de la url, te manda a dashboard )
			if ($view == "login") {
				redirect(base_url() . "Dashboard", "location");
			}

			// cargar vistas index
			$this->load->view("includes/header");
			$this->load->view("includes/sidebar");
			$this->load->view($view, $data);
			$this->load->view("includes/footer");
		} else {
			if ($view == "login") {
				$this->load->view($view);
			} else {
				redirect(base_url() . "Dashboard/login", "location");
			}
		}
	}

	// llama a la funcion del modelo para edita un alumno y poner el deleted a true
	public function eliminarAlumno()
	{
		if ($_POST["idAlumno"]) {
			$this->ejemplo_model->delete_Alumno($_POST["idAlumno"]);
		}
	}

	// Crea tareas
	public function crearTareas()
	{
		$this->loadViews("crearTareas");

		// si se ejecuta el formulario
		if ($_POST) {

			if ($_FILES["archivo"]) {
				$config['upload_path']          = './uploads/';
				$config['allowed_types']        = 'gif|jpeg|png';
				// $config['max_size']             = 100;
				// $config['max_width']            = 1024;
				// $config['max_height']           = 768;

				if ($_FILES["archivo"]["name"] == "") {
					$config["file_name"] = "";
				} else {
					$config["file_name"] = uniqid() . $_FILES["archivo"]["name"];	// id unico mas el nombre del archivo
				}


				$this->load->library('upload', $config);


				// si se ha subido llamo a la funcion del modelo
				$this->ejemplo_model->subirTarea($_POST, $config["file_name"]);
			} else {
				// subida pero sin archivo
				$this->ejemplo_model->subirTarea($_POST);
			}
		}
	}

	public function gestionAlumnos()
	{
		// Si no eres profesor te manda a home 
		if ($_SESSION["tipo"] == "profesor") {
			// las variables que se pasan a vistas se guardan en arrays
			$data["alumnos"] = $this->ejemplo_model->get_alumnos($_SESSION["curso"]); // despues se llama por alumnos

			$this->loadViews("gestionAlumnos", $data);
		} else {
			redirect(base_url() . "Dashboard", "location");
		}
	}

	public function misTareas()
	{

		if ($_SESSION["id"]) {

			$data["tareas"] = $this->ejemplo_model->mis_tareas($_SESSION["curso"]);
			$this->loadViews("misTareas", $data);
		} else {
			redirect(base_url() . "Dashboard", "location");
		}
	}


	// Mensajes
	public function mensajes()
	{

		if ($_SESSION["id"]) {

			// Insertar mensaje
			if ($_POST) {
				$token = $this->ejemplo_model->get_token($_SESSION["id"],$_SESSION["tipo"]);
				$this->ejemplo_model->insertar_mensaje($_POST, $token);
			}
			// Obtener a los usuarios
			$data["usuarios"] = $this->ejemplo_model->get_usuarios($_SESSION["tipo"], $_SESSION["curso"]);

			// Obtener los mensajes
			$token = $this->ejemplo_model->get_token($_SESSION["id"],$_SESSION["tipo"]);
			$data["mensajes"] = $this->ejemplo_model->get_mensajes($token);

			$this->loadViews("mensajes", $data);
		} else {
			redirect(base_url() . "Dashboard", "location");
		}
	}
}
