<?php

class ApiService {
    // DB stuff
    private $conn;
    private $userTable = 'user';
    private $reportTable = 'report';
    private $indexalgorithmsTable = 'indexalgorithms';
    private $documentTable = 'document';
   



    //User Table Properties
    public $user_id;
    public $user_name;
    public $user_surname;
    public $user_email;   
    public $user_password;
    public $user_role;
    public $user_access_level;
   
 
    //Teport Table Properties
    public $report_id;
    

    //Indexalgorithms Table Properties
    public $IndexAlgo_id;
    public $TimeTaken;
    public $MeanAveragePrecision;
    public $F1Score;
    public $MeanReciprocalRank;
   

    //Document Table Properties
    public $doc_id;   
    public $doc_title;
    public $doc_author;
    public $doc_location;
    public $km_level;

 
   
    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }



       // register user
    public function RegisterUserProfile(){
      // Create Query
      $query = 'INSERT INTO ' . $this->userTable . ' SET user_id = :user_id,user_name = :user_name,user_surname = :user_surname,user_email = :user_email,user_password = :user_password,user_role = :user_role,user_access_level = :user_access_level';


      // prepare statement
      $stmt = $this->conn->prepare($query);

      //clean data
      $this->user_id = htmlspecialchars(strip_tags($this->user_id));
      $this->user_name = htmlspecialchars(strip_tags($this->user_name));
      $this->user_surname = htmlspecialchars(strip_tags($this->user_surname));
      $this->user_email = htmlspecialchars(strip_tags($this->user_email));    
      $this->user_password = htmlspecialchars(strip_tags($this->user_password));
      $this->user_role = htmlspecialchars(strip_tags($this->user_role));
      $this->user_access_level = htmlspecialchars(strip_tags($this->user_access_level));

      //bind data
      $stmt->bindParam(':user_id', $this->user_id);
      $stmt->bindParam(':user_name', $this->user_name);
      $stmt->bindParam(':user_surname', $this->user_surname);
      $stmt->bindParam(':user_access_level', $this->user_access_level);
      $stmt->bindParam(':user_email', $this->user_email);
      $stmt->bindParam(':user_password', $this->user_password);
      $stmt->bindParam(':user_role', $this->user_role);
      // execute query
      if($stmt->execute()){
        return true;
      }

      // print error if something goes wrong
      printf("Error: %s.\n",$stmt->error);

      return false;
    }

  //read all user
    public function readAllUsers(){

        // create query 
        $query = 'SELECT * FROM ' . $this->userTable;

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;

    }
    
     public function deleteUser(){
      //create query
      $query = 'DELETE FROM ' . $this->userTable . ' WHERE user_id = :user_id';

      // prepare statemnet
      $stmt = $this->conn->prepare($query);

      // clean data
      $stmt->bindParam(':user_id', $this->user_id);
     
      // execute query
      if($stmt->execute()){
        return true;
      }

      // print error if something goes wrong
      printf("Error: %s.\n",$stmt->error);

      return false; 
    }

          //read a single employee
          public function read_singleUser(){

            // create query
            $query = 'SELECT * FROM ' . $this->userTable . ' u WHERE u.user_id = ? ';
    
            // prepare statement
            $stmt = $this->conn->prepare($query);
    
            // Bind ID
            $stmt->bindParam(1,$this->user_id);
    
            //execute the query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            //set properties
            $this->user_id = $row['user_id'];
            $this->user_name = $row['user_name'];
            $this->user_surname = $row['user_surname'];
            $this->user_access_level = $row['user_access_level'];
            $this->user_email = $row['user_email'];
            $this->user_password = $row['user_password'];
            $this->user_role = $row['user_role'];
    
          }
          
          public function Login(){

            // create query
            $query = 'SELECT * FROM ' . $this->userTable . ' u WHERE u.user_email = ? ';
    
            // prepare statement
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(1,$this->user_email);
           //$stmt->bindParam(1,$this->user_password);
    
            //execute the query
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if($row > 1){

                // create query
                $query2 = 'SELECT * FROM ' . $this->userTable . ' u WHERE u.user_password = ? ';
        
                // prepare statement
                $stmt2 = $this->conn->prepare($query2);

                $stmt2->bindParam(1,$this->user_password);

                //execute the query
                $stmt2->execute();

                $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                //set properties
                $this->user_id = $row2['user_id'];
                $this->user_email = $row2['user_email'];
                $this->user_role = $row2['user_role'];

            }



    
          }


        public function UpdateUserProfile(){
          //create query 
          $query ='UPDATE '. $this->userTable . ' SET user_id = :user_id,user_name = :user_name,user_surname = :user_surname,user_access_level = :user_access_level,user_idNumber = :user_idNumber,user_email = :user_email,user_password = :user_password,user_role = :user_role WHERE user_id = :user_id';
          
          // prepare statement
          $stmt = $this->conn->prepare($query);

        
            //clean data
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->user_name = htmlspecialchars(strip_tags($this->user_name));
            $this->user_surname = htmlspecialchars(strip_tags($this->user_surname));
            $this->user_access_level = htmlspecialchars(strip_tags($this->user_access_level));
            $this->user_email = htmlspecialchars(strip_tags($this->user_email));
            $this->user_password = htmlspecialchars(strip_tags($this->user_password));
            $this->user_role = htmlspecialchars(strip_tags($this->user_role));

            //bind data
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':user_name', $this->user_name);
            $stmt->bindParam(':user_surname', $this->user_surname);
            $stmt->bindParam(':user_access_level', $this->user_access_level);
            $stmt->bindParam(':user_email', $this->user_email);
            $stmt->bindParam(':user_password', $this->user_password);
            $stmt->bindParam(':user_role', $this->user_role);

            // execute query
            if($stmt->execute()){
              return true;
            }

            // print error if something goes wrong
            printf("Error: %s.\n",$stmt->error);

            return false;
        }

      }


?>