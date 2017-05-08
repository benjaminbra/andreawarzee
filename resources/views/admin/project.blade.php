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
    <span class="question"><i class="fa fa-question-circle-o"></i>
      <div class="sub-question">
        Lors de la création du projet, il est nécessaire de modifier la date et la catégorie pour les enregistrer. <br/>
        La sauvegarde d'un champ de texte (titre ou description) se fait lorsque l'on quitte ce champ.<br/>
        (En appuyant sur la touche Entrée ou en cliquant en dehors de celui-ci.)
      </div>
    </span>
    <div id="update-status">Sauvegardé</div>
    <form action="{{ url('/admin/project/save') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        @if(isset($project->id) && !empty($project->id))
            <input type="hidden" name="id" value="{{ $project->id }}"/>
        @endif
        <div class="form-group col-sm-12">
            <label for="public" class="col-sm-2">Publication</label>
            <div class="col-sm-6">
                @if(FrmChk::value($project,"published") == 1)
                    <button type="button" id="public" title="Mettre en non publié" class="public">Publié</button>
                @else
                    <button type="button" id="public" title="Mettre en publié" class="unpublic">Non publié</button>
                @endif
            </div>
        </div>
        <div class="form-group col-sm-12">
            <label for="tag" class="col-sm-2">Catégorie</label>
            <div class="col-sm-6">
                <select name="tag" class="form-control" id="tag">
                    <option value="NULL">Choisissez une catégorie</option>
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
                    <input type="text" name="title[{{ $lang->label }}]" value="{{ FrmChk::value($pT,"title","translate",$lang->label) }}" class="text form-control" id="title[{{ $lang->label }}]" required maxlength="35">
                </div>
            </div>
            <div class="form-group col-sm-12">
                <label for="description[{{ $lang->label }}]" class="col-sm-2">Description</label>
                <div class="col-sm-6">
                  <textarea class="text form-control" id="description[{{ $lang->label }}]" name="description[{{ $lang->label }}]">{{ FrmChk::value($pT,"description","translate",$lang->label) }}</textarea>
                </div>
            </div>
            <hr/>
        @endforeach
        <div class="col-sm-12">
            <div class="no-padd col-sm-12">* Requis</div>
        </div>
        <div class="form-group col-sm-12">
            <div class="col-sm-12">
                <h3>
                    Gestion des images
                </h3>
                <div class="form-group col-sm-12">
                    <label for="type" class="col-sm-2">Type d'image</label>
                    <div class="col-sm-6">
                        <select name="type" class="form-control" id="type">
                          <option value="diaporama">Diaporama</option>
                          <option value="vignette">Vignette</option>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                  <input id="file" type="file" name="file" />
                </div>
                <hr/>
            </div>
            <div id="images">

            </div>
            @if(isset($pI) && !empty($pI))
                <div id="image">
                    @foreach($pI as $image)
                        <div class="col-sm-2 grab"  id="g{{ $image->position }}">
                            <div class="col-sm-12">
                              <select id="s{{ $image->id }}" class="form-control typeS">
                                <option value="diaporama" {{ FrmChk::value($image,"type","option","diaporama") }}>Diaporama</option>
                                <option value="vignette" {{ FrmChk::value($image,"type","option","vignette") }}>Vignette</option>
                              </select>
                            </div>
                            <div class="col-sm-12">
                                <input type="hidden" name="imageUpdate[{{ $image->id }}][id]" value="{{ $image->id }}">
                                <input type="text" id="p{{ $image->id }}" class="position form-control" value="{{ $image->position }}">
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
    <link rel="stylesheet" href="{{ url('/lib/pekebyte/css/custom.css') }}">
@endsection

