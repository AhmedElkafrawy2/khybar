<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $settings->meta_keywords }}">
    <meta name="description" content="{{ $settings->meta_description }}">
    <title>{{ $settings->name }} @yield('title')</title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquerysctipttop.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.slidey.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link href="https://fontlibrary.org/face/droid-arabic-naskh" rel="stylesheet">

	<!--[if lt IE 9]>
        <script src=".{{ asset('js/ie8-responsive-file-warning.js') }}"></script>
    <![endif]-->
	<!--[if lt IE 9]>
        <script src="{{ asset('js/html5shiv.min.js') }}"></script>
        <script src="{{ asset('js/respond.min.js') }}"></script>
    <![endif]-->

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.slidey.js') }}"></script>
    <script src="{{ asset('js/jquery.dotdotdot.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <meta name="twitter:card" content="summary">
    <meta name="twitter:site" content="@SeyamMs">
    <meta name="twitter:creator" content="@SeyamMs">
    <meta name="twitter:domain" content="{{ route('index') }}">
    @if ( isset ( $new ) )
        <meta name="twitter:image" content="{{ asset($path.'news/'.$new->image()->first()->filename) }}">
        <meta name="twitter:title" content="{{ $settings->name }} | {{ $new->title }}">
        <meta name="twitter:description" content="{{ $new->description }}">
    @elseif ( isset ( $essay ) )
        <meta name="twitter:image" content="{{ asset($path.'essays/'.$essay->image()->first()->filename) }}">
        <meta name="twitter:title" content="{{ $settings->name }} | {{ $essay->title }}">
        <meta name="twitter:description" content="{{ $essay->description }}">
    @else
        <meta name="twitter:title" content="{{ $settings->name }}">
        <meta name="twitter:description" content="{{ $settings->name }}">
    @endif


    <meta property="og:url"content="{{ route('index') }}">
    @if ( isset ( $new ) )
        <meta property="og:image" content="{{ asset($path.'news/'.$new->image()->first()->filename) }}">
        <meta property="og:title" content="{{ $settings->name }} | {{ $new->title }}">
    @elseif ( isset ( $essay ) )
        <meta property="og:image" content="{{ asset($path.'essays/'.$essay->image()->first()->filename) }}">
        <meta property="og:title" content="{{ $settings->name }} | {{ $essay->title }}">
    @else
        <meta property="og:title" content="{{ $settings->name }}">
    @endif

</head>
<body>
    <div id="app">
        @yield('content')
    </div>

    <script>
        $("#slidey").slidey({
            interval: 3000,
            listCount: 5,
            showList: true
        });
        $(".slidey-list-description").dotdotdot();
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/ie-emulation-modes-warning.js') }}"></script>
    <script src="{{ asset('js/ie10-viewport-bug-workaround.js') }}"></script>
    <script src="{{ asset('js/jquery.webticker.min.js') }}"></script>
    <script>
		jQuery(function($) {
	        $('.ticker').webTicker({
                height:'45px'
            });
        });
    </script>

    <script>
		var slideIndex = 1;
		showSlides(slideIndex);
		function plusSlides(n) {
            showSlides(slideIndex += n);
		}
		function currentSlide(n) {
            showSlides(slideIndex = n);
		}
		function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
		}
	</script>
</body>
</html>
