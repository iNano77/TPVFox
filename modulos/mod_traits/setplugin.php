<?php

trait setPlugin {


     public function SetPlugin($nombre_plugin){
            // @ Objetivo
            // Devolver el Object del plugin en cuestion.
            // @ nombre_plugin -> (string) Es el nombre del plugin que hay parametros de este.
            // Devuelve:
            // Puede devolcer Objeto  o boreano false.
            $Obj = false;
            if (count($this->plugins)>0){
                foreach ($this->plugins as $plugin){
                    if ($plugin['datos_generales']['nombre_fichero_clase'] === $nombre_plugin){
                        $Obj = $plugin['clase'];
                    }
                }
            }
        
        return $Obj;
    }

}