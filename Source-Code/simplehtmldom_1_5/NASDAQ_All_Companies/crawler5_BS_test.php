<?php 
error_reporting(0);
$start = microtime(true);

include_once('../simple_html_dom.php');

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

$query = "SELECT NASDAQ_Symbol, NASDAQ_URL FROM NASDAQ_All_Companies WHERE ID >= " . $counter;

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$companiesAvailable = false;

while ($row = mysql_fetch_assoc($result)) {
	$companiesAvailable = true;     

	if ($counter == $counter_end)
		break;

	echo $counter . ': ' . $row['NASDAQ_Symbol'] . ' - ' . $row['NASDAQ_URL'];

	$counter++;	
	
    // Create DOM from URL or file
    $html = file_get_html($row['NASDAQ_URL'] . '/financials?query=balance-sheet');

    if (!$html) {
    	$html = file_get_html($row['NASDAQ_URL'] . '/financials?query=balance-sheet');
    	while (!$html) {
    		$html = file_get_html($row['NASDAQ_URL'] . '/financials?query=balance-sheet');
    	}    
    }
    
    //foreach($html->find('a') as $element)
    //       echo $element->href . '<br>';

    // Find all td elements
    $sqlValues = array();
    $arrayCounter = 0;

    foreach($html->find('td') as $element) {
    $string = $element->plaintext;
    
    if (ereg("\\\$", $string)) {
    	//echo $counter . ' - ' . $string . '</br>';
    	//$counter++;

    	/*
     	* Data Cleaning
     	*/
    	$string = str_replace("$", "", $string);
    	$string = str_replace(",", "", $string);

    	// replacing brackets '(' and ')' and adding '-'
    	if (ereg("\(", $string)) {
    		$string = str_replace("(", "-", $string);
    		$string = str_replace(")", "", $string);
    	}

    	$sqlValues[$arrayCounter] = $string;

    	//echo "array value: " . $arrayCounter . " - " . $sqlValues[$arrayCounter] . "</br>";

    	$arrayCounter++;
    }
    }

    
    if ($arrayCounter == 120) {
 		echo "120";
    
    } elseif ($arrayCounter == 90) {
 		echo "90";
    
    } elseif ($arrayCounter == 60) {
    	echo "60";
    } elseif ($arrayCounter == 30) {
    	echo "30";
    } else {
    	echo " - No data available. " . $arrayCounter;
    }
    
    echo '<br>';

}

mysql_close($conn);

$exec_time = microtime(true) - $start;
echo "</br> Execution time: " . $exec_time;
echo '</br>';
// html redirect after 3 seconds with URL '?counter=' . $counter
//header( 'Location: http://www.google.com' ) ;
?>


