<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 */

include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseFusion.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/claseRegistroSistema.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/clasePasotestigo.php';

class tareasImportar {

    private static function array2html($atabla) {
        $htabla = '';
        foreach ($atabla as $fila) {
            $hfila = '<tr>';
            foreach ($fila as $columna) {
                $hfila .= '<td>' . $columna . '</td>';
            }
            $htabla .= $hfila . '</tr>';
        }
        return $htabla;
    }

    public static function EstadoProgreso($testigo) {
        $testigo = pasoTestigo::leerTestigo($testigo);

        $tabla = [[$testigo['testigo'], $testigo['estado'] == 1 ? 'Proceso en marcha (1)' : 'Proceso a la espera (0)', 3, 4, 5, 6]];
        if ($testigo['estado'] == pasoTestigo::K_ESTADO_BLOQUEADO) {
            $registros = registroSistema::leerXFichero($testigo['origen']);
            if ($registros) {
                foreach ($registros as $registro) {
                    $tabla[] = [$testigo['testigo'], $registro['accion'], $registro['error'], '', '', ''];
                    if ($registro['accion'] == 'fusionar articulos') {
                        $fusiones = fusion::leerOrigen($testigo['origen'], 'fusion articulos');
                        if ($fusiones) {
                            $fusion = $fusiones[0];
                            $tabla[] = [$testigo['testigo'], $fusion['accion']
                                , 'Insertados', $fusion['numRegistro']
                                , 'de', $fusion['totalRegistros']];
                        }
                    }
                }
            }
        }
        return ['html' => self::array2html($tabla)];
    }

}
