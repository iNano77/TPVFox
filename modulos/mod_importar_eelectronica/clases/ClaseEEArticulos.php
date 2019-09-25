<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulosTienda.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulos.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulosStocks.php';
include_once $URLCom . '/modulos/mod_producto/clases/ClaseArticulosPrecios.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseFusion.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseRegistroSistema.php';

require_once $URLCom . '/modulos/mod_traits/traitCalculaMD5.php';

/**
 * Description of ClaseEEArticulos
 * Articulos importados de Electronica Enrique
 * 
 * @author alagoro
 */
class ClaseEEArticulos extends ModeloP {

    use traitCalcularMD5;

    protected static $tabla = 'modulo_eelectronica_articulos';

    /**
     * 
     * @return array
     */
    public static function limpia() {
        $sql = 'DELETE FROM ' . self::$tabla;
        return self::_consultaDML($sql);
    }

    //~ private static function ActualizaEEFamilia() {
        //~ $sql = 'UPDATE modulo_eelectronica_articulos '
                //~ . ' JOIN familiasTienda ON (modulo_eelectronica_articulos.Cat=familiasTienda.cRefTienda) '
                //~ . ' SET modulo_eelectronica_articulos.idFamilia=familiasTienda.idFamilia';
        //~ return parent::_consultaDML($sql);
    //~ }

    public static function importar($ficherosql, $origenmdb='') {
        $contador = 0;

        $errores = [];
        if (file_exists($ficherosql)) {
            $idProgreso = fusion::crear('articulos', $contador, $origenmdb);
            ClaseEEArticulos::limpia();
            $fichero = fopen($ficherosql, 'r');
            $linea = fgets($fichero);
            while ($linea) {
                $lineanueva = $linea;
                $linea = fgets($fichero);
                while ($linea && (strpos($linea, 'INSERT INTO') === false)) {
                    $lineanueva .= $linea;
                    $linea = fgets($fichero);
                }
                if ($lineanueva) {
                    $lineawrite = str_replace('Articulos', ClaseEEArticulos::$tabla, $lineanueva);
                    $inserta = ClaseEEArticulos::_consultaDML($lineawrite);
                    if($idProgreso > 0){
                        fusion::actualizar($idProgreso, $contador++);
                    }
                    if ($inserta === false) {
                        registroSistema::crear('ClaseEEArticulos->importar'
                                , $lineawrite
                                , ClaseEEArticulos::getSQLConsulta()
                                , ClaseEEArticulos::getErrorConsulta());
                        $errores[] = [$lineawrite, ClaseEEArticulos::getErrorConsulta(), ClaseEEArticulos::getSQLConsulta()];
                    }
                }
            }
            fusion::finalizar($idProgreso);
            $idProgreso = fusion::crear('familias de articulos', $contador);
            //~ $actualiza = self::ActualizaEEFamilia();
            //~ if (!$actualiza) {
                        //~ registroSistema::crear('ClaseEEArticulos->importar', 'update--->'
                                //~ , ClaseEEArticulos::getSQLConsulta()
                                //~ , ClaseEEArticulos::getErrorConsulta());
                //~ $errores[] = ['update--->', ClaseEEArticulos::getErrorConsulta(), ClaseEEArticulos::getSQLConsulta()];
            //~ }
            fusion::finalizar($idProgreso);
            return ($errores);
        }
        return false;
    }

    public static function QuitaIva($coniva, $iva) {
        return $coniva / (1 + ($iva / 100));
    }

    public static function SumaIva($siniva, $iva) {
        return $siniva * (1 + ($iva / 100));
    }

