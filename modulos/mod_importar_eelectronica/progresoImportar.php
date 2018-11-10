<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once './../../inicial.php';

// Mostramos formulario si no tiene acceso.
include_once ($URLCom . '/controllers/parametros.php');

$VarJS = ""; 
?>
<!DOCTYPE html>
<html>
    <head>

        <?php
        include_once $URLCom . '/head.php';
        ?>
        
        <link rel="stylesheet" href="<?php echo $HostNombre; ?>/jquery/jquery-ui.min.css" type="text/css">
        <script type="text/javascript" src="<?php echo $HostNombre; ?>/controllers/global.js"></script>

        <script type="text/javascript" src="<?php echo $HostNombre; ?>/modulos/mod_importar_eelectronica/funciones.js"></script>
    </head>

    <body>
        <?php
        include_once $URLCom . '/modulos/mod_menu/menu.php';
        ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center"> Importar productos EEnrique </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <button onclick="javascript:progresoIniciar();">Iniciar</button>
                    <button onclick="javascript:progresoParar();">Parar</button>
                </div>
                <div class="col-md-10">
                    <!-- Tabla de lineas de productos -->

                    <div class="row" id="tablafamilias">
                        <label for="contador">Contador:</label><input type="text" id="contador">
                        <table id="tabla" class="table table-bordered table-hover table-striped" >
                            <thead>
                                <tr>
                                    <th>L</th>
                                    <th>Id Familia</th>
                                    <th>Nombre</th>
                                    <th >padre</th>
                                    <th></th>
                                    <th>Productos</th>
                                </tr>
                            </thead>
                            <tbody id="lineas">
                                
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </body>
</html>
