<?php 
error_reporting(E_ALL);
$start = microtime(true);



// establish MySQL connection
$servername = "localhost";
$username = "constr10_userA";
$password = "DESFs73tfgP(*Sk6Ws*H#s";

$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully <br/>';

// make foo the current db
$db_selected = mysql_select_db('constr10_stock_market', $conn);
if (!$db_selected) {
    die ('Can\'t use constr10_stock_market : ' . mysql_error());
}

$query = "SELECT *, COUNT(*) c FROM NASDAQ_All_Companies GROUP BY Industry_Name";

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

while ($row = mysql_fetch_assoc($result)) {
    
	$query2 = "INSERT INTO NASDAQ_All_Industries (Industry, Companies) VALUES ('".$row['Industry_Name']."', '".$row['c']."')";

	$result2 = mysql_query($query2);

	if (!$result2) {
    	$message  = 'Invalid query: ' . mysql_error() . "\n";
    	$message .= 'Whole query: ' . $query2;
   		die($message);
	}
}

mysql_close($conn);

$exec_time = microtime(true) - $start;
echo "<br/> Execution time: " . $exec_time;

// html redirect after 3 seconds with URL '?counter=' . $counter
//header( 'Location: http://www.google.com' ) ;
/* <META HTTP-EQUIV="Refresh" CONTENT="<?php echo rand(3,15); ?>; URL=?counter=<?php echo $counter; ?>"> */
?>
