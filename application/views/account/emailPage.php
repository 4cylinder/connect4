<!DOCTYPE html>
<html>
<head>
<link href="<?echo base_url();?>css/template.css" rel="stylesheet" type="text/css"/>
</head> 
<body>  
<h1>Password Recovery</h1>
<p>Please check your email for your new password.</p>

<?php 
	if (isset($errorMsg)) {
		echo "<p>" . $errorMsg . "</p>";
	}

	echo "<p>" . anchor('account/index','Login') . "</p>";
?>	
</body>
</html>
