
<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');

include_once(SITE_PATH.'/includes/php/utils/TaskRetriever.class.php');
include_once(SITE_PATH.'/includes/php/utils/TaskPrinter.class.php');

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
  $ctr = 0;

  $retriever = new TaskRetriever();
  $taskPrinter = new TaskPrinter();
  $allTasks = $retriever -> getFlaggedTasks($start, $tasksPerPage);

  for($i = 0; $i < sizeof($allTasks); $i++){
    $flags = $retriever -> getRelevantFlags($allTasks[$i] -> getTaskID() );
	$ctr += sizeof($flags);
    $taskPrinter -> printFlaggedTask($allTasks[$i], $flags);
  }


  if($ctr < $tasksPerPage ){
    echo '<p id="stop-loading-flagged" class="offset-md-5"></p>';
  }
}

?>
