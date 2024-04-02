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
