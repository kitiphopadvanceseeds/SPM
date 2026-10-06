<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config( 'SPM ระบบคลังเมล็ด') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link href="https://fonts.googleapis.com/css2?family=Prompt&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Prompt', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-weight: 700;
        }

    </style>
    @yield('style')

</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

<!-- JavaScript Libraries -->

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>


<script>
    var url = "{{ url('/') }}";
    var secure_url = "{{ secure_url('/') }}";
    // var base_url = (document.domain === "127.0.0.1" || document.domain === "localhost") ? url : secure_url;

    const base_url = window.location.origin;

    const baseUrl       = "{{ url('/') }}";
    const secureBaseUrl = "{{ secure_url('/') }}";
    function getAjaxUrl(pathUrl = "", condition = "/") {
            return window.location.protocol === 'https:' 
                ? secureBaseUrl + condition + pathUrl 
                : baseUrl + condition + pathUrl;
    }

</script>
<script>
    function setSpiner(status) {
        $("#spinner").addClass("spinner2");
        if (status == 'on') {
            $("#spinner").css({
                "opacity": "1",
                "visibility": "inherit"
            });
            return false;
        }
        setTimeout(() => {
            $("#spinner").css({
                "opacity": "0",
                "visibility": "hidden"
            });
        }, 1000);
    }
</script>
@yield('script')
</body>

</html>
