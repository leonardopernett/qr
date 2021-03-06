<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\PeticionMailer;
use App\Mail\ClienteMailer;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PeticionController extends Controller
{
     public function create(){
        header("X-Powered-By:");
        header("Cache-Control: no-cache,no-store, must-revalidate"); 
        header("Pragma: no-cache"); //HTTP 1.0
        header("X-Content-Type-Options:nosniff");
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
       $data = str_replace("<script>",'',$request->input('mensaje')); 
       $resp = str_replace("</script>",'',$data); 

    
    
        request()->validate([
           'tipo'            => 'required',
           'areas'           => 'required',
           'tipologia'       => 'required',
           'nombre'          => ['required', 'max:80', 'regex:/^[a-zA-Z,ñ ]*$/',] ,
           'identificacion'  => ['required','max:20','regex:/^[0-9,$]*$/',],
           'email'           => ['required', 'email','regex:/^\S+@\S+\.\S+$/'],
           'cliente'         => 'required',
           'message'         => 'required | max:150',
           'areas'           => 'required',
           'autorizacion'    => 'required',
           'file'            => 'mimes:pdf, xlsx,xls,doc,docx,png,jpg,jpeg,ppt,rar,zip  | max:20000',
           'file2'           => 'mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg,ppt,rar,zip  | max:20000'
         ]);
   
         $recaptch = $request->input('g-recaptcha-response');

         if(isset($recaptch)){ 

          $res = DB::connection('mysql')->select('SELECT COUNT(*) as total FROM tbl_qr_casos');

          $id_solicitud  =  $request->tipo;
          $id_tipologia  =  $request->tipologia;
          $comentario    =  $resp;
          $documento     =  $request->identificacion;
          $nombre        =  $request->nombre;
          $correo        =  $request->email;
          $id_cliente    =  $request->cliente;
          $numero_caso   =  'C-' .( $res[0]->total + 1);
          $id_estado_caso     =  1;
           dd($request->message);
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
          
           /*   Mail::to($valor)->send(new PeticionMailer($data[0]) );
             
             Mail::to($request->email)->send(new ClienteMailer($data[0]) ); */
        
             
            return redirect()->route('quejas')->with('message','Su peticion ha sido enviada');
        }else {
          
            return redirect()->route('quejas')->with('flash','Error Recaptcha Invalido');
        }
     }
     public function tipologia(Request $request){
      
       return DB::connection('mysql')->select('SELECT * FROM tbl_qr_tipologias WHERE id_areas =?',[$request->input('areas')]);
     }



     public function insertjarvis(Request $request){

      $result = [];
      $jarvis = DB::connection('jarvis')->select('select * from dp_clientes');

      for ($i=0; $i < count($jarvis) ; $i++) { 
          array_push($result, $jarvis[$i]->cliente);
       }

       /*  DB::connection('mysql')->delete('truncate table tbl_qr_clientes');

        for ($index=0; $index <= count($result) ; $index++) { 
          DB::connection('mysql')->insert('insert into tbl_qr_clientes (clientes) values (?)',[ $result[$index] ]); 
        } */ 

        $response = explode(' ', $request->header('Authorization'));

        $bearer = strtolower($response[0]);
        

        if(Str::startsWith('bearer ', $bearer)){

         if($response[1]==env('SECRET_KEY')){

           return  response()->json(['success'=>'table insert success'],200);

          }else{
            return response()->json(['error'=>'unathorized'],401);

          }
        } else{
          return response()->json(['error'=>'unathorized'],401);

        }

        if($response[1]==''){
          return response()->json(['error'=>'unathorized'],401);
        }
          return response()->json(['error'=>'unathorized'],401);
      }

}
