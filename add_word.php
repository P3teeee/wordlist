<?php

    // databas
    $mysqli = new mysqli("localhost", "boxpek", "c9W0rfw4FvLgIiEE", "team2");
    /* check connection */
    if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    date_default_timezone_set("Europe/Stockholm");

    if(isset($_POST["text"]))
    {

    $filtered = filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS);
    $filtered = trim($filtered);

    $filtered_explode = explode('|',$filtered,2);

    // spara i databas med prep statements
    if(!$stmt = $mysqli->prepare("INSERT INTO wordlist(word, description) VALUES (?, ?)")){   
    echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;    
    }
    // viktigt att typen är rätt, si samt att antalet värden stämmer överens med placeholders i SQL
    if (!$stmt->bind_param("ss", $filtered_explode[0], $filtered_explode[1])) {
    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
    }


     $sql = "SELECT * FROM wordlist WHERE word = '$filtered_explode[0]'";
    $result = $mysqli->query($sql);

    if(empty($filtered_explode[0])) {
    } else {
    if($result->num_rows > 0) {
         http_response_code(200);
        echo json_encode("detta namn finns redan ");
    } else {
    $stmt->execute();
    if(empty($filtered_explode[1])) {
        http_response_code(200);
        header('Content-type:application/json;charset=utf-8');
        echo json_encode("The word " . $filtered_explode[0] . " has been added!", JSON_UNESCAPED_UNICODE);
    } else {
    http_response_code(200);
    header('Content-type:application/json;charset=utf-8');
    echo json_encode("The word " . $filtered_explode[0] . " with the description " . $filtered_explode[1] . " has been added!", JSON_UNESCAPED_UNICODE);
}
        if ($result === false) {
        http_response_code(400);
        echo "SQL error: " .$conn->error;
        echo json_encode("detta namn finns redan ");
    }
}
}
 

    

    }

?>