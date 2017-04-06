<?php 
error_reporting(0);

include_once('simple_html_dom.php');

// Create DOM from URL or file
$html = file_get_html('http://www.nasdaq.com/symbol/AAC/financials?query=income-statement');

//foreach($html->find('a') as $element)
//       echo $element->href . '<br>'; 

// Find all td elements
$counter = 0;
$sqlValues = array();
$arrayCounter = 0;
$number_td = 0;
$useful_tds = 0; 

echo $html;

foreach($html->find('td') as $element0) {
	$number_td++;
}

echo 'Number of TD: ' . $number_td . '</br>';

foreach($html->find('td') as $element) {
	$string = $element->plaintext;
	
	
	if (ereg("\\\$", $string)) {
		//echo $counter . ' - ' . $string . '</br>';
		
		$sqlValues[$arrayCounter] = $string;
		echo "array value: " . $arrayCounter . " - " . $sqlValues[$arrayCounter] . "</br>";
		$arrayCounter++;
	}
}

echo '</br></br> Useful Dollar Values: ' . $arrayCounter;
/*
echo 							'13-14 </br>'.
								$sqlValues[0] .'</br>'.
								
								72
								0	1	2	3
								4	5	6	7
								8	9	10	11	
								12	13	14	15
								
								72
								0=a	1+(x/18)	2+(x/18)	3+(x/18)
								4=a	5	6	7
								8	9	10	11	
								12	13	14	15
								
								54
								0	1	2
								3	4	5
								6	7	8
								9	10	11
								
								32
								0	1
								2	3
								4	5
								6	7
								
								13-14
								72 0+4 
								54 0+3
								36 0+2
								18 0+1
								
								12-13
								72 1+4 
								54 1+3
								36 1+2
								18 1+1
								
								13-14
								72=x 0+(x/18) 
								54=x 0+(x/18)
								36=x 0+(x/18)
								18=x 0+(x/18)
								
								12-13
								72=x 1+(x/18) 
								54=x 1+(x/18)
								36=x 1+(x/18)
								18=x 1+(x/18)
								
								$sqlValues[8] .'</br>'.
								$sqlValues[12] .'</br>'.
								$sqlValues[16] .'</br>'.
								$sqlValues[20] .'</br>'.
								$sqlValues[24] .'</br>'.
								$sqlValues[28] .'</br>'.
								$sqlValues[32] .'</br>'.
								$sqlValues[36] .'</br>'.
								$sqlValues[40] .'</br>'.
								$sqlValues[44] .'</br>'.
								$sqlValues[48] .'</br>'.
								$sqlValues[52] .'</br>'.
								$sqlValues[56] .'</br>'.
								$sqlValues[60] .'</br>'.
								$sqlValues[64] .'</br>'.
								$sqlValues[68] .'</br>';

echo							'12-13</br>'.
								$sqlValues[1] .'</br>'.
								$sqlValues[5] .'</br>'.
								$sqlValues[9] .'</br>'.
								$sqlValues[13] .'</br>'.
								$sqlValues[17] .'</br>'.
								$sqlValues[21] .'</br>'.
								$sqlValues[25] .'</br>'.
								$sqlValues[29] .'</br>'.
								$sqlValues[33] .'</br>'.
								$sqlValues[37] .'</br>'.
								$sqlValues[41] .'</br>'.
								$sqlValues[45] .'</br>'.
								$sqlValues[49] .'</br>'.
								$sqlValues[53] .'</br>'.
								$sqlValues[57] .'</br>'.
								$sqlValues[61] .'</br>'.
								$sqlValues[65] .'</br>'.
								$sqlValues[69] .'</br>';

echo							'11-12 </br>'.
								$sqlValues[2] .'</br>'.
								$sqlValues[6] .'</br>'.
								$sqlValues[10] .'</br>'.
								$sqlValues[14] .'</br>'.
								$sqlValues[18] .'</br>'.
								$sqlValues[22] .'</br>'.
								$sqlValues[26] .'</br>'.
								$sqlValues[30] .'</br>'.
								$sqlValues[34] .'</br>'.
								$sqlValues[38] .'</br>'.
								$sqlValues[42] .'</br>'.
								$sqlValues[46] .'</br>'.
								$sqlValues[50] .'</br>'.
								$sqlValues[54] .'</br>'.
								$sqlValues[58] .'</br>'.
								$sqlValues[62] .'</br>'.
								$sqlValues[66] .'</br>'.
								$sqlValues[70] .'</br>';

echo 							'10-11 </br>'.
								$sqlValues[3] .'</br>'.
								$sqlValues[7] .'</br>'.
								$sqlValues[11] .'</br>'.
								$sqlValues[15] .'</br>'.
								$sqlValues[19] .'</br>'.
								$sqlValues[23] .'</br>'.
								$sqlValues[27] .'</br>'.
								$sqlValues[31] .'</br>'.
								$sqlValues[35] .'</br>'.
								$sqlValues[39] .'</br>'.
								$sqlValues[43] .'</br>'.
								$sqlValues[47] .'</br>'.
								$sqlValues[51] .'</br>'.
								$sqlValues[55] .'</br>'.
								$sqlValues[59] .'</br>'.
								$sqlValues[63] .'</br>'.
								$sqlValues[67] .'</br>'.
								$sqlValues[71] .'</br>';

*/
?>
