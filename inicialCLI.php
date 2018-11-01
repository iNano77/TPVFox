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

/* Este fichero lo utilizamos para cargar lo necesario para el funcionamiento.
 * en entorno linea de comandos.
 * 
*/


//deprecated: usar traitFormateaFechas 2018-10-29
define('FORMATO_FECHA_ES', 'd-m-Y H:m:s');
define('FORMATO_FECHA_MYSQL', 'Y-m-d H:m:s');

define('MODO_EJECUCION','cli');

$Ruta = __DIR__.'/';
	
	if (file_exists($Ruta.'configuracion.php')){
		include_once ($Ruta.'configuracion.php');
		if (file_exists($RutaServidor . $HostNombre)){
			$URLCom = $RutaServidor . $HostNombre;
		}
   	}
   	if (!isset($URLCom)) {
		echo '<pre>';
			print_r('No se encuentra o esta mal el fichero de configuracion.php');
		echo '</pre>';
		exit();
		
	}
	
    
	
