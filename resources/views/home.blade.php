@extends('layouts.app')

@section('content')
    @if(isset($tagList) && !empty($tagList))
        @foreach($tagList as $tag)
            @if($tag->lang_id == $lang)
                <div class="no-padd col-lg-12 col-md-12 col-xs-12">
                    <h1 class="home-title">
                        {{ $tag->content }}
                    </h1>
                    <span class="home-description col-lg-6 col-md-8 col-xs-12">
                        {{ $tag->description }}
                    </span>
                </div>
            @endif
        @endforeach
    @endif
    @if(empty($projectList[0]))
        <div class="col-lg-12 text-center">
            Il n'y a pas de projet dans cette catégorie pour l'instant.
        </div>
    @endif
    @foreach($projectList as $project)
      @foreach($project->imageList as $image)
          @if($image->type == "vignette")
              <a href="{{ url($lang.'/p/'.$project->id) }}" style="background:url('{{ url('/res/img/'.$image->id.'.'.$image->extension) }}');background-repeat: no-repeat;background-size: cover;background-position:center;" class="block-menu col-lg-2 col-md-3 col-xs-6">

                  <span class="description description-projet">
                      @foreach($project->content as $content)
                          @if($content->lang == $lang)
                              {{ $content->title }}
                          @endif
                      @endforeach
                      <span class="date-project">
                          {{ $project->datePost }}
                      </span>
                  </span>
              </a>
              @break
          @endif
      @endforeach

    @endforeach
@endsection
