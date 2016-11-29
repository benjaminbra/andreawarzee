<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Benjamin Brasseur</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/res/adminStyle.css') }}">
    <link rel="stylesheet" href="{{ url('/lib/fontawesome/css/font-awesome.min.css') }}">
    @yield('css')
</head>
<body>
<div class="page-container">
    <div class="mobile-menu col-md-12">
        <div class="mobile-header">
            <div class="col-md-10 col-xs-10">
                <div class="col-md-1">
                    <a class="title" href="{{ url('/admin') }}">
                        Administration
                    </a>
                </div>
            </div>
            <div class="col-md-1">
                <button class="btn btn-default"><i class="fa fa-bars"></i></button>
            </div>
        </div>
        <div class="menu col-lg-12 col-md-12 col-xs-12 text-center">
            <a href="{{ url('/') }}" class="col-lg-3">
                Retour au site
            </a>
            <a href="{{ url('/admin') }}" class="col-lg-3">
                Liste des projets
            </a>
            <a href="{{ url('/admin/project/new') }}" class="col-lg-3">
                Nouveau projet
            </a>
            <a href="{{ url('/admin/param') }}" class="col-lg-3">
                Paramètres
            </a>
        </div>
    </div>
    <div class="col-md-12">
        @yield('content')
    </div>
</div>
<script type="application/javascript" src="{{ url('lib/jquery/jquery.min.js') }}"></script>
<script type="application/javascript">
    $('.block-menu').mouseenter(function(){
        $(this).children('.description').slideToggle();
    }).mouseleave(function(){
        $(this).children('.description').slideToggle();
    });

    $('.mobile-menu button').on('click', function(){
        $('.menu').toggleClass('active');
    });
</script>
@yield('script')
</body>
</html>