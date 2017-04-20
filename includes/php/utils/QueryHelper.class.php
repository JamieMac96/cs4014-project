<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH . '/includes/php/utils/User.class.php');
include_once(SITE_PATH . '/includes/php/utils/Database.class.php');

class QueryHelper{

  private $database;


  function __construct(){
    $this->database = new Database();
  }

  //The database class is paired with this class exclusively (to simplify includes) thus we require this
  //functionality at times.
  function select($query){
    $database = $this->database;

    $res = $database -> select($query);
    return $res;
  }

  function getSubjectIdFromSubjectName($subject){
    $database = $this->database;

    $selectSubjectIdQuery = "SELECT *
                             FROM Subject
                             WHERE SubjectName = '$subject';";


    $subjectIdResult = $database -> select($selectSubjectIdQuery);
    $subjectID = $subjectIdResult[0]['SubjectID'];

    return $subjectID;
  }

  function insertUser($studentID, $subjectID, $firstName, $lastName, $signUpEmail, $signUpPassword, $passwordSalt){
    $database = $this->database;
    echo "student ID: $studentID subjectID: $subjectID fname: $firstName lname: $lastName email: $signUpEmail pword: $signUpPassword salt:  $passwordSalt";

    $insertSql = "INSERT INTO   `User` (
                          `UserID` ,
                          `Subject_SubjectID` ,
                          `ForeName` ,
                          `LastName` ,
                          `EmailAddress` ,
                          `StudentID`,
                          `Password` ,
                          `Reputation` ,
                          `IsMod`,
                          `PasswordSalt`
                          )
                          VALUES (

                         NULL,  $subjectID,  '$firstName',  '$lastName',  '$signUpEmail', $studentID, '$signUpPassword',  '0',  '0', '$passwordSalt'
                        );";

    $result = $database -> query($insertSql);

