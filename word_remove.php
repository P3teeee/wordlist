<?php

    // databas
    $mysqli = new mysqli("localhost", "boxpek", "c9W0rfw4FvLgIiEE", "team2");
    /* check connection */
    if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    if(isset($_POST["text"])){
        
        $filtered = filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS);
        $filtered = trim($filtered);
        
        if(!$stmt = $mysqli->prepare("DELETE FROM wordlist WHERE word = (?)")){   
        echo "Prepare failed: (" . $stmt->errno . ") " . $stmt->error;    
        }
        // viktigt att typen är rätt, si samt att antalet värden stämmer överens med placeholders i SQL
        if (!$stmt->bind_param("s", $filtered)) {
        echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
        }
        
        $sql = "SELECT * FROM wordlist WHERE word = '$filtered'";
        
        $result = $mysqli->query($sql);
        
        if (empty($filtered)) {
        http_response_code(200);
        echo json_encode("Write a word to delete.");
        } 
        
        else {
        if($result->num_rows === 0) {
        echo json_encode("This word doens't exist.");
        }else {
            $stmt->execute();
            http_response_code(200);
            header('Content-type:application/json;charset=utf-8');
            echo json_encode("The word '" . filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS) . "' has been removed.", JSON_UNESCAPED_UNICODE);
        }
            
        if($result === TRUE) {
        http_response_code(200);
        header('Content-type:application/json;charset=utf-8');
        echo json_encode("The word '" . filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS) . "' has been removed.", JSON_UNESCAPED_UNICODE);
        }
        }
            
        
    }

?>