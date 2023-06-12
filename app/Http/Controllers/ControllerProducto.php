<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\Producto;
use DB;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\DomPDF\Facade\pdf;
use Illuminate\Support\Str;

use App\Exports\reporteExcel;
use Maatwebsite\Excel\Facades\Excel;

class ControllerProducto extends Controller
{

    public function index(){
         $menu=1; 
        return view('inicio.inicio_index',compact('menu'));
    }
    public function adminProductos(){
        
       // SELECT categorias.cat_nombre, productos.*
       // FROM `productos` INNER JOIN 
       //categorias on productos.categoria_id = categorias.id 
       //WHERE productos.pro_estado <> 'eliminar' ORDER BY productos.id DESC;
       $listado =  DB::table('productos')
       ->select('categorias.cat_nombre','productos.*')
       ->join('categorias','productos.categoria_id','categorias.id')
       ->where('productos.pro_estado','<>','eliminar')
       ->orderby('productos.id','DESC')->get();
      
      
       $menu=2; 
        return view('productos.producto_index',compact('menu','listado'));
    }

    public function nuevoProducto(){
        $categorias =  DB::table('categorias')
        ->where('categorias.cat_estado','=','active')
        ->get();
        $menu=2; 
         return view('productos.nuevoProducto',compact('menu','categorias'));
    }

    public function nuevoRegistroProducto(Request $request){
     $obj=new Producto();
     $obj->pro_nombre=mb_strtoupper($request->post('nombre'),'utf-8');
     $obj->pro_descripcion=mb_strtoupper($request->post('descripcion'),'utf-8');
     $obj->pro_stock=$request->post('stock');
     $obj->pro_item=$request->post('item');
     $obj->pro_fecha_reg=date('Y-m-d');
     $obj->pro_estado='active';
     $obj->categoria_id=$request->post('categoria_id');
      if($request->hasFile('imagen')){
        $imagen=$request->file('imagen');
        $nombreimagen=Str::slug(date('ymdHs')).".".$imagen->guessExtension();
        $ruta=public_path('imagen_producto/');
        $imagen->move($ruta,$nombreimagen);
      }
      $obj->pro_imagen=$nombreimagen;
      $obj->save();
    }
     
    //Editar producto
    public function editarProducto($id){
        $obj=DB::table('productos')->where('productos.id','=',$id)->first();
        $categorias=DB::table('categorias')->where('categorias.cat_estado','=','active')->get();
        $menu=2;
        return view('productos.editarProducto', compact('menu','categorias','obj'));
    }
    public function editarRegistroProducto(Request $request){
        $id=$request->post('id');
        $pro_imagen=$request->post('pro_imagen');

        $obj=Producto::find($id);
        $obj->pro_nombre=mb_strtoupper($request->post('nombre'),'utf-8');
        $obj->pro_descripcion=mb_strtoupper($request->post('descripcion'),'utf-8');
        $obj->pro_stock=$request->post('stock');
        $obj->pro_item=$request->post('item');
        $obj->categoria_id=$request->post('categoria_id');
        if($request->hasFile('imagen')){
            $imagen=$request->file('imagen');
            $nombreimagen=Str::slug(date('ymdHs')).".".$imagen->guessExtension();
            $ruta=public_path('imagen_producto/');
            $imagen->move($ruta,$nombreimagen);
        }else{
            $nombreimagen=$pro_imagen;
        }
        $obj->pro_imagen=$nombreimagen;
        $obj->save();
    }

    //Eliminar producto
    public function eliminarProducto(Request $request){ 
        $id=$request->post('id');
        $obj=Producto::find($id);
        $obj->pro_estado='eliminar';
        $obj->save();
    }

    //Modulo reportes pdf
    public function reportePdf(){
        $listado=DB::table('productos')
        ->select('categorias.cat_nombre','productos.*')
        ->join('categorias','productos.categoria_id','=','categorias.id')
        ->where('productos.pro_estado','<>','eliminar')
        ->orderBy('productos.id','DESC')->get();

        $pdf=\PDF::loadView('pdf.reportePdf',compact('listado'));
        return $pdf->setPaper('a4','portrait')->stream('ejemplo.pdf');
       // return $pdf->setPaper('a4', 'landscape')->download('ejemplo.pdf');//horizontal
        // return $pdf->setPaper('a4', 'portrait')->download('ejemplo.pdf');//vertical
        // return $pdf->setPaper('Legal', 'landscape')->download('ejemplo.pdf');//horizontal
        // return $pdf->setPaper('Legal', 'portrait')->download('ejemplo.pdf');//vertical
    }

    public function reporteExcel(){
        return Excel::download(new reporteExcel, 'ejemplo.xlsx');
    }

    public function grafico(){
        $menu=3;
        return view('grafico.grafico_index',compact('menu'));
    }
    public function grafico_resp(){
        $obj_a=DB::table('productos')->select(DB::raw('count(*) as total'))->where('pro_estado','=','active')->first();
        $obj_e=DB::table('productos')->select(DB::raw('count(*) as total'))->where('pro_estado','=','eliminar')->first();

        echo json_encode(array(
            0=>$obj_a->total,
            1=>$obj_e->total
        ));
    }
}
