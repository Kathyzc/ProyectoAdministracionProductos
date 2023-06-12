<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>reporte pdf</title>
	
	<style>
		table{
			width: 100%;
			font-size: 10px;
			border-collapse: collapse;
		}
		table,th,td{
			border: 0.5px solid #000;
		}
		thead{
			background:#c9c9c9;
		}

	</style>
</head>
<body>
	<h1 align="center">REPORTE DE PRODUCTO</h1>

	<table>
        <thead>
          <tr>
          	<th>#</th>
          	<th>IMAGEN</th>
          	<th>ITEMS</th>
          	<th>CATEGORIA</th>
          	<th>NOMBRE </th>
          	<th>DESCRIPCION</th>
          	<th>STOCK</th>
          	<th>FECHA REG.</th>
          </tr>
        </thead>
        <tbody>
        	<?php $con=1; 
        	foreach ($listado as $value) { ?>
          	<tr>
          		<td><?php echo $con++; ?></td>
          		<td><img width="50" src="imagen_producto/<?php echo $value->pro_imagen; ?>" alt=""></td>
          		<td><?php echo $value->pro_item; ?></td>
          		<td><?php echo $value->cat_nombre ?></td>
          		<td><?php echo $value->pro_nombre ?></td>
          		<td><?php echo $value->pro_descripcion ?></td>
          		<td><?php echo $value->pro_stock ?></td>
          		<td><?php echo $value->pro_fecha_reg ?></td>
          		
          	</tr>
          	<?php } ?>
        </tbody>
     </table>
	
</body>
</html>