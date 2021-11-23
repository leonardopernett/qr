<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\PeticionMailer;
use App\Mail\ClienteMailer;
use Illuminate\Support\Facades\Mail;

class PeticionController extends Controller
{
     public function create(){
         $solicitud = DB::connection('mysql')->select('select * from qr_tipos_de_solicitud');
         $areas = DB::connection('mysql')->select('select * from qr_areas');
         $clientes  = DB::connection('mysql')->select('select * from qr_clientes');
         $casos = DB::connection('mysql')->select('select * from qr_clientes where id=?',[4]);
          return view('web.peticion',[ 
            'solicitud' => $solicitud ,
            'clientes'  => $clientes,
            'areas'     => $areas,
            'casos'     => $casos
            ]);
     }
     public function store(Request $request){
   
        request()->validate([
           'tipo'          => 'required',
           'name'          => 'required | string',
           'identification'=> 'required',
           'email'         => 'required',
           'client'        => 'required',
           'message'       => 'required',
           'areas'         => 'required'
         ]);

         $recaptch = $request->input('g-recaptcha-response');
         if($recaptch){ 

          $res = DB::connection('mysql')->select('SELECT COUNT(*) as total FROM qr_casos');

          $id_solicitud  =  $request->tipo;
          $id_tipologia  =  $request->tipologia;
          $comentario    =  $request->message;
          $documento     =  $request->identification;
          $nombre        =  $request->name;
          $correo        =  $request->email;
          $id_cliente    =  $request->client;
          $numero_caso   =  'C-' .( $res[0]->total + 1);
          $id_estado_caso     =  1;
          
           DB::connection('mysql')->insert('insert into qr_casos (id_solicitud, id_tipologia, comentario, documento, nombre, correo, id_cliente, numero_caso, id_estado_caso) values (?,?,?,?,?,?,?,?,?)',[
             $id_solicitud,$id_tipologia, $comentario, $documento, $nombre, $correo, $id_cliente , $numero_caso,  $id_estado_caso  
           ]);

            $object = DB::connection('mysql')->select('select last_insert_id() as id');
            
            if($request->file('file')){
                $file = $request->file('file')->store('public');
                DB::update('UPDATE qr_casos SET archivo=? where id=? ',[$file,$object[0]->id]);
            }

            if($request->file('file2')){
                $file2 = $request->file('file2')->store('public');
                DB::connection('mysql')->update( 'UPDATE qr_casos SET archivo2=? where id=?',[ $file2, $object[0]->id ] );
            }

            $data = DB::connection('mysql')->select('SELECT tipo_de_dato AS tipo, a.nombre AS area, tipologia, c.nombre AS nombre, documento, correo, clientes,numero_caso
            FROM qr_casos c
            INNER JOIN qr_tipos_de_solicitud s
            ON c.id_solicitud = s.id
            INNER JOIN qr_tipologias t 
            ON t.id = c.id_tipologia
            INNER JOIN qr_areas a
            ON a.id= t.id_areas 
            INNER JOIN qr_clientes q
            ON q.id = c.id_cliente where c.id=?',[$object[0]->id]);

             Mail::to('engie.guerrero@grupokonecta.com')->send(new PeticionMailer($data[0]) );
             Mail::to($request->email)->send(new ClienteMailer($data[0]) );
        
             
            return redirect()->route('quejas')->with('message','Su peticion ha sido enviada');
        }else {

          request()->validate([
            'tipo'          => 'required',
            'name'          => 'required | string',
            'identification'=> 'required',
            'email'         => 'required',
            'client'        => 'required',
            'message'       => 'required',
            'areas'         => 'required'
          ]);
            return redirect()->route('quejas')->with('flash','Error Recaptcha Invalido');
        }
     }
     public function tipologia(Request $request){
       return DB::connection('mysql')->select('SELECT * FROM qr_tipologias WHERE id_areas =?',[$request->input('areas')]);
     }
}
