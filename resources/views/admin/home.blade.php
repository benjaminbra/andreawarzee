@extends('admin.layouts.app')

@section('content')
    <div class="col-md-12 paddingizer">
        <form class="form-inline" action="{{ url('/admin/project/load') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="categoryList">Catégorie</label>
                <select name="category" class="form-control">
                    @foreach(Trnslt::tagL() as $tag)
                        @if($tag->lang_id == "fr" && $tag->actif == 1)
                            <option value="{{ $tag->label }}">{{ $tag->content }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Charger</button>
            <a href="{{ url('/admin/image/optimizer') }}" class="btn btn-primary pull-right">Nettoyer les images</a>
        </form>
        @if(isset($category))
            @foreach($category as $tag)
                @if($tag->lang_id == "fr")
                    <div class="paddingizer">
                        Catégorie actuelle : {{ $tag->content }}
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <div class="col-md-12">
        <table class="table table-bordered table-stripped">
            <tr>
                <th>
                    Titre
                </th>
                <th>
                    Description
                </th>
                <th>
                    Date
                </th>
                <th>
                    Nombre d'images
                </th>
                <th>
                    Actions
                </th>
            </tr>
            @foreach($projectList as $project)
                <tr>
                    @foreach($project->content as $content)
                        @if($content->lang == "fr")
                            <td>
                                {{ $content->title }}
                            </td>
                            <td>
                                {{ str_limit($content->description, $limit = 50, $end = '...') }}
                            </td>
                        @endif
                    @endforeach
                    <td>
                        {{ $project->datePost }}
                    </td>
                    <td>
                        {{ count($project->imageList) }}
                    </td>
                    <td>
                        <a href="{{ url('/admin/project/edit/'.$project->id) }}" class="btn btn-primary">
                            Voir / Modifier
                        </a>
                        <a href="{{ url('/admin/project/delete/'.$project->id) }}" class="btn btn-danger">
                            Supprimer (Definitif !)
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
