<div>
  <br>
  <p>We recommend that you notify the task owner by email before completing the task.<br>
    When you click confirm the task owner will be notified and your performance will be rated.</p>
  <?php
            $caseref = "123";
            $email_subject = "PEER REVIEW WEBSITE USER: $firstname $lastname COMPLETED YOUR TASK";
            $email_message = "\n";
            $email_message .= "\n";
            $email_message .= "\n";

            echo '<a href="mailto:'.$ownerEmail.'?subject='.urlencode($email_subject).'&body='.urlencode($email_message).'">Email The Task Owner!</a>'; ?>

  <form action="task-details.php?taskID=<?php echo "$taskID"?>" method="post">
    <div class="form-group">
      <input name='complete-task' type="submit" class="btn-default btn" value="Complete" role="button"></input>
    </div>
  </form>
</div>
