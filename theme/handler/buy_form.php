<?php
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
error_reporting(0);

$tour_line_pay_ids = [14018, 1323, 1341, 1378, 1347, 2157, 12897, 11528, 1302, 1344, 1370];

/*if(in_array($_POST['post_id'], $tour_line_pay_ids)){
	$mrh_login = 'parusttlavto';
	$mrh_pass1 = 'aBt7Qx10kevnvNfqt4M4';
	$mrh_pass2 = 'DhxZmSrb9z5CF6aq38Cg';
} else {*/
	$mrh_login = 'parusspb';
	$mrh_pass1 = 'PMcI9hsYb84nri92lhRD';
	$mrh_pass2 = 'GR9448Ew7bpeuyoThmuN';
/*}*/

if (!$_POST['name'] || !$_POST['phone']) {
    echo json_encode ([
        'status'=>'error',
        'msg' => 'Не заполнено одно из обязательных полей: ФИО и телефон!'
    ]);
}

$promo_main = [/*'parus', */'аврора', 'спутник', 'парус', 'парус78', 'вафли'];
$promo_luxrent = ['люкс рент', 'lux rent', 'luxrent', 'люксрент'];
$promo_tourline = ['турлайн', 'tourline', 'tour line', 'тур лайн', 'каникулы'];

/*$_promocode_crm = array();
 $_t = file_get_contents('https://bazaparus.aristoff.ru/api/promokods');
if ($_t!='') {
	$_t = json_decode($_t);

	print_r(unserialize( $_t));
	if (is_array($_t)) {
		foreach($_t as $val){
			$_promocode_crm[$val['name']] = $val['value'];
		}
	}
//print_r($_promocode_crm);
}*/

$_promocode_crm = array();
$_t = file_get_contents('https://bazaparus.aristoff.ru/api/promokods');
if ($_t!='') {
	$_t = (unserialize($_t));
	if (is_array($_t)) { $_t=array($_t[0]);
		foreach($_t as $val){
			$start = strtotime($val->start_valid_date);
			$end = strtotime($val->end_valid_date);
			$cur_time = time();
			if(!$val->disable && $cur_time>=$start && $cur_time<=$end)
				$_promocode_crm[$val->name] = $val->value;
		}
	}
}

$promo_main = array_merge($promo_main, $promo_luxrent, $promo_tourline);



$promo_valid = false;
$promo = isset($_POST['promo']) ? $_POST['promo'] : '';
$promo = str_replace(array('"', "'", ' ', " "), null, $promo);
$promo = mb_strtolower($promo);
$promo_valid = (in_array($promo,$promo_main));

$point = urlencode(base64_encode($_POST['adr'])); //адрес для отправки в црм
$sale_arr = [];

if(isset($_promocode_crm[$promo]))
	$promo_valid = true;
