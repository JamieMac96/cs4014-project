<?php
session_start();
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include(SITE_PATH.'/includes/php/utils/TaskRetriever.class.php');
include(SITE_PATH.'/includes/php/utils/TaskPrinter.class.php');
if(isset($_POST['count'])){
  $count = $_POST['count'];
  printClaimedTasks($count);
}
else{
  printClaimedTasks(0);
}
function printClaimedTasks($count){
  $tasksPerPage = 5;
  $start = $count * $tasksPerPage;
  $retriever = new TaskRetriever();
  $taskPrinter = new TaskPrinter();
  $allTasks = $retriever -> getClaimedTasks($start, $tasksPerPage);
  $size = sizeof($allTasks);
  for($i = 0; $i < sizeof($allTasks); $i++){
    $taskPrinter -> printClaimedTask($allTasks[$i]);
  }
  if($count == 0 && $size == 0){
    echo '<p id="stop-loading-claimed" class="offset-md-5">No claimed tasks.</p>';
  }
  else if($size < 5){
    echo '<p id="stop-loading-claimed" class="offset-md-5">No More Tasks To Show.</p>';
  }
}
?>
