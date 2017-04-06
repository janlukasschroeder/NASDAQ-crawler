<?php 
error_reporting(0);

include_once('simple_html_dom.php');

// establish MySQL connection
$servername = "localhost";
$username = "constr10_userA";
$password = "DESFs73tfgP(*Sk6Ws*H#s";

$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db('constr10_stock_market', $conn);
if (!$db_selected) {
    die ('Can\'t use constr10_stock_market : ' . mysql_error());
}

echo 'Connected successfully';

// Create DOM from URL or file
$html = file_get_html('http://www.nasdaq.com/symbol/blin/financials?query=income-statement');

//foreach($html->find('a') as $element)
//       echo $element->href . '<br>'; 

// Find all td elements
$counter = 0;
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
		echo "array value: " . $arrayCounter . " - " . $sqlValues[$arrayCounter] . "</br>";
		
		$arrayCounter++;
		
		 
	}
}


/*
 * start preparation of SQL data
 */
$sql1 = "INSERT INTO NASDAQ_IS (	
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
								'MDCA',
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

$sql2 = "INSERT INTO NASDAQ_IS (	
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
								'MDCA',
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

$sql3 = "INSERT INTO NASDAQ_IS (	
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
								'MDCA',
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

$sql4 = "INSERT INTO NASDAQ_IS (	
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
								'MDCA',
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

if (!$result1 || !$result2 || !$result3 || !$result4) {
    die('Invalid query: ' . mysql_error());
}


/* mysqli does not work
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
*/


/* 
 * SQL statement for four periods
 */
/*
$stmt = $conn->prepare("INSERT INTO NASDAQ_IS (	
								Company_ID, 
								NASDAQ_Symbol,
								Period,
								Total_Revenue,
								Cost_of_Revenue,
								Gross_Profit,
								R_and_D,
								Sales_General_Admin,
								Non-Recurring_Items,
								Other_Operating_Items,
								Operating_Income,
								Additional_Income,
								EBIT,
								Interest_Expense,
								EBT,
								Income_Tax,
								Minority_Interest,
								Equity_Earnings,
								Net_Income-Cont_Operations,
								Net_Income,
								Net_Income_Shareholders
								)
VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("issssssssssssssssssss", 
								$Company_ID, 
								$NASDAQ_Symbol,
								$Period,
								$Total_Revenue,
								$Cost_of_Revenue,
								$Gross_Profit,
								$R_and_D,
								$Sales_General_Admin,
								$Non_Recurring_Items,
								$Other_Operating_Items,
								$Operating_Income,
								$Additional_Income,
								$EBIT,
								$Interest_Expense,
								$EBT,
								$Income_Tax,
								$Minority_Interest,
								$Equity_Earnings,
								$Net_Income_Cont_Operations,
								$Net_Income,
								$Net_Income_Shareholders );

// set parameters and exectue
$Company_ID 				= 1;
$NASDAQ_Symbol 				= MDCA;
$Period 					= '13-14';
$Total_Revenue				= $sqlValues[0];
$Cost_of_Revenue			= $sqlValues[4];
$Gross_Profit				= $sqlValues[8];
$R_and_D					= $sqlValues[12];
$Sales_General_Admin		= $sqlValues[16];
$Non_Recurring_Items		= $sqlValues[20];
$Other_Operating_Items		= $sqlValues[24];
$Operating_Income			= $sqlValues[28];
$Additional_Income			= $sqlValues[32];
$EBIT						= $sqlValues[36];
$Interest_Expense			= $sqlValues[40];
$EBT						= $sqlValues[44];
$Income_Tax					= $sqlValues[48];
$Minority_Interest			= $sqlValues[52];
$Equity_Earnings			= $sqlValues[56];
$Net_Income_Cont_Operations = $sqlValues[60];
$Net_Income					= $sqlValues[64];
$Net_Income_Shareholders	= $sqlValues[68];

$stmt->execute();			
			
// set parameters and exectue
$Company_ID 				= 1;
$NASDAQ_Symbol 				= MDCA;
$Period 					= '12-13';
$Total_Revenue				= $sqlValues[1];
$Cost_of_Revenue			= $sqlValues[5];
$Gross_Profit				= $sqlValues[9];
$R_and_D					= $sqlValues[13];
$Sales_General_Admin		= $sqlValues[17];
$Non_Recurring_Items		= $sqlValues[21];
$Other_Operating_Items		= $sqlValues[25];
$Operating_Income			= $sqlValues[29];
$Additional_Income			= $sqlValues[33];
$EBIT						= $sqlValues[37];
$Interest_Expense			= $sqlValues[41];
$EBT						= $sqlValues[45];
$Income_Tax					= $sqlValues[49];
$Minority_Interest			= $sqlValues[53];
$Equity_Earnings			= $sqlValues[57];
$Net_Income_Cont_Operations = $sqlValues[61];
$Net_Income					= $sqlValues[65];
$Net_Income_Shareholders	= $sqlValues[69];

$stmt->execute();

// set parameters and exectue
$Company_ID 				= 1;
$NASDAQ_Symbol 				= MDCA;
$Period 					= '11-12';
$Total_Revenue				= $sqlValues[2];
$Cost_of_Revenue			= $sqlValues[6];
$Gross_Profit				= $sqlValues[10];
$R_and_D					= $sqlValues[14];
$Sales_General_Admin		= $sqlValues[18];
$Non_Recurring_Items		= $sqlValues[22];
$Other_Operating_Items		= $sqlValues[26];
$Operating_Income			= $sqlValues[28];
$Additional_Income			= $sqlValues[34];
$EBIT						= $sqlValues[38];
$Interest_Expense			= $sqlValues[42];
$EBT						= $sqlValues[46];
$Income_Tax					= $sqlValues[50];
$Minority_Interest			= $sqlValues[54];
$Equity_Earnings			= $sqlValues[58];
$Net_Income_Cont_Operations = $sqlValues[62];
$Net_Income					= $sqlValues[66];
$Net_Income_Shareholders	= $sqlValues[70];

$stmt->execute();

// set parameters and exectue
$Company_ID 				= 1;
$NASDAQ_Symbol 				= MDCA;
$Period 					= '10-11';
$Total_Revenue				= $sqlValues[3];
$Cost_of_Revenue			= $sqlValues[7];
$Gross_Profit				= $sqlValues[11];
$R_and_D					= $sqlValues[15];
$Sales_General_Admin		= $sqlValues[19];
$Non_Recurring_Items		= $sqlValues[23];
$Other_Operating_Items		= $sqlValues[27];
$Operating_Income			= $sqlValues[31];
$Additional_Income			= $sqlValues[35];
$EBIT						= $sqlValues[39];
$Interest_Expense			= $sqlValues[43];
$EBT						= $sqlValues[47];
$Income_Tax					= $sqlValues[51];
$Minority_Interest			= $sqlValues[55];
$Equity_Earnings			= $sqlValues[59];
$Net_Income_Cont_Operations = $sqlValues[63];
$Net_Income					= $sqlValues[67];
$Net_Income_Shareholders	= $sqlValues[71];

$stmt->execute();
*/

//if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
//} else {
//    echo "Error: " . $sql . "<br>" . $conn->error;
//}

// close MySQL connection
//$conn->close();
mysql_close($conn);

?>
