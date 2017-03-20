<?php
include_once('/var/www/html/cs4014/config.php');

include(SITE_PATH.'/includes/php/utils/TaskRetriever.class.php');
include(SITE_PATH.'/includes/php/utils/TaskPrinter.class.php');

if(isset($_POST['count'])){
  $count = $_POST['count'];
  dynamicPrintTasks($count);
}
else{
  dynamicPrintTasks(0);
}


function dynamicPrintTasks($count){
  $tasksPerPage = 5;
  $start = $count * $tasksPerPage;

  $retriever = new TaskRetriever();
  $taskPrinter = new TaskPrinter();
  $allTasks = $retriever -> getTasksMain($start, $tasksPerPage);

  $size = sizeof($allTasks);

  for($i = 0; $i < sizeof($allTasks); $i++){
    $taskPrinter -> printDefaultTask($allTasks[$i]);
  }


  if($size < 5){
    echo '<p id="stop-loading" class="offset-md-5"> **No More Tasks To Show**</p>';
  }
}

?>
