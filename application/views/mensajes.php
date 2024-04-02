<section id="main-content">
    <section class="wrapper">

        <button class="btn btn-success btn-md" data-toggle="modal" data-target="#myModal"> Enviar mensaje </button>
        <div class="row">
            <table id="alumnos" class="display" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($mensajes as $m) {


                    ?>

                        <tr>
                            <td>asd</td>
                            <td>asd</td>
                            <td>asd</td>
                        </tr>

                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>

        <!-- --------------- MODAL --------------- -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Enviar mensaje</h4>
                    </div>

                    <!-- BODY -->
                    <div class="modal-body">
                        <form action="" method="post" class="form-horizontal style-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Destinatario</label>
                                <div class="col-sm-10">
                                    <select name="id_to">
                                        <option class="form-control" value="0" disabled>Seleccione un usuario</option>
                                        <?php
                                        foreach ($usuarios as $usu) {
                                            echo "<option id='" . $usu->id . " 'value='" . $usu->token_mensaje . "'>" . $usu->nombre . " " . $usu->apellidos . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 col-sm-2 control-label">Mensaje</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="mensaje" cols="6"></textarea>
                                </div>
                            </div>
                            <input class="form-control" type="submit" name="" value="Enviar">
                        </form>
                    </div>
                    <!-- BODY -->

                    <div class="modal-footer" style="margin-top: 25px;">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- --------------- MODAL --------------- -->


    </section>
</section>

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
                targets: [2],
                orderData: [2, 0]
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