    return $result;
  }

  //returns the password salt that belongs to a particular user.
  function getPasswordSalt($email){
    $database = $this->database;
    $query = "SELECT *
              FROM User
              WHERE EmailAddress = '$email';";

    $result = $database -> select($query);
	if($result){
		$salt = $result[0]['PasswordSalt'];
		return $salt;
	}
    return false;
  }

  //returns a user with the specified email and password or false if the user does not exist.
  function getUser($email, $hashedPassword){
    $database = $this->database;

    $sql = "SELECT *
    FROM User
    WHERE EmailAddress = '$email' AND Password = '$hashedPassword';";

    $res = $database -> select($sql);



    return $res;
  }

  //check if the email is already used or belongs to banned user.
  function isUniqueEmail($inputEmail){
    $database = $this->database;

    $bannedUserQuery = "SELECT EmailAddress
                        From BannedUser
                        WHERE EmailAddress = '$inputEmail';";
    $bannedUserResult = $database -> select($bannedUserQuery);

    //if we get false back from our select query we proceed to check if this email is in the user table.
    if(!$bannedUserResult){

      $userQuery = "SELECT EmailAddress
                          From User
                          WHERE EmailAddress = '$inputEmail';";
      $userResult = $database -> select($userQuery);

      //if the email is not in the user table we return true.
      if(!$userResult){
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

  function verifyDropDownInput($input, $selectQuery, $columnName){
    $database = $this->database;

    $result = $database -> select($selectQuery);

    for($i = 0; $i < count($result); $i++){
      if($input == $result[$i][$columnName]){
        return true;
      }
    }
    return false;
  }

  function insertTask($task){
    $database = $this->database;

    //collect the data required to insert into task table.
    $taskTypeID = $this -> getTaskTypeIDFromTaskType($task->getTaskType());
    $subjectID = $this -> getSubjectIDFromSubjectName($task -> getSubject());
    $title = $task -> getTaskTitle();
    $description = $task -> getTaskDescription();
    $numPages = $task -> getNumPages();
    $numWords = $task -> getNumWords();

    $currentUser = User::getUser($_SESSION['userID']);
    $userID = $currentUser -> getUserID();
    echo "user ID is: $userID";

    //sql statement
    $taskInsert = "INSERT INTO `Task`(
      `TaskID`,
      `User_UserID`,
      `TaskType_TaskTypeID`,
      `Subject_SubjectID`,
      `Status_StatusID`,
      `Title`,
      `Description`,
      `NumPages`,
      `NumWords`,
      `ClaimantID`)
    VALUES (NULL,$userID, $taskTypeID, $subjectID,2,'$title','$description',$numPages,$numWords,NULL);";
    //execute query
    $taskInsertSuccess = $database -> query($taskInsert);

    $taskID = $this -> getLastInsertID();
    $task -> setTaskID($taskID);



    if(!$taskInsertSuccess){
      echo "failed to insert task";
      return false;
    }
    else{
      //insert into the associated tables.
      $deadlineInsert = $this -> insertDeadlines($task);
      if(!$deadlineInsert){
        echo "Failed to insert deadlines";
        return false;
      }
      $docInsert = $this -> insertDocument($task);
      if(!$docInsert){
        echo "Failed to insert document";
        return false;
      }
      $taskTagInsert = $this -> insertTaskTags($task);
      if(!$taskTagInsert){
        echo "Failed to insert tasktag";
        return false;
      }
      return true;
    }
  }


  function insertDocument($task){
    $database = $this->database;

    $document = $task -> getDocument();
    $sampleDoc = $task->getSampleDoc();

    $fullDocLocation = $document['tmp_name'];
    $sampleDocLocation = $sampleDoc['tmp_name'];
    $targetFile = basename($document['name']);
    $ext = $task -> getDocFormat();

    $fileNameNew = uniqid('', true) . $ext;
    $sampleFileName = uniqid('', true) . $ext;

    $docDestination = 'files/documents/' . $fileNameNew;
    $sampleDestination = 'files/documents/samples/' . $sampleFileName;

    if(move_uploaded_file($fullDocLocation, $docDestination) && move_uploaded_file($sampleDocLocation, $sampleDestination)){
      $taskID = $task -> getTaskID();
      $format = $task -> getDocFormat();
      $docType = $task -> getDocType();
      $formatID = $this -> getFormatIDFromFormat($format);
      $documentTypeID = $this -> getDocTypeIDFromDocType($docType);


      $insertSQL = "INSERT INTO `Document`(
        `DocumentID`,
        `DocumentURL`,
        `SampleURL`,
        `Task_TaskID`,
        `Format_FormatID`,
        `DocumentType_DocumentTypeID`)
      VALUES (NULL,'$docDestination','$sampleDestination',$taskID,$formatID,$documentTypeID);";

      $docInsert = $database -> query($insertSQL);
      if($docInsert){
        return true;
      }
    }
    else{
      $error = $document['error'];
      echo "File not uploaded: $error";
    }
  }

  function insertDeadlines($task){
    $database = $this->database;

    $claimDeadline = $task -> getClaimDeadline();
    $completeDeadline = $task -> getCompleteDeadline();
    $taskID = $task -> getTaskID();
    echo "task ID: $taskID";

    $sql = "INSERT INTO `Deadline`(`Task_TaskID`, `Claim`, `Completion`)
            VALUES($taskID, '$claimDeadline', '$completeDeadline');";

    $deadlineInsert = $database -> query($sql);
    return $deadlineInsert;
  }

  function insertTaskTags($task){
    $database = $this->database;
    $insertSuccess = true;

    //get each tag for the task
    $t1 = $task -> getTag1();
    $t2 = $task -> getTag2();
    $t3 = $task -> getTag3();
    $t4 = $task -> getTag4();

    //convert to array for convenience.
    $tags = array($t1, $t2, $t3, $t4);
    $taskID = $task -> getTaskID();

    //for each tag check if it was given a value and if it was we insert into taskTag
    for ($i=0; $i < sizeof($tags); $i++) {
      $currentTag = $task -> getTag($i + 1);
      if($currentTag != 'Tag'){
        $tagID = $this -> getTagIDFromTagVal($currentTag);
        $tagInsert = $database -> query("INSERT INTO `TaskTag`
                            (`TaskTagID`, `Tag_TagID`, `Task_TaskID`)
                            VALUES (NULL, $tagID, $taskID);");

        if(!$tagInsert){
          echo "Failed to insert tag: $currentTag";
          $insertSuccess = false;
        }
      }
    }
    if($insertSuccess){
      return true;
    }
    else{
      return false;
    }
  }

  function getTagIDFromTagVal($tagVal){
    $database = $this->database;

    $sql = "SELECT * FROM Tag WHERE Value = '$tagVal'";

    $res = $database -> select($sql);

    if(!$res){
      return false;
    }
    else{
      $tagID = $res[0]['TagID'];

      return $tagID;
    }
  }

  function getTaskTypeIDFromTaskType($taskType){
    $database = $this->database;

    $taskTypeIDArray = $database -> select("SELECT TaskTypeID FROM TaskType
                                       WHERE TaskTypeVal = '$taskType';");
    $taskTypeID = $taskTypeIDArray[0]['TaskTypeID'];

    return $taskTypeID;
  }


  function getFormatIDFromFormat($format){
    $database = $this->database;

    $formatArray = $database -> select("SELECT * FROM Format
                                       WHERE FormatVal = '$format';");
    $formatID = $formatArray[0]['FormatID'];

    return $formatID;
  }

  function getDocTypeIDFromDocType($docType){
    $database = $this->database;

    $docTypeArray = $database -> select("SELECT * FROM DocumentType
                                       WHERE DocumentTypeVal = '$docType';");
    $docTypeID = $docTypeArray[0]['DocumentTypeID'];

    return $docTypeID;
  }

  public function getTasksCount() {

    $database = $this->database;

    $query = "SELECT COUNT(*) FROM Task;";

    $num = $database -> select($query);

    return $num[0]['COUNT(*)'];
  }



 function getTasksMain($start, $number){
   $database = $this->database;
   
	if(!isset($_SESSION['userID'])){
		 session_start();
	}

   $currentUser = User::getUser($_SESSION['userID']);
   $currentUserID = $currentUser -> getUserID();

   $joinedTaskSQL =  "SELECT * FROM JoinedTask
                      WHERE StatusVal = 'Pending Claim'
                      AND User_UserID <> '$currentUserID'
                      ORDER BY Claim
                      LIMIT $start, $number;";

   $result = $database -> select($joinedTaskSQL);

   return $result;
 }

 function getTasksMainFiltered($start, $number, $filters){
   $filteredSubject = $filters[0];
   $filteredTaskType = $filters[1];
   $filteredDocType = $filters[2];
   $filteredTag = $filters[3];

   $currentUser = User::getUser($_SESSION['userID']);
   $currentUserID = $currentUser -> getUserID();

   $sql = " SELECT * FROM JoinedTask
            WHERE StatusVal = 'Pending Claim'
            AND User_UserID <> '$currentUserID'
            AND TaskID IN ( SELECT DISTINCT Task_TaskID
                            FROM JoinedTag
                            Where JoinedTag.Value = '$filteredTag' OR '$filteredTag' = '1')
            AND (DocumentTypeVal = '$filteredDocType' OR '$filteredDocType' = '1')
            AND (TaskTypeVal = '$filteredTaskType' OR '$filteredTaskType' = '1')
            AND (SubjectName = '$filteredSubject' OR '$filteredSubject' = '1')
            ORDER BY Claim
            LIMIT $start, $number;";

  $res = $this->database->select($sql);


  return $res;
 }

 function getPersonalizedTasks($start, $number, $favouriteTags, $favouriteSubjects){
   if(!isset($_SESSION['userID'])){
	session_start();
   }

   $currentUser = User::getUser($_SESSION['userID']);
   $currentUserID = $currentUser -> getUserID();
   $firstT = $favouriteTags[0];
   $secondT = $favouriteTags[1];
   $thirdT = $favouriteTags[2];
   $firstS = $favouriteSubjects[0];
   $secondS = $favouriteSubjects[1];
   $thirdS = $favouriteSubjects[2];

   $joinedTaskSQL =  "SELECT * FROM(
                        SELECT * FROM JoinedTask
                        WHERE StatusVal = 'Pending Claim'
                        AND User_UserID <> $currentUserID
                        AND TaskID
                          IN (SELECT Task_TaskID
                              FROM TaskTag
                              WHERE Tag_TagID = $firstT
                                UNION
                              SELECT TaskID
                              FROM Task
                              WHERE Subject_SubjectID = $firstS)
                        UNION

                        SELECT * FROM JoinedTask
                        WHERE StatusVal = 'Pending Claim'
                        AND User_UserID <> $currentUserID
                        AND TaskID
                         IN ( SELECT Task_TaskID
                             FROM TaskTag
                             WHERE Tag_TagID = $secondT
                               UNION
                             SELECT TaskID
                             FROM Task
                             WHERE Subject_SubjectID = $secondS)


                        UNION

                        SELECT * FROM JoinedTask
                        WHERE StatusVal = 'Pending Claim'
                        AND User_UserID <> $currentUserID
                        AND TaskID
                          IN ( SELECT Task_TaskID
                             FROM TaskTag
                             WHERE Tag_TagID = $thirdT
                               UNION
                             SELECT TaskID
                             FROM Task
                             WHERE Subject_SubjectID = $thirdS)) as personalized_table
                      ORDER BY Claim
                      LIMIT $start, $number;
                      ";

   $result = $this->database -> select($joinedTaskSQL);

   return $result;
 }

 function getMyTasks($start, $number){
   $database = $this->database;
	if(!isset($_SESSION['profileID'])){
		session_start();
	}
	
   $currentUser = User::getUser($_SESSION['profileID']);
   $currentUserID = $currentUser -> getUserID();

   //display the tasks that have been completed but not rated first.
   $joinedTaskSQL =  "SELECT * FROM JoinedTask
                      WHERE StatusVal = 'Complete'
                      AND Rated = 0
                      AND User_UserID = '$currentUserID'
                      UNION
                      SELECT * FROM JoinedTask
                      WHERE User_UserID = '$currentUserID'
                      GROUP BY TaskID
                      LIMIT $start, $number;";

   $result = $database -> select($joinedTaskSQL);

   return $result;
 }

 function getClaimedTasks($start, $number){
   $database = $this->database;
	if(!isset($_SESSION['profileID'])){
		session_start();
	}

   $currentUser = User::getUser($_SESSION['profileID']);
   $currentUserID = $currentUser -> getUserID();

   $joinedTaskSQL =  "SELECT * FROM JoinedTask
                      WHERE ClaimantID = '$currentUserID'
                      AND ClaimantID IS NOT NULL
                      AND StatusVal = 'Claimed'
                      LIMIT $start, $number;";

   $result = $database -> select($joinedTaskSQL);

   return $result;
 }


 function getJoinedTask($taskID){
   $database = $this->database;

   $joinedTaskSQL =  "SELECT * FROM JoinedTask WHERE TaskID = '$taskID';";

   $result = $database -> select($joinedTaskSQL);

   return $result;
 }

 function getJoinedTags($taskID){
   $database = $this->database;

   $joinedTaskSQL =  "SELECT * FROM JoinedTag WHERE Task_TaskID = $taskID;";

   $result = $database -> select($joinedTaskSQL);

   return $result;
 }



 function getUserInfo($userID){
   $database = $this->database;

   $userSQL = "SELECT * FROM User WHERE UserID = '$userID';";

   $userResult = $database -> select($userSQL);
   if($userResult){
     $subject = $this -> getSubjectNameFromSubjectId($userResult[0]['Subject_SubjectID']);
     $isMod = false;

     if($userResult[0]['IsMod'] != 0){
       $isMod = true;
     }

     $userInfo = array($subject, $userResult[0]['ForeName'], $userResult[0]['Lastname'],
                        $userResult[0]['EmailAddress'], $userResult[0]['StudentID'], $userResult[0]['reputation'], $isMod, $userResult[0]['ProfilePicURL']);
      return $userInfo;
   }
   else{
     return false;
   }
 }


 function getSubjectNameFromSubjectId($subjectID){
   $database = $this->database;

   $selectSubjectNameQuery = "SELECT *
                            FROM Subject
                            WHERE SubjectID = '$subjectID';";


   $subjectNameResult = $database -> select($selectSubjectNameQuery);
   $subjectName = $subjectNameResult[0]['SubjectName'];

   return $subjectName;
 }

 function getUserEmailFromID($userID){
   $database = $this->database;

   $selectID = "SELECT * FROM User WHERE UserID = '$userID';";

   $result = $database -> select($selectID);

   return $result[0]['EmailAddress'];
 }

 function setCancelled($taskID){
   $statusID = $this->getStatusIdFromStatusVal('Cancelled');

   $currentUser = User::getUser($_SESSION['userID']);
   $currentUserID = $currentUser -> getUserID();

   $updateTask = "UPDATE `Task` SET `Status_StatusID`=$statusID WHERE TaskID = $taskID";

   $this->database -> query($updateTask);
 }

 function setUnclaimed($taskID){
   $statusID = $this->getStatusIdFromStatusVal('Unclaimed');

   $currentUser = User::getUser($_SESSION['userID']);
   $currentUserID = $currentUser -> getUserID();

   $updateTask = "UPDATE `Task` SET `Status_StatusID`=$statusID WHERE TaskID = $taskID";

   $this->database -> query($updateTask);
 }

 function setClaimed($taskID){
   $database = $this->database;

   $statusID = $this->getStatusIdFromStatusVal('Claimed');

   $currentUser = User::getUser($_SESSION['userID']);
   $currentUserID = $currentUser -> getUserID();

   $updateTask = "UPDATE `Task` SET `Status_StatusID`=$statusID,`ClaimantID`=$currentUserID WHERE TaskID = $taskID";

   $database -> query($updateTask);
 }

 function insertFlag($taskID, $complaint){
   $database = $this->database;

   $sql = "INSERT INTO `Flag`(`FlagID`, `Task_TaskID`, `Complaint`) VALUES (NULL,$taskID,'$complaint');";

   $res = $database -> query($sql);
 }

 function getFlaggedTasks($start, $number){
   $database = $this->database;

   $ctr = 0;
	if(!isset($_SESSION['userID'])){
		session_start();
	}

   $currentUser = User::getUser($_SESSION['userID']);
   $currentUserID = $currentUser -> getUserID();

   $joinedTaskSQL =  "SELECT *
                      FROM `Flag`
					  LEFT JOIN `JoinedTask`
                      ON `Flag`.Task_TaskID = `JoinedTask`.TaskID
                      GROUP BY TaskID
                      LIMIT $start, $number;";

   $result = $database -> select($joinedTaskSQL);
   return $result;
 }

 function getFlags($taskID){
   $database = $this->database;

   $sql = "SELECT * FROM Flag WHERE Task_TaskID = $taskID;";

   $res = $database -> select($sql);
   return $res;
 }

 function getLastInsertID(){
   $database = $this->database;
   $lastID = $database -> getLastInsertID();
   return $lastID;
 }

 function getUserIDFromEmail($email){
   $database = $this->database;

   $userSQL = "SELECT * FROM User WHERE EmailAddress = '$email';";

   $res = $database -> select($userSQL);

   return $res[0]['UserID'];
 }

 function removeTask($taskID){
   $database = $this->database;

   $sql = "DELETE FROM `Task` WHERE TaskID = $taskID;";

   $res = $database -> query($sql);

   return $res;
 }

 function setComplete($taskID){
   $database = $this->database;

   $statusID = $this->getStatusIdFromStatusVal('Complete');

   $updateTask = "UPDATE `Task` SET `Status_StatusID`=$statusID WHERE TaskID = $taskID;";

   $database -> query($updateTask);
 }

 function setPendingClaim($taskID){
   $database = $this->database;

   $statusID = $this->getStatusIdFromStatusVal('Pending Claim');

   $updateTask = "UPDATE `Task` SET `Status_StatusID`=$statusID,`ClaimantID`= NULL WHERE TaskID = $taskID;";

   $database -> query($updateTask);
 }

 function changeReputation($userID, $amount){
   $database = $this->database;

   $sql = "UPDATE `User` SET `reputation`=reputation + $amount WHERE UserID = $userID;";

   $database -> query($sql);
 }

 function search($query, $start, $number){
   $database = $this->database;

   if($query != "" && $query != null){
     $sql = " SELECT * FROM JoinedTask
              WHERE Title LIKE '%$query%'
              LIMIT $start, $number;";

     $res = $database -> select($sql);
     return $res;
   }
   else{
     return false;
   }
 }

 function deleteUser($userID){
   $database = $this->database;

   $sql = "DELETE FROM `User` WHERE UserID = $userID;";

   $res = $database -> query($sql);

   return $res;
 }

 function insertClick($userID, $taskID){
   $sql = "INSERT INTO `Click`(`clickID`, `Task_TaskID`, `User_UserID`)
            VALUES (NULL,$taskID,$userID);";

   $this->database->query($sql);
 }

 function getClickTagInfo($userID){
   $sql = "SELECT * FROM JoinedTag
           JOIN Click
           ON JoinedTag.Task_TaskID = Click.Task_TaskID
           WHERE Click.User_UserID = $userID
           ORDER BY clickID
           LIMIT 0, 1000;";

  $res = $this->database->select($sql);

  return $res;
 }

 function getClickTaskInfo($userID){
   $sql = "SELECT * FROM Task
           JOIN Click
           ON Task.TaskID = Click.Task_TaskID
           WHERE Click.User_UserID = $userID
           ORDER BY clickID
           LIMIT 0,1000;";

  $res = $this->database->select($sql);

  return $res;
 }

 function getNumberOfClicksForUser($userID){
   $sql = "SELECT COUNT(*) as count FROM Click WHERE User_UserID = $userID;";

   $res = $this->database->select($sql);
   $count = $res[0]['count'];

   return $count;
 }

 function getAllTasks(){
   $sql = "SELECT * FROM JoinedTask;";

   $res = $this->database->select($sql);

   return $res;
 }

 function updateName($firstName, $lastName, $userID){

   $sql = "UPDATE `User` SET `ForeName`='$firstName', `Lastname`='$lastName' WHERE UserID = $userID;";

   $this->database->query($sql);
 }

 function updateEmail($email, $userID){
   $sql = "UPDATE `User` SET `EmailAddress`='$email' WHERE UserID = $userID;";

   $this->database->query($sql);
 }

 function updateStudentID($studentID, $userID){
   $sql = "UPDATE `User` SET `StudentID`='$studentID' WHERE UserID = $userID;";

   $this->database->query($sql);
 }

 function updateSubject($subject, $userID){
   $subjectID = $this->getSubjectIdFromSubjectName($subject);
   $sql = "UPDATE `User` SET `Subject_SubjectID`=$subjectID WHERE UserID = $userID;";
   $this->database->query($sql);
 }

 function insertBannedUser($profileID, $reason){
   $currentUser = User::getUser($profileID);
   $email = $currentUser -> getEmailAddress();
   $insertSQL = "INSERT INTO `BannedUser`(`BanID`, `EmailAddress`, `Reason`) VALUES (NULL,'$email','$reason');";

   $res = $this->database -> query($insertSQL);
   if($res){
     return true;
   }
   else{
     return false;
   }
 }

 function setTaskRated($taskID){
   $sql = "UPDATE `Task`
          SET `Rated`=1
          WHERE TaskID = $taskID";

   $res = $this->database->query($sql);
 }

 function deleteTaskFlag($taskID){
   $sql = "DELETE FROM `Flag` WHERE Task_TaskID = $taskID;";

   $result = $this->database->query($sql);
   if($result){
     return true;
   }
   else{
     return false;
   }
 }

 function handleClaimedTasksOnUserDelete($userID){
   echo "USERID IN HANDLECLAIMED: $userID";
   $newStatusID = $this->getStatusIdFromStatusVal('Pending Claim');
   echo "statusID: $newStatusID";

   $sql = " UPDATE `Task`
            SET `Status_StatusID`=$newStatusID,`ClaimantID`=DEFAULT
            WHERE `ClaimantID` = $userID;";

   $result = $this->database->query($sql);

   return $result;
 }

 function getStatusIdFromStatusVal($statusVal){
   $sql = "SELECT * FROM Status WHERE StatusVal = '$statusVal';";

   $statusRes = $this->database -> select($sql);

   $statusID = $statusRes[0]['StatusID'];
   return $statusID;
 }

 function getAlsoViewed($taskID, $userID){

   $sql ="SELECT Task_TaskID
          FROM Click
          WHERE User_UserID IN ( SELECT DISTINCT User_UserID
                                FROM Click
                                WHERE Task_TaskID = $taskID)
          AND Task_TaskID <> $taskID
          AND User_UserID <> $userID;";

  $alsoViewedTasks = $this->database->select($sql);
  $size = sizeof($alsoViewedTasks);

  if($size > 0){
    $frequencies = array();

    //get the most common results for Task_TaskID from the above query using the same method as
    //is used in TaskRetriever getFavourites() function.
    for($i = 0; $i < sizeof($alsoViewedTasks); $i++){
      $taskID = $alsoViewedTasks[$i]['Task_TaskID'];
      if(isset($frequencies[$taskID])){
        $frequencies[$taskID]++;
      }
      else{
        $frequencies[$taskID] = 1;
      }
    }

    arsort($frequencies);
    $keys = array_keys($frequencies);
    $mostViewed = array();

    for($i = 0; $i < 5 && $i<sizeof($keys) ; $i++){
      $mostViewed[$i] = $keys[$i];
    }

    $taskIDs = join(',', array_map('intval', $mostViewed));

    $sqlGetTasks = "SELECT * FROM JoinedTask
                    WHERE TaskID IN  ($taskIDs);";

    $res = $this->database->select($sqlGetTasks);

    //nested loop but max 5x5 iterations so efficiency is not really a problem
    //ensures tasks are in descending order by number of views
    for($i = 0; $i < sizeof($res); $i++){
      if($mostViewed[$i] != $res[$i]['TaskID']){
        $temp = $res[$i];
        for($j = 0; $j < sizeof($res); $j++){
          if($mostViewed[$i] == $res[$j]['TaskID']){
            $res[$i] = $res[$j];
            $res[$j] = $temp;
          }
        }
      }
    }
    return $res;
  }
  else{
    return false;
  }
 }

 function updateProfilePic($picURL, $userID){

   $sql = " UPDATE `User` SET `ProfilePicURL`='$picURL'
            WHERE UserID = $userID;";

   $this->database->query($sql);


 }


}









?>
