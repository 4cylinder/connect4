<!DOCTYPE html>
<html>
<head>
<link href="<?echo base_url();?>css/template.css" rel="stylesheet" type="text/css"/>
</head> 
<body>  
	<h1>Recover Password</h1>
<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}

	echo form_open('account/recoverPassword');
	echo form_label('Email'); 
	echo form_error('email');
	echo form_input('email',set_value('email'),"required");
	echo form_submit('submit', 'Recover Password');
	echo form_close();
?>	
</body>
</html>
