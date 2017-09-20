<?php

// databas
    $mysqli = new mysqli("localhost", "boxpek", "c9W0rfw4FvLgIiEE", "team2");
    /* check connection */
    if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    }

    if(isset($_POST["text"]))
    {

    $filtered = filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS);
    $filtered = trim($filtered);

    $filtered_explode = explode('|',$filtered,2);

    $sql1 = "UPDATE wordlist SET description='$filtered_explode[1]' WHERE word='$filtered_explode[0]'";
    $sql = "SELECT * FROM wordlist WHERE word = '$filtered_explode[0]'";
    $result = $mysqli->query($sql);


    if (empty($filtered_explode[0])) {
    	http_response_code(200);
    	echo json_encode("Skriv in ett ord");
    } else {
    	if($result->num_rows == 0) {
    		echo json_encode("Detta ord finns inte");
    	} else{
    if ($mysqli->query($sql1) === TRUE) {
    	http_response_code(200);
    echo  json_encode("Record updated successfully");
		} else {
    echo  json_encode("Error updating record: " . $mysqli->error);
		}
		if ($result == false) {

		}
	}

	}
}
?>