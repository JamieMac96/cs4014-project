
<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH.'/includes/php/utils/TaskRetriever.class.php');
include_once(SITE_PATH.'/includes/php/utils/TaskPrinter.class.php');
if(isset($_POST['count'])){
  $count = $_POST['count'];
  printMyTasks($count);
}
else{
  printMyTasks(0);
}
function printMyTasks($count){
  $tasksPerPage = 5;
  $start = $count * $tasksPerPage;
  $retriever = new TaskRetriever();
  $taskPrinter = new TaskPrinter();
  $allTasks = $retriever -> getMyTasks($start, $tasksPerPage);
  $size = sizeof($allTasks);
  for($i = 0; $i < sizeof($allTasks); $i++){
    $taskPrinter -> printMyTask($allTasks[$i]);
  }
  if($count == 0 && $size == 0){
    echo '<p id="stop-loading-my" class="offset-md-5">No tasks created.</p>';
  }
  else if($size < 5){
    echo '<p id="stop-loading-my" class="offset-md-5">No More Tasks To Show.</p>';
  }
}
?>
