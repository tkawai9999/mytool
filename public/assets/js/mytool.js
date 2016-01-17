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
function openForm(url, id, mode) {
  $.ajax({
    async:false,
    type:"post",
    url:url,
    data:{
      id:id,
    },
    success:function(msg) {
      var modal=document.getElementById('MyModal');
      modal.innerHTML=msg;
      if (mode=="new") $("#MyModal").modal('toggle');
      changeRepeat();
    },
    error:function(msg) {
      var out=document.getElementById('message');
      out.innerHTML=msg;
      return false;
    }
  });
}

function actionForm(url,id) {
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
      bootbox.alert(json.error, function() {});
      return;
    }
    location.reload(true);

  }).fail(function() {
    bootbox.alert('ajaxエラーが発生しました', function() {});
  });
}
function closeForm() {
  location.reload(true);
}

function changeRepeat() {
  var flag=document.getElementById('repeat_flag');
  if (flag.checked)
  {
    document.getElementById("repeat_block").style.display="block";
  }
  else
  {
    document.getElementById("repeat_block").style.display="none";
  }
}

function changeStatus(form,id) {
    var status=document.getElementById('status_'+id);
    form.action='changeStatus';
    form.todo_id.value=id;
    form.status_id.value=status.value;
    form.method='post';
    form.submit();
}

function deleteCategory() {
  var obj=document.getElementsByName('category_id');
  if ( obj[0].value=='') {
    bootbox.alert('削除するカテゴリを選択してください', function() {});
    openForm('/mytool/categoryedit','','refresh');
    return;
  }
  actionCategory('/mytool/categoryedit/delete','1');
}
function sortCategory(action) {
  var obj=document.getElementsByName('category_id');
  if ( obj[0].value=='') {
    bootbox.alert('並べ替えるカテゴリを選択してください', function() {});
    openForm('/mytool/categoryedit','','refresh');
    return;
  }

  var url = '/mytool/categoryedit/' + action;
  actionCategory(url,'1');
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
      bootbox.alert(json.error, function() {});
    }
    openForm('/mytool/categoryedit','','refresh');
  }).fail(function() {
    bootbox.alert('ajaxエラーが発生しました', function() {});
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
