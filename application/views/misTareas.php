<section id="main-content">
    <section class="wrapper">

        <div class="row">
            <?php
            foreach ($tareas as $t) {
            ?>

                <div class="col-md-4">
                    <div class="row">
                        <?= $t->nombre ?>
                    </div>
                    <div class="row">
                        <?= $t->descripcion ?>
                    </div>
                    <div class="row">
                        <?= date( "d-m-Y",strtotime($t->fecha_final)) ?>
                    </div>
                    <div class="row">
                        <a href="<?= base_url()."uploads/". $t->archivo ?>" download="">Descargar</a>
                    </div>
                </div>

            <?php
            }
            ?>
        </div>
    </section>
</section>