<?php
include 'koneksi.php';
session_start();

// Pengecekan apakah pengguna sudah login, jika iya, arahkan ke index.php
if (!isset($_SESSION['user']['user_id'])) {
    echo "<script>alert('Please log in to upload your novel'); window.location.href='loginregister.php';</script>";
    exit();
}

$genres = [];
$sql_genres = "SELECT genre_id, genre_name FROM genre";
$result = $conn->query($sql_genres);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $genres[] = $row;
    }
}

// Tangani formulir jika disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$user_id = $_SESSION['user']['user_id'];
	$genre_id = $_POST['genre'];
    $title = $_POST['title'];
	
	// Unggah file gambar
    $image_path = "uploads/" . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

    // Unggah file PDF
    $pdf_path = "uploads/" . basename($_FILES['pdf']['name']);
    move_uploaded_file($_FILES['pdf']['tmp_name'], $pdf_path);
	

    // Masukkan data ke dalam tabel
	$sql = "INSERT INTO novels (user_id, genre_id, title, image_path, pdf_path) 
			VALUES ('$user_id', '$genre_id', '$title', '$image_path', '$pdf_path')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Novel berhasil ditambahkan');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
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
				<a href="tambah_novel.php" class="menu-item is-active" id="add_novel">Add Novel</a>
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
				<a href="your_upload.php" class="menu-item" id="your_upload">Your Upload</a>
				<a href="tambah_novel.php" class="menu-item is-active" id="add_novel">Add Novel</a>
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
			<h1>Add Novel</h1>
			<p>Silahkan tambahkan novel buatan anda atau novel lainnya</p>
			</br>
			<form action="tambah_novel.php" method="post" enctype="multipart/form-data">
				<label for="title">Judul:</label></br>
				<input type="text" class="novel-title" name="title" required>
				</br></br>
				<label for="genre">Genre:</label></br>
                <select name="genre" class="novel-genre" required>
                    <option value="" disabled selected>Pilih Genre Novel</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?= $genre['genre_id']; ?>"><?= htmlspecialchars($genre['genre_name']); ?></option>
                    <?php endforeach; ?>
                </select>
                </br></br>
				<label for="image">Cover Novel(jpg,png,webp):</label></br></br>
				<input type="file" class="upload-box" name="image" accept=".jpg, .jpeg, .png, .webp" required>
				</br></br>
				<label for="pdf">File Novel (pdf only):</label></br></br>
				<input type="file" class="upload-box" name="pdf" accept=".pdf" required>
				</br></br></br>
				<input type="submit" class="submit-novel" value="Tambah Novel">
			</form>
		</div>
	</div>
	<script src="javascript/script.js"></script>
</body>
</html>