$(document).ready(function() {
  var count = 1;
  if($("#stop-loading-flagged").length){
    $("#remove_row").remove();
  }

  $('#btn_more_flagged').on('click', function(){

    $.post('includes/php/scripts/display-tasks-flag.php',{'count': count} ,function(data){
      $("#display-tasks").append(data);
      if($("#stop-loading-flagged").length){
        $("#remove_row").remove();
      }
      count++;
    });

  });

});
