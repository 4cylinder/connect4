<!DOCTYPE html>
<html>
<head>
<link href="<?echo base_url();?>css/template.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?= base_url() ?>/js/jquery.timers.js"></script>
<script>
$(function(){
	$('#availableUsers').everyTime(500,function(){
		$('#availableUsers').load('<?= base_url() ?>arcade/getAvailableUsers');
		// show help if there are users available
		if ($('#availableUsers').text().length>2){
			$('#help').html("Click on a username below to invite that player to a match.<br><br>");
		}
		$.getJSON('<?= base_url() ?>arcade/getInvitation',function(data, text, jqZHR){
			if (data && data.invited) {
				var user=data.login;
				var time=data.time;
				if(confirm('Play ' + user)) {
					$.getJSON('<?= base_url() ?>arcade/acceptInvitation',
						function(data, text, jqZHR){
							if (data && data.status == 'success')
								window.location.href = '<?= base_url() ?>board/index';
						});
				} else  
					$.post("<?= base_url() ?>arcade/declineInvitation");
			}
		});
	});
});
</script>
</head> 
<body>  
<h1>Connect 4</h1>
<div> Welcome <?= $user->fullName() ?>  
</div>
<?php 
	if (isset($errmsg)) 
		echo "<p>$errmsg</p>";
?>
<h2>Available Users</h2>
<div id='help'></div>
<div id="availableUsers"></div><br>
<?= anchor('account/logout','Log Out') ?><br>
<?= anchor('account/updatePasswordForm','Change Password') ?>
</body>
</html>
