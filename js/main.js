$(document).ready(function(){
  initCheckbox();
  cookieCheckbox();
  refresh();
});

function initCheckbox(){
  var taskNumber = $('.todo-checkbox').length;
  for (var i = 0; i < taskNumber; i++) {
    $('#task-'+i).attr("checked", $.cookie('task-'+i));
  }
}

function cookieCheckbox(){
  $('.todo-checkbox').click(function(){
    var taskName = $(this).attr('id');
    if ($(this).is(':checked')){
      $.cookie(taskName, 'true');
    }else {
      $.removeCookie(taskName);
    }
  });
}

function refresh(){
  $("#cookie-rmv").click(function(){
    var taskNumber = $('.todo-checkbox').length;
    for (var i = 0; i < taskNumber; i++) {
      $.removeCookie('task-'+i);
    }
    $.removeCookie('LastTodoSpreadsheet');
    window.location = "index.php";
  });
}

