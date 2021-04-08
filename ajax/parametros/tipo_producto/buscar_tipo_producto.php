<?php
session_start();


	include '../../../config/conexion.php';
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	

	if (isset($_GET['id'])){
		$id=$_GET['id'];

		if ($action == 'eliminar')
		{
			$del1="update tipo_producto set estatus=0 where codigo='".$id."'";
			$mensaje = 'Tipo de producto eliminado exitosamente';
		}
		elseif ($action == 'activar') {
			$del1="update tipo_producto set estatus=1 where codigo='".$id."'";
			$mensaje = 'Tipo de producto activado exitosamente';
		}


		if ($eliminar=$con->query($del1)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>¡Aviso!</strong> <?php echo $mensaje ?>
			</div>
			<?php
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>¡Error!</strong> Ha ocurrido un error al realizar la operación.
			</div>
			<?php
			
		}
	}

	if($action == 'ajax'){

		  $sTable = "tipo_producto";
		 $sWhere = "";

		
		$sWhere.=" order by estatus desc";
		include '../../pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 4; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = $con->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './tipo_producto.php';
		//sql principal para traer los datos
		$sql="SELECT *
			  FROM  $sTable 
			  $sWhere
			  LIMIT $offset,$per_page";

		$query = $con->query($sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th style="width: 35%;">Descripción</th>
					<th>Estado</th>
					<th>Operacion</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$codigo = $row['codigo'];
						$descripcion = $row['descripcion'];
						$estatus = $row['estatus'];
						if ($estatus==1)
							{
								$text_estado="Activo";$label_class='label-success';$funcion='eliminar';$icon='trash';$title='Elminar Producto';
							}
						else
							{
								$text_estado="Inactivo";$label_class='label-danger';$funcion='activar';$icon='check';$title='Activar Producto';
							}	

					?>
					<tr>
						<td><?php echo $descripcion; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
					<td class="text-right">
						<a href="#" class='btn btn-default' data-toggle="modal" data-target="#editar_producto" title="Ver/Editar" onclick="ver_tipo_producto('<?php echo $codigo;?>');"><i class="glyphicon glyphicon-edit"></i></a> 
						<a href="#" class='btn btn-default' title=<?php echo $title ?> onclick="<?php echo $funcion ?>('<?php echo $codigo; ?>')"><i class="glyphicon glyphicon-<?php echo $icon ?>"></i> </a>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>