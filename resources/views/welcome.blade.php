<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="dark">

<head>


    <meta charset="utf-8" />
            <title>Rizz | Rizz - Admin & Dashboard Template</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
            <meta content="" name="author" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />

            <!-- App favicon -->
            <link rel="shortcut icon" href="assets/images/favicon.ico">



    <link rel="stylesheet" href="assets/libs/jsvectormap/css/jsvectormap.min.css">

     <!-- App css -->
     <link href="{{asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
     <link href=" {{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
     <link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />

</head>
@livewireStyles
<body>

    <livewire:user/>
</body>

 @livewireScripts
 <script src="{{asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
 <script src="{{asset('backend/assets/libs/simplebar/simplebar.min.js')}}"></script>

 <script src="{{asset('backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script>
 <script src="{{asset('backend/assets/data/stock-prices.js')}}"></script>
 <script src="{{asset('backend/assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
 <script src="{{asset('backend/assets/libs/jsvectormap/maps/world.js')}}"></script>
 <script src="{{asset('backend/assets/js/pages/index.init.js')}}"></script>
 <script src="{{asset('backend/assets/js/app.js')}}"></script>
</body>
<!--end body-->

</html>
