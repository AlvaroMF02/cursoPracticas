<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	// Funcion para cargar el mensaje de inicio
	public function index()
	{
		$this->load->view("includes/header");
		$this->load->view("includes/sidebar");
		$this->load->view("home");
		$this->load->view("includes/footer");

	}

	// Funcion básica
	public function hola()
	{
		// llamadas a las funciones creadas en el modelo

		echo "<h1>Pruebas</h1>";
		// $this->ejemplo_model->insert_Profesor();

		$this->ejemplo_model->update_profe();

		$resultados = $this->ejemplo_model->get_profesores();
		print_r($resultados);
	}
}
