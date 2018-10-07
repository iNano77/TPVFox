<?php

/* 
 * Copyright (C) 2018 alagoro
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


	$ruta = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/tpvfox';
	if (!file_exists($ruta.'/inicial.php')){		
  	  $ruta = '/var/www/html/tpvfox';
        }

include_once $ruta.'/inicial.php';
include_once $URLCom . '/modulos/mod_importar_eelectronica/clases/ClaseEEArticulos.php';


var_dump(ClaseEEArticulos::importar('/var/www/html/tpvfox/BD/importar_eelectronica/csv/articulos_1538936061.sql'));


//var_dump(ClaseEEArticulos::fusionar());
