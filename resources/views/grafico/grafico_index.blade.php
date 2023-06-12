@extends('plantilla')
@section('contenido')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">REPORTES GRAFICO</h4>
      </div>
      <div class="card-body">
         <div id="graph"></div>
      </div>
    </div>
  </div>
  
</div>
<script>
$( document ).ready(function() {
    $.post('<?php echo route('pro.grafico_resp') ?>', {}, function(data) {
        var valores=eval(data);

          Morris.Donut({
            element: 'graph',
            data: [
              {value: valores[0], label: 'ACTIVO'},
              {value: valores[1], label: 'ELIMINADO'}
            ],
            formatter: function (x) { return x + " U"}
          }).on('click', function(i, row){
            console.log(i, row);
          }); 
    });
});
</script>

@endsection