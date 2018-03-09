<?php 

include_once ('./clases/ClaseCompras.php');

class PedidosCompras extends ClaseCompras{
	private $num_rows; // (array) El numero registros qure tiene la tabal pedprot
	
	public function __construct($conexion){
		parent::__construct($conexion);
		//~ $this->db = $conexion;
		// Obtenemos el numero registros.
		$sql = 'SELECT count(*) as num_reg FROM pedprot';
		$respuesta = $this->consulta($sql);
		$this->num_rows = $respuesta->fetch_object()->num_reg;
		// Ahora deberiamos controlar que hay resultado , si no hay debemos generar un error.
	}
	
	
	public function consulta($sql){
		// Realizamos la consulta.
		$db = $this->db;
		$smt = $db->query($sql);
		return $smt;
	}
	
	
	//Modifica los datos del pedido temporal. Llamamos a esta función cuando el pedido temporal ya existe y seguimos añadiendo elementos
	public function modificarDatosPedidoTemporal($idUsuario, $idTienda, $estadoPedido, $fecha ,  $numPedidoTemp, $productos){
		// @ Objetivo:
		//Modificar los datos de pedidos temporal cada vez que hacemos agregamos un producto, modificamos una candidad ...
		// @ Parametros:
		//Todos los datos del pedido temporal
		$db = $this->db;
		$UnicoCampoProductos=json_encode($productos);
		$sql='UPDATE pedprotemporales SET idUsuario='.$idUsuario.' , idTienda='.$idTienda.' , estadoPedPro="'.$estadoPedido.'" , fechaInicio="'.$fecha.'"  ,Productos='."'".$UnicoCampoProductos."'".'  WHERE id='.$numPedidoTemp;
		$smt=$db->query($sql);
		$respuesta['sql']=$sql;
		$respuesta['idTemporal']=$numPedidoTemp;
		$respuesta['productos']=$UnicoCampoProductos;
	
		return $respuesta;
	}
	//INsertar un nuevo pedido temporal
	public function insertarDatosPedidoTemporal($idUsuario, $idTienda, $estadoPedido, $fecha ,  $productos, $idProveedor){
		//@Objetivo:
		// Insertar un pedido temporal , cuando el pedido temporal no exste lo insertamos
		//@ Parametros:
		// Todos los parametros que tenemos incialmente cuando creamos el pedido temporal
		$db = $this->db;
		$UnicoCampoProductos=json_encode($productos);
		$sql = 'INSERT INTO pedprotemporales ( idUsuario , idTienda , estadoPedPro , fechaInicio, idProveedor,  Productos ) VALUES ('.$idUsuario.' , '.$idTienda.' , "'.$estadoPedido.'" , "'.$fecha.'", '.$idProveedor.' , '."'".$UnicoCampoProductos."'".')';
		$smt = $db->query ($sql);
		$id=$db->insert_id;
		$respuesta['id']=$id;
		$respuesta['sql']=$sql;
		$respuesta['productos']=$productos;
		return $respuesta;
	}
	//Cada vez que se añade un  nuevo producto tenemos que modificar el total en pedidos temporales
	public function modTotales($res, $total, $totalivas){
		//@ Objetivo:
		// El objetico principal es que cada vez que modificamos una cantidad o añadimos un producto nuevo , modificar en el pedido temporal los datos de total
		//@ Parametros:
		// $res-> id del pedido temporal
		//$total->El total del pedido
		//$total_ivas->la suma de todos los ivas 
		$db=$this->db;
		$sql='UPDATE pedprotemporales set total='.$total .' , total_ivas='.$totalivas .' where id='.$res;
		$smt=$db->query($sql);
		$resultado['sql']=$sql;
		return $resultado;
	}
	//Si el pedido ya existia como guardado y lo modificamos tenemos que guardar en el temporal el numero del pedido real
	public function addNumRealTemporal($idTemporal, $idReal){
		// @Objetivo: Si el pedido es modificado en el temporal tenemos que registrar el id del pedido real 
		// @Parametros:
		// $idTemporal-> id del pedido temporal que hemos creado anteriormente
		// $idReal-> id del pedido real que estamos modificando
		$db=$this->db;
		$sql='UPDATE pedprotemporales set idPedpro='.$idReal .'  where id='.$idTemporal;
		$smt=$db->query($sql);
		return $resultado;
	}
	//Esta función la vamos a llamar en varios momentos del proceso 
	public function modEstadoPedido($idPedido, $estado){
		//@Objetivo: Mofificar el estado del pedido real 
		// @estado :
			//-Facturado: que ese pedido ya está en el albarán
			//-Guardado: que el pedido no tiene ninguna modificación pendiente
			//- Sin guardar : que el pedido tiene un pedido temporal
		//@Parametros : 
		// $idPedido-> id del pedio real
		// $estado-> string del estado
		$db=$this->db;
		$sql='UPDATE pedprot set estado="'.$estado .'"  where id='.$idPedido;
		$smt=$db->query($sql);
		return $sql;
	}
	public function DatosTemporal($idTemporal){
		// @ Objetivo:
		// Obtener todos los datos de temporal
		// @ Parametros:
		// $idTemporal -> (string) Numero de idTemporal
		$tabla='pedprotemporales';
		$where='id='.$idTemporal;
		$pedido = parent::SelectUnResult($tabla, $where);
		//~ $db=$this->db;
		//~ $sql='SELECT * from pedprotemporales where id='.$idTemporal;
		//~ $smt=$db->query($sql);
		//~ if ($result = $smt->fetch_assoc () ){
			//~ $pedido=$result;
		//~ }
		return $pedido;
	}
	//Muestra todos los datos de un pedido real
	public function DatosPedido($idPedido){
		//@Objetivo : Mostrar todo los datos de un pedido de la tabla pedprot
		//@Parametros:
		//idPedido: id del pedido
		$tabla='pedprot';
		$where='id='.$idPedido;
		$pedido = parent::SelectUnResult($tabla, $where);
		
		//~ $db=$this->db;
		//~ $sql='SELECT * from pedprot where id='.$idPedido;
		//~ $smt=$db->query($sql);
		//~ if ($result = $smt->fetch_assoc () ){
			//~ $pedido=$result;
		//~ }
		return $pedido;
	}
	//Cuando añadimos un pedido nuevo tenemos que borrar los registros de ese pedido en las tablas reales para poder crearlos con los datos modificados
	public function eliminarPedidoTablas($idPedido){
		//@Objetivo: Eliminar todo los datos de un id de pedido completo
		//@Parametros:
			//idPedido->id del pedido real
		$db=$this->db;
		$smt=$db->query('DELETE FROM pedprot where id='.$idPedido );
		$smt=$db->query('DELETE FROM pedprolinea where idpedpro ='.$idPedido );
		$smt=$db->query('DELETE FROM pedproIva where idpedpro ='.$idPedido );
	}
	//Esta función se ejecuta cuando añadimos un pedido nuevo o estamos modificando y seleccionamos guardar
	//Añade de nuevo todos los registros . 
	public function AddPedidoGuardado($datos, $idPedido, $numPedido){
		//@Objetivo: GUardar todos los datos de un pedido real nuevo , los datos se guardan en tres tablas 
		//@tablas:
		//pedprot->tabla donde se almacenan los pedidos guardados
		//pedprolinea->tabla que contiene las lineas de los productos
		//pedproIva->tabla que contiene los registros de los distintos ivas de los productos
		$db = $this->db;
		if ($idPedido>0){
			$sql='INSERT INTO pedprot (id, Numpedpro, Numtemp_pedpro, FechaPedido, idTienda, idUsuario, idProveedor, estado, total, fechaCreacion) VALUES ('.$idPedido.' , '.$datos['numPedido'].', '.$datos['Numtemp_pedpro'].', "'.$datos['FechaPedido'].'", '.$datos['idTienda'].' , '.$datos['idUsuario'].', '.$datos['idProveedor'].', "'.$datos['estado'].'", '.$datos['total'].', "'.$datos['fechaCreacion'].'")';
			$smt = $db->query($sql);
			$id=$idPedido;
		}else{
			$sql='INSERT INTO pedprot ( Numtemp_pedpro, FechaPedido, idTienda, idUsuario, idProveedor, estado, total, fechaCreacion) VALUES ('.$datos['Numtemp_pedpro'].', "'.$datos['FechaPedido'].'", '.$datos['idTienda'].' , '.$datos['idUsuario'].', '.$datos['idProveedor'].', "'.$datos['estado'].'", '.$datos['total'].', "'.$datos['fechaCreacion'].'")';
			$smt=$db->query($sql);
			$id=$db->insert_id;
			$smt=$db->query('UPDATE pedprot set Numpedpro='.$id.' WHERE id='.$id);
		}
		$productos = json_decode($datos['Productos'], true); 
		foreach ( $productos as $prod){
			if ($prod['estado']=='Activo'){
			if ($prod['ccodbar']){
				$codBarras=$prod['ccodbar'];
			}else{
				$codBarras=0;
			}
			if ($prod['crefProveedor']){
				$refProveedor=$prod['crefProveedor'];
			}else{
				$refProveedor=0;
			}
			if ($idPedido>0){
				$smt=$db->query('INSERT INTO pedprolinea (idpedpro, Numpedpro, idArticulo, cref, ref_prov , ccodbar, cdetalle, ncant, nunidades, costeSiva, iva, nfila, estadoLinea) values ('.$id.', '.$datos['numPedido'].', '.$prod['idArticulo'].', '."'".$prod['cref']."'".', '."'".$refProveedor."'".', '.$codBarras.', "'.$prod['cdetalle'].'", '.$prod['ncant'].', '.$prod['nunidades'].', '.$prod['ultimoCoste'].', '.$prod['iva'].', '.$prod['nfila'].', "'.$prod['estado'].'")');
			}else{
				$smt=$db->query('INSERT INTO pedprolinea (idpedpro, Numpedpro, idArticulo, cref, ref_prov , ccodbar, cdetalle, ncant, nunidades, costeSiva, iva, nfila, estadoLinea) values ('.$id.', '.$id.', '.$prod['idArticulo'].', '."'".$prod['cref']."'".', '."'".$refProveedor."'".', '.$codBarras.', "'.$prod['cdetalle'].'", '.$prod['ncant'].', '.$prod['nunidades'].', '.$prod['ultimoCoste'].', '.$prod['iva'].', '.$prod['nfila'].', "'.$prod['estado'].'")');
			}
		}
	}
		foreach ($datos['DatosTotales']['desglose'] as  $iva => $basesYivas){
			if($idPedido>0){
				$smt=$db->query('INSERT INTO pedproIva (idpedpro, Numpedpro, iva, importeIva, totalbase) values ('.$id.', '.$datos['numPedido'].', '.$iva.', '.$basesYivas['iva'].', '.$basesYivas['base'].')');
			}else{
				$smt=$db->query('INSERT INTO pedproIva (idpedpro, Numpedpro, iva, importeIva, totalbase) values ('.$id.', '.$id.', '.$iva.', '.$basesYivas['iva'].', '.$basesYivas['base'].')');
				$sql='INSERT INTO pedproIva (idpedpro, Numpedpro, iva, importeIva, totalbase) values ('.$id.', '.$id.', '.$iva.', '.$basesYivas['iva'].', '.$basesYivas['base'].')';
				
			}
		}
		return $sql;
	}
	// Cuando guardamos un registro en las tablas reales lo tenemos que elimminar de temporal
	public function eliminarTemporal($idTemporal, $idPedido){
		
		$db=$this->db;
		if ($idPedido>0){
			$smt=$db->query('DELETE FROM pedprotemporales WHERE idPedpro='.$idPedido);
		}else{
			$smt=$db->query('DELETE FROM pedprotemporales WHERE id='.$idTemporal);
		}
	}
	public function TodosTemporal(){
		//Muestra todos los temporales, esta función la utilizamos en el listado de pedidos
		$db = $this->db;
		$Sql= 'SELECT tem.idPedpro, tem.id , tem.idProveedor, tem.total, b.nombrecomercial, c.Numpedpro from pedprotemporales as tem left JOIN proveedores as b on tem.idProveedor=b.idProveedor left JOIN pedprot as c on tem.idPedpro=c.id';
		$smt=$db->query($Sql);
			$pedidosPrincipal=array();
		while ( $result = $smt->fetch_assoc () ) {
			array_push($pedidosPrincipal,$result);
		}
		return $pedidosPrincipal;
		
	}
	
