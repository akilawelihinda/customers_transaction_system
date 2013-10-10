<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
	function displayForm(){
print <<<BLOCK
<h1>RECORD PAYMENTS:</h1>
<b>Enter ID Number to record payment.<br><br></b>
<form name="formName" action="recordPayments.php" method="post" onsubmit="return validateForm()">
ID Number:  <input type="text" name="licenseID"><br><br>
<input type="hidden" name="check_submit" value="1">
<input class="submit" type="submit" name="Submit">
</form>

<script>
		function validateForm(){
		var array=new Array();
		array[0]=document.forms["formName"]["licenseID"].value;
			for(var x=0; x<array.length; x++)
			{
				if(array[x]=="" || array[x]==null){
				alert("All fields must be filled out");
				return false;
				}
			}
		}
</script>
BLOCK;
require 'returnToMenu.php';
	}
	
	function processForm(){
	require 'calculateInterest.php';
	$array=$_POST;
	$licenseID=$array['licenseID'];
	require 'connectToBapaDb.php';
		if(!$transactions=$db->query("SELECT * FROM customerinfo WHERE ID=\"$licenseID\""))
			die('There was an error in recording this payment [' . $db->error . ']');
		elseif($transactions->num_rows==0)
		{
			print "<p style=\"color:red;\">The customer with ID number \"<b>$licenseID</b>\" is not a registered customer. If you wish to add a customer, click on the \"Add Customer\" link.</p>";
			require 'returnToMenu.php';
		}
		elseif(!$transactions=$db->query("SELECT * FROM transactions WHERE customerID=\"$licenseID\" AND paid='no'"))
			die('There was an error in recording this payment [' . $db->error . ']');
		elseif($transactions->num_rows==0)
		{
			print "<p style=\"color:red;\">The customer with ID number \"<b>$licenseID</b>\" currently has no unpaid transactions.</p>";
			require 'returnToMenu.php';
		}
		else{
	print  "<h1>RECORD PAYMENTS:</h1>";
	print "<b>Choose transactions to record payments</b>";
	print "<form name=\"formName\" action=\"recordPaymentsHalf.php\" method=\"post\">";

	print "<br><br><table border=\"1\"> <th>Select</th><th>Item</th><th>Item Value</th><th>Money Borrowed</th><th><p style=\"color:red;\">Interest</p></th><th>Description</th><th>Expected Pay Day</th><th>Transaction Date</th>";
	while($transaction=$transactions->fetch_assoc())
	{
	$expectedDOR=date('d-m-Y', $transaction['expectedDOR']);
	$timeSubmitted=date('d-m-Y', $transaction['timeSubmitted']);
	$secondTime=$transaction['timeSubmitted'];
	$moneyOwed=$transaction['moneyBorrowed'];
	$moneyOwed=calculateInterest($transaction['moneyBorrowed'], $secondTime);
	$moneyBorrowed=$transaction['moneyBorrowed'];
	print <<<BLOCK
	<tr><td><input type="checkbox" name="$secondTime" value="$secondTime"></td><td>{$transaction['item']}</td> <td>{$transaction['itemValue']}</td><td>$moneyBorrowed</td><td>$moneyOwed</td> <td>{$transaction['description']}</td> <td>$expectedDOR</td> <td>$timeSubmitted</td> </tr>
BLOCK;
	}
	print <<<HTMLBLOCK
	<input type="hidden" name="check_submit" value="skipMe"><br><br><input class="submit" type="submit" name="Submit"/></form></table>
HTMLBLOCK;
require 'returnToMenu.php';
	}
	}
	
?>