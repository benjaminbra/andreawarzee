@extends('layouts.app')

@section('content')
  <div itemscope itemtype="http://schema.org/Article" class="project col-lg-12 col-md-12 col-xs-12">
        <span itemprop="author" itemscope itemtype="http://schema.org/Person">
            <meta itemprop="name" content="Andrea Warzee">
        </span>
    @foreach($project[0]->content as $content)
      @if($content->lang == $lang)
          <h1 itemprop="name" class="title col-lg-12 col-md-12 col-xs-12">
              {{ $content->title }}
          </h1>
          <span itemprop="articleBody" class="project-description col-lg-12 col-md-12 col-xs-12">
              {!! nl2br(e($content->description)) !!}
          </span>
      @endif
    @endforeach
    <div class="wallop Wallop--slide project-images col-lg-12 col-md-12 col-xs-12">
      <div class="Wallop-list">
        @foreach($project[0]->imageList as $img)
          @if($img->type == "diaporama")
            <div class="Wallop-item">
              <img src="{{ url('/res/img/'.$img->id.'.'.$img->extension) }}"/>
            </div>
          @endif
        @endforeach
      </div>
      @if(count($project[0]->imageList)-1>1)
        <button class="Wallop-buttonPrevious left"><i class="fa fa-arrow-left"></i></button>
        <button class="Wallop-buttonNext right"><i class="fa fa-arrow-right"></i></button>
      @endif
    </div>
  </div>
@endsection

@section('script')
  <script src="{{ url('/lib/wallop/js/Wallop.min.js') }}"></script>
  <script>
    var text = $('.project-description').html().split('<br>');
    var newText = Array();
    for(i in text){
      newText.push(urlify(text[i]));
    }
    $('.project-description').html(newText.join('<br>'));

    function urlify(text) {
      var urlRegex = /(https?:\/\/[^\s]+)/g;
      return text.replace(urlRegex, function(url) {
          return '<a href="' + url + '">' + url + '</a>';
      })
    }
  </script>
  <script type="application/javascript">
  var wallopEl = document.querySelector('.wallop');
  var slider = new Wallop(wallopEl);

  @if(count($project[0]->imageList)-1>1)
  window.onkeydown = function(e) {
    switch (e.keyCode) {
      case 37:
      slider.previous();
      break;
      case 39:
      slider.next();
      break;
    }
  };
  @endif
  </script>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ url('/lib/wallop/css/wallop.css') }}"/>
    <link rel="stylesheet" href="{{ url('/lib/wallop/css/wallop--slide.css') }}"/>
@endsection
