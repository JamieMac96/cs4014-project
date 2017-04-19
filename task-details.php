<?php include('includes/head.php');?>
<?php include('includes/header.php');?>
<?php include_once('includes/php/scripts/task-click.php'); ?>
<?php include_once('includes/php/scripts/task-actions.php'); ?>
<?php  if(!isset($_GET['taskID']) || !isset($title)){
  header('location: index.php');
}

?>
<div class="container">
  <div class="row my-4">
    <div class="col-md-6">
      <h2><b>Task Title: </b> <?php echo $title?></h2>
      <br><p><b>Description: </b> <?php echo $description?></p>
      <br><p><b>Owner: </b><a href="profile.php?userID=<?php echo $owner?>">Profile</a></p>
      <br><p><b>Paper Type:</b> <?php echo "$docType"; ?></p>
      <br><p><b>Task Type:</b> <?php echo "$taskType"; ?></p>
      <br><p><b>Number of Pages: </b> <?php echo "$numPages"; ?></p>
      <br><p><b>Number of words: </b> <?php echo "$numWords"; ?></p>
      <br><p><?php echo "<b>Claim Deadline:</b> $claimDate"; ?> </p>
      <br><p><?php echo "<b>Completion Deadline:</b> $completeDate"; ?></p>
      <br><p><b>Status:</b> <?php echo "$status"; ?></p>
      <br><p><b>Tags:</b> <?php echo "$tag1 $tag2 $tag3 $tag4"; ?></p>
      <?php
      if($claimant == $userID && $status == 'Claimed'){
        ?>

        <br><p><b>Download Full Document: </b><a href=" <?php echo "$document"; ?> " download>
          <img src="http://testweb3.csisad.ul.campus/modules/cs4014/group2/files/images/document_download.jpg" alt="download-doc" height="42" width="42">
        </a></p>

        <?php

        $modalTitle = 'Complete Task';
        $target = 'complete-modal';
        $includeURL = 'includes/partial/complete-task-modal.php';
        include('includes/php/scripts/dynamic-modal.php');

        ?> <br><br> <?php
        $modalTitle = 'Cancel Task';
        $target = 'cancel-modal';
        $includeURL = 'includes/partial/cancel-task-modal.php';
        include('includes/php/scripts/dynamic-modal.php');
      }
      ?>

      <?php
      if($userID == $owner || $reputation >= 40){
        ?> <br><br> <?php
        $modalTitle = 'Remove Task';
        $target = 'remove-modal';
        $includeURL = 'includes/partial/remove-task-modal.php';
        include('includes/php/scripts/dynamic-modal-danger.php');
      } ?>

      <?php if($status == "Pending Claim" && $userID != $owner){
        ?> <br><br> <?php
        $modalTitle = 'Claim Task';
        $target = 'claim-modal';
        $includeURL = 'includes/partial/claim-task-modal.php';
        include('includes/php/scripts/dynamic-modal.php');
      }?>
      <?php
      ?> <br><br> <?php
      $modalTitle = 'Flag Task';
      $target = 'flag-modal';
      $includeURL = 'includes/partial/flag-task-modal.php';
      include('includes/php/scripts/dynamic-modal.php');
      ?>
      <br><br>
    </div>
    <div class="col-md-5 offset-md-1">
      <p>Document Sample: </p>
      <?php
      if($docFormat == '.pdf' && file_exists($sampleDoc)){?>
        <object data="<?php echo $sampleDoc ?>" type="application/<?php echo str_replace(".","",$docFormat) ?>" width="100%" height="65%">
          <embed type="application/<?php echo str_replace(".","",$sampleDoc) ?>" src="<?php echo $sampleDoc ?>" width="100%" height="100%">
          </embed>
        </object>
        <?php
      }else if(file_exists($sampleDoc)){
        ?>
        <br><p><b>Download the document sample: </b><a href=" <?php echo "$sampleDoc"; ?> " download>
          <img src="http://testweb3.csisad.ul.campus/modules/cs4014/group2/files/images/document_download.jpg" alt="face" height="42" width="42">
        </a></p>
        <?php
        }
        else{
          echo "No document sample available";
        }
         ?>
    </div>
  </div>
  <div>
    <div class="col-md-6">
      <?php include_once('includes/php/scripts/display-also-viewed.php') ?>
    </div>
  </div>
</div>

<?php include('includes/footer.php') ?>
