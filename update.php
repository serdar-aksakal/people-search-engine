<?php
	include 'db.php';

	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}

	if (isset($_POST["id"], $_POST["column"], $_POST["value"])) {
		$id = $_POST["id"];
		$column = $_POST["column"];
		$value = trim($_POST["value"]) === "" ? "NULL" : "'" . $db->real_escape_string($_POST["value"]) . "'";
		$sql = "UPDATE pse SET $column = $value, last_updated = NOW() WHERE id = $id";

		if ($db->query($sql) === TRUE) {
			$result = $db->query("SELECT last_updated FROM pse WHERE id = $id");
			$row = $result->fetch_assoc();
			echo $row["last_updated"];
		}
	}

	$db->close();
?>