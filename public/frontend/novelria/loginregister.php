<?php
require_once('koneksi.php');

session_start();

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'login') {
        // Login
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user'] = $user;
            header("Location: index.php"); // Ganti dengan halaman utama setelah login
            exit();
        } else {
            $error = "Username or password is invalid";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'register') {
        // Register
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "INSERT INTO users (name, username, password) VALUES ('$name', '$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Berhasil registrasi');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/styles.css" />
    <title>Novelria - Tempat Baca Novel Gratis</title>
</head>
<body>
	<div class="login-bg">
		<div class="form-box">
			<div class="logreg-box">
				<div id="logreg-btn"></div>
					<button type="button" class="logreg-toggle-btn" onClick="login()">Log in</button>
					<button type="button" class="logreg-toggle-btn" onClick="register()">Register</button>
			</div>
			<h1>NOVELRIA</h1>
			<form method="post" action="" id="login" class="input-group">
				<input type="hidden" name="action" value="login"> <!-- Pembeda untuk form login -->
				<input type="text" name="username" class="input-field" placeholder="Username" required>
				<input type="password" name="password" class="input-field" placeholder="Password" required>
				<input type="checkbox" class="check-box"><span>Ingat Password</span>
				<button type="submit" class="submit-btn">Log in</button>
				<?php if (isset($error) && $_POST['action'] == 'login') { // Tampilkan pesan kesalahan hanya untuk login ?>
					<div class="error-message">
					<?php echo $error; ?>
					</div>
				<?php } ?>
			</form>	
			<form method="post" action="" id="register" class="input-group">
				<input type="hidden" name="action" value="register"> <!-- Pembeda untuk form register -->
				<input type="text" name="name" class="input-field" placeholder="Nama Anda" required>
				<input type="text" name="username" class="input-field" placeholder="Buat Username" required>
				<input type="password" name="password" class="input-field" placeholder="Buat Password" required>
				<input type="checkbox" class="check-box"><span>Saya setuju dengan syarat & ketentuan</span>
				<button type="submit" class="submit-btn">Register</button>
				<?php if (isset($error) && $_POST['action'] == 'register') { // Tampilkan pesan kesalahan hanya untuk register ?>
					<div class="error-message"><?php echo $error; ?></div>
				<?php } ?>
			</form>		
		</div>
	</div>
	<script>
	var x = document.getElementById("login");
	var y = document.getElementById("register");
	var z = document.getElementById("logreg-btn");
	function login(){
		x.style.left = "50px";
		y.style.left = "450px";
		z.style.left = "0px";
	}
	function register(){
		x.style.left = "-400px";
		y.style.left = "50px";
		z.style.left = "110px";
	}
	</script>
</body>
</html>