<!DOCTYPE html>
<html>
<head>
<link href="<?echo base_url();?>css/template.css" rel="stylesheet" type="text/css"/>
<link href="<?echo base_url();?>css/board.css" rel="stylesheet" type="text/css"/>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="<?= base_url() ?>js/jquery.timers.js"></script>
<script src="<?= base_url() ?>js/detectWin.js"></script>
<script>
var otherUser = "<?= $otherUser->login ?>";
var user = "<?= $user->login ?>";
var status = "<?= $status ?>";
var playerPiece = "<img src='<?= base_url() ?>images/green.jpg'>";
var opponentPiece = "<img src='<?= base_url() ?>images/red.jpg'>";
// make sure these JQuery functions only fire when all DOM objects have loaded
$(function(){
	// every 2 seconds, use ajax querying for updates
	$('body').everyTime(2000,function(){
		if (status == 'waiting') {
			$.getJSON('<?= base_url() ?>arcade/checkInvitation',function(data, text, jqZHR){
				if (data && data.status=='rejected') {
					alert("Sorry, your invitation to play was declined!");
					window.location.href = '<?= base_url() ?>arcade/index';
				}
				if (data && data.status=='accepted') {
					status = 'playing';
					$('#status').html('Your opponent: ' + otherUser);
					// set current turn to that of the player who started the match
					var url = "<?= base_url() ?>board/setGameState";
					$.post(url,'turn='+user);
				}
					
			});
		}
		// see if there are any new messages
		var url = "<?= base_url() ?>board/getMsg";
		$.getJSON(url, function (data,text,jqXHR){
			if (data && data.status=='success') {
				var conversation = $("[name='conversation']").val();
				var msg = data.message;
				if (msg.length > 0) {
					$("[name='conversation']").val(conversation+"\n"+otherUser+": " +msg);
					// scroll chat box to the bottom
					$("[name='conversation']").scrollTop($("[name='conversation']")[0].scrollHeight);
				}
			}
			
		});
	});
	// every 500 ms, check whose turn it is and reprint the board if necessary
	$('#turn').everyTime(500,'updater',function(){
		// grab the game state via ajax
		var url = "<?= base_url() ?>board/getGameState";
		$.getJSON(url, function (data,text,jqXHR){
			if (data && data.status=='success') {
				// set the turn
				var turn = data.turn;
				// if it's the player's turn, set the font colour to green
				if (turn==user) {
					$('#turn').html("You");
					$('#turn').css('color','green');
				}// if it's the opponent's turn, set the font colour to red
				if (turn==otherUser) {
					$('#turn').html("Opponent");
					$('#turn').css('color','red');
				}
				// get the filled cells (JSON string)
				var filled = JSON.parse(data.filled);
				// populate the filled cells appropriately
				for (var key in filled) {
					$("td[id="+key+"]").val(filled[key]);
					// if it's the player's own cell
					if (filled[key]==user)
						$("td[id="+key+"]").html(playerPiece); 
					else // if it's the opponent's cell
						$("td[id="+key+"]").html(opponentPiece);
				}
				// see if anyone has won the game or if the game tied
				var win = data.win;
				// if so, stop updating the board and alert the player
				if (win){ 
					$('#turn').stopTime('updater');
					if (win==user)
						$('#win').html("You win");
					else if (win==otherUser)
						$('#win').html("You lose");
					else if (win=="tie")
						$('#win').html("Draw");
					$('#turn').html("");
					alert($('#win').html());
				} 
			}
		});
	});
	// reprint the chat box whenever the user sends a message (via POST form)
	$('form').submit(function(){
		var arguments = $(this).serialize();
		var url = "<?= base_url() ?>board/postMsg";
		$.post(url,arguments, function (data,textStatus,jqXHR){
			var conversation = $("[name='conversation']").val();
			var msg = $('[name=msg]').val();
			// make player's username appear green in the chat window
			$("[name='conversation']").val(conversation+"\n"+user+": "+msg);
			// clear the input form field
			$("input[name='msg']").val('');
			// scroll the chat box to the very bottom
			$("[name='conversation']").scrollTop($("[name='conversation']")[0].scrollHeight);
		});
		return false;
	});
	// event handler for clicking on the game's board
	$('td').click(function(){
		// first check to see if it's the user's turn, otherwise exit
		// also if someone won the game, exit
		if ($('#turn').html()!="You" || $('#win').html()=="You win" || $('#win').html()=="You lose")
			return;		
		// coordinates are the ID tag of the table cell
		var position = $(this).attr('id');
		// x-coord is 2nd char, y-coord is 4th char
		var x = position[1];
		var y = position[3];
		// search current column to see if there is space for a piece to "drop"
		var i = 0;
		for (i=0; i<5; i++){
			if ($("#x"+x+'y'+(i+1)).val()!='')
				break;
		}
		// fill in the space
		$("#x"+x+'y'+i).val(user);
		$("#x"+x+'y'+i).html(playerPiece);
		
		// keep track of filled cells
		var filled = {};
		var numFilled = 0;
		// convert the board into an array and JSON it to the controller
		// to save space/time, just get filled cells, not empty ones
		$("td").each(function(){
			if ($(this).val()!="") {
				numFilled++;
				filled[$(this).attr('id')] = $(this).val();
			}
		});
		// see if this current move happens to be a winning move
		var win = "";
		if (checkWin(parseInt(i),parseInt(x),user,filled)){
			win = user;
		} else if (numFilled==42){
			win = "tie";
		}
		// JSON the board and the turn (make it that of other player)
		var url = "<?= base_url() ?>board/setGameState";
		var tmp = JSON.stringify(filled);
		var arguments = {"turn":otherUser, "filled":tmp, "win":win};
		$.post(url,arguments);
	});
});
</script>
</head> 
<body>  
<h1>Game Area</h1>
<div>
Hello <?= $user->fullName() ?>  
</div>
<div id='status'> 
<?php 
	if ($status == "playing")
		echo "Your opponent: " . $otherUser->login;
	else
		echo "Wating on " . $otherUser->login;
?>
</div>
<p> You: <img height="20" width="20" src="<?= base_url() ?>images/green.jpg"/>
Opponent: <img height="20" width="20" src="<?= base_url() ?>images/red.jpg"/>
</p>
Current turn: <span id='turn'></span><br>
<?php
	echo "<table>\n";
	echo "<tr><td>";
	// print out the game board
	echo "<br>\n<table id='game'>\n";
	for ($i=0;$i<6;$i++){
		echo "<tr>";
		for ($j=0;$j<7;$j++){
			echo "<td id='x{$j}y{$i}' value=''></td>";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
	echo "<p align='center'><span id='win'></span></p>";
	echo "</td><td>";
	echo form_textarea('conversation');
	echo form_open();
	echo form_input('msg');
	echo form_submit('Send','Send');
	echo form_close();
	echo "</td></tr></table>";
	echo anchor("arcade", "Back to game lobby")."<br>";
	echo anchor('account/logout','Log out');
?>
</body>
</html>
