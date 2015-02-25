<?php if(isset($_GET['no'])){$no_of_players = $_GET['no'];}else{$no_of_players = 6;}?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Bowling</title>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
a:link{color:black;}a:visited{color:black;}
</style>
</head>
<script type="text/javascript">
var currentFrame = 0;
var currentPlayer = 0;
var currentGo = 0;
function changePlayerName(playerID) {
	var newName = prompt("Please enter a new name:", '');
	if(newName != '') {
		document.getElementById(playerID + '-name').innerHTML = newName;
	}
	else {
		alert('Please enter a valid string for a player name');
	}
}

function getPlayerName(playerID) {
	return document.getElementById(playerID + '-name').innerHTML;
}
function setScore(score) {
	disableAllButtons();
	if(currentGo == 1) {
		var subFrame = 'a';
	}
	if(currentGo == 2) {
		var subFrame = 'b';
	}
	if(currentGo == 3) {
		var subFrame = '3';
	}
	//alert(currentPlayer + '-' + currentFrame + subFrame);
	if(score == 'strike') {
		document.getElementById(currentPlayer + '-' + currentFrame + subFrame).innerHTML = 'X';
		document.getElementById(currentPlayer + '-' + currentFrame + subFrame + '-field').value = 'X';
	}
	else if(score == 'spare') {
		document.getElementById(currentPlayer + '-' + currentFrame + subFrame).innerHTML = '/';
		document.getElementById(currentPlayer + '-' + currentFrame + subFrame + '-field').value = '/';
	}
	else {
		document.getElementById(currentPlayer + '-' + currentFrame + subFrame).innerHTML = parseInt(score);
		document.getElementById(currentPlayer + '-' + currentFrame + subFrame + '-field').value = parseInt(score);
	}
	drawScores();

	if(currentFrame < 10 && (currentGo == 2 || score == 'strike')) {
		if(currentPlayer == <?php echo $no_of_players;?>){
			currentPlayer = 1;
			currentFrame++;
		}
		else {
			currentPlayer++;
		}
		currentGo = 1;
	}
	else if((currentFrame < 10 && currentGo == 1) || (currentFrame == 10 && currentGo < 3)) {
		if(score == 'strike') {
			currentPlayer++;
		}
		else {
			currentGo++;
		}
	}
	askForInput();
}
function startGame() {
	document.getElementById('btnStartGame').disabled = true;
	currentFrame = 1;
	currentPlayer = 1;
	currentGo = 1;
	askForInput();
}
function askForInput() {	
	document.getElementById('playerInfo').innerHTML = 'Enter score for ' + getPlayerName(currentPlayer) + ' frame ' + currentFrame + ' go ' + currentGo;	
	setScoreButtons(parseInt(document.getElementById(currentPlayer + '-' + currentFrame + 't-field').value), false);
}
function setScoreButtons(currentFrameTotal, state) {
	document.getElementById('btn0').disabled = state;
	for(i = 9; i >0; i--) {
		if(currentFrameTotal < i) {
			var elementID = 'btn' + (10-i);
			//alert(elementID);
			document.getElementById(elementID).disabled = state;	
		}
	}
	
	if(currentGo == 1) {
		document.getElementById('btnStrike').disabled = state;
	}
	else {
		document.getElementById('btnSpare').disabled = state;
	}
	
}
function disableAllButtons() {
	document.getElementById('btn0').disabled = true;
	document.getElementById('btn1').disabled = true;
	document.getElementById('btn2').disabled = true;
	document.getElementById('btn3').disabled = true;
	document.getElementById('btn4').disabled = true;
	document.getElementById('btn5').disabled = true;
	document.getElementById('btn6').disabled = true;
	document.getElementById('btn7').disabled = true;
	document.getElementById('btn8').disabled = true;
	document.getElementById('btn9').disabled = true;
	document.getElementById('btnStrike').disabled = true;
	document.getElementById('btnSpare').disabled = true;
}
function drawScores() {
	for(i=1; i<<?php echo $no_of_players;?>+1; i++) {
		document.getElementById(i + '-total-field').value = 0;
		for(k=1; k<11; k++) {
			if(document.getElementById(i + '-' + k + 'a-field').value == 'X') {
				var a = 10;
				var b = 0;
			}
			else {
				var a = parseInt(document.getElementById(i + '-' + k + 'a-field').value);
				if(document.getElementById(i + '-' + k + 'b-field').value == '/') {
					var b = 10 - a;
				}
				else {
					var b = parseInt(document.getElementById(i + '-' + k + 'b-field').value);
				}
			}
			document.getElementById(i + '-' + k + 't-field').value = a+b;
			if(k ==10) {
				document.getElementById(i + '-' + k + 't-field').value = parseInt(document.getElementById(i + '-' + k + 't-field').value) + parseInt(document.getElementById(i + '-' + k + 'c-field').value);
				document.getElementById(i + '-' + k + 'c').innerHTML = document.getElementById(i + '-' + k + 'c-field').value;
			}
			document.getElementById(i + '-' + k + 'a').innerHTML = document.getElementById(i + '-' + k + 'a-field').value;
			document.getElementById(i + '-' + k + 'b').innerHTML = document.getElementById(i + '-' + k + 'b-field').value;
			document.getElementById(i + '-' + k + 't').innerHTML = document.getElementById(i + '-' + k + 't-field').value;
		document.getElementById(i + '-total-field').value = parseInt(document.getElementById(i + '-total-field').value) + parseInt(document.getElementById(i + '-' + k + 't-field').value);
		document.getElementById(i + '-' + 'total').innerHTML = document.getElementById(i + '-' + 'total-field').value;
		}
	}
}
</script>
<body>
<table id='scoreTable' class="tg">
<tbody>
	<tr>
    	<th>Player</th>
        <th colspan="2">1</th>
        <th colspan="2">2</th>
        <th colspan="2">3</th>
        <th colspan="2">4</th>
        <th colspan="2">5</th>
        <th colspan="2">6</th>
        <th colspan="2">7</th>
        <th colspan="2">8</th>
        <th colspan="2">9</th>
        <th colspan="3">10</th>
        <th>Total</th>
    </tr>
