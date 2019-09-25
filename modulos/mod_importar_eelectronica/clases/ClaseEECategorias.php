<?php
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';
include_once $URLCom . '/modulos/mod_familia/clases/ClaseFamilias.php';
include_once $URLCom . '/modulos/mod_familia/clases/ClaseFamiliasTienda.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseRegistroSistema.php';

/**
 * Description of ClaseFamilias
 *
 * 
 * @author alagoro
 */
class ClaseEECategorias extends ModeloP
{

    protected static $tabla = 'modulo_eelectronica_categorias';

    public static function limpia()
    {
        // Eliminamos datos de tabla antes importar
        $sql = 'DELETE FROM ' . self::$tabla;
        return self::_consultaDML($sql);
    }

    public static function limpiaCategoria()
    {
        $sql = 'UPDATE `familiasTienda` SET `cRefTienda`="" WHERE `idTienda`=1';
        return self::_consultaDML($sql);
    }

    public static function importar($ficherosql, $origenmdb='') //, $ruta='')
    {
        if (file_exists($ficherosql)) {
            self::limpia();
            self::limpiaCategoria();
            $errores = [];
            $contador = 0;
            $idProgreso = fusion::crear('categorias', $contador, $origenmdb);
            $fichero = fopen($ficherosql, 'r');
            while ($linea = fgets($fichero)) {
                $lineanueva = str_replace('Categorias', ClaseEECategorias::$tabla, $linea);
                $resultado = ClaseEECategorias::_consultaDML($lineanueva);                
                fusion::actualizar($idProgreso, $contador++);
                if (!$resultado){
                    registroSistema::crear(__FILE__, 'importar categorias::'. basename($ficherosql), ClaseEECategorias::getSQLConsulta(), ClaseEECategorias::getErrorConsulta());
                }                                     
            }
            registroSistema::crear(__FILE__, 'importar categorias', $ficherosql, 'importar categorias finalizado');
//            if((count($errores)==0) && ($ruta!=='')){
//                rename($ficherosql, $ruta . '/' . basename($ficherosql));
//            }
            return json_encode($errores);
        }
        return false;
    }

    public static function fusionar($registroid, $ficherosql)
    {
        $categorias = self::leer();
        $idTienda = 1;
        $errores = [];        
        foreach ($categorias as $categoriaEE) {
            $datos = [
                'familiaNombre' => $categoriaEE['Cat'],
                'descripcion' => $categoriaEE['Des'],
                'familiaPadre' => 0,
                'beneficiomedio' => 0.0,
                'estado' => 'importado'
            ];
            $idfamiliasTienda = alFamiliasTienda::existeCRef($categoriaEE['Cat'], $idTienda);
            if (!$idfamiliasTienda) {
                $nuevoid = ClaseFamilias::insertar($datos);
                if ($nuevoid) {
                    $idfamiliasTienda = $nuevoid;
                    if (!alFamiliasTienda::insert([
                            'idFamilia' => $idfamiliasTienda,
                            'idTienda' => $idTienda,
                            'idFamilia_tienda' => '0',
                            'crefTienda' => $categoriaEE['Cat']                            
                        ])) {
                        $errores[] = ['insert CATT', $categoriaEE['Cat'], 
                            alFamiliasTienda::getErrorConsulta(), alFamiliasTienda::getSQLConsulta()];
                    }
                } else {
                    $errores[] = ['insert fam', $categoriaEE['Cat'], ClaseFamilias::getErrorConsulta()];
                }
            } else {

                $familiatpv = ClaseFamilias::read($idfamiliasTienda);
                if (count($familiatpv) > 0) {
                    $familiatpv = $familiatpv[0];
//                    $actualizar = false;

                    if ($familiatpv['descripcion'] != $categoriaEE['Des']) {
                        $datos = [];
                        $datos['familiaNombre'] = $categoriaEE['Cat'];
                        $datos['descripcion'] = $categoriaEE['Des'];
                        $datos['estado'] = 'actualizado';
                        if (!ClaseFamilias::actualizar($idfamiliasTienda, $datos)) {
                            $errores[] = ['ac art', $idfamiliasTienda, $categoriaEE['Cat']];
                        }
                    }
                }
            }
        }
        return $errores;
    }

    public static function leer()
    {

        return self::_leer(self::$tabla);
    }
}
