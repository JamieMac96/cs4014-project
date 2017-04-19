<?php
  include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
  include_once(SITE_PATH . '/includes/php/utils/TaskRetriever.class.php');
  include_once(SITE_PATH . '/includes/php/utils/TaskPrinter.class.php');
  include_once(SITE_PATH. "/includes/php/utils/Database.class.php");

if(isset($_POST['dynamic-search'])){
	$db = new Database();
  $searchQuery = $db->quote(htmlentities($_POST['dynamic-search']));

  $retriever = new TaskRetriever();
  $allTasks = $retriever -> getSearchResults($searchQuery, 0, 5);

  if(sizeof($allTasks) == 0){
    echo "No results for search term: \"$searchQuery\"";
  }
  else{
    $printer = new TaskPrinter();
    for($i = 0; $i < sizeof($allTasks); $i++){
      $printer -> printDynamicSearchTask($allTasks[$i]);
    }
  }
}

?>
