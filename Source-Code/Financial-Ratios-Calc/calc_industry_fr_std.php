<?php 
error_reporting(0);
$start = microtime(true);

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

		$query3 = "SELECT 	STD(Current_Ratio) STD_Current_Ratio, 
							STD(Gross_Margin) STD_Gross_Margin,
							STD(Net_Margin) STD_Net_Margin,
							STD(ROI) STD_ROI,
							STD(ROE) STD_ROE,
							STD(Receivable_Turnover) STD_Receivable_Turnover,
							STD(Collection_Period) STD_Collection_Period,
							STD(Asset_Turnover) STD_Asset_Turnover
					FROM NASDAQ_All_Companies_FR GROUP BY Industry='".$row['Industry']."' AND Period='13-14'";
	
		$result3 = mysql_query($query3);
	
		if (!$result3) {
	    	$message  = 'Invalid query: ' . mysql_error() . "\n";
	    	$message .= 'Whole query: ' . $query2;
	   		die($message);
		}	

$query = "SELECT * FROM NASDAQ_All_Industries WHERE ID >= '".$counter."'";

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

$companies_current_ratio = 0;
$companies_gross_margin= 0;
$companies_net_margin= 0;
$companies_ROI= 0;
$companies_ROE= 0;
$companies_receivable_turnover= 0;
$companies_collection_period= 0;
$companies_asset_turnover= 0;

$companiesAvailable = false;

