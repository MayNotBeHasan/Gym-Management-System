<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

if(isset($_POST['save'])){

    $name = $_POST['name'];
    $category = $_POST['category'];
    $purchase_date = $_POST['purchase_date'];
    $condition = $_POST['equipment_condition'];
    $maintenance_date = $_POST['maintenance_date'];

    $sql = "INSERT INTO equipment (name, category, purchase_date, equipment_condition, maintenance_date)
            VALUES ('$name', '$category', '$purchase_date', '$condition', '$maintenance_date')";

    mysqli_query($conn, $sql);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Add New Equipment</h2>

    <form method="POST">

        <label>Name</label>
        <input type="text" name="name" class="form-control" required><br>

        <label>Category</label>
        <input type="text" name="category" class="form-control" required><br>

        <label>Purchase Date</label>
        <input type="date" name="purchase_date" class="form-control" required><br>

        <label>Condition</label>
        <select name="equipment_condition" class="form-control">
            <option value="good">Good</option>
            <option value="fair">Fair</option>
            <option value="poor">Poor</option>
        </select><br>

        <label>Next Maintenance Date</label>
        <input type="date" name="maintenance_date" class="form-control"><br>

        <button class="btn btn-success" name="save">Save Equipment</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
