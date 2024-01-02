<?php
    require_once('core.php');
//هسته اصلی کار
    $content = file_get_contents("php://input");
    $update = json_decode($content, true);
    if (isset ($update["message"])) {
        $message_id = $update["message"]['message_id'];
        $user_id = $update["message"]['from']['id'];
        $chat_id = $update["message"]['chat']['id'];
        $text = $update["message"]['text'];
        $reply_message_id = $update["message"]['reply_to_message']['message_id'];
		$reply_from_id = $update["message"]['reply_to_message']['from']['id'];
		$reply_first_name = $update["message"]['reply_to_message']['from']['first_name'];
    }
    else if (isset($update["callback_query"])) {
        $callback_id=$update["callback_query"]['id'];
        $chat_id=$update["callback_query"]['message']['chat']['id'];
        $user_id=$update["callback_query"]['from']['id'];
        $data=$update["callback_query"]['data'];
        $message_id=$update["callback_query"]["message"]['message_id'];
        $text=$update["callback_query"]['message']['text'];
        $inline_message_id=$update["callback_query"]['inline_message_id'];
    }
    else if (isset($update["inline_query"])) {
        $id=$update["inline_query"]['id'];
        $user_id=$update["inline_query"]['from']['id'];
        $query=$update["inline_query"]['query'];
    }
   
    MessageRequestJson('sendMessage', array('chat_id' => $chat_id, 'text'=> $content));
    exit();
?>  
