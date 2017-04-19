<?php
  include_once('includes/php/utils/QueryHelper.class.php');
  include_once(SITE_PATH. "/includes/php/utils/Database.class.php");

  $qh = new QueryHelper();
  $db = new Database();

  if(isset($_POST['cancel-task'])){
    $qh -> setPendingClaim($taskID);
    $qh -> changeReputation($userID, -15);
    header("location: task-details.php?taskID=$taskID");
  }

  //ownerEmail is required by the claim-task modal thus we get this value here in the corersponding script
  $ownerEmail = $qh -> getUserEmailFromID($owner);
  if(isset($_POST['claim-task'])){
    $message = $db -> quote(htmlentities($_POST['email-text']));
    //email user functionality
    $qh -> setClaimed($taskID);
    $qh -> changeReputation($userID, 10);
    header("location: task-details.php?taskID=$taskID");
  }

  if(isset($_POST['complete-task'])){
    //email user funtionality
    $qh -> setComplete($taskID);
    header("location: task-details.php?taskID=$taskID");
  }

  if(isset($_POST['flag-task'])){
    $complaint = $db -> quote(htmlentities($_POST['complaint']));
    $qh -> changeReputation($userID, 2);
    $qh -> insertFlag($taskID, $complaint);
  }

  if(isset($_POST['remove-task'])){
    $res = $qh -> removeTask($taskID);
    if($res){
      header('location: index.php');
    }
  }
 ?>
