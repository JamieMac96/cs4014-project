<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH . '/includes/php/utils/QueryHelper.class.php');

class User{
  private $userID;
  private $subject;
  private $foreName;
  private $lastname;
  private $emailAddress;
  private $studentID;
  private $reputation;
  private $isMod;
  private $profilePicURL;

  function setUserID($userID) { $this->userID = $userID; }
  function getUserID() { return $this->userID; }
  function setSubject($subject) { $this->subject = $subject; }
  function getSubject() { return $this->subject; }
  function setForeName($foreName) { $this->foreName = $foreName; }
  function getForeName() { return $this->foreName; }
  function setLastname($lastname) { $this->lastname = $lastname; }
  function getLastname() { return $this->lastname; }
  function setEmailAddress($emailAddress) { $this->emailAddress = $emailAddress; }
  function getEmailAddress() { return $this->emailAddress; }
  function setStudentID($studentID) { $this->studentID = $studentID; }
  function getStudentID() { return $this->studentID; }
  function setReputation($reputation) { $this->reputation = $reputation; }
  function getReputation() { return $this->reputation; }
  function setIsMod($isMod) { $this->isMod = $isMod; }
  function getIsMod() { return $this->isMod; }
  function setProfilePicURL($profilePicURL) { $this->profilePicURL = $profilePicURL; }
  function getProfilePicURL() { return $this->profilePicURL; }

  //This function is a static method used to return the current user of the website.
  //Allows us to access info on the current user without having to query the database each time.
  public static function getUser($userID){
    $qh = new QueryHelper();

    $userInfo = array();

    $userInfo = $qh -> getUserInfo($userID);

    if($userInfo){

      $user = new User();
      $user -> setUserID($userID);
      $user -> setSubject($userInfo[0]);
      $user -> setForeName($userInfo[1]);
      $user -> setLastname($userInfo[2]);
      $user -> setEmailAddress($userInfo[3]);
      $user -> setStudentID($userInfo[4]);
      $user -> setReputation($userInfo[5]);
      $user -> setIsMod($userInfo[6]);
      $user -> setProfilePicURL($userInfo[7]);

      return $user;
    }
    else{
      return false;
    }
  }

  function getUserIDFromEmail($userEmail){
    $qh = new QueryHelper();

    return $qh -> getUserIDFromEmail();
  }
}


?>
