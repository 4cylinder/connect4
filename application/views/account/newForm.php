<!DOCTYPE html>
<html>
<head>
<link href="<?echo base_url();?>css/template.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
function checkPassword() {
	var p1 = $("#pass1"); 
	var p2 = $("#pass2");
	
	if (p1.val() == p2.val()) {
		p1.get(0).setCustomValidity("");  // All is well, clear error message
		return true;
	}	
	else	 {
		p1.get(0).setCustomValidity("Passwords do not match");
		return false;
	}
}
// refresh the image captcha
function refreshCaptcha(){
	var link = "<?= site_url('account/securimage') ?>?";
	link += Math.random();
	$("#captcha").attr("src",link);
}
</script>
</head> 
<body>  
	<h1>Connect 4 Registration</h1>
<?php 
	echo form_open('account/createNew')."\n"; 
	echo form_label('Username')."\n"; 
	echo form_error('username')."\n"; 
	echo form_input('username',set_value('username'),"required maxlength='10'")."\n"; 
	echo form_label('Password')."\n"; 
	echo form_error('password')."\n"; 
	echo form_password('password','',"id='pass1' required")."\n"; 
	echo form_label('Password Confirmation')."\n"; 
	echo form_error('passconf')."\n"; 
	echo form_password('passconf','',"id='pass2' required oninput='checkPassword();'")."\n"; 
	echo form_label('First Name')."\n"; 
	echo form_error('first')."\n"; 
	echo form_input('first',set_value('first'),"required")."\n"; 
	echo form_label('Last Name')."\n"; 
	echo form_error('last')."\n"; 
	echo form_input('last',set_value('last'),"required")."\n"; 
	echo form_label('Email')."\n"; 
	echo form_error('email')."\n"; 
	echo form_input('email',set_value('email'),"required")."\n"; 
	echo form_label("Image Verification")."<br>\n";
	echo form_error('captcha_code')."\n"; 
	echo "<img id='captcha' src='".site_url('account/securimage');
	echo "' alt='CAPTCHA Image'/>\n";
	echo form_input("captcha_code",'',"size='10' maxlength='6'")."\n";
	echo "<a id='refresh' href='#' onClick='refreshCaptcha();'>[Different Image]</a>"."\n";
	echo form_submit('submit', 'Register');
	echo form_close();
?>	
</body>
</html>
