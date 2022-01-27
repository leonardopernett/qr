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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">   
    {{-- style --}}
 
    <link rel="stylesheet" href="../public/css/main.css">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @yield('styles')
</head>
<body>

    @include('partial.navbar')
        
    <div class="container">
        @yield('content')
    </div>s


    <div class="container">
        @yield('footer')
    </div>


    {{-- script --}}

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" ></script>

    <script src="../public/js/vendor/ckeditor/ckeditor.js"></script>
    <script src="../public/js/main.js"></script>  
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" > </script>

    
    @yield('scripts')
   

</body>
</html>