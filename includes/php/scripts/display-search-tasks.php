<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH.'/includes/php/utils/TaskRetriever.class.php');
include_once(SITE_PATH.'/includes/php/utils/TaskPrinter.class.php');
include_once(SITE_PATH. "/includes/php/utils/Database.class.php");

if(isset($_GET['submit-search']) || isset($_GET['count'])){
	$db = new Database();
  $searchQuery = $db -> quote(htmlentities($_GET['search-query']));
  if(isset($_GET['count'])){
    $count = $_GET['count'];
    printMyTasks($count, $searchQuery);
  }
  else{
    printMyTasks(0, $searchQuery);
  }

}



function printMyTasks($count, $searchQuery){
  $tasksPerPage = 5;
  $start = $count * $tasksPerPage;

  $retriever = new TaskRetriever();
  $allTasks = $retriever -> getSearchResults($searchQuery, $start, $tasksPerPage);

  $printer = new TaskPrinter();
  for($i = 0; $i < sizeof($allTasks); $i++){
    $printer -> printDefaultTask($allTasks[$i]);
  }

  $size = sizeof($allTasks);

  if($count == 0 && $size == 0){
    echo '<p id="stop-loading-search" class="offset-md-5">'. "No results for search term: \"$searchQuery\"" . '</p>';
  }
  else if($size < 5){
    echo '<p id="stop-loading-search" class="offset-md-5">No More Tasks To Show.</p>';
  }


}
?>
