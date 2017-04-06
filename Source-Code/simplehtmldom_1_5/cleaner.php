<?php 
error_reporting(E_ALL);
$start = microtime(true);

include_once('simple_html_dom.php');

if (isset($_GET['counter'])) {
	$counter = $_GET['counter'];
	$counter_end = $counter + 30;
} else {
	$counter = 1;
	$counter_end = $counter + 30;
}

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

$query = "DELETE FROM NASDAQ_IS WHERE ID<=120";

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

mysql_close($conn);

$exec_time = microtime(true) - $start;
echo "<br/> Execution time: " . $exec_time;

// html redirect after 3 seconds with URL '?counter=' . $counter
//header( 'Location: http://www.google.com' ) ;
?>

