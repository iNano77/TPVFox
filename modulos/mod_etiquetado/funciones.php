<?php 

function repetirLineasProducto($veces, $idProducto, $BDTpv, $idTienda, $fechaCad, $numProd, $tipo){
	$CArticulo= new Articulos($BDTpv);
	$respuesta=array();
	$datosArticulo=$CArticulo->datosArticulosPrincipal($idProducto, $idTienda);
	$Productos=array();
	$html="";
	
	for($i=1;$i<=$veces;$i++){
		
		
		switch($tipo){
			case 1:
				$codigoBarras=codigoBarrasUnidades($datosArticulo['crefTienda'], 1);
			break;
			case 2:
				$codigoBarras=codigoBarrasPeso($datosArticulo['crefTienda'], 1);
			break;
		}
		
		$nuevoProducto=array();
		$nuevoProducto['nombre']=$datosArticulo['articulo_name'];
		$nuevoProducto['peso']=1;
		$nuevoProducto['precio']=$datosArticulo['pvpCiva'];
		$nuevoProducto['Fecha']=$fechaCad;
		$nuevoProducto['NumAlb']="";
		$nuevoProducto['codBarras']=$codigoBarras;
		$nuevoProducto['estado']='Activo';
		$nuevoProducto['Nfila']=$numProd+$i;
		
		
		
		array_push($Productos, $nuevoProducto);
		
		if ($nuevoProducto['estado'] !=='Activo'){
				$classtr = ' class="tachado" ';
				$estadoInput = 'disabled';
				$funcOnclick = ' retornarFila('.$nuevoProducto['Nfila'].', "etiquetas");';
				$btnELiminar_Retornar= '<td class="eliminar"><a onclick="'.$funcOnclick.'">
							<span class="glyphicon glyphicon-export"></span></a></td>';
			} else {
				$funcOnclick = ' eliminarFila('.$nuevoProducto['Nfila'].' , "etiquetas");';
				$btnELiminar_Retornar= '<td class="eliminar"><a onclick="'.$funcOnclick.'">
							<span class="glyphicon glyphicon-trash"></span></a></td>';
				$classtr = '';
				$estadoInput = '';
			}
		
		$html.='<tr id="Row'.($nuevoProducto['Nfila']).'" '.$classtr.'>'
		 .'<td class="linea">'.$nuevoProducto['Nfila'].'</td>'
		 .'<td><input type="text" id="nombre_'.$nuevoProducto['Nfila'].'" value="'.$nuevoProducto['nombre'].'"></td>'
		 .'<td><input type="text" id="peso_'.$nuevoProducto['Nfila'].'" value="'.$nuevoProducto['peso'].'"></td>'
		 .'<td><input type="text" id="precio_'.$nuevoProducto['Nfila'].'" value="'.$nuevoProducto['precio'].'"></td>'
		 .'<td><input type="text" id="fecha_'.$nuevoProducto['Nfila'].'" value="'.$nuevoProducto['Fecha'].'"></td>'
		 .'<td><input type="text" id="numAlb_'.$nuevoProducto['Nfila'].'" value="'.$nuevoProducto['NumAlb'].'"></td>'
		 .'<td>'.$codigoBarras.'</td>'
		 . $btnELiminar_Retornar
		 .'</tr>';
		
	}
	$respuesta['productos']=$Productos;
	$respuesta['html']=$html;
	return $respuesta;
	
}
function htmlProductos($busqueda, $productos){
	$resultado = array();
	$resultado['encontrados'] = count($productos);
	$resultado['html'] = '<label>Busqueda De Productos</label>
				<input id="cajaBusquedaproductos" name="valorProducto" placeholder="Buscar"'.
				'size="13" data-obj="cajaBusquedaproductos" value="'.$busqueda.'"
				 onkeydown="controlEventos(event)" type="text">';
	if (count($productos)>10){
		$resultado['html'] .= '<span>10 Productos de '.count($productos).'</span>';
	}
	$resultado['html'] .= '<table class="table table-striped"><thead>'
	. ' <th></th> <th>Id</th><th>Nombre del Producto</th><th>PVPCiva</th></thead><tbody>';
	if (count($productos)>0){
			$contad = 0;
			foreach($productos as $producto){
				$resultado['html'] .= '<tr id="Fila_'.$contad.'" class="FilaModal" onclick="buscarProducto('
				.$producto['idArticulo'].', '."'".'id_producto'."'".')">'
				.'<td id="C'.$contad.'_Lin" >'
				.'<input id="N_'.$contad.'" name="filaproducto" data-obj="idN" onkeydown="controlEventos(event)" type="image"  alt="">'
				. '<span  class="glyphicon glyphicon-plus-sign agregar"></span></td>'
				. '<td>'.$producto['idArticulo'].'</td>'
				. '<td>'.$producto['articulo_name'].'</td>'
				. '<td>'.$producto['pvpCiva'].'</td>'
				.'</tr>';
				$contad = $contad +1;
				if ($contad === 10){
					break;
				}
			}
			$resultado['html'] .='</tbody></table>';
			return $resultado;
	}
}
function lineasProductos($productos){
	$html="";
	foreach($productos as $producto){
			if ($producto['estado'] !=='Activo'){
				$classtr = ' class="tachado" ';
				$estadoInput = 'disabled';
				$funcOnclick = ' retornarFila('.$producto['Nfila'].', "etiquetas");';
				$btnELiminar_Retornar= '<td class="eliminar"><a onclick="'.$funcOnclick.'">
							<span class="glyphicon glyphicon-export"></span></a></td>';
			} else {
				$funcOnclick = ' eliminarFila('.$producto['Nfila'].' , "etiquetas");';
				$btnELiminar_Retornar= '<td class="eliminar"><a onclick="'.$funcOnclick.'">
							<span class="glyphicon glyphicon-trash"></span></a></td>';
				$classtr = '';
				$estadoInput = '';
			}
		
		$html.='<tr id="Row'.($producto['Nfila']).'" '.$classtr.'>'
		 .'<td class="linea">'.$producto['Nfila'].'</td>'
		 .'<td><input type="text" id="nombre_'.$producto['Nfila'].'" value="'.$producto['nombre'].'"></td>'
		 .'<td><input type="text" id="peso_'.$producto['Nfila'].'" value="'.$producto['peso'].'"></td>'
		 .'<td><input type="text" id="precio_'.$producto['Nfila'].'" value="'.$producto['precio'].'"></td>'
		 .'<td><input type="text" id="fecha_'.$producto['Nfila'].'" value="'.$producto['Fecha'].'"></td>'
		 .'<td><input type="text" id="numAlb_'.$producto['Nfila'].'" value="'.$producto['NumAlb'].'"></td>'
		 .'<td>'.$producto['codBarras'].'</td>'
		 . $btnELiminar_Retornar
		 .'</tr>';
		 
	}
	return $html;
}