	//MUestra todos los pedidos dependiendo del límite que tengamos en listado pedidos
	public function TodosPedidosLimite($limite = ''){
		$db	=$this->db;
		$Sql = 'SELECT a.id , a.Numpedpro , a.FechaPedido, b.nombrecomercial, a.total, a.estado FROM `pedprot` as a LEFT JOIN proveedores as b on a.idProveedor=b.idProveedor '. $limite ;
		$smt=$db->query($Sql);
		$respuesta=array();
		
		while ( $result = $smt->fetch_assoc () ) {
			array_push($respuesta,$result);
		}
		return $respuesta;
	}
	//MUestra los datos de un pedido real
	//~ public function datosPedidos($idPedido){
		//~ $db=$this->db;
		//~ $smt=$db->query('SELECT * FROM pedprot WHERE id= '.$idPedido );
		//~ if ($result = $smt->fetch_assoc () ){
			//~ $pedido=$result;
		//~ }
		//~ return $pedido;
	//~ }
	public function sumarIva($numPedido){
		//Función para sumar los ivas de un pedido
		$from_where= 'from pedproIva where Numpedpro ='.$numPedido;
		$pedido = parent::sumarIvaBases($from_where);
		//~ $db=$this->db;
		//~ $smt=$db->query('select sum(importeIva ) as importeIva , sum(totalbase) as  totalbase from pedproIva where Numpedpro ='.$numPedido);
		//~ if ($result = $smt->fetch_assoc () ){
			//~ $pedido=$result;
		//~ }
		return $pedido;
	}
	//Extraer todos los productos de un pedido
	public function ProductosPedidos($idPedido){
	//@Objetivo:
	//Buscar todos los productos que tenga un id de pedido real
	//@Parametros :
	//idPedido-> id del pedido real
		$tabla='pedprolinea';
		$where='idpedpro= '.$idPedido;
		$pedido = parent::SelectVariosResult($tabla, $where);
		
		//~ $db=$this->db;
		//~ $smt=$db->query('SELECT * FROM pedprolinea WHERE idpedpro= '.$idPedido );
		//~ $pedidosPrincipal=array();
		//~ while ( $result = $smt->fetch_assoc () ) {
			//~ array_push($pedidosPrincipal,$result);
		//~ }
		//~ return $pedidosPrincipal;
		return $pedido;
	}
	//Muestra los ivas de un pedido
	public function IvasPedidos($idPedido){
		//@Objetivo:
		//Extraer todos los ivas que tengamos de un pedido ya guardado
		//@Parametros: 
		//idPedido->id del pedido guardado
		$tabla='pedproIva';
		$where='idpedpro= '.$idPedido;
		$pedido = parent::SelectVariosResult($tabla, $where);
		
		//~ $db=$this->db;
		//~ $smt=$db->query('SELECT * FROM pedproIva WHERE idpedpro= '.$idPedido );
		//~ $pedidosPrincipal=array();
		//~ while ( $result = $smt->fetch_assoc () ) {
			//~ array_push($pedidosPrincipal,$result);
		//~ }
		//~ return $pedidosPrincipal;
		return $pedido;
	}
	//Muestra los pedidos de un proveedor con el estado guardado
	public function pedidosProveedorGuardado($idProveedor, $estado){
		$db=$this->db;
		$smt=$db->query('SELECT * FROM pedprot WHERE idProveedor= '.$idProveedor.' and estado='."'".$estado."'");
		 $pedidosPrincipal=array();
		while ( $result = $smt->fetch_assoc () ) {
			array_push($pedidosPrincipal,$result);
		}
		
		return $pedidosPrincipal;
	}
	
	public function buscarPedidoProveedorGuardado($idProveedor, $numPedido, $estado){
		$db=$this->db;
		if ($numPedido>0){
			$smt=$db->query('SELECT Numpedpro, FechaPedido, total, id FROM pedprot WHERE idProveedor= '.$idProveedor.' and estado='."'".$estado."'".' and Numpedpro='.$numPedido);
			$pedidosPrincipal=array();
			if ($result = $smt->fetch_assoc () ){
				$pedido=$result;
			}
			$pedido['Nitem']=1;
		}else{
			$smt=$db->query('SELECT Numpedpro, FechaPedido, total, id FROM pedprot WHERE idProveedor= '.$idProveedor.'  and estado='."'".$estado."'");
			$pedidosPrincipal=array();
			while ( $result = $smt->fetch_assoc () ) {
				array_push($pedidosPrincipal,$result);	
			}
			$pedido['datos']=$pedidosPrincipal;
		}
		
		
		return $pedido;
	}
	
	
}

?>