<?php
for ($i=1; $i<$no_of_players+1; $i++)
{
        echo '<tr>';
        echo '<td rowspan="2"><a id="' . $i . '-name" href="#" onClick="changePlayerName(' . $i . ');">Player ' . $i . '</a></td>';
        for($k=1; $k<11; $k++)
        {
                echo '<td id="' . $i . '-' . $k . 'a">0</td>';
				echo '<input id="' . $i . '-' . $k . 'a-field" type="hidden" value=0>';
                echo '<td id="' . $i . '-' . $k . 'b">0</td>';
				echo '<input id="' . $i . '-' . $k . 'b-field" type="hidden" value=0>';
				if($k==10)
				{
					echo '<td id="' . $i . '-' . $k . 'c">0</td>';
					echo '<input id="' . $i . '-' . $k . 'c-field" type="hidden" value=0>';	
				}
        }
		echo '<td id="' . $i . '-total">0</td>';
		echo '<input id="' . $i . '-total-field" type="hidden" value="0">';
        echo '</tr>';
        echo '<tr>';
        for($k=1; $k<11; $k++)
        {
                echo '<td id="' . $i . '-' . $k . 't" colspan="';
				if($k==10){echo '3';}else{echo '2';}
				echo '">0</td>';
				echo '<input id="' . $i . '-' . $k . 't-field" type="hidden" value=0>';
        }
}
?>
</tbody></table>
<input id="btnStartGame" type="button" value="Start Game" onClick="startGame();">
<span id="playerInfo"></span>
<table>
    <tr>
        <td><input type="button" value="0" id="btn0" onClick="setScore(0);" disabled="true"></td>
        <td><input type="button" value="1" id="btn1" onClick="setScore(1);" disabled="true"></td>
        <td><input type="button" value="2" id="btn2" onClick="setScore(2);" disabled="true"></td>
        <td><input type="button" value="3" id="btn3" onClick="setScore(3);" disabled="true"></td>
        <td><input type="button" value="4" id="btn4" onClick="setScore(4);" disabled="true"></td>
        <td><input type="button" value="5" id="btn5" onClick="setScore(5);" disabled="true"></td>
        <td><input type="button" value="6" id="btn6" onClick="setScore(6);" disabled="true"></td>
        <td><input type="button" value="7" id="btn7" onClick="setScore(7);" disabled="true"></td>
        <td><input type="button" value="8" id="btn8" onClick="setScore(8);" disabled="true"></td>
        <td><input type="button" value="9" id="btn9" onClick="setScore(9);" disabled="true"></td>
        <td><input type="button" value="x" id="btnStrike" onClick="setScore('strike');" disabled="true"></td>
        <td><input type="button" value="/" id="btnSpare" onClick="setScore('spare');" disabled="true"></td>
    </tr>
</table>
</body>
</html>
