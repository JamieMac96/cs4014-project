<?php



// Submission check
if(isset($_POST['signUpButton'])) {
	if( ! $_POST['contact'] == '') return;
  $firstName = $db->quote(trim($_POST['signUpFirstName']));
  $lastName = $db->quote(trim($_POST['signUpLastName']));
  $signUpEmail = $db->quote(trim(strtolower($_POST['signUpEmail'])));
  $StudentID = $db->quote(trim($_POST['signUpID']));
  $subject = $db->quote($_POST['signUpSubject']);
  $signUpPassword = $db->quote(trim($_POST['signUpPassword']));
  $passwordConfirm = $db->quote(trim($_POST['signUpPasswordConfirm']));
  $connection = $db->connect();

  //REQUIRED:
  //          -connection through SSL for login/ sign up
  if($val->isValidSignUp($firstName, $lastName, $signUpEmail, $StudentID, $subject, $signUpPassword, $passwordConfirm)){
    if($connection){
      //check if the email is already used or belongs to banned user.
      if($qh -> isUniqueEmail($signUpEmail)){



        //Salted password hashing
        //$mysalt = openssl_random_pseudo_bytes(64, $strong);
		//$mysalt = random_bytes(64);
		$mysalt = md5(rand(10,1000));
        $saltyPassword = $signUpPassword . $mysalt;


        $hashedPassword = hash('sha256', $saltyPassword);


        $subjectID = $qh->getSubjectIdFromSubjectName($subject);
        $result = $qh -> insertUser($StudentID, $subjectID, $firstName, $lastName, $signUpEmail, $hashedPassword, $mysalt);



        if($result){
          session_start();
          $_SESSION['userID'] = $qh -> getLastInsertID();
          print_r($_SESSION);
          header('Location: thank-you.php');
          exit();
        }
        else{
          echo "<script>alert('Failed to create account');</script>";
        }
      }
      else{
        echo "<script>alert('The email supplied is already used by another account');</script>";
      }
    }
  }
  else{
    echo "<script>alert('One or more of your entries was invalid');</script>";
  }
}

?>