function codigoBarrasUnidades($referenciaTienda, $cantidad){
	$principio='20';
	$referencia=$referenciaTienda;
	$dividir = explode(".", $cantidad);
	if(isset($dividir['0'])){
		$entero=str_pad($dividir['0'], 2, "0", STR_PAD_LEFT); 
	}
	if(isset($dividir['1'])){
		$decimal=str_pad($dividir['1'], 3, "0", STR_PAD_RIGHT); 
	}else{
		$decimal='000';
	}
	$codigo=$principio.$referencia.$entero.$decimal;
	$dc=calcularDigitoControl($codigo);
	$codigoBarras=$codigo.$dc;
	return $codigoBarras;
	
}
function codigoBarrasPeso($referenciaTienda, $cantidad){
	$principio='21';
	$referencia=$referenciaTienda;
	$dividir = explode(".", $cantidad);
	if(isset($dividir['0'])){
		$entero=str_pad($dividir['0'], 2, "0", STR_PAD_LEFT); 
	}
	if(isset($dividir['1'])){
		$decimal=str_pad($dividir['1'], 3, "0", STR_PAD_RIGHT); 
	}else{
		$decimal='000';
	}
	$codigo=$principio.$referencia.$entero.$decimal;
	$dc=calcularDigitoControl($codigo);
	$codigoBarras=$codigo.$dc;
	return $codigoBarras;
}

function calcularDigitoControl($codigo){
	$par=0;
	$impar=0;
	$bandera=1;//bandera es 1 por que se la primera corresponde a la posición 0
	$longitud=strlen($codigo)-1;//obtenemos la longitud del string , se resta uno por que la primera posición es 0
	  for ($i=$longitud; $i>=0; $i--){//se realiza el for al reves 
		if($bandera%2 == 0){//Si la bandera es divisible por 2 es par 
		  $par += $codigo[$i];//se selecciona el número y se suma a la variable par
		}else{//si no es impar y se hace los mismo pero multiplicando por 3
		  $impar += $codigo[$i]*3;
		}
		$bandera++;
	  }
	$control = ($par+$impar)%10;//se suman el par e impar y se divide entre 10
	if($control > 0){
		$control = 10 - $control;//si es mayor que cero se le resta a 10
	}
	return $control;
}
?>
