<?php
    include 'db.php';

	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}

    function generateIdx($length = 8) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $code;
    }

    $insertQuery = "INSERT INTO pse () VALUES ()";
    if ($db->query($insertQuery) === TRUE) {
        $newId = $db->insert_id;

        do {
            $idx = generateIdx();
            $check = $db->prepare("SELECT id FROM pse WHERE idx = ?");
            $check->bind_param("s", $idx);
            $check->execute();
            $result = $check->get_result();
        } while ($result->num_rows > 0);

        $update = $db->prepare("UPDATE pse SET idx = ? WHERE id = ?");
        $update->bind_param("si", $idx, $newId);

        if ($update->execute()) {
            header("Location: process.php?search=" . urlencode($idx));
            exit;
        } else {
            echo "Error updating idx: " . $update->error;
        }
    } else {
        echo "Error inserting record: " . $db->error;
    }

    $db->close();
?>