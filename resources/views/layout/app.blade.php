<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konecta | Quejas - Reclamos</title>
    <!-- <link rel="shortcut icon" href="{{ asset('k1.png') }}" type="image/x-icon"> -->
    <link rel="shortcut icon" href="../public/k1.png" type="image/x-icon">
    {{-- bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
   
    {{-- style --}}
    <!-- <link rel="stylesheet" href="{{ asset('/css/main.css') }}"> -->
    <link rel="stylesheet" href="../public/css/main.css">
  
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @yield('styles')
</head>
<body>

    @include('partial.navbar')
        
    <div class="container">
        @yield('content')
    </div>


    <div class="container">
        @yield('footer')
    </div>


    {{-- script --}}

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.min.js" ></script>
    <script src="../public/js/vendor/ckeditor/ckeditor.js"></script>
    <!-- <script src="{{ asset('js/vendor/ckeditor/ckeditor.js')}}"></script> -->
    <script src="../public/js/main.js"></script>
    <!-- <script src="{{ asset('js/main.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"> </script>

    
    @yield('scripts')
   

</body>
</html>