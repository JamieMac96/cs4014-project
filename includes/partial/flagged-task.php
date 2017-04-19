<?php include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
      include_once(SITE_PATH . '/includes/php/scripts/dismiss-flag.php'); ?>

<div class="card task-card mb-3">
  <div class="card-block">
    <a href="task-details.php?taskID=<?php echo "$taskID"?>">
    <h4 class="card-title">
      <?php echo "$title"; ?>
    </h4>
    </a>
    <div class="card-text">
      <div class="row">
        <div class="col-md-6">
          <ul>
            <li>Paper Type: <?php echo "$docType"; ?></li>
            <li>Number of Pages: <?php echo "$numPages"; ?></li>
            <li>Number of words: <?php echo "$numWords"; ?></li>
            <b><?php
              for($i = 0; $i < sizeof($flags); $i++){
                $complaint = $flags[$i] -> getComplaint();
                echo "<li>Complaint: " . $complaint . "</li>";
              }
             ?></b>

          </ul>
        </div>
        <div class="col-md-2.7 offset-md-3">
          <?php echo "Claim Deadline: $claimDate"; ?>
          <br><br><?php echo "Completion Deadline: $completeDate"; ?>
          <br><br>
          <?php
          $modalTitle = 'Dismiss Flag';
          $target = 'dismiss-flag';
          $includeURL = SITE_PATH . '/includes/partial/dismiss-flag-modal.php';
          include(SITE_PATH . '/includes/php/scripts/dynamic-modal.php');
          ?>
        </div>
      </div>
      <p>Description: <?php echo "$description"; ?></p>
    </div>
  </div>
</div>
