<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('ACCESS DENIED');
}

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

if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
    $sql = "DELETE FROM autos WHERE autos_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
    $_SESSION['error'] = "Missing user_id";
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT make FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header('Location: index.php');
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Samarth Srivastava</title>
    <?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
    <p>Confirm: Deleting <?php echo $row['make'] ?></p>
    <form method="post"><input type="hidden" name="autos_id" value="<?php echo $_GET['autos_id'] ?>"> <input
                type="submit" value="Delete"
                name="delete"><a
                href="index.php">Cancel</a>
    </form>
</div>
</body>