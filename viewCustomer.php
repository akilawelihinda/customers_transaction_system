<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
	function displayForm(){
print <<<BLOCK
<h1>VIEW CUSTOMER:</h1>
<b>Enter ID Number to view customer information and transactions.<br><br></b>
<form name="formName" action="viewCustomer.php" method="post" onsubmit="return validateForm()">
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
	
	if(!$customersInfo=$db->query("SELECT * FROM customerinfo WHERE ID=\"{$licenseID}\" LIMIT 1"))
			die('There was an error connecting to database [' . $db->error . ']');
	$rows=$customersInfo->num_rows;
		if($rows==0)
		{
		print "<p style=\"color:red;\"> There if no customer with ID number \"<b>$licenseID</b>\" registered. If you would like to add a new customer, please go to the menu and click \"Add Customer\"</p>";
		require 'returnToMenu.php';
		}
		
		else
		{
		$customerInfo=$customersInfo->fetch_assoc();
$name=$customerInfo['name'];
$licenseID=$customerInfo['ID'];
$date=$customerInfo['dateRegistered'];
$phoneNumber=$customerInfo['phoneNumber'];
$address=$customerInfo['address'];
$transactions=$customerInfo['transactions'];

	print "<h2>Customer Information</h2><b>Name:</b> $name <br><b>ID Number:</b> $licenseID<br><b>Date Registered: </b>$date<br><b>Phone Number: </b>$phoneNumber<br><b>Address:</b> $address<br> <b>Number of Transactions:</b> $transactions";
	if(!$transactions=$db->query("SELECT * FROM transactions WHERE customerID=\"{$licenseID}\" AND paid='no' ORDER BY timeSubmitted DESC"))
			die('There was an error connecting to database [' . $db->error . ']');
	print "<br><br><table border=\"1\"> <th>Item</th><th>Item Value</th><th>Money Borrowed</th><th>Interest</th><th>Description</th><th>Expected Pay Day</th><th>Transaction Date</th><th>Paid</th>";
	while($transaction=$transactions->fetch_assoc())
	{
	$expectedDOR=date('d-m-Y', $transaction['expectedDOR']);
	$timeSubmitted=date('d-m-Y', $transaction['timeSubmitted']);
	$moneyOwed=calculateInterest($transaction['moneyBorrowed'], $transaction['timeSubmitted']);
	print "<tr><td>{$transaction['item']}</td> <td>{$transaction['itemValue']}</td> <td>{$transaction['moneyBorrowed']}</td> <td>$moneyOwed</td><td>{$transaction['description']}</td> <td>$expectedDOR</td> <td>$timeSubmitted</td> <td>{$transaction['paid']}</td></tr>";
	}
	if(!$transactions=$db->query("SELECT * FROM transactions WHERE customerID=\"{$licenseID}\" AND paid='yes' ORDER BY timeSubmitted DESC "))
			die('There was an error connecting to database [' . $db->error . ']');
			
	while($transaction=$transactions->fetch_assoc())
	{
	$expectedDOR=date('d-m-Y', $transaction['expectedDOR']);
	$timeSubmitted=date('d-m-Y', $transaction['timeSubmitted']);
	print "<tr><td>{$transaction['item']}</td> <td>{$transaction['itemValue']}</td> <td>{$transaction['moneyBorrowed']}</td> <td>-------</td><td>{$transaction['description']}</td> <td>$expectedDOR</td> <td>$timeSubmitted</td> <td>{$transaction['paid']}</td></tr>";
	}
	
	print "</table>";
	require 'returnToMenu.php';
	}
	}
	
?>