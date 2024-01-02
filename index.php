<?php
    require_once('core.php');
    require_once('db.php');
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
   
    // MessageRequestJson(sendMessage, array(chat_id => $chat_id, text=> $content));
    // exit();
    
    $db = Db::getInstance();
    $player = $db -> query ("SELECT * FROM game WHERE user_id=:user_id", array(
        'user_id' => $user_id,
    ));
    if (count($player) == 1 ){
        $db = Db::getInstance();
        MessageRequestJson(sendMessage, array(chat_id => $chat_id, text=> "test 1"));
    }
    else {
        $db -> insert ("INSERT INTO game (user_id) VALUES (:user_id)", array(
            'user_id' => $user_id
        ));
    }
    $count = $db -> query ("SELECT COUNT(user_id) AS count FROM game WHERE user_id");
    $count = $count[0][count];

    if ($count < 3) {
        MessageRequestJson(sendMessage, array(chat_id => $chat_id, text=> "doroste"));
    }
    else {
        MessageRequestJson(sendMessage, array(chat_id => $chat_id, text=> "qalate"));
        }
    
    
        // exit();

        if ($text == "S"){
        MessageRequestJson(sendMessage, array(chat_id => $chat_id, text=> 'بزن روی پایه ام', reply_markup => array( inline_keyboard => array(
            array(array(text=>"شروع بازی", callback_data=> "start_".$user_id)),
            array(array(text=>"پایه ام", callback_data=> "join_".$user_id."_1"))
    ))));

    }
    
    if (strpos($data, "join") === 0) {
        $data = explode ("_",$data);

            if($data[1] == $user_id){
                MessageRequestJson(answerCallbackQuery, array(callback_query_id=>$callback_id, text=>"شما در بازی هستید"));
            }
            else {
   
            $player1=$data[1];
            $p1name = getChat ($player1);
            $player2 = $user_id;
            $p2name = getChat ($player2);
            
            MessageRequestJson(editMessageText, array(chat_id=>$chat_id, message_id=>$message_id, text=> "بزن روی پایه ام \n شرکت کنندگان: \n $p1name \n $p2name",
            reply_markup => array( inline_keyboard => array(
                array(array(text=>"شروع بازی", callback_data=> "start_".$user_id)),
                array(array(text=>"پایه ام", callback_data=> "join_".$user_id."_2"))
            ))));
            }

        
    }
    exit();


































// برنامه نویسی ربات
    if ($query=='q') {

        MessageRequestJson(answerInlineQuery, array(inline_query_id=>$id, results=> array(
            array(type=> "article", id=> microtime()."a", title=>"ss", input_message_content=>array(message_text=>"hello"),
            reply_markup=> array(	
                inline_keyboard => array(
                    array(array(text=>'اشتراک گذاری', switch_inline_query_current_chat=>"2"))
                
            ))        
        
        ))));
    }

    else if ($data=='1'){
            $matn="صفحه بازی";
            
            MessageRequestJson(editMessageText, array(chat_id => $chat_id, message_id => $message_id, text => $matn,
                reply_markup=> array(	
                    inline_keyboard => array(
                        array(array(text=>'test', callback_data=>'test')),
                        array(array(text=>'بازگشت', callback_data=> '0'))
                )))); 
        }
    else if ( $data=='0') {
            $matn="سلام
         بهترین ربات بازی حکم";

        MessageRequestJson(editMessageText, array(chat_id => $chat_id, message_id => $message_id, text => $matn,
            reply_markup=> array(
                inline_keyboard => array(
                    array(array(text=>'بریم سراغ بازی', callback_data=> '1'), array(text=>'راهنما', callback_data=>'2')),
                    array(array(text=>'ارتباط با ما', callback_data=>'3'))
                )
        )));
        // MessageRequestJson(editMessageText, array(inline_message_id=>$inline_message_id, text=> $matn, reply_markup=> array(
        //     inline_keyboard => array(
        //         array(array(text=>'بریم سراغ بازی', callback_data=> '1'), array(text=>'راهنما', callback_data=>'2')),
        //             array(array(text=>'ارتباط با ما', callback_data=>'3'))
     
        // )
        // )));
    }
    else if ($text=='/start') {

        $matn="سلام
         بهترین ربات بازی حکم";

        MessageRequestJson(sendMessage, array(chat_id => $chat_id, text => $matn, reply_markup=> array(
        inline_keyboard => array(
            array(array(text=>'بریم سراغ بازی', callback_data=> '1'), array(text=>'راهنما', callback_data=>'2')),
            array(array(text=>'ارتباط با ما', callback_data=>'3'))
        )
        )));
    }

?>  