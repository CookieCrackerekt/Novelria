<?php
include 'koneksi.php';
session_start();
$sql = "SELECT novels.*, genre.genre_name 
        FROM novels 
        LEFT JOIN genre ON novels.genre_id = genre.genre_id";
$result = $conn->query($sql);

// Check if the form was submitted to add a favorite
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user']['user_id'])) {
        $novel_id = $_POST['novel_id'];
        $user_id = $_SESSION['user']['user_id'];

        // Check if the action is to add or remove a favorite
        if (isset($_POST['add_to_favorites'])) {
            // Insert into the favorites table
            $favorite_sql = "INSERT INTO favorites (user_id, novel_id) VALUES ('$user_id', '$novel_id')";
            if ($conn->query($favorite_sql) === TRUE) {
                echo "<script>alert('Novel berhasil ditambahkan ke favorit');</script>";
            } else {
                echo "Error: " . $favorite_sql . "<br>" . $conn->error;
            }
        } elseif (isset($_POST['remove_from_favorites'])) {
            // Remove from the favorites table
            $remove_sql = "DELETE FROM favorites WHERE user_id = '$user_id' AND novel_id = '$novel_id'";
            if ($conn->query($remove_sql) === TRUE) {
                echo "<script>alert('Novel berhasil dihapus dari favorit');</script>";
            } else {
                echo "Error: " . $remove_sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "<script>alert('Please log in to view your favorites.'); window.location.href='loginregister.php';</script>";
		exit();
    }
}
?>

<!DOCTYPE html>
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
				<a href="list_novel.php" class="menu-item is-active" id="library">Library</a>
				<a href="favorit.php" class="menu-item" id="favorite">Your Favorite</a>
				<a href="your_upload.php" class="menu-item" id="your_upload">Your Upload</a>
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
				<a href="list_novel.php" class="menu-item is-active" id="library">Library</a>
				<a href="favorit.php" class="menu-item" id="favorite">Your Favorite</a>
				<a href="your_upload.php" class="menu-item" id="your_upload">Your Upload</a>
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
			<h1>Library</h1>
			<p>Silahkan jelajahi beberapa novel yang disediakan</p>
			</br>
			<input type="text" class="searchBar" id="searchBar" placeholder="Cari novel..." onkeyup="filterNovels()">
			</br>
			<div class="card-container">
				<?php while ($row = $result->fetch_assoc()): ?>
					<?php
					// Check if the novel is already in the user's favorites
					$is_favorite = false;
					if (isset($_SESSION['user']['user_id'])) {
						$user_id = $_SESSION['user']['user_id'];
						$novel_id = $row['novel_id'];
						$favorite_check_sql = "SELECT * FROM favorites WHERE user_id = '$user_id' AND novel_id = '$novel_id'";
						$favorite_check_result = $conn->query($favorite_check_sql);
						if ($favorite_check_result->num_rows > 0) {
							$is_favorite = true;
						}
					}
					?>
					<div class="card">
						<img src="<?= $row['image_path']; ?>" class="card-img" alt="Card Image" height="345" width="240" style="border-radius:7%">
						<div class="card-body">
							<h3 class="card-title"><?= $row['title']; ?></h3>
							</br>
							<p class="card-genre">Genre: <?= htmlspecialchars($row['genre_name']); ?></p> 
							<?php if (!empty($row['pdf_path'])): ?>
								<a href="<?= $row['pdf_path']; ?>" class="card-btn" target="_blank">Buka PDF</a>
							<?php endif; ?>
							</br>
							<form action="" method="POST" class="favorite-form">
								<input type="hidden" name="novel_id" value="<?= $row['novel_id']; ?>">
								<?php if ($is_favorite): ?>
									<button type="submit" name="remove_from_favorites" class="favorite-btn">Hapus dari Favorit</button>
								<?php else: ?>
									<button type="submit" name="add_to_favorites" class="favorite-btn">Tambah ke Favorit</button>
								<?php endif; ?>
							</form>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</div>
	<script>
		function filterNovels() {
			let input = document.getElementById('searchBar').value.toLowerCase();
			let cards = document.getElementsByClassName('card');
			
			for (let i = 0; i < cards.length; i++) {
				let title = cards[i].getElementsByClassName('card-title')[0].innerText.toLowerCase();
				if (title.includes(input)) {
					cards[i].style.display = "";
				} else {
					cards[i].style.display = "none";
				}
			}
		}
	</script>
	<script src="javascript/script.js"></script>
</body>
</html>