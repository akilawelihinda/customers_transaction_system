<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
function displayForm(){
print <<<BLOCK
<h1>ADD TRANSACTION:</h1>
<b>Enter ID number to add transaction.<br><br></b>
<form name="formName" action="addTransaction.php" method="post" onsubmit="return validateForm()">
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
	$array=$_POST;
	$licenseID=$array['licenseID'];
	$currentTime=time();
	require 'connectToBapaDb.php';
	
	if(!$customersInfo=$db->query("SELECT * FROM customerinfo WHERE ID=\"{$licenseID}\" LIMIT 1"))
			die('There was an error connecting to database [' . $db->error . ']');
		elseif($customersInfo->num_rows==0)
		{
		print "<p style=\"color:red;\"> There if no customer with ID number \"<b>$licenseID</b>\" registered. If you would like to add a new customer, please go to the menu and click \"Add Customer\"</p>";
		require 'returnToMenu.php';	
		}
		
	elseif(!$customersInfo=$db->query("SELECT * FROM blocklist WHERE customerID=\"{$licenseID}\" LIMIT 1"))
			die('There was an error connecting to database [' . $db->error . ']');
	elseif($customersInfo->num_rows>0)
		{
		$customerInfo=$customersInfo->fetch_assoc();
		print "<p style=\"color:red;\">This customer is currently on the block list.<br><br> Reason: {$customerInfo['reason']}</p>";
		require 'returnToMenu.php';
		}
	elseif(!$customersInfo=$db->query("SELECT * FROM transactions WHERE customerID=\"{$licenseID}\" AND expectedDOR<$currentTime AND paid='no'"))
		die('There was an error connecting to database [' . $db->error . ']');
	elseif($customersInfo->num_rows>0)
	{
			print "<p style=\"color:red;\">This customer currently has an overdue transaction and is unable to make a new transaction.</p>";
			require 'returnToMenu.php';
	}
		else
		{
print "<h1>ADD TRANSACTION</h1><h2>Customer ID: $licenseID</h2>";
print "<b>Enter the item, item value, item description, and expected date of release. <br><p style=\"color:red;\">Enter all numbers without commas or spaces.</b></p><br><br>";
print <<<HTMLBLOCK
<form name="formName" action="addTransaction2.php" method="post" onsubmit="return validateForm()">
Item:  <input type="text" name="name"><br><br>
Item Value:  <input type="text" name="itemValue"><br><br>
Money Borrowed:  <input type="text" name="moneyBorrowed"><br><br>
Item Description:<br><textarea name="description" rows=4 cols=30></textarea><br><br>
Expected Date of Release: <input type="text" name="expectedDOR"> (Enter in format DD-MM-YYYY)<br><br>
<input type="hidden" name="ID" value="$licenseID">
<input type="hidden" name="check_submit" value="1"><br><br>
<input class="submit" type="submit" name="Submit"/>
</form>

<script>
		function validateForm(){
		var array=new Array();
		array[0]=document.forms["formName"]["name"].value;
		array[1]=document.forms["formName"]["itemValue"].value;
		array[2]=document.forms["formName"]["description"].value;
		array[3]=document.forms["formName"]["expectedDOR"].value;
		array[4]=document.forms["formName"]["moneyBorrowed"].value;
			for(var x=0; x<array.length; x++)
			{
				if(array[x]=="" || array[x]==null){
				alert("All fields must be filled out");
				return false;
				}
			}
			if(isNaN(document.formName.itemValue.value))
			{
			alert("Item Value must be a number");
			return false;
			}
			if(isNaN(document.formName.moneyBorrowed.value))
			{
			alert("Money Borrowed must be a number");
			return false;
			}
				if(!validatedate(document.formName.expectedDOR))
				{
					alert("Invalid date format");
					return false;
				}
		}
</script>
<script src="mmddyyyy-validation.js"></script>
HTMLBLOCK;
require 'returnToMenu.php';
}
}
	
?>