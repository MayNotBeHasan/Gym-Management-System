<?php
// Make sure session is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function allow_role($roles) {

    if (!in_array($_SESSION['role'], $roles)) {

        // dynamic home redirection
        $home = "../dashboard/index.php";

        if ($_SESSION['role'] == "admin") $home = "../dashboard/admin_dashboard.php";
        if ($_SESSION['role'] == "trainer") $home = "../dashboard/trainer_dashboard.php";
        if ($_SESSION['role'] == "member") $home = "../dashboard/member_dashboard.php";
        if ($_SESSION['role'] == "cafeteria") $home = "../dashboard/cafe_dashboard.php";

        echo "<div style='text-align:center; padding:40px;'>
                <h2 style='color:red;'>ACCESS DENIED</h2>
                <p>You do not have permission to access this page.</p>
                <a href='$home' class='btn btn-primary'>Go Back</a>
              </div>";
        exit;
    }
}
?>
