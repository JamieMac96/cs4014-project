<?php
  include_once('includes/php/utils/QueryHelper.class.php');

  $qh = new QueryHelper();

  //ownerEmail is required by the claim-task modal thus we get this value here in the corersponding script
  $ownerEmail = $qh -> getUserEmailFromID($owner);
  if(isset($_POST['claim-task'])){
    $qh -> setClaimed($taskID);
    $qh -> changeReputation($userID, 10);
    header("location: task-details.php?taskID=$taskID");
  }
 ?>
