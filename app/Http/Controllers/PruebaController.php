<?php

namespace App\Http\Controllers;

use App\Mail\PruebaMailable;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PruebaController extends Controller
{
    public function index(){
        $pokemones = Http::get("https://pokeapi.co/api/v2/pokemon/");

        return $pokemones['results'];
    }

    public function generarFactura(){
        /*$img = '/img/logo-factura.png';
        $pdf = PDF::loadView('pdf.factura', compact('img'));
        
        /**
         * stream() => visualiza el pdf y tiene la opcion de descargar
         * download() => descargar el pdf de inmediato
         */
        //return $pdf->stream('factura.pdf');
        //$pdf->save(public_path("pdf/hola.pdf"));
        //return "enviado";
        //echo now();

        setlocale(LC_ALL, 'es');
        $mes = Carbon::now()->month(-1)->formatLocalized('%B');
        echo $mes;

    }

    public function enviarCorreos(){
        $usuarios = Http::get("http://localhost/api_proveedores_fsj17/public/api/proveedores_activos");

        $mes_actual = Carbon::now()->month;
        setlocale(LC_ALL, 'es');
        $mes_nombre = Carbon::now()->month(-1)->formatLocalized('%B');
        $img = '/img/logo-factura.png';
        
        $correos = $usuarios['detalle'];
        foreach($correos as $value){
            $mes_factura_salida = Carbon::parse($value['checkOutDate'])->month;
            //echo $mes_factura_salida . "<br>";
            if($mes_factura_salida == $mes_actual){
                $usuario = $value['nombre'];
                $sub_total = $value['totalAmount'];
                $pdf = PDF::loadView('pdf.factura', compact('usuario','img','mes_nombre','sub_total'));
                $pdf->save(public_path("pdf/$usuario-$mes_nombre.pdf"));
                //echo $value['correo'];
                Mail::to($value['correo'])->send(new PruebaMailable($usuario,$mes_nombre));
                echo "Mensaje Enviado";
            }
        }
        //Mail::to('yanetprogrammin19@gmail.com')->send(new PruebaMailable);
        //return "Mensaje Enviado";

        //return $usuarios['detalle'];
    }
}