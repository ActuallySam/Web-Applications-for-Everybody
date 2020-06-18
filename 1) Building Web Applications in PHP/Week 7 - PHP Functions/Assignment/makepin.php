<!DOCTYPE html>
<html>
<head>
<title>Samarth Srivastava PIN Maker</title>
</head>
<body>
<h1>MD5 PIN Maker</h1>

<pre>
<?php
print "\n";
$error = false;
$md5 = false;
$code = ""; 

if(isset($_GET['code'])){
    $code = $_GET['code'];
    if(strlen($code) != 4){
        $error = "Input must be exactly 4 digits PIN";
    }  else if($code[0] < "0" || $code[0] > "9" || $code[1] < "0" || $code[1] > "9" || $code[2] < "0" || $code[2] > "9" || $code[3] < "0" || $code[3] > "9" ){
        $error = "Input must contains digits";
    }
    else{
        $number = hash('md5', $code);
    }
}
print "<h3> MD5 Hashcode is:   ";
print "$number";
print "</h3>\n";

?>
</pre>


<form>
<input type="number" name="code">
<input type = "submit" value = "Compute MD5 for PIN">
</form>

<ul>
<li> <a href="index.php"> Convert MD5 PIN </a></li>
</ul>

</body>
</html>

