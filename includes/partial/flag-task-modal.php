<form class="form" enctype="multipart/form-data" action="task-details.php?taskID=<?php echo "$taskID"?>" method="post">
  <div class="form-group">
    <div>
      <label>Why are you flagging this task?</label>
      <textarea name="complaint" class="form-control my-2 input-large" maxlength="199" type="text" value="" placeholder="Complaint"  required></textarea>
    </div>
    <div class="my-2 form-inline">
      <input name='flag-task' type="submit" class="btn-default btn" value="Submit" role="button"></input>
    </div>
  </div>
</form>
