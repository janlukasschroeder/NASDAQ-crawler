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

	echo $counter . ': ' . $row['NASDAQ_Symbol'] . ' - ' . $row['NASDAQ_URL'] . '<br>';

	$counter++;	
	
    // Create DOM from URL or file
    $html = file_get_html($row['NASDAQ_URL'] . '/financials?query=income-statement');

    if (!$html) {
    	$html = file_get_html($row['NASDAQ_URL'] . '/financials?query=income-statement');
    	while (!$html) {
    		$html = file_get_html($row['NASDAQ_URL'] . '/financials?query=income-statement');
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

    
    if ($arrayCounter == 72) {
    /*
     * start preparation of SQL data
     */
    $sql1 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'13-14',
								'$sqlValues[0]',
								'$sqlValues[4]',
								'$sqlValues[8]',
								'$sqlValues[12]',
								'$sqlValues[16]',
								'$sqlValues[20]',
								'$sqlValues[24]',
								'$sqlValues[28]',
								'$sqlValues[32]',
								'$sqlValues[36]',
								'$sqlValues[40]',
								'$sqlValues[44]',
								'$sqlValues[48]',
								'$sqlValues[52]',
								'$sqlValues[56]',
								'$sqlValues[60]',
								'$sqlValues[64]',
								'$sqlValues[68]')";

    $sql2 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'12-13',
								'$sqlValues[1]',
								'$sqlValues[5]',
								'$sqlValues[9]',
								'$sqlValues[13]',
								'$sqlValues[17]',
								'$sqlValues[21]',
								'$sqlValues[25]',
								'$sqlValues[29]',
								'$sqlValues[33]',
								'$sqlValues[37]',
								'$sqlValues[41]',
								'$sqlValues[45]',
								'$sqlValues[49]',
								'$sqlValues[53]',
								'$sqlValues[57]',
								'$sqlValues[61]',
								'$sqlValues[65]',
								'$sqlValues[69]')";

    $sql3 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'11-12',
								'$sqlValues[2]',
								'$sqlValues[6]',
								'$sqlValues[10]',
								'$sqlValues[14]',
								'$sqlValues[18]',
								'$sqlValues[22]',
								'$sqlValues[26]',
								'$sqlValues[30]',
								'$sqlValues[34]',
								'$sqlValues[38]',
								'$sqlValues[42]',
								'$sqlValues[46]',
								'$sqlValues[50]',
								'$sqlValues[54]',
								'$sqlValues[58]',
								'$sqlValues[62]',
								'$sqlValues[66]',
								'$sqlValues[70]')";

    $sql4 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'10-11',
								'$sqlValues[3]',
								'$sqlValues[7]',
								'$sqlValues[11]',
								'$sqlValues[15]',
								'$sqlValues[19]',
								'$sqlValues[23]',
								'$sqlValues[27]',
								'$sqlValues[31]',
								'$sqlValues[35]',
								'$sqlValues[39]',
								'$sqlValues[43]',
								'$sqlValues[47]',
								'$sqlValues[51]',
								'$sqlValues[55]',
								'$sqlValues[59]',
								'$sqlValues[63]',
								'$sqlValues[67]',
								'$sqlValues[71]')";

    $result1 = mysql_query($sql1);
    $result2 = mysql_query($sql2);
    $result3 = mysql_query($sql3);
    $result4 = mysql_query($sql4);

    if (!$result1 && !$result2 && !$result3 && !$result4) {
    	die('Invalid query: ' . mysql_error());
    }
    
    } elseif ($arrayCounter == 54) {
     /*
     * 3 data columns
     */
    $sql1 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'13-14',
								'$sqlValues[0]',
								'$sqlValues[3]',
								'$sqlValues[6]',
								'$sqlValues[9]',
								'$sqlValues[12]',
								'$sqlValues[15]',
								'$sqlValues[18]',
								'$sqlValues[21]',
								'$sqlValues[24]',
								'$sqlValues[27]',
								'$sqlValues[30]',
								'$sqlValues[33]',
								'$sqlValues[36]',
								'$sqlValues[39]',
								'$sqlValues[42]',
								'$sqlValues[45]',
								'$sqlValues[48]',
								'$sqlValues[51]')";

    $sql2 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'12-13',
								'$sqlValues[1]',
								'$sqlValues[4]',
								'$sqlValues[7]',
								'$sqlValues[10]',
								'$sqlValues[13]',
								'$sqlValues[16]',
								'$sqlValues[19]',
								'$sqlValues[22]',
								'$sqlValues[25]',
								'$sqlValues[28]',
								'$sqlValues[31]',
								'$sqlValues[34]',
								'$sqlValues[37]',
								'$sqlValues[40]',
								'$sqlValues[43]',
								'$sqlValues[46]',
								'$sqlValues[49]',
								'$sqlValues[52]')";

    $sql3 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'11-12',
								'$sqlValues[2]',
								'$sqlValues[5]',
								'$sqlValues[8]',
								'$sqlValues[11]',
								'$sqlValues[14]',
								'$sqlValues[17]',
								'$sqlValues[20]',
								'$sqlValues[23]',
								'$sqlValues[26]',
								'$sqlValues[29]',
								'$sqlValues[32]',
								'$sqlValues[35]',
								'$sqlValues[38]',
								'$sqlValues[41]',
								'$sqlValues[44]',
								'$sqlValues[47]',
								'$sqlValues[50]',
								'$sqlValues[53]')";

    $result1 = mysql_query($sql1);
    $result2 = mysql_query($sql2);
    $result3 = mysql_query($sql3);

    if (!$result1 && !$result2 && !$result3) {
    	die('Invalid query: ' . mysql_error());
    }
    } elseif ($arrayCounter == 36) {
    /*
     * 2 data columns
     */
    $sql1 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'13-14',
								'$sqlValues[0]',
								'$sqlValues[2]',
								'$sqlValues[4]',
								'$sqlValues[6]',
								'$sqlValues[8]',
								'$sqlValues[10]',
								'$sqlValues[12]',
								'$sqlValues[14]',
								'$sqlValues[16]',
								'$sqlValues[18]',
								'$sqlValues[20]',
								'$sqlValues[22]',
								'$sqlValues[24]',
								'$sqlValues[26]',
								'$sqlValues[28]',
								'$sqlValues[30]',
								'$sqlValues[32]',
								'$sqlValues[34]')";

    $sql2 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'12-13',
								'$sqlValues[1]',
								'$sqlValues[3]',
								'$sqlValues[5]',
								'$sqlValues[7]',
								'$sqlValues[9]',
								'$sqlValues[11]',
								'$sqlValues[13]',
								'$sqlValues[15]',
								'$sqlValues[17]',
								'$sqlValues[19]',
								'$sqlValues[21]',
								'$sqlValues[23]',
								'$sqlValues[25]',
								'$sqlValues[27]',
								'$sqlValues[29]',
								'$sqlValues[31]',
								'$sqlValues[33]',
								'$sqlValues[35]')";

    $result1 = mysql_query($sql1);
    $result2 = mysql_query($sql2);

    if (!$result1 && !$result2) {
    	die('Invalid query: ' . mysql_error());
    }    
    } elseif($arrayCounter == 18) {
    /*
     * 2 data columns
     */
    $sql1 = "INSERT INTO NASDAQ_All_Companies_IS (
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non_Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income_Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
		VALUES (
								1,
								'" . $row['NASDAQ_Symbol'] . "',
								'13-14',
								'$sqlValues[0]',
								'$sqlValues[1]',
								'$sqlValues[2]',
								'$sqlValues[3]',
								'$sqlValues[4]',
								'$sqlValues[5]',
								'$sqlValues[6]',
								'$sqlValues[7]',
								'$sqlValues[8]',
								'$sqlValues[9]',
								'$sqlValues[10]',
								'$sqlValues[11]',
								'$sqlValues[12]',
								'$sqlValues[13]',
								'$sqlValues[14]',
								'$sqlValues[15]',
								'$sqlValues[16]',
								'$sqlValues[17]')";

    $result1 = mysql_query($sql1);

    if (!$result1) {
    	die('Invalid query: ' . mysql_error());
    }      
    } else {
    	echo " '-- No data available.</br>";
    }
}

mysql_close($conn);

$exec_time = microtime(true) - $start;
echo "<br/> Execution time: " . $exec_time;

// html redirect after 3 seconds with URL '?counter=' . $counter
//header( 'Location: http://www.google.com' ) ;
?>

<?php if ($companiesAvailable) { ?>
<META HTTP-EQUIV="Refresh" CONTENT="5; URL=?counter=<?php echo $counter; ?>">
<?php } else { ?>
 Crawler finished. 
<?php } ?>