while ($row = mysql_fetch_assoc($result)) {
	$companiesAvailable = true; 

	if ($counter == $counter_end)
		break;

	$counter++;		
		
	$query2 = "SELECT * FROM NASDAQ_All_Companies_FR WHERE Industry='".$row['Industry']."' AND Period='13-14'";

	$result2 = mysql_query($query2);

	if (!$result2) {
    	$message  = 'Invalid query: ' . mysql_error() . "\n";
    	$message .= 'Whole query: ' . $query2;
   		die($message);
	}
	
	$sum_current_ratio = 0;
	$number_current_ratio = 0;
	$sum_gross_margin = 0;
	$number_gross_margin = 0;
	$sum_net_margin = 0;
	$number_net_margin = 0;
	$sum_ROI = 0;
	$number_ROI = 0;
	$sum_ROE = 0;
	$number_ROE = 0;
	$sum_receivable_turnover = 0;
	$number_receivable_turnover = 0;
	$sum_collection_period = 0;
	$number_collection_period = 0;
	$sum_asset_turnover = 0;
	$number_asset_turnover = 0;
	
	/*
	 * Calculate mean per industry for every financial ratio
	 */
	while ($row2 = mysql_fetch_assoc($result2)) {
		if ($row2['Current_Ratio']) {
			$sum_current_ratio += $row2['Current_Ratio'];
			$number_current_ratio++;
			$companies_current_ratio++;			
		}
		
		if ($row2['Gross_Margin']) {
			$sum_gross_margin += $row2['Gross_Margin'];
			$number_gross_margin++;
			$companies_gross_margin++;			
		}
		
		if ($row2['Net_Margin']) {
			$sum_net_margin += $row2['Net_Margin'];
			$number_net_margin++;
			$companies_net_margin++;			
		}	

		if ($row2['ROI']) {
			$sum_ROI += $row2['ROI'];
			$number_ROI++;
			$companies_ROI++;			
		}

		if ($row2['ROE']) {
			$sum_ROE += $row2['ROE'];
			$number_ROE++;
			$companies_ROE++;			
		}
		
		if ($row2['Receivable_Turnover']) {
			$sum_receivable_turnover += $row2['Receivable_Turnover'];
			$number_receivable_turnover++;
			$companies_receivable_turnover++;			
		}
		
		if ($row2['Collection_Period']) {
			$sum_collection_period += $row2['Collection_Period'];
			$number_collection_period++;
			$companies_collection_period++;			
		}
		
		if ($row2['Asset_Turnover']) {
			$sum_asset_turnover += $row2['Asset_Turnover'];
			$number_asset_turnover++;
			$companies_asset_turnover++;			
		}
	}
//		echo "Industry: " . $row['Industry_Name'] . '</br>';
//		echo 'Period: 13-14' . '</br>';
//		echo 'Current Ratio (avg): ' . $sum_current_ratio/$number_current_ratio . ', Companies: '.$number_current_ratio.'</br>';
//		echo 'Gross Margin (avg): ' . $sum_gross_margin/$number_gross_margin . ', Companies: '.$number_gross_margin.'</br>';
//		echo 'Net Margin (avg): ' . $sum_net_margin/$number_net_margin . ', Companies: '.$number_net_margin.'</br>';
//		echo 'ROI (avg): ' . $sum_ROI/$number_ROI . ', Companies: '.$number_ROI.'</br>';
//		echo 'ROE (avg): ' . $sum_ROE/$number_ROE . ', Companies: '.$number_ROE.'</br>';
//		echo 'Receivable Turnover (avg): ' . $sum_receivable_turnover/$number_receivable_turnover . ', Companies: '.$number_receivable_turnover.'</br>';
//		echo 'Collection Period (avg): ' . $sum_collection_period/$number_collection_period . ', Companies: '.$number_collection_period.'</br>';
//		echo 'Asset Turnover (avg): ' . $sum_asset_turnover/$number_asset_turnover . ', Companies: '.$number_asset_turnover.'</br>';
//		echo '</br>';

		$query3 = "SELECT 	STD(Current_Ratio) STD_Current_Ratio, 
							STD(Gross_Margin) STD_Gross_Margin,
							STD(Net_Margin) STD_Net_Margin,
							STD(ROI) STD_ROI,
							STD(ROE) STD_ROE,
							STD(Receivable_Turnover) STD_Receivable_Turnover,
							STD(Collection_Period) STD_Collection_Period,
							STD(Asset_Turnover) STD_Asset_Turnover
					FROM NASDAQ_All_Companies_FR GROUP BY Industry='".$row['Industry']."' AND Period='13-14'";
	
		$result3 = mysql_query($query3);
	
		if (!$result3) {
	    	$message  = 'Invalid query: ' . mysql_error() . "\n";
	    	$message .= 'Whole query: ' . $query2;
	   		die($message);
		}	
	
		$query4 = "INSERT INTO NASDAQ_All_Industries_FR (	
									Industry,
									Companies,
									Period,
									Average_Revenue_Growth,
									Average_Current_Ratio,
									Average_Gross_Margin,
									Average_Net_Margin,
									Average_ROI,
									Average_ROE,
									Average_Receivable_Turnover,
									Average_Collection_Period,
									Average_Asset_Turnover)
					VALUES (
									'".$row['Industry']."',
									'".max($number_current_ratio,$number_gross_margin,$number_net_margin,
												$number_ROI,$number_ROE,$number_receivable_turnover, $number_collection_period,$number_asset_turnover)."',
									'13-14',
									'0',
									'".round($sum_current_ratio/$number_current_ratio, 3)."',
									'".round($sum_gross_margin/$number_gross_margin, 3)."',
									'".round($sum_net_margin/$number_net_margin, 3)."',
									'".round($sum_ROI/$number_ROI, 3)."',
									'".round($sum_ROE/$number_ROE, 3)."',
									'".round($sum_receivable_turnover/$number_receivable_turnover, 3)."',
									'".round($sum_collection_period/$number_collection_period, 3)."',
									'".round($sum_asset_turnover/$number_asset_turnover, 3)."')	";
		
		$result4 = mysql_query($query4);
	
		if (!$result4) {
	    	$message  = 'Invalid query: ' . mysql_error() . "\n";
	    	$message .= 'Whole query: ' . $query3;
	   		die($message);
		}	
}

mysql_close($conn);


echo 'Companies for:';
echo '</br>current_ratio ' . $companies_current_ratio;
echo '</br>gross_margin ' .$companies_gross_margin;
echo '</br>net_margin ' .$companies_net_margin;
echo '</br>ROI ' .$companies_ROI;
echo '</br>ROE ' .$companies_ROE;
echo '</br>receivable_turnover ' .$companies_receivable_turnover;
echo '</br>collection_period ' .$companies_collection_period;
echo '</br>asset_turnover ' .$companies_asset_turnover;

$exec_time = microtime(true) - $start;
echo "<br/> Execution time: " . $exec_time;

// html redirect after 3 seconds with URL '?counter=' . $counter
//header( 'Location: http://www.google.com' ) ;
/* <META HTTP-EQUIV="Refresh" CONTENT="<?php echo rand(3,15); ?>; URL=?counter=<?php echo $counter; ?>"> */
?>

<?php if ($companiesAvailable) { ?>
<META HTTP-EQUIV="Refresh" CONTENT="1; URL=?counter=<?php echo $counter; ?>">
<?php } else { ?>
 Crawler finished. 
<?php } ?>
