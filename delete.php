<?php
    include 'db.php';

	if (!$db) {
		die("Connection failed: " . mysqli_connect_error());
	}

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $db->prepare("DELETE FROM pse WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $deleted = $stmt->affected_rows;
        $stmt->close();

        $db->query("ALTER TABLE pse AUTO_INCREMENT = 1");
        $db->close();

        echo ($deleted > 0) ? "Success" : "NotFound";
    }
?>