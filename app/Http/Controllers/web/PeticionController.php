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
         $solicitud = DB::connection('mysql')->select('select * from tbl_qr_tipos_de_solicitud');
         $areas = DB::connection('mysql')->select('select * from tbl_qr_areas');
         $clientes  = DB::connection('mysql')->select('select * from tbl_qr_clientes');
         $jarvis = DB::connection('jarvis')->select("select * from dp_clientes");
         
      
         $casos = DB::connection('mysql')->select('select * from tbl_qr_clientes where id=?',[4]);
          return view('web.peticion',[ 
            'solicitud' => $solicitud ,
            'clientes'  => $clientes,
            'areas'     => $areas,
            'casos'     => $casos,
            'jarvis'    => $jarvis
            ]);
     }
     public function store(Request $request){
   
        request()->validate([
           'tipo'          => 'required',
           'areas'         => 'required',
           'tipologia'     => 'required',
           'nombre'          => ['required', 'regex:/^[a-zA-Z,ñ ]*$/', 'max:80'] ,
           'identificacion'=> ['required','regex:/^[0-9,$]*$/','max:20'],
           'email'         => ['required', 'email','regex:/^\S+@\S+\.\S+$/'],
           'cliente'        => 'required',
           'mensaje'       => 'required | max:255',
           'areas'         => 'required',
           'autorizacion' => 'required'
         ]);
   
       
         $recaptch = $request->input('g-recaptcha-response');

         if(isset($recaptch)){ 

          $res = DB::connection('mysql')->select('SELECT COUNT(*) as total FROM tbl_qr_casos');

          $id_solicitud  =  $request->tipo;
          $id_tipologia  =  $request->tipologia;
          $comentario    =  $request->message;
          $documento     =  $request->identification;
          $nombre        =  $request->name;
          $correo        =  $request->email;
          $id_cliente    =  $request->client;
          $numero_caso   =  'C-' .( $res[0]->total + 1);
          $id_estado_caso     =  1;
          
           DB::connection('mysql')->insert('insert into tbl_qr_casos (id_solicitud, id_tipologia, comentario, documento, nombre, correo, id_cliente, numero_caso, id_estado_caso) values (?,?,?,?,?,?,?,?,?)',[
             $id_solicitud,$id_tipologia, $comentario, $documento, $nombre, $correo, $id_cliente , $numero_caso,  $id_estado_caso  
           ]);

            $object = DB::connection('mysql')->select('select last_insert_id() as id');
            
            if($request->file('file')){
                $file = $request->file('file')->store('public');
                DB::update('UPDATE tbl_qr_casos SET archivo=? where id=? ',[$file,$object[0]->id]);
            }

            if($request->file('file2')){
                $file2 = $request->file('file2')->store('public');
                DB::connection('mysql')->update( 'UPDATE tbl_qr_casos SET archivo2=? where id=?',[ $file2, $object[0]->id ] );
            }

            $data = DB::connection('mysql')->select('SELECT s.tipo_de_dato AS tipo, t.tipologia, a.nombre AS areas, c.nombre, documento, correo,numero_caso 
            FROM tbl_qr_casos c
            INNER JOIN tbl_qr_tipos_de_solicitud s
            ON c.id_solicitud = s.id
            INNER JOIN tbl_qr_tipologias t 
            ON t.id = c.id_tipologia
            INNER JOIN tbl_qr_areas a
            ON a.id= t.id_areas where c.id=?',[$object[0]->id]);

            
            $correos = Db::connection('mysql')->select('SELECT * FROM tbl_qr_correos');
            $valor = [];
            foreach ($correos as $correo ) {
                array_push($valor, $correo->email) ;
            }
          
             Mail::to($valor)->send(new PeticionMailer($data[0]) );
             
             Mail::to($request->email)->send(new ClienteMailer($data[0]) );
        
             
            return redirect()->route('quejas')->with('message','Su peticion ha sido enviada');
        }else {
          
            return redirect()->route('quejas')->with('flash','Error Recaptcha Invalido');
        }
     }
     public function tipologia(Request $request){
       return DB::connection('mysql')->select('SELECT * FROM tbl_qr_tipologias WHERE id_areas =?',[$request->input('areas')]);
     }

     public function insertjarvis(Request $request){
      if ($request->hasHeader('Authorization')) {
          $token = $request->bearerToken();
          if($token == 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.SflKxwRJSMeKKF2QT4fwpMeJf36POk6yJV_adQssw5c'){
           
           /*  DB::connection('mysql')->delete('delete from tbl_qr_clientes');
            $jarvis = DB::connection('jarvis')->select("SELECT * FROM dp_clientes");
            $data = count($jarvis);
             
            foreach ($jarvis as $key ) {
              DB::connection('mysql')->insert(' INSERT INTO tbl_qr_clientes (`clientes`) VALUES (?)',[$key->cliente]);
            }
 */
            return "updated table";
          }else{
            return "token failed";
          }
       }else{
          return "Error authentication";
       }

     
        
        
     }



}
