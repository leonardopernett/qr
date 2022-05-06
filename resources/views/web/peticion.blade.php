@extends('layout.app')


@section('styles')
   <style>

     .authorizacion{
        text-align: justify;
        font-size: 10px
     }
    
       .form-control{
         height: 32px;
       }
       .contenido{
           margin-top:100px;
           z-index: 5;
       }
      .btn-primary{
          background: #21355e;
          border:none
      }

      .btn-primary:hover{
          background: #1B2C4D;
          border:none
      }

      .card{
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            -moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            border-radius: 10px
      }
      .hide {
        display:none;
      }

    </style>  
@endsection

@section('content')

  <div class="row contenido mb-5">
      <div class="col-md-12 mx-auto">
          <div class="card">
              <div class="card-header"> 
                <h5 class="">Escríbenos</h5>
              </div>
             <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
            
                       <form action="../public/contact" method="POST" enctype="multipart/form-data" id="form">
                         @csrf
                           <div class="mb-2">
                               <label for=""> <small class="asterisco">*</small> Tipo de petición: </label>
                               <select name="tipo" class="form-control" value="{{ old('tipo')  }}">
                                   <option value="">Seleccione</option>
                                   @foreach ($solicitud as $item)
                                     <option value="{{ $item->id }}" {{old('tipo') ==  $item->id ? 'selected':''}} >{{ $item->tipo_de_dato }}</option> 
                                   @endforeach
                               </select>
                               @error('tipo')
                                 <small class="text-danger">{{$message}}</small>  
                               @enderror
                           </div>

                           <div class="mb-2">
                            <label for=""> <small class="asterisco">*</small> Área: </label>
                              <select name="areas" id="area" class="form-control">
                               <option value="">Seleccionar</option>
                               @foreach ($areas as $area)
                                 <option value="{{ $area->id }}" {{old('areas') ==  $item->id ? 'selected':''}}>{{$area->nombre}}</option>
                               @endforeach
                             </select>
                             @error('areas')
                               <small class="text-danger">{{$message}}</small>  
                             @enderror
                            
                           </div>
                          
                           <div class="mb-2 hide" id="select">
                            <label for=""> <small class="asterisco">*</small> Tipificación: </label>
                            
                            <select name="tipologia" id="contenido" class="form-control">
                               <option value="">Seleccione</option>
                               
                            </select>
                            @error('tipologia')
                              <small class="text-danger">{{$message}}</small>  
                            @enderror
                           </div>
                           
                           <div class="mb-2">
                              <label for=""> <small class="asterisco">*</small> Nombre Completo:</label>
                              <input type="text" name="nombre" class="form-control  @error('nombre') ? 'is-invalid' : 'is-valid' @enderror }}" placeholder="Nombre" value="{{ old('nombre') }}">
                                @error('nombre')
                                   <small class="text-danger">{{ $message}}</small>  
                                @enderror
                              
                           </div>

                           <div class="mb-2">
                            <label for=""> <small class="asterisco">*</small> Identificación:</label>
                            <input type="text" name="identificacion" class="form-control" placeholder="Identificación" value="{{ old('identificacion') }}">
                                @error('identificacion')
                                   <small class="text-danger">{{ $message}}</small>  
                                @enderror
                         </div>


                         <div class="mb-2">
                            <label for=""> <small class="asterisco">*</small> Correo:</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                              <small class="text-danger">{{$message}}</small>  
                            @enderror
                         </div>

                         <div class="mb-2">
                            <label for=""> <small class="asterisco">*</small> Cliente:</label><br>
                            <select name="cliente" class="js-example-basic-single form-control" value="{{ old('cliente') }}" >
                                <option value="">Seleccione</option>
                                @foreach ($jarvis as $item)
                                  <option value="{{ $item->id_dp_clientes }}" {{old('cliente') ==  $item->id_dp_clientes ? 'selected':''}} >{{ $item->cliente }}</option> 
                                @endforeach
                            </select>
                            @error('cliente')
                              <small class="text-danger">{{$message}}</small>  
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for=""> <small class="asterisco">*</small> Mensaje:</label>
                            <textarea name="message" maxlength="255" id="message" class="form-control" style="height: 120px" cols="20" placeholder="Mensaje">{{old('mensaje')}}</textarea>
                            <small class="contador"><span id="contador">0</span> <span>/255</span></small>
                            @error('message')
                              <small class="text-danger">{{$message}}</small>  
                            @enderror
                         </div>

                         <div class="mb-2 d-flex justify-content-between" style="gap:5px" >
                           <input type="checkbox" name="autorizacion" class="form-ckeck-input mr-2" @if(old('autorizacion')) checked @endif>
                           <p class="autorizacion" style="text-align: justify; font-size:12px" >Autorizo a Konecta (Multienlace S.A.S) para el almacenamiento y gestión de mis datos personales en los términos de la ley 1581 de 2012 para efectos del envío de encuestas, respuesta de solicitudes, invitaciones a eventos corporativos, noticias, felicitaciones y cualquier otro concepto que pueda mejorar el servicio prestado por Konecta y la relación con la compañía. Konecta podrá contactarme a través de correo electrónico, mensaje de texto, WhatsApp, teléfono o mensajería física. Como titular puedo ejercer derechos para conocer, actualizar, rectificar, suprimir y/o revocar el uso de mis datos personales a través del correo electrónico proteccióndedatos@grupokonecta.co o a la dirección de correspondencia Cra 37A No. 8-43 Medellín, Colombia o a los teléfonos (4) 510 57 00 ó (1) 3431920 ​y conocer la política de tratamiento de mis datos en www.grupokonecta.com.co</p>
                          </div>
                           @error('autorizacion')
                              <small class="text-danger" style="">{{$message}}</small>  
                           @enderror

                         <div class="mb-2">
                            <label for="">Cargar Archivo 1:</label>
                            <input type="file" class="form-control" accept=".pdf, .xlsx,.xls,.doc,.docx,.png,.jpg,.jpeg, .ppt,.rar,.zip" name="file"></textarea>
                            @error('file')
                               <small class="text-danger" style="">{{$message}}</small>  
                            @enderror
                         </div>

                         <div class="mb-2">
                          <label for="">Cargar Archivo 2:</label>
                          <input type="file" class="form-control" accept=".pdf, .xlsx,.xls,.doc,.docx,.png,.jpg,.jpeg, .ppt,.rar,.zip" name="file2"></textarea>
                          @error('file2')
                          <small class="text-danger" style="">{{$message}}</small>  
                       @enderror
                       </div>

                         <small class="text-danger">
                            @if (Session::has('flash'))
                                {{ Session::get('flash') }}                  
                            @endif
                       </small>
                         <div class="g-recaptcha ml-3 mb-3" data-theme="light" data-sitekey="6LegZbIcAAAAAKBdSmx7yQU0FLRKFSEMAS-ZBdpS"></div>
                         
    
                         <small class="campos">los campos <span class="text-danger">( * )</span> son requeridos</small>
                         <div class="d-grid">
                             <button class="btn btn-primary">Enviar</button>
                         </div>

                       </form>
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center mt-3 hidden">
                        <img src="../public/images/send.png" alt="" width="500" class="img-fluid "> 
                     
                    </div>
                </div>
             </div>
          </div>
      </div>
  </div>
 
  

@endsection


@section('scripts')
    
    @if(Session::has('message'))
    <script>
        toastr.info('Su peticion fue enviada exitosamente')
    </script>
    @endif

<script>

    /*   CKEDITOR.replace( 'mensaje',{editorplaceholder: 'Start typing here...', }); */
 
    let contador = document.getElementById('contador')
    document.getElementById('mensaje').addEventListener('keyup',(e)=>{
      contador.innerText=e.target.value.length
    })

    $(function(){
      
        let contenido = document.getElementById('contenido')
        $('#area').change(function(){
            document.getElementById('select').classList.remove('hide')
            $.ajax({
            url:'tipologia/all',
            method:'POST',
            data:$('#form').serialize()
            }).done(function(res){
                contenido.innerHTML = ""
                res.map(element =>  contenido.innerHTML+=`<option value=" ${element.id}" > ${element.tipologia} </option>`);
            })
        });
    })

   </script>   
 
@endsection

