<?php
class database_conn {
    private $server_name;
    private $user_name;
    private $password;
    private $database;
    //my constructor to set private variables
    function __construct($server_name, $user_name, $password, $database){
        $this-> server_name = $server_name;
        $this-> user_name = $user_name;
        $this-> password = $password;
        $this-> database = $database;
    }
   
    //attempt connection '\' is needed to prevent uncaught error
    function connection($server_name, $user_name, $password, $database){
        $conn = new mysqli($server_name, $user_name, $password, $database);
        /* check connection */
        if ($conn->connect_errno) {
            printf("Connect failed: %s\n", $conn->connect_error);
            exit();
        }
        
       /* check if server is alive */
//         if ($conn->ping()) {
//             printf ("Our connection is ok!");
//         } else {
//             printf ("Error: %s\n", $conn->error);
//         }
    }
    
}
$connection = new mysqli("localhost", "root", "", "gen_cyber");
// $connection->connection("localhost", "root", "", "gen_cyber");
?>