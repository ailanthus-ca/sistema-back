<?php
if (isset($_GET['term'])){

include '../../config/conexion.php';


$return_arr = array();
/* If connection to database, run sql statement. */
	$fetch = $con->query("SELECT * FROM proveedor where estatus = 1 and nombre like '%" . mysqli_real_escape_string($con,$_GET['term']) . "%' LIMIT 0 ,50"); 
		
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_proveedor=$row['codigo'];
		$row_array['value'] = $row['nombre'];
		$row_array['id_proveedor']=$id_proveedor;
		$row_array['nombre_proveedor']=$row['nombre'];
		$row_array['telefono_proveedor']=$row['telefono'];
		$row_array['direccion_proveedor']=$row['direccion'];
		$row_array['email_proveedor']=$row['correo'];
		array_push($return_arr,$row_array);
    }

/* Free connection resources. */

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
mysqli_close($con);
?>