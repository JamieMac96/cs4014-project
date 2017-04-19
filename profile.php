<?php include_once('includes/head.php');?>
<?php include_once('includes/header.php');?>
<?php include_once('includes/php/utils/User.class.php');
      include_once('includes/php/scripts/edit-profile.php');
      include_once('includes/php/utils/DropdownOptionGenerator.class.php');
      include_once('includes/php/scripts/rate-performance.php');
      $gen = new DropdownOptionGenerator();

if(!isset($_GET['userID'])){
  header("location: index.php");
}
      include_once('includes/php/scripts/profile-info.php');
      include_once('includes/php/scripts/remove-user.php');
?>
<div class="container">
  <div class="row my-5">
    <div class="col-md-3">
      <h2>My Profile</h2>
      <?php
        $testURL  = $profilePicURL;
        clearstatcache();
        if(file_exists($testURL)){
          $picTopBeUsed = 'http://testweb3.csisad.ul.campus/modules/cs4014/group2/' . $profilePicURL;
        }
        else{
          $picTopBeUsed = 'http://testweb3.csisad.ul.campus/modules/cs4014/group2/files/images/default-profile-image.png';
        }
      ?>
      <img src="<?php echo $picTopBeUsed ?>" alt="face" height="200" width="200">
      <?php
        if($profileID == $userID){
        $query = "SELECT * FROM Subject;";
      ?>
      <br><br>Name: <span class="editable-text" id="editable-name" contenteditable="true"><?php echo "$profileFirstname $profileLastname";?>
                <a href="" id="username"><i class="fa fa-pencil"></i></a></span>
      <br><br>Field of expertise:<br><span id="dropdown-subject" contenteditable="true" class="editable-text"><?php echo "$profileSubject";?>
                <a href="" id="username"><i class="fa fa-pencil"></i></a></span>

      <br><br>Email Address: <span contenteditable="true" id="editable-email" class="editable-text"><?php echo "$profileEmailAddress";?>
                <a href="" id="username"><i class="fa fa-pencil"></i></a></span>
      <br><br>Student ID: <span contenteditable="true" id="editable-studentid" class="editable-text"><?php echo "$profileStudentID";?>
                <a href="" id="username"><i class="fa fa-pencil"></i></a></span>
      <br><br>Reputation: <?php echo "$profileReputation";?>
      <br><br><label for="profile-pic">Change your profile picture:</label>
      <form id="edit-profile-form" enctype="multipart/form-data" action="profile.php?userID=<?php echo $profileID?>" method="post">
        <input id="profile-pic" name="profile-pic" type="file" class="my-2 btn-default btn-file"/>
        <input  class="form-control my-2" maxlength="74" type="hidden" id="edit-name-input" name="editable-name" value="" placeholder="Task Title"/>
        <input  class="form-control my-2" maxlength="74" type="hidden" id="edit-subject-input" name="editable-subject" value="" placeholder="Task Title"/>
        <input  class="form-control my-2" maxlength="74" type="hidden" id="edit-studentid-input" name="editable-studentid" value="" placeholder="Task Title"/>
        <input  class="form-control my-2" maxlength="74" type="hidden" id="edit-email-input" name="editable-email" value="" placeholder="Task Title"/>
      </form>

      <?php }
            else{
              ?>
              <br>Name: <?php echo "$profileFirstname $profileLastname";?>
              <br><br>Field of expertise:<br> <?php echo "$profileSubject";?>
              <br><br>Reputation: <?php echo "$profileReputation";?>

            <?php }
      ?>

      <?php
        if($reputation >= 40 && $profileID != $userID){
          ?> <br><br> <?php
          $modalTitle = 'Ban User';
          $target = 'ban-modal';
          $includeURL = 'includes/partial/ban-user-modal.php';
          include_once('includes/php/scripts/dynamic-modal-danger.php');
         }

       ?>
       <?php
         if($userID == $profileID){
           ?> <br><br> <?php
           $modalTitle = 'Remove Profile';
           $target = 'remove-profile';
           $includeURL = 'includes/partial/remove-profile-modal.php';
           include_once('includes/php/scripts/dynamic-modal-danger.php');
          }

        ?>
    </div>
    <div class="col-md-9">
      <button id="my-button" type="button" class="btn btn-outline mb-5" role="button">
        My Tasks
      </button>
      <button id="claimed-button" type="button" class="btn btn-outline mb-5" role="button">
        Claimed Tasks
      </button>
      <div id="display-tasks">
        <?php include_once('includes/php/scripts/display-my-tasks.php'); ?>
      </div>
      <div id="wrap-more-button">
        <div id="remove_row">
          <td><button type="button" name="btn_more_profile" id="btn_more_profile" class="btn-success btn form-control" role="button">more</button></td>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include_once('includes/footer.php'); ?>
<script>
  $(document).ready(function(){
    var email = $("#editable-email").text();
    $("#edit-email-input").val(email);

    var subjectName = $("#dropdown-subject").text();
    $("#edit-subject-input").val(subjectName);


    var id = $("#editable-studentid").text();
    $("#edit-studentid-input").val(id);


    var name = $("#editable-name").text();
    $("#edit-name-input").val(name);

  })

  $("#dropdown-subject").on('click', function(){

    $("#dropdown-subject").html("<select></select>");
    $("#dropdown-subject").children("select").html('<option selected hidden>Select Subject</option><?php $gen->generateOptions($query, 'SubjectName');?>' );


  });

  $("#profile-pic").on('change', function(){
    if(!$('#submit-edit').length){
      $("#edit-profile-form").append('<br><br><input type="submit" id="submit-edit" class="btn btn-default" value="Submit Changes" name="submit-edit" role="button"/>');
    }
  });

  $("#dropdown-subject").on('change', function(){
    var subjectName = $('#dropdown-subject').find(":selected").text();

    $("#dropdown-subject").html(subjectName + '<a href="" id="username"><i class="fa fa-pencil"></i></a>');
    $("#edit-subject-input").val(subjectName);
    if(!$('#submit-edit').length){
      $("#edit-profile-form").append('<br><br><input type="submit" id="submit-edit" class="btn btn-default" value="Submit Changes" name="submit-edit" role="button"/>');
    }

  });

  $("#editable-name").on('input', function(){
    var name = $("#editable-name").text();
    $("#edit-name-input").val(name);
    if(!$('#submit-edit').length){
      $("#edit-profile-form").append('<br><br><input type="submit" id="submit-edit" class="btn btn-default" value="Submit Changes" name="submit-edit" role="button"/>');
    }
  });

  $("#editable-email").on('input', function(){
    var email = $("#editable-email").text();
    $("#edit-email-input").val(email);
    if(!$('#submit-edit').length){
      $("#edit-profile-form").append('<br><br><input type="submit" id="submit-edit" class="btn btn-default" value="Submit Changes" name="submit-edit" role="button"/>');
    }
  });

  $("#editable-studentid").on('input', function(){
    var id = $("#editable-studentid").text();
    $("#edit-studentid-input").val(id);

    if(!$('#submit-edit').length){
      $("#edit-profile-form").append('<br><br><input type="submit" id="submit-edit" class="btn btn-default" value="Submit Changes" name="submit-edit" role="button"/>');
    }
  });

</script>
