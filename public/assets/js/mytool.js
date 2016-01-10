/*
  $(function() {
    $('#remoteModalButton').on('click', function() {
      $('#MyModal').removeData('bs.modal'); //< 毎回新規に読み込み
      $('#MyModal').modal({'remote': 'http://27.120.86.104/mytool/todo/dialog?kind=todo'});
    });
    $('#remoteModalButton2').on('click', function() {
      $('#MyModal').removeData('bs.modal'); //< 毎回新規に読み込み
      $('#MyModal').modal({'remote': 'http://27.120.86.104/mytool/todo/dialog?kind=category'});
    });
  });
*/
function openForm(url, id) {
  var refer=location.href;
  $.ajax({
    async:false,
    type:"post",
    url:url,
    data:{
      id:id,
      refer:refer,
    },
    success:function(msg) {
      var modal=document.getElementById('MyModal');
      modal.innerHTML=msg;
      $("#MyModal").modal('toggle');
    },
    error:function(msg) {
      var out=document.getElementById('message');
      out.innerHTML=msg;
      return false;
    }
  });
}

function saveForm(id) {

  var url='/mytool/todoedit/save';
  var form  = $('#fm');
  document.getElementById('todo_id').value=id;

  $.ajax({
    async:false,
    type:"post",
    dataType : 'json',
    url:url,
    data:form.serialize(),
  }).done(function(json){
    if( json.res != 'OK' )
    {
      alert(json.error);
      return;
    }
    location.href=document.getElementById('refer').value;

  }).fail(function() {
          alert('ajaxエラーが発生しました');
  });
}

function deleteForm(form,id) {
    form.action='/mytool/todoedit/delete';
    form.todo_id.value=id;
    form.method='post';
    form.submit();
}

function changeStatus(form,id) {
    var status=document.getElementById('status_'+id);
    form.action='changeStatus';
    form.todo_id.value=id;
    form.status_id.value=status.value;
    form.refer.value=location.href;
    form.method='post';
    form.submit();
}

function actionCategory(url,delf) {
  var form  = $('#fm');
  var obj=document.getElementsByName('delf');
  obj[0].value=delf;

  $.ajax({
    async:false,
    type:"post",
    dataType : 'json',
    url:url,
    data:form.serialize(),
  }).done(function(json){
    if( json.res != 'OK' )
    {
      alert(json.error);
      return;
    }
    location.href=document.getElementById('refer').value;

  }).fail(function() {
          alert('ajaxエラーが発生しました');
  });
}

function selectCategory(id,name) {
    var category_name=document.getElementById('name');
    var category_id=document.getElementById('category_id');

    category_name.value=name
    category_id.value=id
}

function clearCategory() {
    var category_name=document.getElementById('name');
    var category_id=document.getElementById('category_id');

    category_name.value="";
    category_id.value="";
}
