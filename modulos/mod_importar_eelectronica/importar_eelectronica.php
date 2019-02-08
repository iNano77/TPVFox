
<!DOCTYPE html>
<html>
<head>
<?php
    include_once './../../inicial.php';
    include_once $URLCom.'/head.php';
    include ($URLCom.'/controllers/Controladores.php');
    include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/clasePasotestigo.php';
    $testigo = pasoTestigo::leerTestigo('mdbexport');
    $command = 'ps aux | grep "[p]hp.*fusionar_eelectronica"';
    exec($command ,$ejecutando); // Compruebo si se esta ejecutando fusionar_eelectronica.php
    if ($testigo['estado'] <> count($ejecutando)){
        // Quiere decir que está bloqueado y no se esta ejecutando o viceversa..
        // Ejecutando debe ser un array 0 si no se esta ejecutando.
        // Algo salio mal , ya que no existe la ruta.
        echo  'Algo esta mal ya que testigo es:';
        echo '<pre>';
        print_r($testigo);
        echo '</pre>';
        echo  ' Y se esta ejecutando:';
        echo '<pre>';
        print_r($ejecutando);
        echo '</pre>';
        exit;
    }
    include_once ($URLCom.'/controllers/parametros.php');
    $ClasesParametros = new ClaseParametros('parametros.xml');
    $parametros = $ClasesParametros->getRoot();
    $conf_defecto = $ClasesParametros->ArrayElementos('configuracion');
    foreach ($conf_defecto['ruta'] as $r ){
        switch ($r->nombre) {
            case 'sql':
              $ruta = $r->valor;
            break;
            case 'procesado':
               $rutapro = $r->valor;
            break;
            case 'origen':
               $origen = $r->valor;
            break;
        }
        if (is_dir($r->valor) === FALSE){
            // Algo salio mal , ya que no existe la ruta.
            echo  'Mal ruta Parametros.xml  '. $r->valor;
            exit;
        }
    }
   ?>
   <script type="text/javascript" src="<?php echo $HostNombre; ?>/modulos/mod_importar_eelectronica/funciones.js"></script>

</head>
<body>
      <?php
            include_once $URLCom.'/modulos/mod_menu/menu.php';
            
        ?>
    <div class="container">
        <h2 class="text-center">Acciones para realizar importar y fusionar Gestion Enrique con tpv.</h2>
        <div class="col-md-3">
            <div style="margin: 1%;padding:3%;border-radius:10px;background-color:#f3f3f6;">
                <h3>Iniciar importacion MDB y fusionar</h3>
                <p> Este script se ejecuta tanto por icron como desde la web, donde hacemos:</p>
                <ol>
                    <li>Leer el fichero mdb y convertir los datos de las tablas que indicamos en sql</li>
                    <li>Tambien añadimos sql a las tablas del modulo eelectronica.</li>
                    <li>Añadimos o modificamos los datos tablas a TpvFox</li>
                </ol> 
                <p><a onclick="iniciarImportarFusion()">Empezar</a></p>
            </div>
        </div>
        <div class="col-md-3">
            <div style="margin: 1%;padding:3%;border-radius:10px;background-color:#f3f3f6;">
                <h3>Comprobar el estado de actualizacion</h3>
                <p> Muestra los procesos que esta realizando en segundo plano</p>
                <p><a href="progresoImportar.php">Empezar</a></p>
            </div>
        </div>
        
    </div>
</body>
</html>
