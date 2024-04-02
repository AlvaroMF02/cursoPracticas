<!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <p class="centered"><a href="profile.html"><img src="<?= base_url() ?>assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered">
                <?php
                // escribir el nombre del usuario
                // el pregunta pregunta por la sesion de nombre y apellido, pero con preguntar por una creo que ya vale
                // ¿puede haber casos en los que un usuario no tenga username o nombre o apellidos?
                if (isset($_SESSION["username"])) {
                    echo strtoupper($_SESSION["nombre"] . " " . $_SESSION["apellidos"]);
                }
                ?>
            </h5>

            <li class="mt">
                <a class="active" href="<?=base_url()?>">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php
            // Solo los profesores puede crear tareas y gestionar
            if ($_SESSION["tipo"] == "profesor") {
            ?>
                <li class="sub-menu">
                    <a href="<?= base_url()?>Dashboard/crearTareas">
                        <i class="fa fa-desktop"></i>
                        <span>Crear tareas</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="<?=base_url()?>Dashboard/gestionAlumnos">
                        <i class="fa fa-th"></i>
                        <span>Gestión de alumnos</span>
                    </a>
                </li>
            <?php
            }
            ?>
            <li class="sub-menu">
                <a href="<?= base_url()?>Dashboard/misTareas">
                    <i class="fa fa-book"></i>
                    <span>Mis tareas</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-tasks"></i>
                    <span>Mensajes</span>
                </a>
            </li>

        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->