<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH . '/includes/php/utils/DateFormatConverter.class.php');
include_once(SITE_PATH . '/includes/php/utils/QueryHelper.class.php');

class TaskPrinter{


    function printDefaultTask($task){
      $taskID = $task -> getTaskID();
      $title = $task -> getTaskTitle();
      $type = $task -> getTaskType();
      $docType = $task -> getDocType();
      $numPages = $task -> getNumPages();
      $numWords = $task -> getNumWords();
      $claimDate = $task -> getClaimDeadline();
      $completeDate = $task -> getCompleteDeadline();
      $description = $task -> getTaskDescription();
      $subject = $task->getSubject();
      $ownerID = $task -> getOwnerID();
      $converter = new DateFormatConverter();
      $claimDate = $converter -> convert($claimDate);
      $completeDate = $converter -> convert($completeDate);

      include(SITE_PATH . '/includes/partial/default-task.php');
    }

    function printClaimedTask($task){
      $qh = new QueryHelper();

      $taskID = $task -> getTaskID();
      $title = $task -> getTaskTitle();
      $type = $task -> getTaskType();
      $docType = $task -> getDocType();
      $numPages = $task -> getNumPages();
      $numWords = $task -> getNumWords();
      $claimDate = $task -> getClaimDeadline();
      $completeDate = $task -> getCompleteDeadline();
      $description = $task -> getTaskDescription();
      $subject = $task->getSubject();
      $ownerID = $task -> getOwnerID();
      $status = $task -> getStatus();
      $claimantID = $task->getClaimantID();
      $ownerID = $task -> getownerID();
      $ownerInfo = $qh -> getUserInfo($ownerID);
      if($ownerInfo){
        $ownerEmail = $ownerInfo[3];
      }

      $converter = new DateFormatConverter();
      $claimDate = $converter -> convert($claimDate);
      $completeDate = $converter -> convert($completeDate);

      include(SITE_PATH . '/includes/partial/claimed-task.php');
    }

    function printFlaggedTask($task, $flags){
      $taskID = $task -> getTaskID();
      $title = $task -> getTaskTitle();
      $type = $task -> getTaskType();
      $docType = $task -> getDocType();
      $numPages = $task -> getNumPages();
      $numWords = $task -> getNumWords();
      $claimDate = $task -> getClaimDeadline();
      $completeDate = $task -> getCompleteDeadline();
      $description = $task -> getTaskDescription();
      $subject = $task->getSubject();
      $ownerID = $task -> getOwnerID();
      $converter = new DateFormatConverter();
      $claimDate = $converter -> convert($claimDate);
      $completeDate = $converter -> convert($completeDate);


      include(SITE_PATH . '/includes/partial/flagged-task.php');
    }

    function printMyTask($task){
      $qh = new QueryHelper();

      $taskID = $task -> getTaskID();
      $title = $task -> getTaskTitle();
      $type = $task -> getTaskType();
      $docType = $task -> getDocType();
      $numPages = $task -> getNumPages();
      $numWords = $task -> getNumWords();
      $claimDate = $task -> getClaimDeadline();
      $completeDate = $task -> getCompleteDeadline();
      $description = $task -> getTaskDescription();
      $subject = $task->getSubject();
      $ownerID = $task -> getOwnerID();
      $status = $task -> getStatus();
      $rated = $task -> getRated();
      if($status == "Claimed" || $status == "Complete"){
        $claimantID = $task -> getClaimantID();
        $claimantInfo = $qh -> getUserInfo($claimantID);
        if($claimantInfo){
          $claimantEmail = $claimantInfo[3];
        }

      }
      $converter = new DateFormatConverter();
      $claimDate = $converter -> convert($claimDate);
      $completeDate = $converter -> convert($completeDate);

      include(SITE_PATH . '/includes/partial/my-task.php');
    }

    function printDynamicSearchTask($task){
      $title = $task -> getTaskTitle();
      $taskID = $task -> getTaskID();
      include(SITE_PATH . '/includes/partial/dynamic-search-task.php');
    }
}


 ?>
