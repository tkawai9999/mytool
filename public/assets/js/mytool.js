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

function saveForm(form,id) {
    form.action='/mytool/todoedit/save';
    form.todo_id.value=id;
    form.method='post';
    form.submit();
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

function actionCategory(url) {
    var form=document.getElementById('form');
    form.action=url;
    form.method='post';
    form.submit();
}

function selectCategory() {
    var category_list=document.getElementById('category_list');
    var category_name=document.getElementById('category_name');
    var category_id=document.getElementById('category_id');

    category_name.value=category_list.options[category_list.selectedIndex].text;
    category_id.value=category_list.options[category_list.selectedIndex].value;
}

function clearCategory() {
    var category_name=document.getElementById('category_name');
    var category_id=document.getElementById('category_id');

    category_name.value="";
    category_id.value="";
}

