<?php

        // databas
    $mysqli = new mysqli("localhost", "boxpek", "c9W0rfw4FvLgIiEE", "team2");
    /* check connection */
    if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }
        
    $json_array = array();
    
    if(isset($_POST["text"]))
    {
        
        http_response_code(200);
        header('Content-type:application/json;charset=utf-8');
    
        echo '
        {
            "attachments": [
                {
                    "pretext": "In wordlist",
                    "text":"';
                        $result = $mysqli->query("SELECT * FROM wordlist");
                        if(mysqli_num_rows($result) > 0)
                        {
                            while ($row = $result->fetch_assoc()) {
                                echo  $row["word"] . ": " . $row["description"] . '\n';
                            }
                        }
                        else{
                            echo "0 results";
                        }
                        $mysqli->close();
                    echo'"
                }
            ]
        }';


        
    }

    else {
    http_response_code(400);
    header('Content-type:application/json;charset=utf-8');
    echo json_encode("error");
    }   
           
    /*echo '<pre>';
        print_r($json_array);
    echo '</pre>';*/

?>