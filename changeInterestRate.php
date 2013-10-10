<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
	function displayForm(){
	require 'connectToBapaDb.php';
	if(!$interestRates=$db->query("SELECT * FROM interest ORDER BY theOrder"))
			die('There was an error connecting to database [' . $db->error . ']');
	while($interestRate=$interestRates->fetch_assoc())
	{
	$rates[$interestRate['theOrder']]=$interestRate['rate']*100;
	}
	print <<<HTMLBLOCK
	<h1>CHANGE INTEREST RATES:</h1>
	<b>Change the interest rates and click submit in order to save the changes.</b><br> <b><p style="color:red;">Enter the interest rates in percentages, not decimals.( Example: Enter 3.0 for a 3% interest rate).</p></b> <br><br>
	<form name="formName" action="changeInterestRate.php" method="post" onsubmit="return validateForm()">
	<b>Below 5,000:</b><br><br>  <input type="text" name="rate1" value="$rates[0]"><br><br>
	<b>5,000-10,000:</b><br><br>  <input type="text" name="rate2" value="$rates[1]"><br><br>
	<b>Above 10,000:</b><br><br>
	7 or less days:	<input type="text" name="rate3" value="$rates[2]"><br><br>
	8 or more days: <input type="text" name="rate4" value="$rates[3]">
	<input type="hidden" name="check_submit" value="1"><br><br>
	<input class="submit" type="submit" name="Submit">
	</form>
	<script>
		function validateForm(){
		var array=new Array();
		array[0]=document.forms["formName"]["rate1"].value;
		array[1]=document.forms["formName"]["rate2"].value;
		array[2]=document.forms["formName"]["rate3"].value;
		array[3]=document.forms["formName"]["rate4"].value;

			for(var x=0; x<array.length; x++)
			{
				if(array[x]=="" || array[x]==null){
				alert("All fields must be filled out.");
				return false;
				}
				
				if(isNaN(array[x])){
				alert("Invalid Number was enterd.");
				return false;
				}
			}
		}
</script>
HTMLBLOCK;
require 'returnToMenu.php';
	}
	
	function processForm(){
	$array=$_POST;
	$postNames= array("rate1", "rate2", "rate3", "rate4");
		require 'connectToBapaDb.php';
	$rateNumber=0;
	while($rateNumber<4)
	{
	$currentRate=$array[$postNames[$rateNumber]]/100;
		if(!$transaction=$db->query("UPDATE interest SET rate=$currentRate WHERE theOrder=\"$rateNumber\""))
			die('There was an error connecting to database [' . $db->error . ']');
	$rateNumber++;
	}
	print "<p style=\"color:green;\">The interest rates have successfully been updated!</p>";
	require 'returnToMenu.php';
	}
?>