    public static function fusionar($mdbOrigen='00000000') {
        $articulos = self::leer();
        $idprogreso = fusion::crear('fusion articulos', count($articulos), $mdbOrigen);
        $idTienda = 1;
        $errores = [];
        $contador = 0;
        foreach ($articulos as $articuloEE) {
            $datos = [
                'articulo_name' => substr($articuloEE['Nom'], 0, 100),
                'iva' => $articuloEE['iva'],
                'estado' => 'importado'
            ];
            $idArticuloTienda = alArticulosTienda::existeCRef($articuloEE['Art']);
            if (!$idArticuloTienda) {
                registroSistema::crear(basename(__FILE__), 'fusionar articulos:No existe CRef'
                            , 'consultaSQL'
                            , 'erroresSQL');                        
                $nuevoid = alArticulos::insertar($datos);
                if ($nuevoid) {
                    $idArticuloTienda = $nuevoid;
                    if (!alArticulosTienda::insert([
                                'idArticulo' => $nuevoid,
                                'idTienda' => $idTienda,
                                'crefTienda' => $articuloEE['Art'],
                                'idVirtuemart' => '0',
                                'estado' => 'importado'
                            ])) {
                        $errores[] = ['insert artT', $articuloEE['Art'], alArticulosTienda::getErrorConsulta()];
                        registroSistema::crear(basename(__FILE__), 'fusionar articulos:insert artT'
                            , alArticulosTienda::getSQLConsulta()
                            , alArticulosTienda::getErrorConsulta());
                    }
                    alArticulosPrecios::insert([
                        'idArticulo' => $nuevoid,
                        'idTienda' => $idTienda,
                        'pvpCiva' => self::SumaIva($articuloEE['pvp'], $articuloEE['iva']),
                        'pvpSiva' => $articuloEE['pvp'],
                    ]);
                    alArticulosStocks::actualizarStock($nuevoid, $idTienda, $articuloEE['Stock'], K_STOCKARTICULO_SUMA);

                    if ($articuloEE['idFamilia'] != 0) {
                        if (!alArticulos::borrarArticuloFamilia($idArticuloTienda, $articuloEE['idFamilia'])) {
                            $errores[] = ['borrar Art fam', alArticulos::getErrorConsulta(), alArticulos::getSQLConsulta()];
                        }
                        if (!alArticulos::grabarArticuloFamilia($idArticuloTienda, $articuloEE['idFamilia'])) {
                            $errores[] = ['insert Art fam', alArticulos::getErrorConsulta(), alArticulos::getSQLConsulta()];
                        }
                    }
                } else {
                    $errores[] = ['existe cref', $articuloEE['Art'], alArticulos::getErrorConsulta(), alArticulos::getSQLConsulta()];
                }
            } else {
                // Lee los articulos con precios de la tienda sin iva
                $articulotpv = alArticulos::leerArticuloTienda($idArticuloTienda, $idTienda);
                if (count($articulotpv) > 0) {
                    $articulotpv = $articulotpv[0];
                    $actualizar = false;
                    //~ if (($articuloEE['idFamilia'] != 0) 
                            //~ && (!alArticulos::existeArticuloFamilia($idArticuloTienda, $articuloEE['idFamilia']))) {
                        //~ if (!alArticulos::borrarArticuloFamilia($idArticuloTienda, $articuloEE['idFamilia'])) {
                            //~ $errores[] = ['borrar Art fam', alArticulos::getErrorConsulta(), alArticulos::getSQLConsulta()];
                        //~ }
                        //~ if (!alArticulos::grabarArticuloFamilia($idArticuloTienda, $articuloEE['idFamilia'])) {
                            //~ $errores[] = ['insert Art fam', alArticulos::getErrorConsulta(), alArticulos::getSQLConsulta()];
                        //~ }
                        //~ $actualizar = true;
                        //~ registroSistema::crear(basename(__FILE__), 'fusionar articulos:SI existe CRef. idfamilia!=0'
                            //~ , 'consultaSQL'
                            //~ , 'erroresSQL');                        
                    //~ }
                    $md51 = self::calcularMD5([
                                $articulotpv['ivaArticulo'],
                                substr($articulotpv['descripcion'],0,100)
                    ]);

                    $articuloEE['iva'] = number_format($articuloEE['iva'], 2);
                    $md52 = self::calcularMD5([
                                $articuloEE['iva'],
                                substr($articuloEE['Nom'], 0, 100)
                    ]);
                    registroSistema::crear(basename(__FILE__), 'fusionar articulos:MD5'
                            , $md51
                            , $md52);                        

                    $actualizar = $actualizar || ($md51 != $md52);

                    if ($articuloEE['Stock'] != $articulotpv['stocktpv']) {
                        $actualizar = true;
                        $resultado = alArticulosStocks::actualizarStock($idArticuloTienda, $idTienda, $articuloEE['Stock'], K_STOCKARTICULO_REGULARIZA);
                        registroSistema::crear(basename(__FILE__), 'fusionar articulos:stock'
                            , $md51
                            , $md52);                        
                    }
                    if (number_format($articuloEE['pvp'], 2) != $articulotpv['pvptpv']) {
                        $actualizar = true;
                        registroSistema::crear(basename(__FILE__), 'fusionar articulos:precios'
                            , number_format($articuloEE['pvp'], 2)
                            , $articulotpv['pvptpv']); 
                        
                        $resultado = alArticulosPrecios::update(
                                $idArticuloTienda, $idTienda, ['pvpSiva' => number_format($articuloEE['pvp'], 2),
                            'pvpCiva' => number_format(self::SumaIva($articuloEE['pvp'], $articuloEE['iva']), 2)]
                        );
                    }

                    if ($actualizar) {
                        $datos['estado'] = 'actualizado';
                        if (!alArticulos::actualizar($idArticuloTienda, $datos)) {
                            $errores[] = ['ac art', $idArticuloTienda, $articuloEE['Art']];
                        }
                    }
                }
            }
            fusion::actualizar($idprogreso, $contador++);   
        }
        return $errores;
    }

    public static function leer() {
        return self::_leer(self::$tabla); //, '', [], [], 100);
    }

    //~ public static function leerFamilia($CatEE, $idTienda) {
        //~ $resultado = self::_consulta('SELECT idFamilia FROM familiasTienda WHERE ');
        //~ return self::_leer(self::$tabla);
    //~ }

}