if ($promo_valid) {
    $count = $_POST['sold_adults']
        + $_POST['sold_childs']
        + $_POST['sold_old']
        + $_POST['sold_school']
        + $_POST['sold_students']
        + $_POST['sold_adults_for']
        + $_POST['sold_students_for']
        + $_POST['sold_childs_for'];

    if ($promo == 'аврора' || $promo == 'спутник' || $promo == 'parus150') {
        $_POST['discount'] = 150;
        $_POST['total_discount'] = ($count * $_POST['discount']);
		$sale_arr = [
			'type' => 'count',
			'sale' => 150
		];
    }elseif ($promo == 'KOTPARUS' || $promo == 'kotparus'){
        $_POST['total_discount'] = round($_POST['true_price']*0.25);
		$sale_arr = [
			'type' => 'percent',
			'sale' => 0.25
		];
    } elseif ($promo == 'каникулы'){
		$_POST['discount'] = 200;
		$_POST['total_discount'] = ($_POST['sold_school'] * $_POST['discount']);
		$sale_arr = [
			'type' => 'count',
			'sale' => $_POST['discount']
		];
	} elseif ($promo == 'вафли'){
		$_POST['discount'] = 100;
        $_POST['total_discount'] = ($count * $_POST['discount']);
		$sale_arr = [
			'type' => 'count',
			'sale' => 100
		];
    } elseif (in_array($promo,$promo_luxrent) || in_array($promo,$promo_tourline)){
        $_POST['total_discount'] = round($_POST['true_price']*0.1);
		$sale_arr = [
			'type' => 'percent',
			'sale' => 0.1
		];
    } elseif (isset($_promocode_crm[$promo])){
    		$promovalue=0;
    		if (intval($_promocode_crm[$promo])>0){
    			$promovalue=intval($_promocode_crm[$promo]);
    		}
    		if (stristr($_promocode_crm[$promo],"%") && $promovalue>0){//есть процент
         		$_POST['total_discount'] = round($_POST['true_price']*$promovalue*0.01);
			$sale_arr = [
				'type' => 'percent',
				'sale' => round($promovalue*0.01)
			];
    		}else{
	        	$_POST['total_discount'] = round($_POST['true_price']-($count *$promovalue));
			$sale_arr = [
				'type' => 'count',
				'sale' => round($promovalue)
			];
    		}
    }elseif ($promo == 'парус78'){
        $_POST['total_discount'] = round($_POST['true_price']*0.2);
		$sale_arr = [
			'type' => 'percent',
			'sale' => 0.2
		];
    } else {
        $_POST['total_discount'] = ($count * $_POST['discount']);
		$sale_arr = [
			'type' => 'count',
			'sale' => $_POST['discount']
		];
    }


	$_POST['true_price'] = $_POST['true_price'] - $_POST['total_discount']; //4000 - 1200 == 2800
    //$_POST['amount'] = $_POST['amount'] - $_POST['total_discount']; // 2800 - 1200 == 1400
}

if (isset($_POST['20percent']) && $_POST['20percent']=='on') {
    $_POST['amount']=round(0.3*$_POST['amount'],0);
}


$result = reserve($_POST); //print_r($result);
$result->summ = $_POST['true_price']; //2800



if ($result->result <> 'ok') {
    echo json_encode ([
        'status'=>'error',
        'msg' => 'Возникла ошибка: result <> ok',
        'result' => var_export($result, true)
    ]);
    die();
}

if (!$result->id) {
    echo json_encode ([
        'status'=>'error',
        'msg' => 'Возникла внутреняя проблема сервера. (!$result->id)'
    ]);
    die();
}




$_SESSION['ticket_id'] = $result->id;



//$summ_no_predoplata = (isset($_POST['total_discount']))?$result->summ - $_POST['total_discount']:$result->summ;
$summ_no_predoplata = $result->summ;
$inv_id  = $_SESSION['ticket_id'];
if (isset($_POST['20percent']) && $_POST['20percent']=='on') {
    //Считаем разницу, сколько нужно доплатить туристу при посадке. Потом добавим информацию в комментарий к броне.
    $out_summ=$summ_predoplata_20 = round($summ_no_predoplata*0.3,0);
    $doplata_to_crm = $summ_no_predoplata - $summ_predoplata_20;
    //Добавим коммент, сколько нужно доплатить
    $inv_id_comment = $result->id;
    file_get_contents('https://bazaparus.aristoff.ru/fix_parus_comment.php?InvId='.$inv_id_comment.'&doplata='.$doplata_to_crm . '&point='. $point);
    $inv_desc  = '20%25 предоплата билетов, заказ №'.$inv_id;
	$prepay = true;
}else{
    $inv_id_comment = $result->id;
    $out_summ  = $summ_no_predoplata;
    $inv_desc  = 'Оплата билетов, заказ №'.$inv_id;
    file_get_contents('https://bazaparus.aristoff.ru/fix_parus_comment.php?InvId='.$inv_id_comment.'&point='. $point);
	$prepay = false;
}


send_email_to_customer($_POST,$out_summ,$count);

$shp_cid = $_POST['clientID'];
$shp_neva = 'no';
$shp_pp = $inv_id;
$receipt = get_receipt($_POST, $sale_arr, $prepay);

