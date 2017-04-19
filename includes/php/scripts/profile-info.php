<?php
  $profileID = $_GET['userID'];
  if(!isset($_SESSION)){
	session_start();
  }
  $_SESSION['profileID'] = $profileID;
  if($profileID == $userID){
    $profileReputation = $reputation;
    $profileSubject = $subject;
    $profileFirstname = $firstname;
    $profileLastname = $lastname;
    $profileEmailAddress = $emailAddress;
    $profileStudentID = $studentID;
    $profilePicURL = $picURL;
  }
  else{
    include_once('includes/php/utils/User.class.php');
    $profileUser = User::getUser($profileID);
    if($profileUser){
      $profileReputation = $profileUser -> getReputation();
      $profileSubject = $profileUser -> getSubject();
      $profileFirstname = $profileUser -> getForeName();
      $profileLastname = $profileUser -> getLastname();
      $profileEmailAddress = $profileUser -> getEmailAddress();
      $profileStudentID = $profileUser -> getStudentID();
      $profilePicURL = $profileUser -> getProfilePicURL();
    }
    else{
      if(isset($_SERVER['HTTP_REFERRER'])){
        $referrer = $_SERVER['HTTP_REFERRER'];
        header("location: $referrer");
      }
      else{
        header("location: index.php");
      }
    }
  }



 ?>
