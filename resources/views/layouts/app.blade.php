<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Andréa Warzee</title>
    <link rel="shortcut icon" href="{{url('/res/img/logo.png')}}" type="image/x-icon" />
    <link rel="stylesheet" type="text/css" href="{{ url('/lib/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('/res/style.css') }}">
    <link rel="stylesheet" href="{{ url('/lib/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ url('/lib/perfectscrollbar/css/perfect-scrollbar.min.css') }}" />
    @yield('css')
</head>
<body>
<div class="page-container">
    <div class="no-padd header col-lg-2 col-md-3">
        <div class="no-padd sub-header col-lg-12 col-md-12">
            <div class="header-height col-lg-12 col-md-12">

            </div>
            <a href="{{ url('/'.$lang) }}" class="block-header col-lg-12 col-md-12 col-xs-12">
                <img class="img-responsive" alt="logo" src="{{url('/res/img/logo.png')}}"/>
            </a>
            <div class="block-description col-lg-12 col-md-12 col-xs-12">
                <span class="description">
                    {{ Trnslt::profilD($lang."_description")[0]->content }}
                </span>
            </div>
            <div class="footer col-lg-12 col-md-12 text-center">
                <hr>
                Site par Benjamin Brasseur <br/>
                Plan du site |
                @if(Auth::guest())
                    <a href="{{ url('/login') }}">Connexion</a>
                @else
                    <a href="{{ url('/admin') }}">Administration</a> |
                    <a href="{{ url('/logout') }}" title="Déconnexion">
                        <i class="fa fa-power-off"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="no-padd scrollable-block col-lg-10 col-md-9 col-xs-12">
        <div class="mobile-menu col-xs-12">
            <div class="mobile-header">
                <div class="col-xs-10">
                    <div class="col-xs-1">
                        <a href="{{ url('/'.$lang) }}">
                            <img class="logo" alt="logo" src="{{url('/res/img/logo.png')}}"/>
                        </a>
                    </div>
                </div>
                <div class="col-xs-1">
                    <button class="btn btn-default"><i class="fa fa-bars"></i></button>
                </div>
            </div>
            <div class="no-padd menu col-lg-12 col-md-12 col-xs-12 text-center">
                <span class="description">
                    {{ Trnslt::profilD($lang."_description")[0]->content }}
                </span>
                <a href="{{ url('/'.$lang) }}" class="no-padd col-lg-1 col-md-1 col-xs-12 center-block">
                    {{ Trnslt::profilD($lang."_home")[0]->content }}
                </a>
                @foreach(Trnslt::tagL() as $tag)
                    @if($tag->actif == 1 && $tag->lang_id == $lang)
                        <a href="{{ url($lang.'/type/'.$tag->label) }}" class="no-padd col-lg-2 col-md-2 col-xs-12 center-block">
                            {{ $tag->content }}
                        </a>
                    @endif
                @endforeach
                <a href="{{ url($lang.'/contact') }}" class="no-padd col-lg-1 col-md-1 col-xs-12 center-block">
                    Contact
                </a>
                <span class="lang">
                    <a id="langFR" href="{{ url(Trnslt::setRoute('fr')) }}">FR</a> |
                    <a id="langEN" href="{{ url(Trnslt::setRoute('en')) }}">EN</a>
                </span>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-xs-12">
            @yield('content')
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ url('/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ url('/lib/perfectscrollbar/js/perfect-scrollbar.jquery.min.js') }}"></script>
<script type="application/javascript">
    var map = {65: false, 87: false};
    $(document).keydown(function(e) {
        if (e.keyCode in map) {
            map[e.keyCode] = true;
            console.log(map);
            if (map[65] && map[87]) {
                $('body').toggleClass('unicorn');
            }
        }
    }).keyup(function(e) {
        if (e.keyCode in map) {
            map[e.keyCode] = false;
        }
    });
    $('.block-menu').mouseenter(function(){
        $(this).children('.description').slideToggle();
    }).mouseleave(function(){
        $(this).children('.description').slideToggle();
    });

    $('.mobile-menu button').on('click', function(){
        $('.menu').toggleClass('active');
    });

    $('.scrollable-block').perfectScrollbar();
</script>
@yield('script')
</body>
</html>