if($receipt){
	//$crc = md5("$mrh_login:$out_summ:$inv_id:$receipt:$mrh_pass1:Shp_cid={$shp_cid}");
	$crc = md5("$mrh_login:$out_summ:0:$receipt:$mrh_pass1:Shp_cid={$shp_cid}:Shp_neva={$shp_neva}:Shp_pp={$shp_pp}");

	/*$url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
		"OutSum=$out_summ&InvId=$inv_id&Shp_cid=$shp_cid&Description=$inv_desc&SignatureValue=$crc&Receipt=".urlencode($receipt);*/

	$url = "https://auth.robokassa.ru/Merchant/Index.aspx?MrchLogin=$mrh_login&".
		"OutSum=$out_summ&InvId=0&Shp_cid=$shp_cid&Shp_neva=$shp_neva&Shp_pp=$shp_pp&Description=$inv_desc&SignatureValue=$crc&Receipt=".urlencode($receipt);

	$result->pay_url=$url;
}
echo json_encode($result);

function reserve($form_data) {
    $results = post('reserve', $form_data);

    return json_decode($results);
}

function post($action, $data) {
    $data = array_merge($data, array(
        'client_id' => 1,
        'client_key' => '666bd5f709daf449ec5adec685b7077f'
    ));

    $url = 'https://bazaparus.aristoff.ru/api/'.$action;

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}

function send_email_to_customer($arr,$out_summ,$cnt_tikets){
    $tikets_title = [
        'sold_childs'=>'для детей',
        'sold_school'=>'для школьников',
        'sold_students'=>'для студентов',
        'sold_adults'=>'для взрослых',
        'sold_old'=>'для Пенсионеров',
        'sold_adults_for'=>'для иностранцев',
        'sold_students_for'=>'для студентов иностранцев',
        'sold_childs_for'=>'для детей иностранцев'
    ];

    /* получатели */
    //$to = "info@parus-peterburg.ru,k8573737@yandex.ru";
    $to = "info@groupspb.ru,testdev@kometatek.ru";
    $excursion_name = $arr['title'];
    $excursion_date =  $arr['date_and_time'];
    $subject =  "Заказ экскурсий ".$excursion_date;

    /* сообщение */
    $message[] = 'Уважаемый(ая), '.$arr['name'];

    //$message[] = 'Для Вас забронирована экскурсия "'.$excursion_name.'" ('.$excursion_date.') на '.plural_form($cnt_tikets, array('человека','человека','человек')).':';
    $message[] = '<br>Для Вас забронирована экскурсия <b>"'.$excursion_name.'" ('.$excursion_date.')'.'</b>:';

    $tikets_text=array();
    foreach($arr as $key=>$val) {
        if (isset($tikets_title[$key]) && $val>0) $tikets_text[]=' - '. plural_form($val, array('билет','билета','билетов')).' '.$tikets_title[$key];
    }
    $message[] =  implode('<br>',$tikets_text);

    $message[] = '<br><b>Адрес отправления</b>: '.$arr['adr'];

    $message[] =  "<br>СТОИМОСТЬ ЭКСКУРСИИ: ".plural_form($_POST['true_price'], array('рубль','рубля','рублей'));

    if (isset($_POST['20percent']) && $_POST['20percent']=='on') {
        $predoplata=round(0.3*$_POST['true_price'],0);
        $message[] =  "СУММА К ПРЕДОПЛАТЕ: ".plural_form($predoplata, array('рубль','рубля','рублей'));
    }else {
        $predoplata=0;
    }

    $message[] =  "СУММА К ОПЛАТЕ: ".plural_form($_POST['true_price']-$predoplata, array('рубль','рубля','рублей'));

    $message[] =  "<br><b>Внимание!</b> Совершите оплату или предоплату в течение 15-ти минут. По истечении этого срока бронь автоматически снимется.<br>";

    $message[] =  "Для дополнительной информации: <a href='tel:88001015692'>8 (800) 101-56-92</a> (бесплатно по РФ)<br><a href='tel:+79516853733'>+7 (951) 685-37-33</a> (только прием сообщений в <a href='https://api.whatsapp.com/send?phone=79516853733&amp;text=Здравствуйте.+Я+обращаюсь+с+сайта+parus-peterburg.ru'>WhatsApp</a>, <a href='tg://resolve?domain=excursion_parus'>Telegram</a>)";

    $message[] =  '<br>При себе обязательно иметь документ удостоверяющий личность и документ подтверждающий льготу (пенсионное удостоверение или справку, НЕ паспорт и студенческий билет дневного очного обучения, справку со школу для школьников старше 15 лет).<br>

		 <br>
		 <br>
		_________________________<br>

		С уважением,<br>
		экскурсионное бюро "Парус"<br>
		<br>
			<a href="tel:88001015692">8 (800) 101-56-92</a><br>
			<a href="tel:+79516853733">+7 (951) 685-37-33</a><br>
		<br>
			www.parus-peterburg.ru';

    /* Для отправки HTML-почты вы можете установить шапку Content-type. */
    $headers= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";

    /* дополнительные шапки */
    $headers .= "From: parus-peterburg.ru<no-reply@parus-peterburg.ru>\r\n";

    //$result=json_decode($result);//print_r($result);
    /* и теперь отправим из */

    //die($to."*******".$subject."*******".implode(" ",$message));
    $text=implode('<br>',$message);
    if($arr['mail']){
        //mail($arr['mail'], $subject, $text, $headers);
        wp_mail('info@groupspb.ru', $subject, $text);
    }
    $headers .= "Bcc: testdev@kometatek.ru\r\n";
    /*if ($result->success=mail($to, $subject, $text, $headers)) $result->text='<p class="green">Спасибо. Ваше сообщение отправлено администрации сайта</p>';
    else $result->text = '<p class="red">Внимание! При отправке сообщения возникла ошибка. Свяжитесь с нами другим удобным для вас способом.';*/



    $chat_id="1731649696";//"300193513";
    $bot_id="5309473099:AAEcvzdzq_tVs7LEK3Zebw5J9q7w9OEaAnU";

    $disable_web_page_preview = null;
    $reply_to_message_id = null;
    $reply_markup = null;
    $data = array(
        'chat_id' => urlencode($chat_id),
        'text' => $subject.'
					'.strip_tags(str_ireplace("<br>",'
					',$text)),
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


    //die();
    //echo json_encode($result);;
    //
}

function plural_form($number, $after) {
    $cases = array (2, 0, 1, 1, 1, 2);
    return $number.' '.$after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ];
}

