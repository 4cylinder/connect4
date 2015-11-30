<!DOCTYPE html>
<html>
<head>
<link href="<?echo base_url();?>css/template.css" rel="stylesheet" type="text/css"/>
</head> 
<body>  
<h1>Connect 4 Login</h1>
<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}

	echo form_open('account/login');
	echo form_label('Username'); 
	echo form_error('username');
	echo form_input('username',set_value('username'),"required maxlength='10'");
	echo form_label('Password'); 
	echo form_error('password');
	echo form_password('password','',"required");
	
	echo form_submit('submit', 'Login');
	
	echo "<p>".anchor('account/newForm','Create Account')." | ";
	echo anchor('account/recoverPasswordForm','Recover Password')."</p>";
	echo form_close();
?>
<h2>Game Rules</h2>
<p>The game is played with 2 players using a board with 6 rows and 7 columns. 
Each player moves by dropping a piece down one of the columns. 
The piece drops to the lowest unoccupied spot in that column. 
The first player to get 4 pieces in a row (vertically, horizontally, or diagonally) wins. 
The game ends in a draw if the entire board is filled up with neither player getting four
pieces in a row.
</body>
<p>Examples of winning combinations:<br>
<img src="<?= base_url()?>images/vertical.png"/>
<img src="<?= base_url()?>images/horizontal.png"/>
<img src="<?= base_url()?>images/diagonal.png"/>
</p>

</html>
