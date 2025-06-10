<?php
include 'koneksi.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user']['user_id'])) {
    echo "<script>alert('Please log in to view your favorites.'); window.location.href='loginregister.php';</script>";
    exit();
}

// Handle removal from favorites
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_favorites'])) {
    $novel_id = $_POST['novel_id'];
    $user_id = $_SESSION['user']['user_id'];
    
    // Remove the novel from favorites for the logged-in user
    $remove_sql = "DELETE FROM favorites WHERE user_id = '$user_id' AND novel_id = '$novel_id'";
    if ($conn->query($remove_sql) === TRUE) {
        echo "<script>alert('Novel berhasil dihapus dari favorit'); window.location.href='favorit.php';</script>";
    } else {
        echo "Error: " . $remove_sql . "<br>" . $conn->error;
    }
}

// Fetch the favorite novels for the logged-in user
$user_id = $_SESSION['user']['user_id'];
$favorites_sql = "SELECT novels.*, genre.genre_name 
                  FROM favorites 
                  JOIN novels ON favorites.novel_id = novels.novel_id 
                  LEFT JOIN genre ON novels.genre_id = genre.genre_id 
                  WHERE favorites.user_id = '$user_id'";
$favorites_result = $conn->query($favorites_sql);
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
				<a href="favorit.php" class="menu-item is-active" id="favorite">Your Favorite</a>
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
				<a href="list_novel.php" class="menu-item" id="library">Library</a>
				<a href="favorit.php" class="menu-item is-active" id="favorite">Your Favorite</a>
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
            <h1>Your Favorite Novels</h1>
            <p>Berikut adalah novel yang telah Anda tambahkan ke favorit Anda</p>
            </br>
			<input type="text" class="searchBar" id="searchBar" placeholder="Cari novel favorit..." onkeyup="filterFavorites()">
			</br>
            <div class="card-container">
                <?php if ($favorites_result->num_rows > 0): ?>
                    <?php while ($row = $favorites_result->fetch_assoc()): ?>
                        <div class="card">
                            <img src="<?= $row['image_path']; ?>" class="card-img" alt="Card Image" height="345" width="240" style="border-radius:7%">
                            <div class="card-body">
                                <h3 class="card-title"><?= htmlspecialchars($row['title']); ?></h3>
                                </br>
                                <p class="card-genre">Genre: <?= htmlspecialchars($row['genre_name']); ?></p>
                                <?php if (!empty($row['pdf_path'])): ?>
                                    <a href="<?= $row['pdf_path']; ?>" class="card-btn" target="_blank">Buka PDF</a>
                                <?php endif; ?>
                                </br>
                                <form action="" method="POST" class="favorite-form">
                                    <input type="hidden" name="novel_id" value="<?= $row['novel_id']; ?>">
                                    <button type="submit" name="remove_from_favorites" class="favorite-btn">Hapus dari Favorit</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Anda belum menambahkan novel apa pun ke favorit Anda</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
	<script>
        function filterFavorites() {
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
