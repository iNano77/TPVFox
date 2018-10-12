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

trait CalcularMD5 {

    /**
     * 
     * Calcula el MD5 de los elementos concatenados.
     * recibe un array. Si lo que recibe es un string
     * se convierte en un array
     * 
     * @param array $elementos
     * @return string
     */
    public function calcularMD5($elementos) {
        $suma = '';
        if (!is_array($elementos)) {
            $elementos = [$elementos];
        }
        foreach ($elementos as $elemento) {
            $suma .= $elemento;
        }
        return md5($suma);
    }

}
