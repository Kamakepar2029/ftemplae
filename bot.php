<?php
include_once('telegrambot.php');
$token = "1933282784:AAGnMBeoAC81hLM-PJmxRjr39H7mnTq6F9E";
$users = [
	"1816299800" => [
			"admin" => "yes",
			"userid" => "1816299800"
		],
	"1966135285" => [
			"admin" => "yes",
			"userid" => "1966135285"
		],
];
if ($msg == '/about'){
	if ($username){
		sendMessage($chatid, 'Hello, <b>'.$name."</b>\nYour username: ".$username."\nId: ".$chatid,$token);
	}else{
		sendMessage($chatid, 'Hello, <b>'.$name."</b>\nYour username: None\nId: ".$chatid,$token);
	}
}
elseif($msg == '/start'){
	sendMessage_keyboard($chatid, "Здравствуйте, я бот помощник по удалению материала.\nЕсли вы тут, значит ваш менеджер позволил Вам удалить свой материал, так как наш проект дает второй шанс, и считает что вы оступились по ошибке, искренне надеемся что получив этот урок вы более не будете себя продавать и не попадете в злые руки.\nЕсли вы не пожелаете удалить материал, значит ваш менеджер ошибся в вас и вы не дорожите своей конфиденциальностью и достойны публикации и постов автоматическом режиме.\nВы получите ссылку после того как менеджер даст полномочия на архив и будет публикация всего материала\nВы можете воспользоваться меню ниже 🔽",$token, [new_keyboard("🗑 Удалить материал"),new_keyboard("👨‍👧‍👦 О нас"),new_keyboard("🧑‍💻 Диспетчер")]);
}
elseif($msg == '/get_lines'){
	if ($users[$chatid]["admin"] == 'yes'){
		sendMessage($chatid, get_all_lines(),$token);
	}
}
elseif($msg == '🗑 Удалить материал'){
	/*sendMessage_keyboard($chatid, "Вы можете удалить материал двумя алгоритмами:\n1. Полное удаление без возможности восстановить материал стоимость разовая 1400Eu.\n2.Без удаления материала, но предотвращение рассылки друзьям, родственникам и коллегам, стоимость 700Eu.",$token, [
		new_keyboard("1. ❌🗑 Полное удаление!"),
		new_keyboard("2. ❌🛍Частичное удаление!"),
		[new_keyboard("Назад", $ex='me'), new_keyboard("Главное меню", $ex='me')]
		]);*/
	sendMessage_keyboard($chatid, "Напишите в одном сообщении 3 причины по которым вы считаете что достойны получить полное удаление материала и нажмите отправить, ответ ваш увидит менеджер.", $token, [new_keyboard("🚫 Отмена")]);
	file_put_contents($chatid.'.json', 'active');
}
elseif($msg == '🚫 Отмена'){
	sendMessage_keyboard($chatid, 'Главное меню',$token, [new_keyboard("🗑 Удалить материал"),new_keyboard("👨‍👧‍👦 О нас"),new_keyboard("🧑‍💻 Диспетчер")]);
	file_put_contents($chatid.'.json', '');
}
elseif($msg == 'Удалить материал'){
	sendMessage_keyboard($chatid, "Вы можете удалить материал двумя алгоритмами:\n1. Полное удаление без возможности восстановить материал стоимость разовая 1400Eu.\n2.Без удаления материала, но предотвращение рассылки друзьям, родственникам и коллегам, стоимость 700Eu.",$token, [
		new_keyboard("1. ❌🗑 Полное удаление!"),
		new_keyboard("2. ❌🛍Частичное удаление"),
		[new_keyboard("Назад", $ex='me'), new_keyboard("Главное меню", $ex='me')]
		]);
}
elseif($msg == 'Главное меню'){
	sendMessage_keyboard($chatid, 'Главное меню',$token, [new_keyboard("🗑 Удалить материал"),new_keyboard("👨‍👧‍👦 О нас"),new_keyboard("🧑‍💻 Диспетчер")]);
}
elseif($msg == 'Назад'){
	sendMessage_keyboard($chatid, 'Главное меню',$token, [new_keyboard("🗑 Удалить материал"),new_keyboard("👨‍👧‍👦 О нас"),new_keyboard("🧑‍💻 Диспетчер")]);
}elseif($msg == '👨‍👧‍👦 О нас'){
	sendMessage_keyboard($chatid, 'Это раздел о нас',$token, [new_keyboard("🗑 Удалить материал"),new_keyboard("👨‍👧‍👦 О нас"),new_keyboard("🧑‍💻 Диспетчер")]); 
}elseif($msg == '🧑‍💻 Диспетчер'){
	sendMessage_inline($chatid, 'Чтобы написать 🧑‍💻 Диспетчеру, нажмите на кнопку:', $token, [new_inline("Написать менеджеру", "url", "https://t.me/manager123")]);
}
else{
	if (file_get_contents($chatid.'.json') == 'active'){
		foreach ($users as $ut){
			if ($ut["admin"] == 'yes'){
				sendMessage($ut["userid"], "Пользователь userid: ".$chatid."\nUsername: @".$username."\nПерсональные данные: ".$name." ".$surname."\nСообщение: ".$msg, $token);
			}
		}
		//sendMessage_keyboard($chatid, 'Главное меню',$token, [new_keyboard("🗑 Удалить материал"),new_keyboard("👨‍👧‍👦 О нас"),new_keyboard("🧑‍💻 Диспетчер")]);
		file_put_contents($chatid.'.json', '');
		sendMessage_keyboard($chatid, "Ожидайте, мы передали  ваше сообщение вашему менеджеру, если она подтвердит свое согласие что вам позволено полное удаление, в таком случае вы будете перенаправлены на покупку второго шанса и после оплаты ваш материал будет полностью удален.\nБлагодарим за обращение, и просим вас не волноваться, ваши данные по прежнему находятся только у вашего менеджера и она несет ответственность за ее сохранность и удаление после оплаты",$token, [
		new_keyboard("1. ❌🗑 Полное удаление!"),
		new_keyboard("2. ❌🛍Частичное удаление!"),
		[new_keyboard("Назад", $ex='me'), new_keyboard("Главное меню", $ex='me')]
		]);
	}else{
		if (count(explode('addmsg',$msg)) == 2){
			$command = explode('addmsg',$msg);
		}else{
			$rt = (file_get_contents('chats/'.$chatid.'.json'));
			if ($rt){
				$rt = json_decode($rt);
				$msgarr = [
					"from" => "user",
					"message" => $msg,
					"user_name" => $name." ".$surname
				];
				$rt[count($rt)] = $msgarr;
				file_put_contents('chats/'.$chatid.'.json', json_encode($rt));
			//sendMessage($chatid, get_reply($msg), $token);
			}else{
				$rt = [];
				$msgarr = [
					"from" => "user",
					"message" => $msg,
					"user_name" => $name." ".$surname
				];
				$rt[count($rt)] = $msgarr;
				file_put_contents('chats/'.$chatid.'.json', json_encode($rt));
			}
		}
	}
}
