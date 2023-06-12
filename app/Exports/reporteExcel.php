<?php 

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use App\User;
use DB;

class reporteExcel implements FromView, ShouldAutoSize
{
	
	use Exportable;
	private $listado;
	public function __construct(){
		$this->listado=DB::table('productos')
        ->select('categorias.cat_nombre','productos.*')
        ->join('categorias','productos.categoria_id','=','categorias.id')
        ->where('productos.pro_estado','<>','eliminar')
        ->orderBy('productos.id','DESC')->get();
	}
	public function view():View{
		return view('pdf.reportePdf',['listado'=>$this->listado]);
	}

}