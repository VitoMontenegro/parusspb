<?php

session_start();

header('Content-Type: application/json');

$data=$_POST;

//проверяем ввод промо
//$promo_main = 'parus';
$promo_main = 'парус';
$promo_valid = false;
$promo = isset($data['promo']) ? $data['promo'] : '';
$promo = str_replace(array('"', "'", ' ', " "), "", $promo);
$promo = mb_strtolower($promo);

$promo_value='';
$promo_value = isset($data['promo_value']) ? $data['promo_value'] : '';
$promo_value = str_replace(array('"', "'", ' ', " "), "", $promo_value);
$promo_value = mb_strtolower($promo_value);

$promo_valid = (($promo_value!='')?($promo == $promo_value):($promo == $promo_main));

$promo_luxrent = ['люкс рент', 'lux rent', 'luxrent', 'люксрент'];
$promo_tourline = ['турлайн', 'tourline', 'tour line', 'тур лайн'];


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
$index_array=array('sold_adults', 'sold_childs','sold_old','sold_school','sold_students','sold_adults_for','sold_students_for','sold_childs_for');
$count = 0;

//считаем билеты пока простая скидка с каждого билета
foreach($index_array as $index){
	if (isset($data[$index])) $count +=$data[$index];
}
$discount = 0;
if ($promo_valid || $promo == 'аврора'  || $promo == 'парус' || $promo == 'parus150' || $promo == 'вафли'){// = ($promo == $promo_main)){//промо введено верно
	$promo_valid = true;

	if (isset($data['discount'])) {
		$discount=(int) $data['discount'];
	} else {
		$discount=100;$minus=0;
	}

	if ($promo == 'аврора'  || $promo == 'parus150') $discount=150;

	$minus = $count * $discount;

	echo json_encode([
		'ok' => $promo_valid,
		'minus' => $minus,
		'discount' => (int) $discount,
		'count'=>$count
	]);
} elseif(in_array($promo,$promo_luxrent) || in_array($promo,$promo_tourline)){
	$promo_valid = true;
	$minus = round($data['true_price']*0.1);

	echo json_encode([
		'ok' => $promo_valid,
		'minus' => $minus,
		'discount' => (int) $discount,
		'count'=>$count
	]);
} elseif(isset($_promocode_crm[$promo])){
	$promo_valid = true;
	$promovalue=0;
	if (intval($_promocode_crm[$promo])>0){
		$promovalue=intval($_promocode_crm[$promo]);
	}
	if (stristr($_promocode_crm[$promo],"%",) && $promovalue>0){//есть процент

		$discount=round($data['true_price']*$promovalue*0.01);
		$minus = $discount;
	}else{

		$minus = $count*$promovalue;
	}



	echo json_encode([
		'ok' => $promo_valid,
		'minus' => $minus,
		'discount' => (int) $discount,
		'count'=>$count
	]);
} elseif($promo == 'парус78'){
	$promo_valid = true;
	$minus = round($data['true_price']*0.2);

	echo json_encode([
		'ok' => $promo_valid,
		'minus' => $minus,
		'discount' => (int) $discount,
		'count'=>$count
	]);
} elseif($promo == 'каникулы'){
	if($data['sold_school']!=0){
		echo json_encode([
			'ok' => true,
			'minus' => (int) $data['sold_school']*200,
			'discount' => (int) $data['sold_school']*200,
			'count'=>$count
		]);
	} else {
		echo json_encode([
			'ok' => false,
			'minus' => 0,
			'discount' => 0,
			'count'=>0,
			'msg' => 'Промокод действует только для школьников'
		]);
	}
}
else {//промо введено не верно
	echo json_encode([
		'ok' => $promo_valid,
		'minus' => 0,
		'discount' => 0,
		'count'=>0
	]);

}
