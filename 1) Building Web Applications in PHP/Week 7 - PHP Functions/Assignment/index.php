<!DOCTYPE html>
<html>
<head>
<title>Samarth Srivastava MD5</title>
</head>
<body>
<h1>MD5 Cracker</h1>
<p>This application takes an MD5 hash of a four digit pin and checks all 10,000 possible four digit PIN's to determine the PIN. 
</p>

<pre>
Debug Output: 
<?php
$foundtext = "Not Found";

if(isset($_GET['md5'])){
    $pre_time = microtime(true);
    $md5 = $_GET['md5'];

    $show = 15;
    $text = "0123456789";
    $textlen = strlen($text);

    for($i=0; $i<$textlen; $i++){
        $one = $text[$i];
        for($j=0; $j<$textlen; $j++){
            $two = $text[$j];
            for($k=0; $k<$textlen; $k++){
                $three = $text[$k];
                for($l=0; $l<$textlen; $l++){
                    $four = $text[$l];
                    $try = $one.$two.$three.$four;

                    $hashcode = hash('md5', $try);
                    if($hashcode == $md5){
                        $foundtext = $try;
                        break;
                    }

                    if($show > 0){
                        print "$hashcode   $try\n";
                        $show = $show - 1;
                    }
                }
            }
        }
    }

    $post_time = microtime(true);
    print "\n";
    print "\n";
    print "Elapsed time: ";
    print $post_time - $pre_time;
    print "\n";
}
print "<h2>";
print "MD5 PIN entered:  $md5";
print "</pre>";

?>
</pre>



<pre>
<h2>PIN:  <?= htmlentities($foundtext) ?> </h2>
</pre>

<form>
<input type="text" name="md5" size="40">
<input type="submit" value="Crack MD5">
</form>

<ul>
<li> <a href="makepin.php">Make an MD5 PIN </a></li>
</ul>

</body>
</html>