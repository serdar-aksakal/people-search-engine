
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="icon" href="logo/pse.png">
        <title>People Search Engine</title>
        <link rel="stylesheet" href="css/process.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        <script>
            $(document).ready(function () {

				function autoResize(el) {
					el.style.height = '0px';
					el.style.height = el.scrollHeight + 'px';
				}

				$("textarea").each(function() {
					autoResize(this);
				});

				$("table").on("input", "textarea", function() {
					autoResize(this);
				});

                $("table").on("focus", "textarea", function () {
                    if ($(this).val().trim() === "-") {
                        $(this).val("");
                    }
                });

                $("table").on("blur", "textarea", function () {
                    var id = $(this).data("id");
                    var column = $(this).data("column");
                    var value = $(this).val().trim();
                    var dbValue = value;

                    if (value === "" || value === "-") {
                        $(this).val("-");
                        dbValue = "";
                    }

                    if (id && column) {
                        $.ajax({
                            url: "update.php",
                            type: "POST",
                            data: { id: id, column: column, value: dbValue },
                            success: function (response) {
                                console.log("Updated:", response);
                            },
                            error: function (xhr) {
                                console.error("Update failed:", xhr.responseText);
                            }
                        });
                    }
                });

                $("table").on("click", ".deleteRow", function() {
                    var id = $(this).data("id");

                    if (confirm("Are you sure you want to delete this record?")) {
                        $.ajax({
                            url: "delete.php",
                            type: "POST",
                            data: { id: id },
                            success: function(response) {
                                var trimmed = response.trim();
                                if (trimmed === "Success") {
                                    window.location.href = "index.php";
                                } else if (trimmed === "NotFound") {
                                    window.location.href = "no_result.php";
                                } else {
                                    alert("Failed to delete: " + trimmed);
                                }
                            },
                            error: function(xhr) {
                                alert("Error: " + xhr.responseText);
                            }
                        });
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('form').forEach(form => {
                    const fileInput = form.querySelector('input[type="file"]');
                    const uploadBtn = form.querySelector('button.upload');
                    const deleteBtn = form.querySelector('button.delete');

                    if (uploadBtn) {
                        uploadBtn.addEventListener('click', () => {
                            fileInput && fileInput.setAttribute('required', 'required');
                        });
                    }
                    if (deleteBtn) {
                        deleteBtn.addEventListener('click', () => {
                            fileInput && fileInput.removeAttribute('required');
                        });
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function () {
                const pos = sessionStorage.getItem('scrollPos');
                if (pos !== null) {
                    window.scrollTo(0, parseInt(pos, 10));
                    sessionStorage.removeItem('scrollPos');
                }

                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', function () {
                        if (this.name === "form1") {
                            sessionStorage.removeItem('scrollPos');
                        } else {
                            sessionStorage.setItem('scrollPos', window.scrollY);
                        }
                    });
                });
            });
        </script>
        <header class="container">
            <?php
                include 'db.php';
            
                $searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : '%%';

                $params = array_fill(0, 20, $searchTerm);

                $stmt = $db->prepare('SELECT * FROM pse WHERE 
                    id LIKE ? OR idx LIKE ? OR family_name LIKE ? OR prev_surname LIKE ? OR surname LIKE ? 
                    OR given_name LIKE ? OR sex LIKE ? OR dob LIKE ? OR pob LIKE ? OR cob LIKE ? OR nationality LIKE ? 
                    OR father LIKE ? OR mother LIKE ? OR siblings LIKE ? OR spouse LIKE ? OR children LIKE ?
                    OR email LIKE ? OR social_media LIKE ? OR occupation LIKE ? OR justification LIKE ?');

                $stmt->bind_param(str_repeat('s', 20), ...$params);

                $stmt->execute();
                $result = $stmt->get_result();
                
                $rowcount = mysqli_num_rows($result);
                
                if ($result->num_rows > 0) { ?>
            <header id="leftheader">
                <a href="index.php" style="text-decoration: none; color: inherit;">
                    <h2 id="title">People Search Engine</h2>
                </a>
            </header>
            <header id="rightheader">
                <form name="form1" method="get" action="process.php" class="search-form">
                    <input type="text" placeholder="Search" name="search" aria-label="Search" required>
                    <input type="submit" value="Search" name="submit">
                </form>
            </header>
           <header id="countheader">
				<?php 
					$word = $rowcount == 1 ? "result" : "results";
					echo "<div id='counter'>" . $rowcount . " relevant " . $word . " found.</div>"; 
				?>
			</header>
            <header id="clearheader"></header>
        </header>
        <div id="main">
            <?php while($row = $result->fetch_assoc()) { ?>
            <table id='resultbox'>
                <tr>
                    <th>Actions</th>
                    <td class="special">
                        <div style="display: flex; gap: 10px;">
                            <button class="addRow" onclick="window.location.href='add.php'">Add New Record</button>
                            <button class="deleteRow" data-id="<?php echo $row['id']; ?>">Delete Record</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>ID</th>
                    <td id='idtd'>161905 <?php echo empty($row['id']) ? '-' : $row['id']; ?></td>
                </tr>
                <tr>
                    <th>Photo</th>
                    <td>
                        <?php 
                            if (empty($row['photo'])) {
                                echo "<img src='photo_db/0.jpg' width='100' height='120' />";
                            } else {
                                $photo = htmlspecialchars($row['photo']);
                                $filePath = 'photo_db/' . $photo;
                                $cacheBuster = file_exists($filePath) ? filemtime($filePath) : time();
                                echo "<img src='photo_db/{$photo}?v={$cacheBuster}' width='100' height='120'/>";
                            }
                        ?>
                        <form action="upload_photo.php" method="POST" enctype="multipart/form-data" style="margin-top:10px; display:flex; gap:6px; align-items:center;">
                            <input type="hidden" name="person_id" value="<?php echo $row['id']; ?>">
                            <input type="file" name="photo" accept="image/*" style="max-width:175px;">
                            <button type="submit" style="padding:4px 10px;" class="upload">Upload</button>
                            <?php if (!empty($row['photo'])): ?>
                                <button type="submit" name="action" value="delete" class="delete" style="padding:4px 10px;">Delete</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Signature</th>
                    <td>
                        <?php 
                            if (empty($row['signature'])) {
                                echo "<a style='font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;'>No Signature Found.</a>";
                            } else {
                                $signature = htmlspecialchars($row['signature']);
                                $filePath = 'signature_db/' . $signature;
                                $cacheBuster = file_exists($filePath) ? filemtime($filePath) : time();
                                echo "<img src='signature_db/{$signature}?v={$cacheBuster}' width='100' height='100'/>";
                            }
                        ?>
                        <form action="upload_signature.php" method="POST" enctype="multipart/form-data" style="margin-top:10px; display:flex; gap:6px; align-items:center;">
                            <input type="hidden" name="person_id" value="<?php echo $row['id']; ?>">
                            <input type="file" name="signature" accept="image/*" style="max-width:175px;">
                            <button type="submit" style="padding:4px 10px;" class="upload">Upload</button>
                            <?php if (!empty($row['signature'])): ?>
                                <button type="submit" name="action" value="delete" class="delete" style="padding:4px 10px;">Delete</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <tr>
                    <th>Family Name</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='family_name'><?php echo empty($row['family_name']) ? '-' : htmlspecialchars(trim($row['family_name'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Previous Surname(s)</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='prev_surname'><?php echo empty($row['prev_surname']) ? '-' : htmlspecialchars(trim($row['prev_surname'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Surname</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='surname'><?php echo empty($row['surname']) ? '-' : htmlspecialchars(trim($row['surname'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Given Name(s)</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='given_name'><?php echo empty($row['given_name']) ? '-' : htmlspecialchars(trim($row['given_name'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Sex</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='sex' placeholder='M/F'><?php echo empty($row['sex']) ? '-' : htmlspecialchars(trim($row['sex'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Date of Birth</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='dob' placeholder='YYYY-MM-DD'><?php echo empty($row['dob']) ? '-' : htmlspecialchars(trim($row['dob'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Place of Birth</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='pob'><?php echo empty($row['pob']) ? '-' : htmlspecialchars(trim($row['pob'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Country of Birth</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='cob' placeholder='XXX'><?php echo empty($row['cob']) ? '-' : htmlspecialchars(trim($row['cob'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Nationality</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='nationality'><?php echo empty($row['nationality']) ? '-' : htmlspecialchars(trim($row['nationality'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Father</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='father'><?php echo empty($row['father']) ? '-' : htmlspecialchars(trim($row['father'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Mother</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='mother'><?php echo empty($row['mother']) ? '-' : htmlspecialchars(trim($row['mother'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Sibling(s)</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='siblings'><?php echo empty($row['siblings']) ? '-' : htmlspecialchars(trim($row['siblings'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Spouse</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='spouse'><?php echo empty($row['spouse']) ? '-' : htmlspecialchars(trim($row['spouse'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Children</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='children'><?php echo empty($row['children']) ? '-' : htmlspecialchars(trim($row['children'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Electronic Mail(s)</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='email'><?php echo empty($row['email']) ? '-' : htmlspecialchars(trim($row['email'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Social Media</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='social_media'><?php echo empty($row['social_media']) ? '-' : htmlspecialchars(trim($row['social_media'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Occupation</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='occupation'><?php echo empty($row['occupation']) ? '-' : htmlspecialchars(trim($row['occupation'])); ?></textarea></td>
                </tr>
                <tr>
                    <th>Justification</th>
                    <td><textarea data-id='<?php echo $row["id"]; ?>' data-column='justification'><?php echo empty($row['justification']) ? '-' : htmlspecialchars(trim($row['justification'])); ?></textarea></td>
                </tr>
            </table>
            <?php } }
            else {
                echo "<script> window.location.href = 'no_result.php'; </script>";
            }
            $db->close();
            ?>
        </div>
    </body>
</html>