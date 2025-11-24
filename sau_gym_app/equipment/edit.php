<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM equipment WHERE equipment_id=$id";
$eq = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $category = $_POST['category'];
    $purchase_date = $_POST['purchase_date'];
    $condition = $_POST['equipment_condition'];
    $maintenance_date = $_POST['maintenance_date'];

    $sql = "UPDATE equipment SET
            name='$name',
            category='$category',
            purchase_date='$purchase_date',
            equipment_condition='$condition',
            maintenance_date='$maintenance_date'
            WHERE equipment_id=$id";

    mysqli_query($conn, $sql);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Equipment</h2>

    <form method="POST">

        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= $eq['name'] ?>" required><br>

        <label>Category</label>
        <input type="text" name="category" class="form-control" value="<?= $eq['category'] ?>" required><br>

        <label>Purchase Date</label>
        <input type="date" name="purchase_date" class="form-control" value="<?= $eq['purchase_date'] ?>" required><br>

        <label>Condition</label>
        <select name="equipment_condition" class="form-control">
            <option value="good" <?= ($eq['equipment_condition']=='good')?'selected':'' ?>>Good</option>
            <option value="fair" <?= ($eq['equipment_condition']=='fair')?'selected':'' ?>>Fair</option>
            <option value="poor" <?= ($eq['equipment_condition']=='poor')?'selected':'' ?>>Poor</option>
        </select><br>

        <label>Next Maintenance Date</label>
        <input type="date" name="maintenance_date" class="form-control" value="<?= $eq['maintenance_date'] ?>"><br>

        <button class="btn btn-success" name="update">Update</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
