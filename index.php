<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>People Search Engine</title>
		<link rel="icon" href="logo/PSE.png">
		<link rel="stylesheet" href="css/index.css">
	</head>
	<body>
		<header>
			<img src="logo/pse.png"/>
			<h1>People Search Engine</h1>
		</header>
		<div id="main">
		<form name="searchform" method="get" action="process.php" id="searchform">
			<div class="search-wrapper">
				<input type="text" placeholder="Search" name="search" aria-label="Search" required>
				<button type="submit" name="submit" formaction="process.php">Search</button>
				<button type="button" onclick="window.location.href='add.php'">+</button>
			</div>
		</form>
		</div>
		<footer>
			People Search Engine was created on 2 November 2020, and modernized on 23 June 2025 by Serdar Aksakal.
		</footer>
	</body>
</html>