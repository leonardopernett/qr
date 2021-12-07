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

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>   --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>


    <script src="../public/js/vendor/ckeditor/ckeditor.js"></script>
    <!-- <script src="{{ asset('js/vendor/ckeditor/ckeditor.js')}}"></script> -->
    <script src="../public/js/main.js"></script>
    <!-- <script src="{{ asset('js/main.js') }}"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" integrity="sha384-d3UHjPdzJkZuk5H3qKYMLRyWLAQBJbby2yr2Q58hXXtAGF8RSNO9jpLDlKKPv5v3"></script>
    <script src=" //cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha384-Si3HKTyQYGU+NC4aAF3ThcOSvK+ZQiyEKlYyfjiIFKMqsnCmfHjGa1VK1kYP9UdS"> </script>

    
    @yield('scripts')
   

</body>
</html>