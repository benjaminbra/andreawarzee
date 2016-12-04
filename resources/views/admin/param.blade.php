@extends('admin.layouts.app')

@section('content')
    <div class="col-lg-12">
        <h1>
            Gestion des paramètres
        </h1>
        <hr/>
    </div>
    <form action="{{ url('/admin/param/save') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @foreach($params as $param)
            <div class="form-group col-sm-12">
                <label for="{{ $param->label }}" class="col-sm-2">{{ $param->label }}</label>
                <div class="col-sm-6">
                    @if($param->type == "text")
                        <textarea name="{{ $param->label }}" class="form-control" id="{{ $param->label }}">{{ $param->content }}</textarea>
                    @elseif($param->type == "image")
                        <input type="file" name="{{ $param->label }}" class="form-control" id="{{ $param->label }}"/>
                        <div class="col-sm-12">Version actuelle : <img class="preview-image" src="{{ $param->content }}"/></div>
                    @endif
                </div>
            </div>
        @endforeach
        <button class="btn btn-primary">Mettre à jour</button>
    </form>
@endsection
