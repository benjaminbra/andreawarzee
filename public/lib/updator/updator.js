function checkUpdate(){
  if(updateList.length > 0){
    $("#update-status").text('Sauvegarde en cours');
  } else {
    $("#update-status").text('Sauvegardé');
  }
}

function getData(token,urlD,table,id,callback){
    console.log(id);
    console.log(table);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': token
        }
    });
    $.ajax({
      url: urlD,
      method: 'POST',
      dataType: 'json',
      data :  {"table":table,"id":id},
      crossDomain : false,
      success : function(data){
          callback(data);
      },
      error : function(e){
        console.log(e);
      }
    });
};

function updateForm(token,urlS,table="",name="",id="",data=""){
  var updated;
  var dataOut;
  dataOut = {"table":table,"name":name,"id":id,"data":data};
  updateAjax(token,urlS,dataOut);
  return updated;
}

function updateAjax(token,urlS,dataOut){
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': token
      }
  });
  $.ajax({
    url: urlS,
    method: 'POST',
    dataType: 'json',
    data : dataOut,
    crossDomain : false,
    success: function(d){
      console.log(d);
    },
    error: function(e){
      console.log(e);
    }
  });
}
