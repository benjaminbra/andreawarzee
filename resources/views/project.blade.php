@extends('layouts.app')

@section('content')
<div class="project col-lg-12 col-md-12 col-xs-12">
    @foreach($project[0]->content as $content)
        @if($content->lang == $lang)
            <h1 class="title col-lg-12 col-md-12 col-xs-12">
                {{ $content->title }}
            </h1>
            <span class="project-description col-lg-12 col-md-12 col-xs-12">
                {!! nl2br(e($content->description)) !!}
            </span>
        @endif
    @endforeach
    <div class="wallop Wallop--slide project-images col-lg-12 col-md-12 col-xs-12">
        <div class="Wallop-list">
            @foreach($project[0]->imageList as $img)
                @if($img->type == "diaporama")
                    <div class="Wallop-item">
                        <img class="project-image" src="{{ url('/res/img/'.$img->id.'.'.$img->extension) }}"/>
                    </div>
                @endif
            @endforeach
        </div>
        @if(count($project[0]->imageList)-1>1)
            <button class="Wallop-buttonPrevious left"><i class="fa fa-arrow-left"></i></button>
            <button class="Wallop-buttonNext right"><i class="fa fa-arrow-right"></i></button>
        @endif
    </div>
    @if(count($projectList)>0 && $projectList[0]->content != null)
      <div class="col-lg-12 col-md-12 col-xs-12">
        <h2>Suggestions</h2>
        <div class="col-lg-12 col-md-12 col-xs-12">
          @foreach($projectList as $projectLink)
            @if(count($projectLink->imageList)>0)
              @foreach($projectLink->imageList as $imageLink)
                @if($imageLink->type == "vignette")
                    <a href="{{ url($lang.'/p/'.$projectLink->id) }}" style="background:url('{{ url('/res/img/'.$imageLink->id.'.'.$imageLink->extension) }}');background-repeat: no-repeat;background-size: cover;background-position:center;" class="block-menu col-lg-2 col-md-2 col-xs-2">

                        <span class="description description-projet">
                            @foreach($projectLink->content as $content)
                                @if($content->lang == $lang)
                                    {{ $content->title }}
                                @endif
                            @endforeach
                            <span class="date-project">
                                {{ $projectLink->datePost }}
                            </span>
                        </span>
                    </a>
                    @break
                @endif
              @endforeach
            @endif
          @endforeach
        </div>
      </div>
    @endif

</div>
@endsection

@section('script')
    <script src="{{ url('/lib/wallop/js/Wallop.min.js') }}"></script>
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
