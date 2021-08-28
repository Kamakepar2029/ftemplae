<?php
session_start();
if (isset($_SESSION["logged"])){
	$token = '1933282784:AAGnMBeoAC81hLM-PJmxRjr39H7mnTq6F9E';
	function sendMessage($chat_id, $msg, $token){
		$sendToTelegram = file_get_contents(("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text=".urlencode($msg)),"r");
	}
	if (isset($_GET["action"])){
		if ($_GET['action'] == 'get_messages'){
			$scd = scandir('chats');
			$all = json_encode($scd);
			$read = [];
			foreach ($scd as $a){
				if ($a != '.' and $a != '..'){
					$gf = json_decode(file_get_contents('chats/'.$a));
					$mg = [
						"userid" => str_replace('.json','', $a),
						"lastmsg" => $gf[count($gf)-1]
					];
					$read[count($read)] = $mg;
				}
			}
			echo json_encode($read);
		}elseif($_GET['action'] == 'send_msg'){
			if (isset($_POST["msg"])){
				$rt = (file_get_contents('chats/'.$_POST["chatid"].'.json'));
			if ($rt){
				$rt = json_decode($rt);
				$msgarr = [
					"from" => "me",
					"message" => $_POST["msg"],
					"user_name" => 'My Bot'
				];
				$rt[count($rt)] = $msgarr;
				file_put_contents('chats/'.$_POST["chatid"].'.json', json_encode($rt));
				sendMessage($_POST["chatid"], $_POST["msg"], $token);
			}else{
				$rt = [];
				$msgarr = [
					"from" => "me",
					"message" => $_POST["msg"],
					"user_name" => 'My Bot'
				];
				$rt[count($rt)] = $msgarr;
				file_put_contents('chats/'.$_POST["chatid"].'.json', json_encode($rt));
			}
			}
		}elseif($_GET['action'] == 'get_msgs'){
			echo file_get_contents('chats/'.$_GET["userid"].'.json');
		}elseif($_GET["action"] == 'script_main'){
			?>
			var timerId = 'me';

			function el(iig){
					return document.getElementsByClassName(iig)[0];
			}

			function display_me_id(uid, ef){
					var timerId = setInterval(() => mmmmmj(), 8000);
					el('topbar').innerHTML = `<i class="fa fa-arrow-left" aria-hidden="true" onclick="show_all();"></i> `+ef.getElementsByClassName('name')[0].innerText;
					el('botbar').innerHTML = `
							<div class="botbar_m_messages">
									<div class="botbar_m_messages_y"></div>
									<div class="botbar_m_messages_lines">
											<input class="botbar_messages_input" placeholder="Enter message"><i class="fa fa-paper-plane" aria-hidden="true" onclick="sendmsg_f();"></i>
									</div>
							</div>
					`;
					el('botbar_m_messages_y').innerHTML = '';
					el('topbar').setAttribute('userid', uid);
					let ru = JSON.parse(r.get('?action=get_msgs&userid='+uid));
					for (let t in ru){
							let rt = ru[t];
							let rty = document.createElement('div');
							rty.className = 'botbar_m_messages_y_'+rt["from"];
							rty.innerHTML = `<div class="from_msg_i_id_f">`+rt["user_name"]+`</div><div class="from_msg_i_text_f">`+rt["message"]+`</div>`;
							el('botbar_m_messages_y').append(rty);
							rty.scrollIntoView(false);
					}
			}

			function display_m_id(uid){
					el('botbar_m_messages_y').innerHTML = '';
					el('topbar').setAttribute('userid', uid);
					let ru = JSON.parse(r.get('?action=get_msgs&userid='+uid));
					for (let t in ru){
							let rt = ru[t];
							let rty = document.createElement('div');
							rty.className = 'botbar_m_messages_y_'+rt["from"];
							rty.innerHTML = `<div class="from_msg_i_id_f">`+rt["user_name"]+`</div><div class="from_msg_i_text_f">`+rt["message"]+`</div>`;
							el('botbar_m_messages_y').append(rty);
							rty.scrollIntoView(false);
					}
			}
			
			function mmmmmj(){
				console.log('man');
				display_m_id(el('topbar').getAttribute('userid'));
			}

			function getRandomColor() {
				var letters = '0123456789ABCDEF';
				var color = '#';
				for (var i = 0; i < 6; i++) {
					color += letters[Math.floor(Math.random() * 16)];
				}
				return color;
			}

			var r = new Tcp;
			let dc = JSON.parse(r.get('?action=get_messages'));
			let botbars = document.getElementsByClassName('botbar')[0];
			botbars.innerHTML = '';
			for (let k in dc){
					let dv = document.createElement('div');
					dv.className = 'botbar_users '+dc[k]["lastmsg"]["from"];
					dv.setAttribute('userid', dc[k]["userid"]);
					dv.innerHTML = `<div class="logo"><div class="logo_img" style="background-color: `+getRandomColor()+` ;color:white;">`+dc[k]["lastmsg"]["user_name"][0]+`</div></div>
					<div class="name_text">
			<div class="name">
					`+dc[k]["lastmsg"]["user_name"]+`
			</div>
			<div class="usid">Userid: `+dc[k]["userid"]+`</div>
			<div class="text">
					`+dc[k]["lastmsg"]["message"]+`
			</div></div>`;
					dv.onclick = function(){
							display_me_id(dc[k]["userid"], this);
					}
					botbars.append(dv);
			}

			function sendmsg_f(){
					let msg = el('botbar_messages_input').value;
					if (msg){
							let user_id = el('topbar').getAttribute('userid');
							r.post('?action=send_msg',{"msg":msg, "chatid":user_id});
							display_m_id(user_id);
							el('botbar_messages_input').value = '';
					}else{
							alert('Поле не может быть пустым');
					}
			}

			function show_all(){
				el('topbar').innerHTML = 'Telegram Adminpanel';
				let dc = JSON.parse(r.get('?action=get_messages'));
			let botbars = document.getElementsByClassName('botbar')[0];
			botbars.innerHTML = '';
			for (let k in dc){
					let dv = document.createElement('div');
					dv.className = 'botbar_users '+dc[k]["lastmsg"]["from"];
					dv.setAttribute('userid', dc[k]["userid"]);
					dv.innerHTML = `<div class="logo"><div class="logo_img" style="background-color: `+getRandomColor()+` ;color:white;">`+dc[k]["lastmsg"]["user_name"][0]+`</div></div>
					<div class="name_text">
			<div class="name">
					`+dc[k]["lastmsg"]["user_name"]+`
			</div>
			<div class="usid">Userid: `+dc[k]["userid"]+`</div>
			<div class="text">
					`+dc[k]["lastmsg"]["message"]+`
			</div></div>`;
					dv.onclick = function(){
							display_me_id(dc[k]["userid"], this);
					}
					botbars.append(dv);
			}
			 clearInterval(timerId);
			}
			<?php	
		}elseif($_GET['action'] == 'script_tcp'){
			?>
			class Tcp{
				get(url){
								let xhr = new XMLHttpRequest();
								xhr.open('GET', url, false);
								xhr.send();
								if (xhr.status != 200) {
										return 'When loading got error. Error status: '+String(xhr.status);
								} else {
										return( xhr.responseText );
								}
						}

				post(url, jsonmass){
								let xhr = new XMLHttpRequest();
								let index = 0;
								let body = '';
								for (let k in jsonmass){
										if (index == 0){
												body += k+'='+encodeURIComponent(jsonmass[k]);
										}else{
												body += '&'+k+'='+encodeURIComponent(jsonmass[k]);
										}
										index+=1;
								}
						
								xhr.open("POST", url, false);
								xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
						
								xhr.onreadystatechange = function(){return xhr.responseText};
								xhr.send(body);
								return xhr.responseText;
						}
		}
			<?php
		}else{
			echo "Command not found";
		}
	}else{
		?>
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8">
			<title>Administration</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
			<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
			<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
			<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
			<link rel="manifest" href="/site.webmanifest">
			<style>
			@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&display=swap');
			body {
				background: #1a1f25;
				font-family: "Roboto", sans-serif;
				display: flex;
				align-items: center;
				justify-content: center;
				height: 100%;
				width: 100%;
				margin: 0px;
				flex-direction:column;
			}

			.chat {
					height: 100%;
					max-width: 500px;
					width: 100%;
					display: flex;
					flex-direction: column;
			}

			.topbar {
					background: #4f719b;
					padding: 15px 20px;
					font-size: 20px;
					border-bottom:1px solid #ced0d4;
			}

			.from_msg_i_id_f {
					font-weight:bold;
			}

			.botbar {
					width: 100%;
					flex-grow: 1;
					background: #ffffff;
			}

			*{
				font-family: "Roboto", sans-serif;
				color:white;
			}

			html {
					height: 100%;
					width: 100%;
			}

			.botbar_users {
					background: white;
					display: flex;
					width: calc(100% - 40px);
					padding: 10px 20px;
					border-bottom: 1px solid #f4f4f4;
					color: black;
					align-items: center;
					cursor: pointer;
			}

			.botbar_users *{
				color:black;
			}

			.botbar_users > .name_text {
					flex-grow: 1;
					padding-left: 20px;
			}

			.botbar_users > .logo > .logo_img {
					font-size: 35px;
					height: 50px;
					width: 50px;
					display: flex;
					align-items: center;
					justify-content: center;
					border-radius: 50%;
			}

			.usid {
					margin-bottom: 8px;
			}

			.botbar_users > .name_text > .name {
					font-weight: bold;
					margin-bottom: 8px;
			}

			.botbar_users > .name_text > .text {
					width: 100%;
					overflow: hidden;
					color: #909091;
			}

			.botbar_users.user {
					background: #ff000045;
			}

			.topbar > i {
					padding: 5px 10px;
					margin-right: 20px;
			}

			.botbar_m_messages {
					height: 100%;
					width: 100%;
					display: flex;
					flex-direction: column;
			}

			.botbar_m_messages_y {
					flex-grow: 1;
					background: #22272a;
					overflow: auto;
					height: 100px;
			}

			.botbar_m_messages_lines {
					padding: 10px;
					background: white;
					display: flex;
			}

			.botbar_m_messages_lines > * {
					color: gray;
			}

			input.botbar_messages_input {
					flex-grow: 1;
					padding: 10px 10px;
					outline: none;
					border: none;
					border-bottom: 1px solid;
			}

			.botbar_m_messages_lines > i {
					padding: 5px;
					background: none;
					width: 30px;
					color: black;
					height: 30px;
					display: flex;
					align-items: center;
					justify-content: center;
					border-radius: 50%;
					cursor: pointer;
			}

			.botbar_m_messages_lines > i:hover {
					background: #dedede;
			}

			.botbar_m_messages_y_user {
					width: 70%;
					margin: 10px;
					background: #6851e8;
					padding: 10px;
					border-radius: 15px 15px 15px 0px;
					float: left;
			}

			.botbar_m_messages_y_me {
					width: 70%;
					margin: 10px;
					background: #e85151;
					padding: 10px;
					border-radius: 15px 15px 0px 15px;
					float: right;
			}
			</style>
			</head>
			<body>
				<div class="chat">
					<div class="topbar">
						Telegram Adminpanel
					</div>
					<div class="botbar">
					</div>
				</div>
			<script src="?action=script_tcp"></script>
			<script src="?action=script_main"></script>
			</body>
			</html>
		<?php
	}
}else{
	if (isset($_POST["submit"])){
		$username = $_POST["username"];
		$pass = $_POST["password"];
		if ($username and $pass){
			if ($username == 'admin' and $pass == ''){
				$_SESSION["logged"] = 'Logged in!';
			}else{
				?>
				<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8">
			<title>Error</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<style>
			@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&display=swap');
			body {
				background: #1a1f25;
				font-family: "Roboto", sans-serif;
				display: flex;
				align-items: center;
				justify-content: center;
				height: 100%;
				width: 100%;
				margin: 0px;
				flex-direction:column;
			}

			*{
				font-family: "Roboto", sans-serif;
				color:white;
			}

			html {
					height: 100%;
					width: 100%;
			}
			</style>
			</head>
			<body>
				<h1>Error logging in. Credentials are not right</h1>
				<br><a class="color:#e6b333;" href="">Login again</a>
			</body>
			</html>
				<?php
			}
		}else{
			?>
			<!DOCTYPE html>
			<html>
			<head>
			<meta charset="utf-8">
			<title>Error</title>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<style>
			@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&display=swap');
			body {
				background: #1a1f25;
				font-family: "Roboto", sans-serif;
				display: flex;
				align-items: center;
				justify-content: center;
				height: 100%;
				width: 100%;
				margin: 0px;
				flex-direction:column;
			}

			*{
				font-family: "Roboto", sans-serif;
				color:white;
			}

			html {
					height: 100%;
					width: 100%;
			}
			</style>
			</head>
			<body>
				<h1>Error logging in. Some fileds are empty</h1>
				<br><a class="color:#e6b333;" href="">Login again</a>
			</body>
			</html>
			<?php
		}
	}else{
	?>
	<!DOCTYPE html>
	<html>
		<head>
		 <meta charset="utf-8">
		 <title>Sign in</title>
		 <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,700;1,100;1,300;1,400;1,700&display=swap');
body {
	  background: #1a1f25;
		font-family: "Roboto", sans-serif;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    margin: 0px;
}

*{
	font-family: "Roboto", sans-serif;
}

html {
    height: 100%;
    width: 100%;
}

form.form {
    max-width: 300px;
    width: 100%;
    display: flex;
    flex-direction: column;
}

.label {
    float: left;
    color: white;
    font-size: 1.3em;
}

input.inp {
    background: transparent;
    border: 2px solid #22272d;
    color: #e6b333;
    padding: 10px 20px;
    margin-top: 7px;
    margin-bottom: 7px;
}

input[type="submit"] {
    background: #e6b333;
    border: none;
    color: white;
    text-align: center;
    font-size: 0.8em;
    cursor: pointer;
    width: 100%;
    padding: 5px;
    height: 40px;
    border-radius: 3px;
    margin: 5px 0;
    outline: none;
}

input.inp:focus {
    outline: none;
    border: 2px solid #e6b333;
}
		</style>
		</head>
		<body>
			<form class="form" method="POST">
				<div class="label">Sign in</div>
				<input name="username" class="inp" type="text" value="" placeholder="Enter username">
				<input name="password" class="inp" type="password" value="" placeholder="Enter password">
				<input name="submit" value="Login" type="submit">
			</form>
		</body>
	</html>
	<?php
	}
}
?>