function save_values_orders($post, $t_id) {
    global $wpdb;
    $table_name = $wpdb->get_blog_prefix() . 'my_orders';

    $ticket_id = $t_id;
    $client_id = $post['clientID'] ? $post['clientID'] : '';
    $date_tour = $post['date_and_time'] ? $post['date_and_time'] : '';
    $amount = $post['amount'] ? $post['amount'] : '';
    $discount = $post['discount'] ? $post['discount'] : '';
    $sold_childs = $post['sold_childs'] ? $post['sold_childs'] : '';
    $sold_school = $post['sold_school'] ? $post['sold_school'] : '';
    $sold_students = $post['sold_students'] ? $post['sold_students'] : '';
    $sold_adults = $post['sold_adults'] ? $post['sold_adults'] : '';
    $sold_old = $post['sold_old'] ? $post['sold_old'] : '';
    $sold_adults_for = $post['sold_adults_for'] ? $post['sold_adults_for'] : '';
    $sold_childs_for = $post['sold_childs_for'] ? $post['sold_childs_for'] : '';
    $sold_students_for = $post['sold_students_for'] ? $post['sold_students_for'] : '';
    $name_excurs = $post['title'] ? $post['title'] : '';
    $name = $post['name'] ? $post['name'] : '';
    $mail = $post['mail'] ? $post['mail'] : '';
    $start_excur =  $post['adr'] ? $post['adr'] : '';
    $tripid = $post['trip'] ? $post['trip'] : '';
    $phone = $post['phone'] ? $post['phone'] : '';
    $post_id = $post['post_id'] ? $post['post_id'] : '';


    $wpdb->insert(
        $table_name, // указываем таблицу
        array( // 'название_колонки' => 'значение'
            'ticket_id' => $ticket_id,
            'client_id' => $client_id,
            'date_tour' => $date_tour,
            'amount' => $amount,
            'discount' => $discount,
            'sold_school' => $sold_school,
            'sold_students' => $sold_students,
            'sold_adults' => $sold_adults,
            'sold_old' => $sold_old,
            'sold_adults_for' => $sold_adults_for,
            'sold_childs_for' => $sold_childs_for,
            'sold_students_for' => $sold_students_for,
            'name_excurs' => $name_excurs,
            'name' => $name,
            'mail' => $mail,
            'start_excur' => $start_excur,
            'tripid' => $tripid,
            'phone' => $phone,
            'post_id' => $post_id
        ),
        array(
            '%s', // %s - значит строка
            '%s'
        )
    );
}

