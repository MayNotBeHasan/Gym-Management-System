<?php
session_start();
include("../config/db.php");

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // FETCH THE USER WITH PREPARED STATEMENT
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // USER FOUND
    if ($result && $result->num_rows === 1) {

        $row = $result->fetch_assoc();

        // PASSWORD CHECK (plain text because DB has plain passwords)
        if ($row['password'] === $password) {

            // SAVE USER SESSION
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['name'] = $row['name'];

            // ROLE-BASED REDIRECTS
            switch ($row['role']) {

                case 'admin':
                    header("Location: ../dashboard/admin_dashboard.php");
                    exit;

                case 'trainer':
                    header("Location: ../dashboard/trainer_dashboard.php");
                    exit;

                case 'member':
                    header("Location: ../dashboard/member_dashboard.php");
                    exit;

                case 'cafeteria':
                    header("Location: ../dashboard/cafe_dashboard.php");
                    exit;

                default:
                    header("Location: ../dashboard/index.php");
                    exit;
            }

        } else {
            $error = "Incorrect password!";
        }

    } else {
        $error = "No user found with this email!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login - SAU Gym</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="col-md-4 mx-auto card p-4">
        <h3 class="text-center">SAU Gym Login</h3>

        <?php if(isset($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>

        <form method="POST">
            <input type="email" name="email" class="form-control" placeholder="Email" required><br>
            <input type="password" name="password" class="form-control" placeholder="Password" required><br>
            <button class="btn btn-primary w-100" name="login">Login</button>
        </form>
    </div>
</div>

</body>
</html>