@section('script')
<script type="application/javascript" src="{{ url('/lib/airdatepicker/js/datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ url('/lib/airdatepicker/js/i18n/datepicker.fr.js') }}"></script>
<script type="text/javascript" src="{{ url('/lib/updator/updator.js')}}"></script>
<script type="text/javascript" src="{{ url('/lib/pekebyte/js/pekeUpload.min.js') }}"></script>
<script>
  var updateList = Array();
  sId = {{ $project->id }};
  imgType = "diaporama";
  token = "{{ csrf_token() }}";
  lastPos = 0;
  selectedD = "";
  selectedV = "";
  urlD = "{{ url('/admin/project/api/data') }}";
  urlS = "{{ url('/admin/project/api/save') }}";
  urlR = "{{ url('/admin/project/image/delete') }}";
  @if(isset($pI) && !empty($pI))
    lastPos = {{ count($pI) }};
  @endif

  $('#public').on('click',function(){
    var obj = $(this);
    updateList.push(obj);
    checkUpdate();
    var published = Array("Non publié","Publié");
    var project = getData(token,urlD,"project",sId,function(data){
      updateForm(token,urlS,'project','published',sId,1-data.published);
      $('#public').toggleClass('public unpublic').text(published[1-data.published]);
      var i = updateList.indexOf(obj);
      updateList.splice(i,1);
      checkUpdate();
    });
  });


  $('#date').datepicker({
    onSelect : function(fd, d, inst){
      var obj = $(this);
      updateList.push(obj);
      checkUpdate();
      var project = getData(token,urlD,"project",sId,function(data){
        updateForm(token,urlS,'project','datePost',sId,fd);
        var i = updateList.indexOf(obj);
        updateList.splice(i,1);
        checkUpdate();
      });
    }
  });

  $('#tag').on('change',function(){
    var obj = $(this);
    updateList.push(obj);
    checkUpdate();
    var project = getData(token,urlD,"project",sId,function(data){
      updateForm(token,urlS,'project','labelTag',sId,obj.val());
      var i = updateList.indexOf(obj);
      updateList.splice(i,1);
      checkUpdate();
    });
  });

  $('.text').on('change',function(){
    var obj = $(this);
    updateList.push(obj);
    checkUpdate();
    var project = getData(token,urlD,"project_translate",sId,function(data){
      updateForm(token,urlS,'project_translate',obj.attr('id'),sId,obj.val());
      var i = updateList.indexOf(obj);
      updateList.splice(i,1);
      checkUpdate();
    });
  });

  $('textarea.text').keyup(function(e){
    if(e.keyCode == 13){
      var obj = $(this);
      updateList.push(obj);
      checkUpdate();
      var project = getData(token,urlD,"project_translate",sId,function(data){
        updateForm(token,urlS,'project_translate',obj.attr('id'),sId,obj.val());
        var i = updateList.indexOf(obj);
        updateList.splice(i,1);
        checkUpdate();
      });
    }
  });

  $("#type").on('change', function(){
    imgType = $(this).val();
  });

  $("#file").pekeUpload({
    dragMode : true,
    url : '{{ url('/admin/project/api/images') }}',
    tokenF : token,
    dragText : "Glissez vos images ici",
    data : {"id":sId, "type":imgType},
    onFileSuccess : function(f,e){
      updateForm(token,urlS,"image","type",e.id,imgType);
      $(".pekerow.pkrw").remove();
      if(imgType == "diaporama"){
        selectedD = "selected";
      } else if (imgType == "vignette"){
        selectedV = "selected";
      }
      insertImage(e,selectedD,selectedV);
    }
  });

  $('#image').on('change','.typeS', function(){
    var pid = $(this).attr("id").substring(1);
    var obj = $(this);
    updateList.push(obj);
    checkUpdate();
    var project = getData(token,urlD,"image",pid,function(data){
      updateForm(token,urlS,"image","type",pid,obj.val());
      var i = updateList.indexOf(obj);
      updateList.splice(i,1);
      checkUpdate();
    });
  });

  $('#image').on('click','.delete',function(){
      var pid = $(this).attr("id");
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.ajax({
        method: "POST",
        url: urlR,
        data : {
            id : pid
        },
        success: function(id){
            $("button#"+id).parent().parent().remove();
        }
      });
  });

  $('#image').on('change','.position',function(){
    var pid = $(this).attr('id').substring(1);
    var obj = $(this);
    updateList.push(obj);
    checkUpdate();
    var project = getData(token,urlD,"image",pid,function(data){
      updateForm(token,urlS,"image","position",pid,obj.val());
      $('#p'+pid).parent().parent().attr('id','g'+obj.val());
      updatePosition($('#p'+pid).parent().parent().index());
      var i = updateList.indexOf(obj);
      updateList.splice(i,1);
      checkUpdate();
    });
  });

  function insertImage(e,selectedD,selectedV){
    $("#image").append('<div class="col-sm-2" id="g'+e.position+'">'+
        '<div class="col-sm-12">'+
          '<select id="s'+e.id+'" class="form-control typeS">'+
            '<option value="diaporama" '+selectedD+'>Diaporama</option>'+
            '<option value="vignette" '+selectedV+'>Vignette</option>'+
          '</select>'+
        '</div>'+
        '<div class="col-sm-12">'+
            '<input type="hidden" name="imageUpdate['+e.id+'][id]" value="'+e.id+'">'+
            '<input type="text" id="p'+e.id+'" class="position form-control" value="'+e.position+'">'+
        '</div>'+
        '<div class="col-sm-12">'+
            '<img class="img-project" src="{{ url('/res/img/') }}/'+e.id+'.'+e.extension+'"/>'+
        '</div>'+
        '<div class="col-sm-12">'+
            '<button type="button" id="'+e.id+'" class="delete btn btn-warning">Supprimer</button>'+
        '</div>'+
        '<hr/>'+
    '</div>');
  }

  function updatePosition(idx){
    var size = $('#image').children().length;
    var obj = $('#image').children().eq(idx);
    var changeUp = null;
    var changeDown = null;
    for(var i = 0; i < size; i++){
      if(i != idx){
        var img = $('#image').children().eq(i);
        if(parseInt(obj.attr('id').substring(1)) < parseInt(img.attr('id').substring(1))){
          changeDown = img;
        } else {
          changeUp = img;
        }
      }
    }
    if(changeUp != null){
      obj.insertAfter(changeUp);
    } else {
      obj.insertBefore(changeDown);
    }
  }
</script>
@endsection
