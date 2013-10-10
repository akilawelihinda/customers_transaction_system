<?php
$array=$_POST;
if(!array_key_exists("check_submit2", $_POST))
		displayForm($array);
	else{
		processForm($array);
	}
	
	function displayForm($array){
	
		require 'connectToBapaDb.php';
		require 'calculateInterest.php';
	print "<p style=\"color:red;\"><b>Enter the amount the customer is paying(including interest).</b></p>"; 
	print "<form name=\"formName\" action=\"recordPaymentsHalf.php\" method=\"post\" onsubmit=\"return validateForm()\">";
	print "<br><br><table border=\"1\"><th>Item</th><th>Item Value</th><th>Money Borrowed</th><th><p style=\"color:red;\">Interest</p></th><th><p style=\"color:red;\">Amount Payed</p></th><th>Description</th><th>Expected Pay Day</th><th>Transaction Date</th>";
		$counter=0;
		foreach($array as $value)
		{
			if($value=="skipMe" || $value=="Submit")
				continue;
						
			if(!$transactions=$db->query("SELECT * FROM transactions WHERE timeSubmitted=\"$value\" LIMIT 1"))
				die('There was an error connecting to database [' . $db->error . ']');
				$transaction=$transactions->fetch_assoc();
				$expectedDOR=date('d-m-Y', $transaction['expectedDOR']);
				$timeSubmitted=date('d-m-Y', $transaction['timeSubmitted']);
				$secondTime=$transaction['timeSubmitted'];
				$moneyOwed=$transaction['moneyBorrowed'];
				$moneyOwed=calculateInterest($transaction['moneyBorrowed'], $secondTime);
				$moneyBorrowed=$transaction['moneyBorrowed'];
				print <<<BLOCK
				<tr><td>{$transaction['item']}</td> <input type="hidden" name="$secondTime" value="$secondTime"><td>{$transaction['itemValue']}</td><td>$moneyBorrowed</td><td>$moneyOwed</td> <td><input type="text" name="PAID$counter"></td> <td>{$transaction['description']}</td> <td>$expectedDOR</td> <td>$timeSubmitted</td> </tr>
BLOCK;
		$counter++;
		
		}
				

	print <<<HTMLBLOCK
	<input type="hidden" name="check_submit2" value="skipMe"><br><br><input class="submit" type="submit" name="Submit" value="Submit"/></form></table>

	<script>
	function validateForm(){
		for(var x=0; x<$counter; x++)
						{
						var currentIndex="PAID"+x;
						var currentVar=document.forms["formName"][currentIndex].value;
							if((currentVar=="" || currentVar==null) || currentVar==0){
							alert("All fields must be filled out");
							return false;
							}
							
							if(isNaN(currentVar))
							{
							alert("Amount payed is not a valid number");
							return false;
							}
						}
		}
	</script>
HTMLBLOCK;
require 'returnToMenu.php';

	}
	
function processForm($array){
		require 'connectToBapaDb.php';
		require 'calculateInterest.php';
	print "<p style=\"color:red;\"><b>Are you sure you want to save these payments?</b></p>"; 
	print "<form name=\"formName\" action=\"recordPayments2.php\" method=\"post\">";
	print "<br><br><table border=\"1\"><th>Item</th><th>Item Value</th><th>Money Borrowed</th><th><p style=\"color:red;\">Interest</p></th><th><p style=\"color:red;\">Amount Payed</p></th><th>Description</th><th>Expected Pay Day</th><th>Transaction Date</th>";
		$counter=0;
		foreach($array as $key=>$value)
		{
	
			if($value=="skipMe" || $value=="Submit")
				continue;
			if(strpos($key, "AID"))
				continue;
		
			if(!$transactions=$db->query("SELECT * FROM transactions WHERE timeSubmitted=\"$value\" LIMIT 1"))
				die('There was an error connecting to database [' . $db->error . ']');
				$transaction=$transactions->fetch_assoc();
				$expectedDOR=date('d-m-Y', $transaction['expectedDOR']);
				$timeSubmitted=date('d-m-Y', $transaction['timeSubmitted']);
				$secondTime=$transaction['timeSubmitted'];
				$moneyOwed=$transaction['moneyBorrowed'];
				$moneyOwed=calculateInterest($transaction['moneyBorrowed'], $secondTime);
				$moneyBorrowed=$transaction['moneyBorrowed'];
				$payed=str_replace(",", "", $array["PAID$counter"]);
				$payedWithoutInterest=$payed-calculateInterest($transaction['moneyBorrowed'], $secondTime);
				print <<<BLOCK
				<tr><td>{$transaction['item']}</td> <input type="hidden" name="$secondTime" value="$secondTime"><input type="hidden" name="PAID$counter" value="$payedWithoutInterest"><td>{$transaction['itemValue']}</td><td>$moneyBorrowed</td><td>$moneyOwed</td><td>$payed</td> <td>{$transaction['description']}</td> <td>$expectedDOR</td> <td>$timeSubmitted</td> </tr>
BLOCK;
		$counter++;
		
		}
				

	print <<<HTMLBLOCK
	<input type="hidden" name="check_submit2" value="skipMe"><br><br><input class="submit" type="submit" name="Submit" value="Yes"/></form></table>
HTMLBLOCK;
require 'returnToMenu.php';
}
?>