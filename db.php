<?php

function EintragInDB($Datum,$uW, $oW, $Puls){
	//Werte in DB Schreiben
$servername = "";
$username = "";
$password = "";
$dbname = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);	
}   
    $sql = "SELECT * FROM tb_Blutdruck WHERE Datum = '".$Datum."';";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {  
	$conn->close();
	dbupdate($Datum,$uW, $oW, $Puls);
	} else {
    dbinsert($Datum,$uW, $oW, $Puls);
	}	
}

function dbinsert( $Datum, $uW, $oW, $Puls ){
	//insert
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	echo "wtf";
    die("Connection failed: " . $conn->connect_error);	
}

    // prepare sql and bind parameters
    $stmt = $conn->prepare("INSERT INTO tb_Blutdruck (Datum,oW, uW, Puls) VALUES ( ?, ?, ?, ?);");
    $stmt->bind_param("siii", $Datum, $uW, $oW, $Puls);
    $stmt->execute();

echo "created successfully";

$stmt->close();
$conn->close();
}

function dbupdate( $Datum, $uW, $oW, $Puls ){
	//update
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // prepare sql and bind parameters
	echo "-+";
    $stmt = $conn->prepare("UPDATE tb_Blutdruck SET uW = ?,oW = ? , Puls = ? WHERE Datum = ?;") ;
	echo "1";
    $stmt->bind_param("iiis", $uW, $oW, $Puls,$Datum);
	echo "2";

    // insert a row
    $stmt->execute();

echo "edited successfully";

$stmt->close();
$conn->close();
}

function dbdelete( $Datum ){
	//delete
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // prepare sql and bind parameters
    $stmt = $conn->prepare("DELETE FROM tb_Blutdruck WHERE Datum = ?;");
    $stmt->bind_param("s", $Datum);

    // insert a row
    $stmt->execute();

echo "deleted successfully";

$stmt->close();
$conn->close();
}

function dbselect( $Datum ){
	//select 
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $erg = "";
    $sql = "SELECT * FROM tb_Blutdruck WHERE Datum = '".$Datum."';";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $erg =  $row["oW"]."<br>".$row["uW"]."<br>".$row["Puls"];
    }
	} else {
    $erg = "kein<br>Eintrag<br><br>";
	}

$conn->close();
return $erg;
}

function dbselect2( $Datum ){
	//select mit return array
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    $array = array(0, 0, 0);
    $sql = "SELECT * FROM tb_Blutdruck WHERE Datum = '".$Datum."';";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $array = array( $row["oW"],$row["uW"], $row["Puls"]);
    }	}

$conn->close();
return $array;

}

function selectfirstorlast($first ){
	//letztes und erstes datum finden
$servername = "";
$username = "";
$password = "";
$dbname = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if($first) $sql = "SELECT Datum FROM tb_Blutdruck ORDER BY Datum ASC LIMIT 1";
else $sql = "SELECT Datum FROM tb_Blutdruck ORDER BY Datum DESC LIMIT 1";    
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $firstorlast = $row["Datum"];
    }	}

$conn->close();
return $firstorlast;

}

?>