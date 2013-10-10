<?php
if(!array_key_exists("check_submit", $_POST))
		displayForm();
	else{
		processForm();
	}
	
	function displayForm(){
print <<<BLOCK
<h1>ADD CUSTOMER:</h1>
<b>Enter customer name, ID number, phone number, and address to save customer into database.</b><br><br>
<form name="formName" action="addCustomer.php" method="post" onsubmit="return validateForm()">
Name:  <input type="text" name="name"><br><br>
ID Number:  <input type="text" name="licenseID"><br><br>
Phone Number:	<input type="text" name="phoneNumber"><br><br>
Address:	<input type="text" name="address">
<input type="hidden" name="check_submit" value="1"><br><br>
<input class="submit" type="submit" name="Submit">
</form>

<script>
		function validateForm(){
		var array=new Array();
		array[0]=document.forms["formName"]["name"].value;
		array[1]=document.forms["formName"]["licenseID"].value;
		array[2]=document.forms["formName"]["phoneNumber"].value;
		array[3]=document.forms["formName"]["address"].value;
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
$name=$_POST['name'];
$licenseID=$_POST['licenseID'];
$date=date('m/d/Y', time());
$phoneNumber=$_POST['phoneNumber'];
$address=$_POST['address'];
require 'connectToBapaDb.php';
	
	if(!$license=$db->query("SELECT ID FROM customerinfo WHERE ID=\"{$licenseID}\""))
			die('There was an error connecting to database [' . $db->error . ']');
	$rows=$license->num_rows;
		if($rows>0)
		{
		print "<p style=\"color:red;\">Customer with ID Number $licenseID has already been added</p>";
		require 'returnToMenu.php';
		}
	else
	{
$statement = $db->prepare("INSERT INTO customerinfo VALUES(?, ?, ?, ?, ?, ?)");
$zero=0;
$statement->bind_param('sssssi', $name, $licenseID, $date, $phoneNumber, $address, $zero);
	if(!$statement->execute())
		die('There was an error in submitting this data [' . $statement->error . ']');
print "<p style=\"color:green;\">This customer has been successfully added!</p>";
require 'returnToMenu.php';
}
}
?>