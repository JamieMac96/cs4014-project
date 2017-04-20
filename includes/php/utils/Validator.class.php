<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH . '/includes/php/utils/QueryHelper.class.php');

class Validator{

  function isValidSignUp($firstName, $lastName, $signUpEmail, $StudentID, $subject, $signUpPassword, $passwordConfirm){
    return ($this -> isValidName($firstName) && $this -> isValidName($lastName) && $this -> isValidEmail($signUpEmail) &&
    $this -> isValidStudentID($StudentID) && $this -> isValidSubject($subject) && $this -> isValidPassword($signUpPassword)
    && ($signUpPassword == $passwordConfirm));
  }

  function isValidProfileEdit($name, $email, $studentID, $subject){
    $names = explode(' ', $name);
    if(sizeof($names) == 2){
      $fname = $names[0];
      $lname = $names[1];

      return ($this->isValidName($fname) && $this -> isValidName($lname) && $this->isValidEmail($email) && $this->isValidSubject($subject) && $this->isValidStudentID($studentID));
    }
    else{
      return false;
    }
  }

  function isValidTask($taskTitle, $taskDescription, $numPages, $numWords, $docFormat, $docType, $subject, $tags, $document, $sampleDoc,
  $claimDeadline, $completeDeadline){

    if($this->isValidTaskTitle($taskTitle) && $this->isValidTaskDescription($taskDescription) && $this->isPosNum($numPages)
    && $this->isPosNum($numWords) && $this->isValidFormat($docFormat) && $this -> isValidDocument($docFormat, $document) && $this->isValidDocument($docFormat, $sampleDoc) &&
    $this->isValidDocType($docType) && $this->isValidSubject($subject) && $this->validTags($tags) && $this->validDeadlines($claimDeadline, $completeDeadline)){
      return true;
    }
    else{
      return false;
    }
  }

  function isValidName($name){
    if (strlen($name) <= 35 && strlen($name) >= 1){
      return true;
    }
    else{
      return false;
    }
  }

  function isValidEmail($signUpEmail) {

    if (!filter_var($signUpEmail, FILTER_VALIDATE_EMAIL) === false) {
		if(strpos($signUpEmail, 'ul.ie') !== false){
			return true;
		}
    }
    return false;
  }

  //Student IDs must be 8 characters in length and must be integers.
  function isValidStudentID($id){
    if(preg_match('/^\d+$/', $id) && strlen($id) == 8){
      return true;
    }
    else{
      return false;
    }
  }

  //passwords can be between 8 and 20 characters long and must have:
  //  -atleast one letter
  //  -atleast one number
  //  -atleast one uppercase letter
  function isValidPassword($password){
    $hasLower = false;
    $hasDigit = false;
    $hasUpper = false;

    if(strlen($password) >= 8 && strlen($password) <= 20){
      $splitStringArray = str_split($password);

      for($i = 0; $i < count($splitStringArray); $i++){
        if(ctype_lower($splitStringArray[$i])){
          $hasLower = true;
        }
        else if(ctype_digit($splitStringArray[$i])){
          $hasDigit = true;
        }
        else if(ctype_upper($splitStringArray[$i])){
          $hasUpper = true;
        }
        if($hasLower && $hasDigit && $hasUpper){
          return true;
        }
      }
    }
    return false;
  }

  //functionality to be added
  function isValidSubject($subject){
    $qh = new QueryHelper();

    $columnName = "SubjectName";
    $selectSubject = "SELECT * FROM Subject;";
    if($qh -> verifyDropDownInput($subject, $selectSubject, $columnName)){
      return true;
    }
    else{
      return false;
    }
  }

  //ensures length of task title is valid
  function isValidTaskTitle($taskTitle){
    if(strlen($taskTitle) <= 74){
      return true;
    }
    else{
      return false;
    }
  }

  //checks if task description is no longer than 200 characters.
  function isValidTaskDescription($taskDescription){
    if (strlen($taskDescription) <= 200){
      return true;
    }
    else{
      return false;
    }
  }

  //Checks whether or not format is valid.
  function isValidFormat($format){
    $qh = new QueryHelper();

    $columnName = "FormatVal";
    $selectFormat = "SELECT * FROM Format;";
    if($qh -> verifyDropDownInput($format, $selectFormat, $columnName)){
      return true;
    }
    else{
      echo "invalid format";
      return false;
    }
  }

  //makes sure user isn't entering negative num (or non number) for numPages/numWords.
  function isPosNum($number){
    if(((int)$number) >= 0){
      return true;
    }
    else{
      return false;
    }
  }

  //Checks each tag is a valid entry in the database.
  function validTags($tags){
    $qh = new QueryHelper();

    $columnName = "Value";
    $selectTag = "SELECT * FROM Tag;";

    for($i = 0; $i < sizeof($tags); $i++){
      if(!$tags[$i] == 'Tag'){
        if(!$qh -> verifyDropDownInput($tags[$i], $selectFormat, $columnName)){
          return false;
        }
      }
    }
    return true;
  }

  //checks if the selected DocumentType is a valid value existing in the database.
  function isValidDocType($docType){
    $qh = new QueryHelper();

    $columnName = "DocumentTypeVal";
    $selectDocumentType = "SELECT * FROM DocumentType;";
    if($qh -> verifyDropDownInput($docType, $selectDocumentType, $columnName)){
      return true;
    }
    else{
      return false;
    }
  }

  //valid deadlines consist of:
  // - valid dates in YYYY-MM-DD Format
  // - the claim deadline being greater than the current Date
  // - the completeDeadline being greater than the claimDeadline
  function validDeadlines($claimDeadline, $completeDeadline){
    if($this -> validateDate($claimDeadline) && $this -> validateDate($completeDeadline)){
      $currentTime = date('Y-m-d');
      if($this -> dateGreaterThan($claimDeadline, $currentTime)){
        if($this -> dateGreaterThan($completeDeadline, $claimDeadline)){
          return true;
        }
      }
    }
    return false;
  }

  //Checks if document matches the given docFormat and that the document has no errors
  //we have already checked that the document format/extension is valid so we do not need
  //to do that here.
  function isValidDocument($docFormat, $document){
    $name = $document['name'];
    $ext = explode('.', $name);
    $ext = '.' . $ext[1];

    if($ext == $docFormat){
      if($document['error'] === 0){
        return true;
      }
      else{
        return false;
      }
    }
    else{
      return false;
    }
  }

  function validateDate($date){
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
  }

  function dateGreaterThan($d1, $d2){
    $tsDate1 = strtotime($d1);
    $tsDate2 = strtotime($d2);

    if($tsDate1 > $tsDate2){
      return true;
    }
    else{
      return false;
    }
  }

}


?>
