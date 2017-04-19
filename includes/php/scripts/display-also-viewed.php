<?php

include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');

include_once(SITE_PATH.'/includes/php/utils/TaskRetriever.class.php');
include_once(SITE_PATH.'/includes/php/utils/TaskPrinter.class.php');
include_once(SITE_PATH.'/includes/php/utils/QueryHelper.class.php');

/*if(isset($_POST['count'])){
  $count = $_POST['count'];
  dynamicPrintTasks($count);
}
else{
  dynamicPrintTasks(0);
}*/

dynamicPrintTasks(0);


function dynamicPrintTasks($count){
  $tasksPerPage = 5;
  $start = $count * $tasksPerPage;

  $retriever = new TaskRetriever();
  $taskPrinter = new TaskPrinter();
  if(!isset($_SESSION['userID'])){
	session_start();
  }
  $allTasks = $retriever->getAlsoViewed($_GET['taskID'], $_SESSION['userID']);

  $size = sizeof($allTasks);
  if($allTasks != false){
    echo "<h3>Users who viewed this task also viewed: </h3>";
  }
  for($i = 0; $i < sizeof($allTasks) && $allTasks != false; $i++){
    $taskPrinter -> printDefaultTask($allTasks[$i]);
  }

  if($size < $tasksPerPage){
    echo '<p id="stop-loading-main" class="offset-md-5"></p>';
  }
}

 ?>
