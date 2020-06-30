<?php 
	$mysqli = new mysqli('127.0.0.1', 'root', 'admin', 'tennis');

    $query = "select * from member";

    $result = $mysqli->query($query);
	
	/*var_dump($result);*/
	
	if (is_object($result)) {

	    /* fetch associative array */
	    while ($row = $result->fetch_assoc()) {
            printf ("<br/>(%d) <br/>%s <br/>%s <br/>%s <br/>%d", $row["id"], $row["firstName"], $row["lastName"], $row["emailAddress"], $row["birthDate"]);
	    }

	    /* free result set */
	    $result->free();
	} else if ($result === false) {
		echo $mysqli->error;
	}