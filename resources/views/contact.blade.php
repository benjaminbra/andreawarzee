@extends('layouts.app')

@section('content')

    <div class="col-md-12 text-center kind-text">
        <h3>
            Retrouvez moi sur d'autres plateformes
        </h3>
    </div>
    <div class="col-md-12 text-center">
        <a href="https://fr.linkedin.com/in/andrea-warzee" target="_blank" class="col-md-1 center-block social" title="Mon LinkedIn">
            <button class="btn btn-primary">
                <i class="fa fa-linkedin"></i>
            </button>
        </a>
        <a href="https://plus.google.com/u/0/118096650572692503483" target="_blank" class="col-md-1 center-block social" title="Mon Google Plus">
            <button class="btn btn-danger">
                <i class="fa fa-google-plus"></i>
            </button>
        </a>
    </div>
    <div class="col-md-12 marginator">

    </div>
    <div class="col-md-12 text-center kind-text">
        <h3>
            Ou laissez moi un message
        </h3>
    </div>
    <div class="col-md-12">
        <form action="{{ url($lang.'/contact/send') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group col-sm-12">
                <label for="email" class="col-sm-2">Email</label>
                <div class="col-sm-6">
                    <input type="email" name="email" class="form-control" id="email" required/>
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label for="email" class="col-sm-2">Contenu</label>
                <div class="col-sm-6">
                    <textarea name="email" class="form-control" id="content" required></textarea>
                </div>
            </div>
            <div class="col-sm-12">
                <button class="btn btn-primary center-block">Envoyer</button>
            </div>
        </form>
    </div>


@endsection