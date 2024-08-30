<!DOCTYPE html>
<html lang="en" dir="ltr" data-startbar="dark" data-bs-theme="light">

<head>


    <meta charset="utf-8" />
    <title>{{ isset($title) ? $title . ' - ' : '' }} {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" data-navigate-once  href="{{ asset('backend/assets/images/favicon.ico') }}">



    <link rel="stylesheet" data-navigate-once href="{{ asset('backend/assets/libs/jsvectormap/css/jsvectormap.min.css') }}">

    <!-- App css -->
    <link  data-navigate-once href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link  data-navigate-once href=" {{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link data-navigate-once  href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link data-navigate-once  href="{{ asset('backend/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link data-navigate-once  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1/themes/prism-okaidia.min.css" />
    <link data-navigate-once  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/prismjs@1/plugins/line-numbers/prism-line-numbers.min.css" />
    <link data-navigate-once rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @isset($head)
        {{ $head }}
    @endisset
    @livewireStyles
</head>

<body>

    @include('components.layouts.dashboard.topbar')
    @include('components.layouts.dashboard.sidebar')

    <div class="page-wrapper">
        <div class="page-content">
            <div class="container-xxl">

                <div class="row">
                    <d iv class="col-lg-12">
                        {{ $slot }}

                </div>
            </div>

        </div>
    </div>



    <script data-navigate-once src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>

    <script data-navigate-once src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('backend/assets/data/stock-prices.js') }}"></script>
    <script data-navigate-once src="{{ asset('backend/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script data-navigate-once src="{{ asset('backend/assets/libs/jsvectormap/maps/world.js') }}"></script>
    <script data-navigate-once src="{{ asset('backend/assets/js/pages/index.init.js') }}"></script>
    <script data-navigate-once src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script data-navigate-once src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--end body-->
    @isset($foot)
        {{ $foot }}
    @endisset
    @livewireScripts

    

    <script>
        window.addEventListener('livewire:init', () => {
            Livewire.on('toast', (data) => {
                console.log(data);
                iziToast.show({
                    position: "topCenter",
                    message: data[0].message,
                });
            })
        })
    </script>
</body>

</html>
