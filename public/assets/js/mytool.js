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

function openForm(name,url) {
  $.ajax({
    async:false,
    type:"post",
    url:url,
    data:{
      text_book_name:name,
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
function changeStatus(form,id) {

    var status=document.getElementById('status_'+id);
    form.action='changeStatus';
    form.todo_id.value=id;
    form.status_id.value=status.value;
    form.refer.value=location.href;
    form.method='post';
    form.submit();

}

