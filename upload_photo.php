<?php
	include 'db.php';

	if ($db->connect_error) {
		die("Connection error: " . $db->connect_error);
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
		
		$personId = intval($_POST['person_id']);

		$stmt = $db->prepare("SELECT photo FROM pse WHERE id = ?");
		$stmt->bind_param("i", $personId);
		$stmt->execute();
		$stmt->bind_result($photoFilename);
		$stmt->fetch();
		$stmt->close();

		if (!empty($photoFilename)) {
			$filePath = 'photo_db/' . $photoFilename;
			if (file_exists($filePath)) {
				unlink($filePath);
			}
		}

		$stmt = $db->prepare("UPDATE pse SET photo = NULL WHERE id = ?");
		$stmt->bind_param("i", $personId);
		$stmt->execute();
		$stmt->close();

		echo "<script>alert('Photo deleted successfully.'); window.history.back();</script>";
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
	}

	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
		$personId = intval($_POST['person_id']);
		$uploadDir = 'photo_db/';

		$fileTmpPath = $_FILES['photo']['tmp_name'];
		$fileExtension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

		$newFileName = "161905" . $personId . "." . $fileExtension;
		$destination = $uploadDir . $newFileName;

		if (move_uploaded_file($fileTmpPath, $destination)) {
			$stmt = $db->prepare("UPDATE pse SET photo = ? WHERE id = ?");
			$stmt->bind_param("si", $newFileName, $personId);
			$stmt->execute();
			$stmt->close();
			echo "<script>alert('The photo was uploaded and updated.'); window.history.back();</script>";
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;
		} else {
			echo "<script>alert('The photo could not be uploaded.'); window.history.back();</script>";
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			exit;
		}
	}
?>