$post = $_POST;


save_values_orders($post, $result->id);

function get_receipt($arr, $sale, $prepay){
	$post_id = $arr['post_id'];

	if($post_id){
		$receipt = [
			'items' => []
		];
		if($arr['sold_adults']){
			$price = get_field('p_vzroslie_sale', $post_id);
			if(!$price) $price = get_field('p_vzroslie', $post_id);

			$receipt['items'][] = [
				"name"=> 'Взрослый',
				"quantity"=> $arr['sold_adults'],
				"cost"=> $price
			];
		}
		if($arr['sold_childs']){
			$price = get_field('p_doshkolniki_sale', $post_id);
			if(!$price) $price = get_field('p_doshkolniki', $post_id);

			$receipt['items'][] = [
				"name"=> 'Детский',
				"quantity"=> $arr['sold_childs'],
				"cost"=> $price
			];
		}
		if($arr['sold_old']){
			$price = get_field('p_pensionery_sale', $post_id);
			if(!$price) $price = get_field('p_pensionery', $post_id);

			$receipt['items'][] = [
				"name"=> 'Пенсионеры',
				"quantity"=> $arr['sold_old'],
				"cost"=> $price
			];
		}
		if($arr['sold_school']){
			$price = get_field('p_pensionery_sale', $post_id);
			if(!$price) $price = get_field('p_pensionery', $post_id);

			$receipt['items'][] = [
				"name"=> 'Школьники',
				"quantity"=> $arr['sold_school'],
				"cost"=> $price
			];
		}
		if($arr['sold_students']){
			$price = get_field('p_studenty_sale', $post_id);
			if(!$price) $price = get_field('p_studenty', $post_id);

			$receipt['items'][] = [
				"name"=> 'Студенты',
				"quantity"=> $arr['sold_students'],
				"cost"=> $price
			];
		}
		if($arr['sold_adults_for']){
			$price = get_field('p_vzroslie_inostrancy_sale', $post_id);
			if(!$price) $price = get_field('p_vzroslie_inostrancy', $post_id);

			$receipt['items'][] = [
				"name"=> 'Взрослые иностранцы',
				"quantity"=> $arr['sold_adults_for'],
				"cost"=> $price
			];
		}
		if($arr['sold_students_for']){
			$price = get_field('p_studenty_inostrancy_sale', $post_id);
			if(!$price) $price = get_field('p_studenty_inostrancy', $post_id);

			$receipt['items'][] = [
				"name"=> 'Студенты иностранцы',
				"quantity"=> $arr['sold_students_for'],
				"cost"=> $price
			];
		}
		if($arr['sold_childs_for']){
			$price = get_field('p_deti_inostrancy_sale', $post_id);
			if(!$price) $price = get_field('p_deti_inostrancy', $post_id);

			$receipt['items'][] = [
				"name"=> 'Дети иностранцы',
				"quantity"=> $arr['sold_childs_for'],
				"cost"=> $price
			];
		}

		$payment_method = ($prepay)?'prepayment':'full_prepayment';
		foreach($receipt['items'] as $k=>$item){
			$receipt['items'][$k]['payment_method'] = $payment_method;
			$receipt['items'][$k]['tax'] = 'none';
			$receipt['items'][$k]['payment_object'] = 'service';
			if(count($sale)){
				if($sale['type'] == 'percent'){
					$receipt['items'][$k]['cost'] = round($item['cost']*(1-$sale['sale']), 2);
				} else {
					$receipt['items'][$k]['cost'] = $item['cost']-$sale['sale'];
				}
			}
			if($prepay) $receipt['items'][$k]['cost'] = round(0.2*$item['cost'], 2);
		}
		$return = urlencode(json_encode($receipt,JSON_UNESCAPED_UNICODE));
		$return = str_replace('+', '%20', $return);
		return json_encode($receipt,JSON_UNESCAPED_UNICODE);
	} else {
		return false;
	}
}
