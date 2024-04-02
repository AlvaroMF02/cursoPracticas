<section id="main-content">
    <section class="wrapper">

        <table id="alumnos" class="display" style="width: 100%;">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Curso</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // If para que no salga el error al borrar todos los alumnos
                if ($alumnos != null) {

                    // si lo pongo en production no me sale este error
                    foreach ($alumnos as $a) {
                ?>

                        <tr id="rowAlumno-<?= $a->id ?>">
                            <td><?= $a->nombre ?></td>
                            <td><?= $a->apellidos ?></td>
                            <td><?= $a->username ?></td>
                            <td><?= $a->curso ?></td>
                            <td><i class="eliminar fa fa-trash-o" style="cursor: pointer;" id="alumno-<?= $a->id ?>"></i></td>
                        </tr>

                <?php
                    }
                }
                ?>

            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $("#alumnos").DataTable({
                    columnDefs: [{
                        targets: [0],
                        orderData: [0, 1]
                    }, {
                        targets: [1],
                        orderData: [1, 0]
                    }, {
                        targets: [4],
                        orderData: [4, 0]
                    }]
                });
            })

            // si da error es por la version, quitar el on del click ( funciona )
            $(".eliminar").on("click", function() {

                // coger el id del alumno
                let idAlumno = this.id; // aqui esta alumno-x
                let res = idAlumno.split("-"); // [0] = alumno || [1] = x
                let id = res[1];
                console.log(id)

                // Manda una variable post a la url, el nost es idAlumno con una id
                $.post("<?= base_url() ?>Dashboard/eliminarAlumno", {
                    idAlumno: id
                }).done(function(data) {
                    $("#rowAlumno-" + id).fadeOut()
                    console.log("Eliminado")
                })
            })
        </script>
    </section>
</section>