<?php
include 'koneksi.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    echo "<script>alert('Please log in to view your novels.'); window.location.href='loginregister.php';</script>";
    exit();
}

// Handle title edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_title'])) {
    $novel_id = $_POST['novel_id'];
    $new_title = $_POST['new_title'];
    
    // Update the novel title in the database
    $update_sql = "UPDATE novels SET title = '$new_title' WHERE novel_id = '$novel_id' AND user_id = '{$_SESSION['user']['user_id']}'";
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Novel title updated successfully.'); window.location.href='your_upload.php';</script>";
    } else {
        echo "Error updating title: " . $conn->error;
    }
}

// Handle novel deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_novel'])) {
    $novel_id = $_POST['novel_id'];
    
    // Delete the novel from the database
    $delete_sql = "DELETE FROM novels WHERE novel_id = '$novel_id' AND user_id = '{$_SESSION['user']['user_id']}'";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('Novel deleted successfully.'); window.location.href='your_upload.php';</script>";
    } else {
        echo "Error deleting novel: " . $conn->error;
    }
}

// Fetch novels uploaded by the logged-in user
$user_id = $_SESSION['user']['user_id'];
$novels_sql = "SELECT * FROM novels WHERE user_id = '$user_id'";
$novels_result = $conn->query($novels_sql);
?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Novelria - Tempat Baca Novel Gratis</title>
	<link rel="stylesheet" href="css/styles.css" />
</head>
<body>
	<div class="app">
		<!-- Navbar for larger screens -->
		<header class="navbar">
			<h3>Novelria</h3>
			<nav class="menu">
				<a href="index.php" class="menu-item" id="home">Home</a>
				<a href="list_novel.php" class="menu-item" id="library">Library</a>
				<a href="favorit.php" class="menu-item" id="favorite">Your Favorite</a>
				<a href="your_upload.php" class="menu-item is-active" id="your_upload">Your Upload</a>
				<a href="tambah_novel.php" class="menu-item" id="add_novel">Add Novel</a>
				<a href="contact.php" class="menu-item" id="contact">Contact</a>
				<?php if (isset($_SESSION['user'])): ?>
					<a href="logout.php" class="menu-item">Log out</a>
				<?php else: ?>
					<a href="loginregister.php" class="menu-item">Log in</a>
				<?php endif; ?>
			</nav>
		</header>
		<!-- Menu toggle button for mobile screens -->
		<div class="menu-toggle">
			<div class="hamburger">
				<span></span>
			</div>
		</div>
		<!-- Sidebar for mobile screens -->
		<aside class="sidebar">
			<h3>Novelria</h3>	
			<nav class="menu">
				<a href="index.php" class="menu-item" id="home">Home</a>
				<a href="list_novel.php" class="menu-item" id="library">Library</a>
				<a href="favorit.php" class="menu-item" id="favorite">Your Favorite</a>
				<a href="your_upload.php" class="menu-item is-active" id="your_upload">Your Upload</a>
				<a href="tambah_novel.php" class="menu-item" id="add_novel">Add Novel</a>
				<a href="contact.php" class="menu-item" id="contact">Contact</a>
				</br></br></br></br>
				<?php if (isset($_SESSION['user'])): ?>
					<p>Hello <?= htmlspecialchars($_SESSION['user']['name']) ?></p>
					<a href="logout.php" class="menu-item">Log out</a>
				<?php else: ?>
					<a href="loginregister.php" class="menu-item">Log in</a>
				<?php endif; ?>
			</nav>
		</aside>
        <div class="content">
            <h1>Your Uploaded Novels</h1>
            <p>Berikut adalah novel yang telah Anda upload</p>
            <br>
            <input type="text" class="searchBar" id="searchBar" placeholder="Cari novel..." onkeyup="filterNovels()">
            <br><br>
            <table class="novels-table">
                <thead>
                    <tr>
                        <th>Edit Title</th>
						<th>Save Edits</th>
                        <th>Delete Novel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($novels_result->num_rows > 0): ?>
                        <?php while ($novel = $novels_result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <form method="POST">
                                        <input type="hidden" name="novel_id" value="<?= $novel['novel_id']; ?>">
                                        <input type="text" name="new_title" value="<?= htmlspecialchars($novel['title']); ?>">
								</td>
								<td>
                                        <button type="submit" name="edit_title" class="save-btn">Save</button>
                                    </form>
								</td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this novel?');">
                                        <input type="hidden" name="novel_id" value="<?= $novel['novel_id']; ?>">
                                        <button type="submit" name="delete_novel" class="delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="3">Anda belum mengupload novel apapun.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function filterNovels() {
            const input = document.getElementById('searchBar').value.toLowerCase();
            const rows = document.querySelectorAll('.novels-table tbody tr');
            
            rows.forEach(row => {
                const title = row.querySelector('input[name="new_title"]').value.toLowerCase();
                row.style.display = title.includes(input) ? '' : 'none';
            });
        }
    </script>
	<script src="javascript/script.js"></script>
</body>
</html>