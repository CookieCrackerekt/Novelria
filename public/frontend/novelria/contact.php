<?php
session_start();
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
				<a href="your_upload.php" class="menu-item" id="your_upload">Your Upload</a>
				<a href="tambah_novel.php" class="menu-item" id="add_novel">Add Novel</a>
				<a href="contact.php" class="menu-item is-active" id="contact">Contact</a>
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
				<a href="your_upload.php" class="menu-item" id="your_upload">Your Upload</a>
				<a href="tambah_novel.php" class="menu-item" id="add_novel">Add Novel</a>
				<a href="contact.php" class="menu-item is-active" id="contact">Contact</a>
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
			<h1>Contact</h1>
			<p>Jika ada masalah hak cipta tolong hubungi kontak dibawah</p>			
			</br>
			<div class="card-container">
				<div class="contact-card">
					<img src="images/WA.jpeg" class="card-contact-img" alt="Card Image" style="border-radius:7%">
					<div class="card-body">
						<h1 class="card-contact-title"style="font-size: 20px; color:#FFFFFF">Whatsapp </h1>
						<a href="https://chat.whatsapp.com/K5J0wYxD1BbHQCWZeGsnMi " class="card-btn" target="_blank">Buka Link </a>
					</div>
				</div> 
				<div class="contact-card">
					<img src="images/GMAIL.jpeg"class="card-contact-img" alt="Card Image" style="border-radius:7%">
					<div class="card-body">
						<h1 class="card-contact-title"style="font-size: 20px; color:#FFFFFF"> Email</h1>
						<a href=" mailto:karcan2356@gmail.com" class="card-btn" target="_blank">Buka Link </a>
					</div>
				</div>
				<div class="contact-card">
					<img src="images/IG.jpeg"class="card-contact-img" alt="Card Image" style="border-radius:7%">
					<div class="card-body">
						<h1 class="card-contact-title"style="font-size: 20px; color:#FFFFFF"> Instagram </h1>
						<a href=" https://instagram.com/n.afkaar_2356?igshid=MTNiYzNiMzkwZA==" class="card-btn" target="_blank">Buka Link </a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="javascript/script.js"></script>
</body>
</html>
					
					