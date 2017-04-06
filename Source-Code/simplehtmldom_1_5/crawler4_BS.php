<?php 
error_reporting(0);
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

$query = "SELECT NASDAQ_Symbol, NASDAQ_URL FROM Companies WHERE ID >= " . $counter;

$result = mysql_query($query);

if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
}

while ($row = mysql_fetch_assoc($result)) {
    
	if ($counter == $counter_end)
		break;

	echo $counter . ': ' . $row['NASDAQ_Symbol'] . ' - ' . $row['NASDAQ_URL'] . '<br>';

	$counter++;	
	
    // Create DOM from URL or file
    $html = file_get_html($row['NASDAQ_URL'] . '/financials?query=balance-sheet');

    
    
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

/*
 * start preparation of SQL data
 */
$sql1 = "INSERT INTO NASDAQ_BS (	
								Company_ID,
								NASDAQ_Symbol,
								Period,
								Cash_and_Cash_Equivalents,	
								Short_Term_Investments,
								Net_Receivables,
								Inventory,
								Other_Current_Assets,
								Total_Current_Assets,
								Long_Term_Investments,
								Fixed_Assets,
								Goodwill,
								Intangible_Assets,
								Other_Assets,
								Deferred_Asset_Charges,
								Total_Assets,
								Accounts_Payable,
								Short_Term_Debt,
								Other_Current_Liabilities,
								Total_Current_Liabilities,
								Long_Term_Debt,
								Other_Liabilities,
								Deferred_Liability_Charges,
								Misc_Stocks,
								Minority_Interest,
								Total_Liabilities,
								Common_Stocks,
								Capital_Surplus,
								Retained_Earnings,
								Treasury_Stock,
								Other_Equity,
								Total_Equity,
								Total_Liabilities_and_Equity
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
								'$sqlValues[68]',
								'$sqlValues[72]',
								'$sqlValues[76]',
								'$sqlValues[80]',
								'$sqlValues[84]',
								'$sqlValues[88]',
								'$sqlValues[92]',
								'$sqlValues[96]',
								'$sqlValues[100]',
								'$sqlValues[104]',
								'$sqlValues[108]',
								'$sqlValues[112]',
								'$sqlValues[116]'
								)";

$sql2 = "INSERT INTO NASDAQ_BS (	
								Company_ID,
								NASDAQ_Symbol,
								Period,
								Cash_and_Cash_Equivalents,	
								Short_Term_Investments,
								Net_Receivables,
								Inventory,
								Other_Current_Assets,
								Total_Current_Assets,
								Long_Term_Investments,
								Fixed_Assets,
								Goodwill,
								Intangible_Assets,
								Other_Assets,
								Deferred_Asset_Charges,
								Total_Assets,
								Accounts_Payable,
								Short_Term_Debt,
								Other_Current_Liabilities,
								Total_Current_Liabilities,
								Long_Term_Debt,
								Other_Liabilities,
								Deferred_Liability_Charges,
								Misc_Stocks,
								Minority_Interest,
								Total_Liabilities,
								Common_Stocks,
								Capital_Surplus,
								Retained_Earnings,
								Treasury_Stock,
								Other_Equity,
								Total_Equity,
								Total_Liabilities_and_Equity
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
								'$sqlValues[69]',
								'$sqlValues[73]',
								'$sqlValues[77]',
								'$sqlValues[81]',
								'$sqlValues[85]',
								'$sqlValues[89]',
								'$sqlValues[93]',
								'$sqlValues[97]',
								'$sqlValues[101]',
								'$sqlValues[105]',
								'$sqlValues[109]',
								'$sqlValues[113]',
								'$sqlValues[117]'
								)";

$sql3 = "INSERT INTO NASDAQ_BS (	
								Company_ID,
								NASDAQ_Symbol,
								Period,
								Cash_and_Cash_Equivalents,	
								Short_Term_Investments,
								Net_Receivables,
								Inventory,
								Other_Current_Assets,
								Total_Current_Assets,
								Long_Term_Investments,
								Fixed_Assets,
								Goodwill,
								Intangible_Assets,
								Other_Assets,
								Deferred_Asset_Charges,
								Total_Assets,
								Accounts_Payable,
								Short_Term_Debt,
								Other_Current_Liabilities,
								Total_Current_Liabilities,
								Long_Term_Debt,
								Other_Liabilities,
								Deferred_Liability_Charges,
								Misc_Stocks,
								Minority_Interest,
								Total_Liabilities,
								Common_Stocks,
								Capital_Surplus,
								Retained_Earnings,
								Treasury_Stock,
								Other_Equity,
								Total_Equity,
								Total_Liabilities_and_Equity
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
								'$sqlValues[70]',
								'$sqlValues[74]',
								'$sqlValues[78]',
								'$sqlValues[82]',
								'$sqlValues[86]',
								'$sqlValues[90]',
								'$sqlValues[94]',
								'$sqlValues[98]',
								'$sqlValues[102]',
								'$sqlValues[106]',
								'$sqlValues[110]',
								'$sqlValues[114]',
								'$sqlValues[118]'
								)";

$sql4 = "INSERT INTO NASDAQ_BS (	
								Company_ID,
								NASDAQ_Symbol,
								Period,
								Cash_and_Cash_Equivalents,	
								Short_Term_Investments,
								Net_Receivables,
								Inventory,
								Other_Current_Assets,
								Total_Current_Assets,
								Long_Term_Investments,
								Fixed_Assets,
								Goodwill,
								Intangible_Assets,
								Other_Assets,
								Deferred_Asset_Charges,
								Total_Assets,
								Accounts_Payable,
								Short_Term_Debt,
								Other_Current_Liabilities,
								Total_Current_Liabilities,
								Long_Term_Debt,
								Other_Liabilities,
								Deferred_Liability_Charges,
								Misc_Stocks,
								Minority_Interest,
								Total_Liabilities,
								Common_Stocks,
								Capital_Surplus,
								Retained_Earnings,
								Treasury_Stock,
								Other_Equity,
								Total_Equity,
								Total_Liabilities_and_Equity
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
								'$sqlValues[71]',
								'$sqlValues[75]',
								'$sqlValues[79]',
								'$sqlValues[83]',
								'$sqlValues[87]',
								'$sqlValues[91]',
								'$sqlValues[95]',
								'$sqlValues[99]',
								'$sqlValues[103]',
								'$sqlValues[107]',
								'$sqlValues[111]',
								'$sqlValues[115]',
								'$sqlValues[119]'
								)";

    $result1 = mysql_query($sql1);
    $result2 = mysql_query($sql2);
    $result3 = mysql_query($sql3);
    $result4 = mysql_query($sql4);

    if (!$result1 && !$result2 && !$result3 && !$result4) {
    	die('Invalid query: ' . mysql_error());
    }
}

mysql_close($conn);

$exec_time = microtime(true) - $start;
echo "<br/> Execution time: " . $exec_time;

// html redirect after 3 seconds with URL '?counter=' . $counter
//header( 'Location: http://www.google.com' ) ;
?>

<META HTTP-EQUIV="Refresh" CONTENT="5; URL=?counter=<?php echo $counter; ?>">
