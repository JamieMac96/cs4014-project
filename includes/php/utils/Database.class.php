<?php
class Database{
  protected static $connection;

  function connect(){
    // Try and connect to the database
     if(!isset(self::$connection)) {
         // Load configuration as an array. Use the actual location of your configuration file
         $config = parse_ini_file('C:\inetpub\wwwroot\modules\cs4014\group2\config.ini');
         self::$connection = new mysqli('localhost',$config['username'],$config['password'],$config['dbname']);
     }

     // If connection was not successful, handle the error
     if(self::$connection === false) {
          echo "<script>alert('connection failed')</script>";
         return false;
     }

     return self::$connection;
  }

  //this function performs select queries to the database.
  public function select($query) {
    $rows = array();

    $result = $this -> query($query);

    //check if query returns no result / false.
    if($result == false) {
        return false;
    }

    //iterate through select query results and create corresponding array.
    while ($row = $result -> fetch_assoc()) {
        $rows[] = $row;
    }

    return $rows;
  }


  //This function removes dangerous characters from user input. protects against sql injection
  function quote($value){
    //ensure we are connected to database by calling this class's function connect().
    $connection = $this -> connect();

    // problematic characters passed and return result.
    return mysqli_real_escape_string($connection,$value);
  }

  //This function allows us to query the database.
  function query($query){
    //ensure we are connected to database by calling this class's function connect().
    $connection = $this -> connect();

    //call the query function on the connection object.
    $result  = $connection -> query($query);
    if(!$result){
      printf("<pre>Errormessage: %s\n</pre>", $connection->error);
    }

    return $result;
  }

  function getLastInsertID(){
    $connection = $this -> connect();

    return $connection->insert_id;
  }
}
