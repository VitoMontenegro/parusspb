<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
$tours = get_posts( array(
		'numberposts' => -1,
		'post_type' => 'tours',
		'suppress_filters' => true,
		'tax_query' => array(                                  // элемент (термин) таксономии
			array(
				'taxonomy' => 'excursion',         // таксономия
				'field' => 'slug',
				'terms'    => 'grup-ekskursii' // термин
			)
		),
	) );
$excursion_date=null;
foreach($tours as $tour){
	if ($tour->id_crm == $_POST['trip']) echo $excursion_date = $tour->start_time;
}

$title=array(
	'name'=>'Имя',
	'mail'=>'Почта',
	'phone'=>'Телефон',
	'trip'=>'ID экскурсии',
	'sold_childs'=>'Билеты для детей',
	'sold_school'=>'Билеты для школьников',
	'sold_students'=>'Билеты для студентов',
	'sold_adults'=>'Билеты для взрослых',
	'sold_old'=>'Билеты для Пенсионеров',
	'sold_adults_for'=>'Билеты для иностранцев',
	'sold_students_for'=>'Билеты для студентов иностранцев',
	'sold_childs_for'=>'Билеты для детей иностранцев',
	'excurs_name'=>'Название экскурсии ',
	'amount'=>'Сумма',
	'promo'=>'Промокод',
	//'discount'=>'Дисконт'
);
/*
    [name] => test
    [mail] =>
    [phone] => +7(888) 888-88-88
    [trip] => 52366
    [price_adults] => 1000
    [price_childs] => 500
    [price_old] => 900
    [price_students] => 900
    [price_school] => 750
    [price_adults_for] => 1100
    [price_students_for] => 1000
    [price_childs_for] => 1000
    [sold_childs] => 0
    [sold_school] => 0
    [sold_students] => 0
    [sold_adults] => 0
    [sold_old] => 0
    [sold_adults_for] => 0
    [sold_students_for] => 0
    [sold_childs_for] => 1
    [promo] =>
    [discount] => 200
    [amount] => 1000

*/

if (!$excursion_date && ($_POST['phone']!='' || $_POST['mail']!='') )
{
	/* получатели */
	//$to= "info@parus-peterburg.ru";
	//$to= "4933750@list.ru";
	//$to= "development@kometatek.ru";
	//$to= "info@parus-peterburg.ru,parus.work1@gmail.com,testdev@kometatek.ru";
	$to= "parus.work1@gmail.com,testdev@kometatek.ru";
	$excursion_name = $_POST['title']; unset($_POST['title']);
	$excursion_date = isset($_POST['date_and_time']) ? $_POST['date_and_time'] : '';
	unset($_POST['date']);

	/* тема/subject */
	$subject =  htmlspecialchars ($excursion_date." ".$_POST['phone']." ".$_POST['email']." ".$_POST['name']." ".$_POST['title']);
	//$subject =  preg_replace('/[^a-zA-Zа-яА-Я0-9]/ui', '',$subject );
	/* сообщение */
	$message = '<html><head> <title>Заявка с сайта groupspb.ru</title></head><body><table>';
	$text = 'С сайта groupspb.ru было отправлено сообщение:' . "\n";
	$text .= 'Тема: Оставить заявку:' . "\n";

	$message .="<tr><td>На сайте оставлена заявка</td><td>groupspb.ru</td></tr>";

	$message .="<tr><td>Дата экскурсии:</td><td>".$excursion_date."</td></tr>";
    $text .= 'Дата экскурсии: ' . $excursion_date . "\n";

	$message .="<tr><td>Адрес отправления:</td><td>".$_POST['adr']."</td></tr>";
    $text .= 'Адрес отправления: ' . $_POST['adr'] . "\n";

	$message .="<tr><td>Экскурсия:</td><td>".$excursion_name."</td></tr>";
    $text .= 'Экскурсия: ' . $excursion_name . "\n";

	foreach($_POST as $key=>$val) {
		if (isset($title[$key]) && $val) {
			$message .="<tr><td>".$title[$key].":</td><td>".$val."</td></tr>";

			$text .=  "{$title[$key]} : {$val}" . "\n";
		}
	}
    $message .="<tr><td>Ссылка на экскурсию:</td><td>".$_POST['ex_link']."</td></tr>";
	$message.="</table></body></html>";

	/* Для отправки HTML-почты вы можете установить шапку Content-type. */
	$headers= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";

	/* дополнительные шапки */
	$headers .= "From: parus-peterburg.ru<recall@parus-peterburg.ru>\r\n";
	//$headers .= "Bcc: sales2@tourline.spb.ru\r\n";
	//$headers .= "Cc: testdev@kometatek.ru";
	//$result=json_decode($result);//print_r($result);
	/* и теперь отправим из */
	wp_mail($to, $subject, $message, $headers);
	if ($result['success']=mail($to, $subject, $message, $headers)) {
		$result['text']='<p class="green">Спасибо. Ваше сообщение отправлено администрации сайта</p>';


        $disable_web_page_preview = null;
        $reply_to_message_id = null;
        $reply_markup = null;
        $chat_id="300193513";//"300193513";
        $bot_id="5309473099:AAEcvzdzq_tVs7LEK3Zebw5J9q7w9OEaAnU";

        $data = array(
                'chat_id' => urlencode($chat_id),
                'text' => $text,
                'disable_web_page_preview' => urlencode($disable_web_page_preview),
                'reply_to_message_id' => urlencode($reply_to_message_id),
                'reply_markup' => urlencode($reply_markup)
            );

        $url = 'https://api.telegram.org/bot' . $bot_id . '/sendMessage';

        //  open connection
        $ch = curl_init();
        //  set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        //  number of POST vars
        curl_setopt($ch, CURLOPT_POST, count($data));
        //  POST data
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //  To display result of curl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //  execute post
        $resultes = curl_exec($ch);
        //  close connection
        curl_close($ch);
	} else {
		$result['text'] = '<p class="red">Внимание! При отправке сообщения возникла ошибка. Свяжитесь с нами другим удобным для вас способом.';
	}
	echo json_encode($result);


//
}
?>
