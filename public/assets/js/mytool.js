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

function aaaa(name,url) {
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
function bbbb(form,id) {
    form.action='http://27.120.86.104/mytool/todo/changeStatus';
    form.id.value=id;
    form.method='post';
    form.submit();

}

