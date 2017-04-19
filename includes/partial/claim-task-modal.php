<div>
  <div class="card-block">
    <h2>Task Details:</h2>
    <p>This task must be completed by <?php echo $completeDate;?> or you will be penalised 30 reputation points.</p>
    <p>As a result of claiming this task you will be awarded 10 reputation points.</p>
    <p>You can cancel this task claim at any point before the deadline but you will be penalised 15 points for doing so.</p>
  </div>
  <div class="card-block">
    <h2>Send Email:</h2>
    <p>We highly recommend that you notify the owner that you will be claiming their task. This will aid future correspondence between you and the owner.<p>
    <form action="task-details.php?taskID=<?php echo "$taskID"?>" method="post">
      <div>
    <?php
              $caseref = "123";
              $name = "Bob";
              $email_subject = "PEER REVIEW WEBSITE USER: $firstname $lastname CLAIMED YOUR TASK";
              $email_message = "Message Body: \n";
              $email_message .= "\n";
              $email_message .= "\n";

              echo '<a href="mailto:'.$ownerEmail.'?subject='.urlencode($email_subject).'&body='.urlencode($email_message).'">Email The Task Owner!</a>'; ?>
      <br>
      </div>
      <div class="form-group">
        <input name='claim-task' type="submit" class="btn-outline btn" value="Claim" role="button"></input>
      </div>
    </form>
  </div>
</div>
