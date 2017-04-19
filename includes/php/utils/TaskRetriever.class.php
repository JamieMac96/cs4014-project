<?php
include_once('C:\inetpub\wwwroot\modules\cs4014\group2\config.php');
include_once(SITE_PATH . '/includes/php/utils/QueryHelper.class.php');
include_once(SITE_PATH . '/includes/php/utils/Task.class.php');
include_once(SITE_PATH . '/includes/php/utils/Flag.class.php');


  class TaskRetriever{
    private $qh;

    function __construct(){
      $this->qh = new queryHelper();
    }

    function getAllTasks(){
      $taskTable = $this->qh -> getAllTasks();
      $allTasksArray = array();

      for($i = 0; $i < sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getTasksMain($start, $number){

      $taskTable = $this->qh -> getTasksMain($start, $number);
      $allTasksArray = array();

      for($i = 0; $i < sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getTasksMainFiltered($start, $number, $filters){
      $unselectedValues = array("Subject / Discipline", "Task Type", "Document Type", "Tag");
      for($i = 0; $i < sizeof($filters); $i++){
        if($filters[$i] == $unselectedValues[$i]){
          $filters[$i] = 1;
        }
      }

      $taskTable = $this->qh -> getTasksMainFiltered($start, $number, $filters);
      $allTasksArray = array();

      for($i = 0; $i < sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getPersonalizedTasks($start, $number){
      $favouriteTags = $this->getFavouriteTags();
      $favouriteSubjects = $this->getFavouriteSubjects();

      $taskTable = $this->qh->getPersonalizedTasks($start, $number, $favouriteTags, $favouriteSubjects);

      $allTasksArray = array();


      for($i = 0; $i < sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getMyTasks($start, $number) {

      $taskTable = $this->qh -> getMyTasks($start, $number);
      $allTasksArray = array();


      for($i = 0; $i < sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getFlaggedTasks($start, $number){

      $taskTable = $this->qh -> getFlaggedTasks($start, $number);
      $allTasksArray = array();


      for($i = 0; $i < sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getClaimedTasks($start, $number) {

      $taskTable = $this->qh -> getClaimedTasks($start, $number);
      $allTasksArray = array();


      for($i = 0; $i < sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getSearchResults($searchQuery, $start, $tasksPerPage){

      $taskTable = $this->qh -> search($searchQuery, $start, $tasksPerPage);
      $allTasksArray = array();

      for($i = 0; $i < sizeof($taskTable) && $taskTable != false; $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getAlsoViewed($taskID, $userID){
      $taskTable = $this->qh->getAlsoViewed($taskID, $userID);
      if(!$taskTable){
        return false;
      }

      $allTasksArray = array();

      for($i = 0; $i< sizeof($taskTable); $i++){
        $allTasksArray[$i] = $this -> initializeTask($taskTable, $i);
      }

      return $allTasksArray;
    }

    function getTask($taskID){

      $taskTable = $this->qh -> getJoinedTask($taskID);

      $task = $this -> initializeTask($taskTable, 0);

      return $task;
    }

    function getRelevantTags($taskID){


      $tags = $this->qh -> getJoinedTags($taskID);

      $returnTags = array();

      for($i = 0; $i < sizeof($tags); $i++){
          $returnTags[$i] = $tags[$i]['Value'];
      }
      for($i = sizeof($returnTags); $i < 4; $i++){
        $returnTags[$i] = 'Tag';
      }
      return $returnTags;
    }

    function getRelevantFlags($taskID){


      $flags = $this->qh -> getFlags($taskID);

      $returnFlags = array();

      for($i = 0; $i < sizeof($flags); $i++){
        $returnFlags[$i] = new Flag($flags[$i]['FlagID'], $flags[$i]['Task_TaskID'], $flags[$i]['Complaint']);
      }
      return $returnFlags;
    }

    private function initializeTask($tasks, $index){
      $taskTitle = $tasks[$index]['Title'];
      $taskID = $tasks[$index]['TaskID'];
      $ownerID = $tasks[$index]['User_UserID'];
      $taskType = $tasks[$index]['TaskTypeVal'];
      $taskDescription = $tasks[$index]['Description'];
      $numPages = $tasks[$index]['NumPages'];
      $numWords = $tasks[$index]['NumWords'];
      $docFormat = $tasks[$index]['FormatVal'];
      $docType = $tasks[$index]['DocumentTypeVal'];
      $documentURL = $tasks[$index]['DocumentURL'];
      $sampleURL = $tasks[$index]['SampleURL'];
      $claimDeadline = $tasks[$index]['Claim'];
      $completeDeadline = $tasks[$index]['Completion'];
      $subject = $tasks[$index]['SubjectName'];
      $taskStatus = $tasks[$index]['StatusVal'];
      $claimantID = $tasks[$index]['ClaimantID'];
      $rated = $tasks[$index]['Rated'];
      $tags = $this -> getRelevantTags($taskID);



      $task = new Task($taskTitle, $taskType, $taskDescription, $numPages, $numWords, $docFormat, $docType, $subject, $documentURL,$sampleURL,
                                  $tags[0], $tags[1], $tags[2], $tags[3], $claimDeadline, $completeDeadline);
      $task -> setStatus($taskStatus);
      $task -> setOwnerID($ownerID);
      $task -> setTaskID($taskID);
      $task -> setClaimantID($claimantID);
      $task -> setRated($rated);

      return $task;
    }

    //This function returns the current users favourite 3 tags
    //i.e the 3 tags contained by the most tasks that the user has clicked on
    function getFavouriteTags(){
      //first we get all the info on tags that belong to tasks that the current user has clicked on
      $clickInfo = $this->qh->getClickTagInfo($_SESSION['userID']);
      return $this->getFavourites($clickInfo, 'TagID');
    }

    function getFavouriteSubjects(){
      $clickInfo = $this->qh->getClickTaskInfo($_SESSION['userID']);
      return $this->getFavourites($clickInfo, 'Subject_SubjectID');
    }

    private function getFavourites($clickInfo, $index){
      $frequencies = array();
      $favourites = array();

      //next we form a list of frequencies of each tag (this is the frequencies array)
      //using the tagID as the index for the array
      for($i = 0; $i < sizeof($clickInfo) ; $i++){
        $ID = $clickInfo[$i][$index];
        if(isset($frequencies[$ID])){
          $frequencies[$ID]++;
        }
        else{
          $frequencies[$ID] = 1;
        }
      }
      //now we sort this array to make it easier to retrieve the most commmon tags
      arsort($frequencies);

      //we get the keys of the array as these are the IDs that we are interested in.
      $keys = array_keys($frequencies);

      //Now we extract the first 3 tagIDs from the keys array
      for($i = 0; $i < 3; $i++){
        $favourites[$i] = $keys[$i];
      }
      return $favourites;
    }

  }

 ?>
