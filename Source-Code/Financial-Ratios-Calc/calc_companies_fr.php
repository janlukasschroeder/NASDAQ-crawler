<?php 
error_reporting(E_ALL);
$start = microtime(true);

if (isset($_GET['ID'])) {
	$ID = $_GET['ID'];
} else {
	$ID = 1;
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

$query = "SELECT * FROM NASDAQ_All_Companies_IS WHERE ID >= '".$ID."' ORDER BY ID ASC";

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$counter = 0;
$entries_left = false;
$break = false;

while ($row_IS = mysql_fetch_assoc($result)) {
	$entries_left = true; 

	if ($counter == 100) {
		$ID = $row_IS['ID'];
		$break = true;
		break;
	}
	$counter++;
		
		
	$query_BS = "SELECT * FROM NASDAQ_All_Companies_BS 
				WHERE NASDAQ_Symbol = '" . $row_IS['NASDAQ_Symbol'] ."' AND Period = '". $row_IS['Period'] ."'";

	$result_BS = mysql_query($query_BS);
	
	if (!$result_BS) {
    	$message  = 'Invalid query: ' . mysql_error() . "\n";
    	$message .= 'Whole query: ' . $query_BS;
   		die($message);
	}

	$row_BS = mysql_fetch_assoc($result_BS);
	
	$current_ratio = $row_BS['Total_Current_Assets']/$row_BS['Total_Current_Liabilities'];
	$gross_margin = (($row_IS['Total_Revenue']-$row_IS['Cost_of_Revenue']) / $row_IS['Total_Revenue']) * 100;
	$net_margin = ($row_IS['Net_Income'] / $row_IS['Total_Revenue']) * 100;
	$ROI = $row_IS['EBIT'] / $row_BS['Total_Assets'];
	$ROE = $row_IS['Net_Income'] / $row_BS['Total_Equity'];
	$recievable_turnover = $row_IS['Total_Revenue'] / $row_BS['Net_Receivables'];
	$collection_period = 365/$recievable_turnover;
	$asset_turnover = $row_IS['Total_Revenue'] / $row_BS['Total_Assets'];
	
	$sql_FR = "INSERT INTO NASDAQ_All_Companies_FR (
										NASDAQ_Symbol,
										Period,
										Revenue_Growth,
										Current_Ratio,
										Gross_Margin,
										Net_Margin,
										ROI,
										ROE,
										Receivable_Turnover,
										Collection_Period,
										Asset_Turnover)
									VALUES (
										'". $row_IS['NASDAQ_Symbol'] ."',
										'". $row_IS['Period'] ."',
										'0',
										'".round($current_ratio, 3)."',
										'".round($gross_margin, 3)."',
										'".round($net_margin, 3)."',
										'".round($ROI, 3)."',
										'".round($ROE, 3)."',
										'".round($recievable_turnover, 3)."',
										'".round($collection_period, 3)."',
										'".round($asset_turnover, 3)."')";
										
										
										
	


			$result_FR = mysql_query($sql_FR);

			if (!$result_FR) {
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

<?php if($entries_left && $break) { ?>
	<META HTTP-EQUIV="Refresh" CONTENT="2; URL=?ID=<?php echo $ID; ?>">
<?php } ?>