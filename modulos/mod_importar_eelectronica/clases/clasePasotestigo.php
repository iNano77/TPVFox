<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

include_once $URLCom . '/modulos/claseModeloP.php';
require_once $URLCom . '/modulos/mod_traits/traitFormateaFechas.php';

/**
 * Guardar en BD el progreso de la fusion asincrona (incrontab)
 * 
 */
class pasoTestigo extends ModeloP {

    use traitFormateaFechas;

    const K_ESTADO_BLOQUEADO = 1;
    const K_ESTADO_DESBLOQUEADO = 0;

    protected static $tabla = 'modulo_eelectronica_pasotestigo';

    public static function crear($testigo) {
        $resultado = self::_insert(self::$tabla, ['testigo' => $testigo]);
        return $resultado;
    }

    public static function actualizar($id, $datos) {
        $datos['actualizado_en'] = date(self::getFormatoFechaHoraSQL());
        $resultado = self::_update(self::$tabla
                        , $datos
                        , ['id=' . $id]);
        return $resultado;
    }

    public static function bloquear($id, $idmdb) {
        return self::actualizar($id, ['estado'=>self::K_ESTADO_BLOQUEADO,'origen'=>$idmdb]);
    }

    public static function desbloquear($id) {
        return self::actualizar($id, ['estado'=>self::K_ESTADO_DESBLOQUEADO]);
    }

    public static function leer($id) {
        echo '1';
        $resultado = parent::_leer(self::$tabla, ['id=' . $id]);
        if($resultado && count($resultado)==1){
            $resultado = $resultado[0];
        }
        return $resultado;
    }

    public static function leertestigo($testigo, $crearSiNoExiste=true) {
        $resultado = parent::_leer(self::$tabla, ['testigo="' . $testigo . '"']);
        if ($crearSiNoExiste && !$resultado) {
            $idnuevo = self::crear($testigo);
            
            if ($idnuevo) {
                $resultado = self::leer($idnuevo);
            }
        } elseif($resultado && count($resultado)==1){
            $resultado = $resultado[0];
        }

        return $resultado;
    }

}
