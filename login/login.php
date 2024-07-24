<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            width: 300px;
            background-color: #fff;
            padding: 60px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .container form {
            display: flex;
            flex-direction: column;
        }

        .container form input[type="email"],
        .container form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .container form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .container form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .container p {
            text-align: center;
            margin-top: 15px;
        }

        .container p a {
            text-decoration: none;
            color: #007bff;
        }

        .container p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            Email: <input type="email" name="email" required><br>
            Pasword: <input type="password" name="pasword" required><br>
            <input type="submit" value="Login">
            
        </form>
    </div>
</body>
</html>

<?php
session_start(); // Start the session
include('../koneksi.php');

// Function to validate login (you might want to implement actual validation logic)
function validateLogin($email, $password) {
    return true;
}

// Process login if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = md5($_POST['pasword']); 

    // Use a prepared statement to prevent SQL injection
    $stmt = $koneksi->prepare("SELECT id_user, nama, email, nim, prodi, role FROM user WHERE email = ? AND pasword = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        echo "Error: " . $koneksi->error;
    } else {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = $row['role'];

            if ($_SESSION['role'] == 'admin') {
                header("Location: ../index.php");
            } else {
                header("Location: ../PENGGUNA/index.php");
            }
            exit();
        } else {
            echo "Email atau password salah!";
        }
    }
    $stmt->close();
}
?>
