<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');

include_once(SITE_PATH.'/includes/php/utils/TaskRetriever.class.php');
include_once(SITE_PATH.'/includes/php/utils/TaskPrinter.class.php');
include_once(SITE_PATH.'/includes/php/utils/QueryHelper.class.php');
  include_once(SITE_PATH. "/includes/php/utils/Database.class.php");

if(isset($_POST['count'])){
  $count = $_POST['count'];
  dynamicPrintTasks($count);
}
else{
  dynamicPrintTasks(0);
}


function dynamicPrintTasks($count){
	$db = new Database();
  $tasksPerPage = 5;
  $start = $count * $tasksPerPage;

  $retriever = new TaskRetriever();
  $taskPrinter = new TaskPrinter();
  if(!isset($_SESSION['userID'])){
	session_start();
  }

  $qh = new QueryHelper();
  $numClicks = $qh -> getNumberOfClicksForUser($_SESSION['userID']);
  if(isset($_POST['filter-tasks-button'])){
    $filters = array();
    $filters[0] = $db -> quote(htmlentities($_POST['filter-subject-name']));
    $filters[1] = $db -> quote(htmlentities($_POST['filter-task-type']));
    $filters[2] = $db -> quote(htmlentities($_POST['filter-doc-type']));
    $filters[3] = $db -> quote(htmlentities($_POST['filter-tag-value']));
    $allTasks = $retriever -> getTasksMainFiltered($start, $tasksPerPage, $filters);
  }
  else if($numClicks >= 50 ){
    $allTasks = $retriever -> getPersonalizedTasks($start, $tasksPerPage);
  }
  else{
    $allTasks = $retriever -> getTasksMain($start, $tasksPerPage);
  }

    $size = sizeof($allTasks);

    for($i = 0; $i < sizeof($allTasks); $i++){
      $taskPrinter -> printDefaultTask($allTasks[$i]);
    }

    if($size < $tasksPerPage){
      echo '<p id="stop-loading-main" class="offset-md-5"></p>';
    }
}

?>
