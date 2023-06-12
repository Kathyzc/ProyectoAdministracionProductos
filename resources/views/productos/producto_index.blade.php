@extends('plantilla')
@section('contenido')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Tabla simple</h4>
        </div>
         <div class="card-body">

            <a href="/nuevoProducto" class="btn btn-success">NUEVO REGISTRO</a>
            <a href="/reportePdf" target="_blank" class="btn btn-danger">REPORTE PDF</a>
            <a href="/reporteExcel" target="_blank" class="btn btn-info">REPORTE EXCEL</a>
          
            <div class="table-responsive">
            <table class="table" style="font-size: 12px">
              <thead class=" text-primary">
                <tr>
                    <th>#</th>
                    <th>IMAGEN</th>
                    <th>ITEMS</th>
                    <th>CATEGORIA</th>
                    <th>NOMBRE</th>
                    <th>DESCRPCION</th>
                    <th>STOCK</th>
                    <th>FECHA REG</th>
                    <th>ESTADO</th>
                    <th>ACCION</th>
                </tr>
              </thead>
              <tbody>
               
                <?php $cont=1; foreach ($listado as $value) {  ?>
                <tr>
                    <td><?php echo $cont++?></td>
                    <td> <img src="/imagen_producto/<?php echo $value->pro_imagen?>"></td>
                    <td><?php echo $value->pro_stock?></td>
                    <td><?php echo $value->cat_nombre?></td>
                    <td><?php echo $value->pro_nombre?></td>
                    <td><?php echo $value->pro_descripcion?></td>
                    <td><?php echo $value->pro_stock?></td>
                    <td><?php echo $value->pro_fecha_reg?></td>
                    <td><?php echo $value->pro_estado?></td>
                    <td>
                      <a href="/editarProducto/<?php echo $value->id ?>" class="btn btn-primary">Editar</a>
                    </td>
                    <td>
                        <a href="#" onclick="eliminarProducto('<?php echo $value->id ?>')" class="btn btn-primary">Eliminar</a>
                    </td>
                </tr>
                  <?php } ?> 
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  </div>

<script>

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function eliminarProducto(id) {
  Swal.fire({
    title: 'ESTA SEGURO DE ELIMINAR EL PRODUCTO ?',
    text: "",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ACEPTAR'
  }).then((result) => {
    if (result.value) {
      $.post('<?php echo route('pro.eliminarProducto') ?>', {id}, function() {
        Swal.fire(
          'EXITOSAMENTE ELIMINADO!',
          '',
          'success'
        )  
        window.location='/adminProductos'; 
      });
    }
  })
}
</script>

@endsection