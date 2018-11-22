<?php 
/*
 * @Copyright 2018, Alagoro Software. 
 * @licencia   GNU General Public License version 2 or later; see LICENSE.txt
 * @Autor Alberto Lago Rodríguez. Alagoro. alberto arroba alagoro punto com
 * @Descripción	
 */
header("Content-Type: application/json;charset=utf8");

function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }





$hora = date("Ymd H:i:s");
$ip= get_client_ip();

if(file_exists('/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/public/index.php')){
    $ruta = '/var/www/vhosts/tpvfox.com/eelectronica.tpvfox.com/mdbs/';
} else {
    $ruta = '/var/www/html/eelectronica/mdbs/';
}

if (isset($_GET['token']) && ($_GET['token'] == '987543aA')) {
	$upload = move_uploaded_file($_FILES['file']['tmp_name'], $ruta."mdb".time().".mdb");
	if ($upload) {
		$msg = '{"code": "202", "msg":"Aceptado", "ip":"'.$ip.'", "time":"'.$ruta.'"}';
	} else {
		$msg = '{"code": "500", "msg":"Error interno del servidor", "ip":"'.$ip.'", "time":"'.$hora.'"}';
	}
} else {
	$msg = '{"code": "401", "msg":"No autorizado", "ip":"'.$ip.'", "time":"'.$hora.'"}';
}
echo $msg."\n";
