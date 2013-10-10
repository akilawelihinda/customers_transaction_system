<?php
print <<<HTMLBLOCK
<b>Email me at akilawelihinda@yahoo.com if you have any questions not covered here.</b><br><br>
<b>Add Customer</b>
<p>To add a customer, click on the "Add Customer" button in the menu. If you try to add a customer that has the same ID number as a currently registered customer, you will get an error. You must fill all the boxes otherwise you cannot add the customer. Make sure to enter the customer ID EXACTLY as it appears on the ID card.</p>
<br><br>
<b>View Customer</b>
<p>To view a customer, you must click on the "View Customer" button in the menu. Then you must enter the ID number of the customer you want to view. If you try to view a customer by entering an ID number that is not currently registered, you will get an error. When you enter the customer's ID number, you can view his or her name, phone number, address, number of transactions, date of registration, and all the information of all the transactions the customer has made in the past.</p>
<br><br>
<b>Update Customer</b>
<p>To update a customer, you must click on the "Update Customer" button in the menu. Then you must enter the ID number of the customer you want to update. If you try to update a customer by entering an ID number that is not currently registered, you will get an error. Once you click 'Submit', then you will see the customer's current information. You may change whichever boxes you want and then click 'Submit'. The customers new information will then be saved.</p>
<br><br>
<b>Add Transaction</b>
<p>To add a transaction to a customer's account, you must click on the "Add Transaction" button in the menu. Then you must enter the ID number of the customer you want to enter the transaction for. You may not enter a transaction for a customer who currently is unregistered, on the block list, or has a overdue unpaid transaction. Once you click 'Submit', then you will need to fill out the information of the transaction. If you enter an invalid price or date, then you will not be allowed to submit the transaction. Once you click 'Submit', then the transaction will be saved under that user's profile. You can view this transaction by clicking on "View Customer" in the menu and entering in the customer's ID number.</p>
<br><br>
<b>Record Payments</b>
<p>When a customer pays you back to settle a debt from a transaction, then you can record this payment by clicking on the "Record Payments" button. You must first enter the ID number of the customer who is paying. Then you will see all of the customer's unpaid transactions. You may select which of the transactions the customer is paying for and then click 'Submit'. Then you must enter the amount of money the customer is paying for each transaction. Once you click 'Submit', the computer will ask you to confirm the payments again. If you click 'Yes', then the payments will be saved. If the customer didnt pay the entire money he owed for a transaction, then a new transaction will automatically be created with the same information as the old transaction, but the "Money Borrowed" column will now contain the amount remaining that the customer has left to pay. The interest of the new transaction will start collecting again as soon as the new transaction is created.</p>
<br><br>
<b>Add to Block List</b>
<p>You may add any customer to the block list for any reason. You may not add an unregistered customer to the block list. You simply go the menu and click on "Add to Block List". Then you must enter the ID number of the customer you wish to add on the block list and click 'Submit'. Then you must enter the reason why the customer is on the block list and then click 'Submit'. Now the customer will be unable to make any future transactions until you remove them from the block list.</p>
<br><br>
<b>View Block List</b>
<p>You may view the block list to see which customers are currently on the block list. Go to the menu and click "View Block List". Then you will see the list of each customer's ID and reason why he/she was added onto the block list. </p>
<br><br>
<b>Remove From Block List</b>
<p>You may remove a customer from the block list in order to allow them to make transactions again. You may not remove a customer from the block list that is not already in the block list. To remove a customer from the block list, go to the menu and click "Remove From Block List". Then enter the ID of the customer that you want to remove from the block list and click 'Submit'. The customer will then be removed from the block list and be allowed to make future transactions.</p>
<br><br>
<b>View Overdue Transactions</b>
<p>You may view the unpaid transactions that have passed their deadline. Any customer on this list will not be able to make transactions because he/she has a overdue, unpaid transaction. Simply click "View Overdue Transactions" in the menu and you will see a list of transactions that haven't been paid and have passed their dealine. Once the transaction is paid by recording the payment, then the transaction will automatically be removed from this list.</p>
<br><br>
<b>Change Interest Rates</b>
<p>You may change the interest rates by clicking on "Change Interest Rates" in the menu. Then you will see the current interest rates and you may change any of them. Please enter the interest rate in percentage(not decimal) otherwise you will get errors. In order to save these changes, click 'Submit'. Now the interest rates you have just entered will automatically be applied to every transaction in the past and the future until you change the interest rates again.</p>
<br><br>
HTMLBLOCK;
require 'returnToMenu.php';
?>