@extends('admin.layouts.app')

@section('content')
    <div class="col-lg-12">
        <h1>
            @if(isset($project->id) && !empty($project->id))
                Modifier le projet N°{{ $project->id }}
            @else
                Nouveau projet
            @endif
        </h1>
        <hr/>
    </div>
    <form action="{{ url('/admin/project/save') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @if(isset($project->id) && !empty($project->id))
            <input type="hidden" name="id" value="{{ $project->id }}"/>
        @endif
        <div class="form-group col-sm-12">
            <label for="tag" class="col-sm-2">Catégorie</label>
            <div class="col-sm-6">
                <select name="tag" class="form-control" id="tag">
                    @foreach(Trnslt::tagL() as $tag)
                        @if($tag->lang_id == "fr" && $tag->actif == 1)
                            <option value="{{ $tag->label }}" {{ FrmChk::value($project,"labelTag","option",$tag->label) }}>{{ $tag->content }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label for="date" class="col-sm-2">Date du projet</label>
            <div class="col-sm-6">
                <input type="text" id="date" name="datePost" value="{{ Trnslt::dateTranslate('en',FrmChk::value($project,"datePost","date",date('d/m/Y'))) }}" class="form-control date-picker-here" data-language="fr" readonly/>
            </div>
        </div>
        @foreach(Trnslt::langL() as $lang)
            <div class="col-sm-12">
                <h3 class="col-sm-12">{{ $lang->label }}</h3>
            </div>
            <div class="form-group col-sm-12">
                <label for="title[{{ $lang->label }}]" class="col-sm-2">Titre*</label>
                <div class="col-sm-6">
                    <input type="text" name="title[{{ $lang->label }}]" value="{{ FrmChk::value($pT,"title","translate",$lang->label) }}" class="form-control" id="title[{{ $lang->label }}]" required maxlength="35">
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label for="description[{{ $lang->label }}]" class="col-sm-2">Description</label>
                <div class="col-sm-6">
                    <textarea name="description[{{ $lang->label }}]" id="description[{{ $lang->label }}]" class="form-control">{{ FrmChk::value($pT,"description","translate",$lang->label) }}</textarea>
                </div>
            </div>
            <hr/>
        @endforeach
        <div class="col-sm-12">
            <div class="col-sm-1">
                <button class="btn btn-primary">Envoyer</button>
            </div>
            <div class="no-padd col-sm-12">* Requis</div>
        </div>
        <div class="form-group col-sm-12">
            <div class="col-sm-12">
                <h3>
                    Gestion des images
                </h3>
                <button id="addImage" type="button" class="btn btn-primary">Ajouter une image</button>
                <hr/>
            </div>
            <div id="images">

            </div>
            @if(isset($pI) && !empty($pI))
                <div id="actualImages">
                    @foreach($pI as $image)
                        <div class="col-sm-2">
                            <div class="col-sm-12">
                                {{ $image->type }}
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" name="imageUpdate[{{ $image->id }}][id]" value="{{ $image->id }}">
                                <input type="number" title="Position" class="form-control text-center" name="imageUpdate[{{ $image->id }}][pos]" value="{{ $image->position }}"/>
                            </div>
                            <div class="col-sm-12">
                                <img class="img-project" src="{{ url('/res/img/'.$image->id.'.'.$image->extension) }}"/>
                            </div>
                            <div class="col-sm-12">
                                <button type="button" id="{{ $image->id }}" class="delete btn btn-warning">Supprimer</button>
                            </div>
                            <hr/>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ url('/lib/airdatepicker/css/datepicker.min.css') }}">
@endsection

@section('script')
<script ype="application/javascript" src="{{ url('/lib/airdatepicker/js/datepicker.min.js') }}"></script>
<script ype="application/javascript" src="{{ url('/lib/airdatepicker/js/i18n/datepicker.fr.js') }}"></script>
<script>
    var lastPos = 0;
    @if(isset($pI) && !empty($pI))
        lastPos = {{ count($pI) }};
    @endif
    $('#addImage').on('click',function(){
        lastPos++;
        $('#images').append(
                '<div class="image-block col-sm-12">' +
                    '<div class="col-sm-7">' +
                        '<input type="file" class="form-control" name="images['+lastPos+'][file]" id="images" accept="image/*">' +
                        '<input type="number" class="form-control" name="images['+lastPos+'][position]" title="position" value="'+lastPos+'">'+
                        '<select class="form-control" name="images['+lastPos+'][type]">' +
                            '<option value="diaporama">Diaporama</option>' +
                            '<option value="vignette">Vignette</option>' +
                        '</select>' +
                    '</div>'+
                    '<div class="col-sm-5">' +
                        '<button id="remove" type="button" class="btn btn-warning">Supprimer</button>' +
                    '</div>' +
                '</div>');
    });

    $('#images').on('click','#remove',function(){
        $(this).parent().parent().remove();
    });

    $('#date').datepicker();

    @if(isset($project->id) && !empty($project->id))
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.delete').on('click',function(){
            var pid = $(this).attr("id");
            console.log('clickDelete'+pid);
            $.ajax({
                method: "POST",
                url: "{{ url('/admin/project/image/delete') }}",
                data : {
                    id : pid
                }
            }).done(function(id){
                $("button#"+id).parent().parent().remove();
            });
        });
    @endif
</script>
@endsection