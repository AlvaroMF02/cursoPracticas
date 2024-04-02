<?php

// modelo de ejemplo copiado de la pagina https://codeigniter.com/userguide3/general/models.html
// recomendable que se llame como el proyecto

class ejemplo_model extends CI_Model
{

    // Dentro pongo las funcions

    // -------------- Inserción --------------
    public function insert_profesor()
    {

        $profesor["nombre"] = "Álvaro";
        $profesor["apellidos"] = "Flores";
        $profesor["curso"] = 2;

        $this->db->insert("profesores", $profesor);
    }

    // -------------- Edición --------------
    public function update_profe()
    {

        $profesor["nombre"] = "Álvaro";
        $profesor["apellidos"] = "Martínez";
        $profesor["curso"] = 5;

        // edita al 1
        $this->db->where("id", 1);
        $this->db->update("profesores", $profesor);
    }

    // -------------- Select --------------
    public function get_profesores()
    {
        $this->db->select("*");
        $this->db->from("profesores");
        // $this->db->where("");

        // obtener consulta generada
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
    public function mis_tareas($curso)
    {
        $this->db->select("*");
        $this->db->from("tareas");
        $this->db->where("curso",$curso);
        $this->db->order_by("fecha_final","ASC");

        $query = $this->db->get();
        // print_r($this->db->last_query());
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    public function get_alumnos($curso)
    {
        $this->db->select("*");
        $this->db->from("alumnos");
        $this->db->where("curso",$curso);
        $this->db->where("deleted",0);

        // obtener consulta generada
        $query = $this->db->get();

        // print_r($this->db->last_query());

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    // -------------- Update --------------
    // no borra, cambia el valor deleted a true
    public function delete_Alumno($id) {
        $actualiza["deleted"] = 1;

        $this->db->where("id",$id);
        $this->db->update("alumnos",$actualiza);
    }

    // -------------- Insert --------------
    public function subirTarea($data,$archivo=null) {
        $tarea["nombre"] = $data["nombre"];
        $tarea["descripcion"] = $data["descripcion"];
        $tarea["fecha_final"] = $data["fecha"];
        $tarea["curso"] = $data["curso"];
        if($archivo != null){
            $tarea["archivo"] = $archivo;
        }

        $this->db->insert("tareas",$tarea);
    }


    // -------------- LOGIN --------------
    public function loginUser($data)
    {

        $this->db->select("*");
        $this->db->from("profesores");
        $this->db->where("username", $data["username"]);
        $this->db->where("password", md5($data["password"]));

        $query = $this->db->get();

        if ($query->num_rows() > 0) {              // parte del alumno, si no hay resultado prueba con alumno

            return $query->result();

        } else {

            $this->db->select("*");
            $this->db->from("alumnos");
            $this->db->where("username", $data["username"]);
            $this->db->where("password", md5($data["password"]));

            $queryAlumno = $this->db->get();

            if ($queryAlumno->num_rows() > 0) {
                return $queryAlumno->result(); // $query
            }

            return NULL;
        }
    }
}
