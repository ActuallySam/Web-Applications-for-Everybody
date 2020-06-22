<?php

session_start();

try 
{
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=misc", "fred", "zap");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
    die();
}

if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])
    && isset($_POST['mileage'])) {
    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Mileage and year must be numeric';
        header("Location: add.php");
        return;
    } elseif (strlen($_POST['make']) < 1) {
        $_SESSION['error'] = 'Make is required';
        header("Location: add.php");
        return;
    }

    $sql = "UPDATE autos SET make = :make,
            model = :model, year = :year,mileage=:mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
            ':make' => $_POST['make'],
            ':model' => $_POST['model'],
            ':year' => $_POST['year'],
            ':mileage' => $_POST['mileage'],
            ':autos_id' => $_GET['autos_id'])
    );
    $_SESSION['success'] = 'Record updated';
    header('Location: index.php');
    return;
}

// Guardian: Make sure that user_id is present
if (!isset($_GET['autos_id'])) {
    $_SESSION['error'] = "Missing autos_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}

// Flash pattern
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once "bootstrap.php"; ?>
    <title>Samarth Srivastava</title>
</head>
<body>
<div class="container">
    <h1>Editing Automobile</h1>
    <form method="post">
        <p>Make<input type="text" name="make" size="40" value="<?php echo $row['make'] ?>"/></p>
        <p>Model<input type="text" name="model" size="40" value="<?php echo $row['model'] ?>"/></p>
        <p>Year<input type="text" name="year" size="10" value="<?php echo $row['year'] ?>"/></p>
        <p>Mileage<input type="text" name="mileage" size="10" value="<?php echo $row['mileage'] ?>"/></p>
        <input type="hidden" name="autos_id" value="0">
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
    </form>
    <p>
</div>
</body>
</html>
