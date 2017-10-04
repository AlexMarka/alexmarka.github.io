<?

include 'LiqPay.php';

if (!empty($_POST['name']) && !empty($_POST['phone'])) {

    if (!empty($_POST['name'])) {
        $name = 'ФИО: ' . $_POST['name'] . "\n";
    } else {
        $name = "ФИО: (не указано) \n";
    }
    if (!empty($_POST['email'])) {
        $email = 'email: ' . $_POST['email'] . "\n";
    } else {
        $email = "email: (не указано) \n";
    }
    if (!empty($_POST['phone'])) {
        $phone = 'телефон: ' . $_POST['phone'] . "\n";
    } else {
        $phone = "телефон: (не указано) \n";
    }
    if (!empty($_POST['company'])) {
        $org = 'компания: ' . $_POST['company'] . "\n";
    } else {
        $org = "компания: (не указано) \n";
    }


    if (!empty($_POST['count'])) {
        $comment = 'кол-во билетов: ' . $_POST['count'] . "\n";
        $comment .= 'на сумму: ' . $_POST['price'] . "\n";
    }

    $message = '<!DOCTYPE HTML>' .
        '<head>' .
        '<meta http-equiv="content-type" content="text/html">' .
        '<title>Покупка билетов</title>' .
        '</head>' .
        '<body>' .
        '<div id="outer" style="width: 90%;margin: 0 auto;margin-top: 10px;">' .
        '<div id="inner" style="width: 100%;margin: 0 auto;background-color: #fff;font-family: Tahoma, Arial,sans-serif;font-size: 15px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">' .
        '<p><b>Покупка билетов Remarketing</b></p>' .
        '<p>' . $name . '</p>' .
        '<p>' . $email . '</p>' .
        '<p>' . $phone . '</p>' .
        '<p>' . $org . '</p>' .
        '<p>' . $comment . '</p>' .
        '</div>' .
        '</div>' .
        '<div id="footer" style="width: 100%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdana;background-color: #E2E2E2;font-size: 13px;">' .
        '© 2017 remarketing.in.ua' .
        '</div>' .
        '</body>';


    $subject = "Покупка билетов Remarketing";
    $header = "From: \"remarketing.in.ua\" <info@remarketing.in.ua>\n";
    $header .= 'MIME-Version: 1.0' . "\r\n";
    $header .= "Content-type: text/html; charset=\"utf-8\"";
    $to = "alek.ivchenko@gmail.com";
//    $to = "pavel.chernetsky@gmail.com";

    mail($to, $subject, $message, $header);

    $count=false;
    if(isset($_POST['count'])){
        $count=$_POST['count'];
    }

    if(!(int)$count || $count<=0){
        $count=1;
    }

    if(time()<strtotime("2017-10-11 00:00:00")){
        $price=750;
    }elseif(time()<strtotime("2017-10-23 00:00:00")){
        $price=850;
    }elseif(time()<strtotime("2017-11-01 00:00:00")){
        $price=950;
    }else{
        $price=1200;
    }


    $total=$price*$count;
    if($count>=3) $total=$total-$total*0.1;

    $public_key='i38158658284';
    $private_key='Qd46V1ydZsA4JzadSmvVzeTML4SryUdE4zgrtnHR';

    $liqpay = new LiqPay($public_key, $private_key);
    $html = $liqpay->cnb_form(array(
        'action'         => 'pay',
        'amount'         => $total,
        'currency'       => 'UAH',
        'description'    => 'Оплата билетов('.$count.') от '.$_POST['name'].' ('.$_POST['phone'].', '.$_POST['email'].')',
        'order_id'       => time(),
        'version'        => '3',
        'result_url'     => 'http://remarketing.in.ua/?success=yes',
        'sandbox'        => 0,
        'server_url'     => 'http://remarketing.in.ua/paymentReceived.php',
    ));

    echo $html;

//    header("Location: /");

//    echo 1;
} else {
//    header("Location: /");
//    echo 2;
}

	
       



