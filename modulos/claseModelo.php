<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */


define('ARTICULOS_MAXLINPAG', 12);

define('K_TARIFACLIENTE_ESTADO_ACTIVO', '1');
define('K_TARIFACLIENTE_ESTADO_BORRADO', '2');


/**
 * Description of claseModelo
 *
 * @author alagoro
 */
class Modelo {

    protected $db;

    public function __construct($conexion) {
        $this->db = $conexion;
    }

    protected function consulta($sql) {
        // Realizamos la consulta.
        $respuesta = [];
        $respuesta['consulta'] = $sql;

        $smt = $this->db->query($sql);
        if ($smt) {
            $respuesta['datos'] = $smt->fetch_all(MYSQLI_ASSOC);
             // (!$datos)||count($datos)==1?$datos[0]:$datos;
        } else {
            $respuesta['error'] = $this->db->error;
        }
        return $respuesta;
    }

        protected function consultaDML($sql) {
        // Realizamos la consulta.
        $respuesta = [];
        $respuesta['consulta'] = $sql;

        $respuesta['error'] = $this->db->query($sql) ? '0': $this->db->error;

        return $respuesta;
    }

}
