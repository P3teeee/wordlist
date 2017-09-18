<?php

$conn = new mysqli("localhost", "boxpek", "c9W0rfw4FvLgIiEE", "team2");

if($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

if (!$conn->set_charset("utf8")) {
    echo "Error loading character set utf8: " . $conn->error;
    exit();
}

$stmt = $conn->prepare("INSERT IGNORE INTO wordlist (word)  VALUES (?)");
	$stmt->bind_param("s", $filtered);


if(isset($_POST["text"])) {
	http_response_code(200);
	header('Content-type:application/json;charset=utf-8');
	$filtered = filter_input(INPUT_POST, "text" , FILTER_SANITIZE_SPECIAL_CHARS);
	$filtered = trim($filtered);

	$sql = "SELECT * FROM wordlist WHERE word = '$filtered'";
	$result = $conn->query($sql);

	if(empty($filtered)) {
	} else {
	if($result->num_rows > 0) {
	} else {
	$stmt->execute();
	if ($result === false) {
		echo "SQL error: " .$conn->error;
	}
}
}

	$sql = "SELECT * FROM wordlist";
	$result = $conn->query($sql);

	$resArr = [];

	while ($row = $result->fetch_assoc()) {
	$resArr[] = $row["word"];
	
	}

	echo json_encode($resArr, JSON_UNESCAPED_UNICODE);

	/*$rand = $resArr[mt_rand(0, count($resArr) -1)];
	$resArrEncoded = json_encode($rand);

	$resArrDecoded = json_decode($resArrEncoded);
	
	echo json_encode($resArrDecoded->ord, JSON_UNESCAPED_UNICODE);*/



$filtered = $conn->real_escape_string($filtered);
	


} else {
	http_response_code(400);
}

$stmt->close();
$conn->close();
?>