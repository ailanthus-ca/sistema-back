<?php
if (isset($_GET['term'])){

include '../../config/conexion.php';


$return_arr = array();
/* If connection to database, run sql statement. */
	$fetch = $con->query("SELECT * FROM producto where codigo like '%" . mysqli_real_escape_string($con,$_GET['term']) . "%' LIMIT 0 ,50"); 
		
	/* Retrieve and store in array the results of the query.*/
	while ($row = mysqli_fetch_array($fetch)) {
		$id_producto=$row['codigo'];
		$row_array['value'] = $row['codigo'];
		array_push($return_arr,$row_array);
    }

/* Free connection resources. */

/* Toss back results as json encoded array. */
echo json_encode($return_arr);

}
mysqli_close($con);
?>