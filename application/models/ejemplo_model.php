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
        $this->db->where("curso", $curso);
        $this->db->order_by("fecha_final", "ASC");

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
        $this->db->where("curso", $curso);
        $this->db->where("deleted", 0);

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
    public function delete_Alumno($id)
    {
        $actualiza["deleted"] = 1;

        $this->db->where("id", $id);
        $this->db->update("alumnos", $actualiza);
    }

    // -------------- Insert --------------
    public function subirTarea($data, $archivo = null)
    {
        $tarea["nombre"] = $data["nombre"];
        $tarea["descripcion"] = $data["descripcion"];
        $tarea["fecha_final"] = $data["fecha"];
        $tarea["curso"] = $data["curso"];
        if ($archivo != null) {
            $tarea["archivo"] = $archivo;
        }

        $this->db->insert("tareas", $tarea);
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

    // coger todos los usuarios 
    public function get_usuarios($tipo, $curso)
    {
        $this->db->select("*");

        if ($tipo == "profesor") {
            $this->db->from("alumnos");
        } else {
            $this->db->from("profesores");
        }

        $this->db->where("curso", $curso);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }

        return NULL;
    }

    // guardar los mensajes que se envian
    public function insertar_mensaje($data, $idUser)
    {
        $mensaje["texto"] = $data["mensaje"];
        $mensaje["id_from"] = $idUser;
        $mensaje["id_to"] = $data["id_to"];

        $this->db->insert("mensajes", $mensaje);
    }

    // pasar el token del usuario
    public function get_token($id, $tipo)
    {
        $this->db->select("*");
        $this->db->where("id", $id);

        if ($tipo == "profesor") {
            $this->db->from("profesores");
        } else {
            $this->db->from("alumnos");
        }

        // obtener consulta generada
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $result = $query->result();
            return $result[0]->token_mensaje;
        } else {
            return NULL;
        }
    }

    // coger los mensajes
    public function get_mensajes($token)
    {
        $this->db->select("*");
        $this->db->where("id_to", $token);
        $this->db->from("mensajes");    // poner el from antes

        // obtener consulta generada
        $query = $this->db->get();

        // print_r($this->db->last_query());

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }

    // coger todos los datos de alumno o profesor
    public function getNombre($id)
    {
        $this->db->select("*");
        $this->db->from("alumnos");
        $this->db->where("token_mensaje", $id);

        $query1 = $this->db->get_compiled_select();

        $this->db->select("*");
        $this->db->from("profesores");
        $this->db->where("token_mensaje", $id);
       
        $query2 = $this->db->get_compiled_select();
        
        $query = $this->db->query($query1." UNION " . $query2 );            // juntar las querys

        // print_r($this->db->last_query());

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return NULL;
        }
    }
}
