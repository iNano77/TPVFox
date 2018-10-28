<?php

/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */

trait traitFormateaFechas {

    public static function getFormatoFecha_dmYHora() {
        return 'd-m-Y H:i:s';
    }

    public static function getFormatoFecha_dmY() {
        return 'd-m-Y';
    }

    public static function getFormatoFechaHoraSQL() {
        return 'Y-m-d H:i:s';
    }

    public static function getFormatoFechaSQL() {
        return 'Y-m-d';
    }
}
