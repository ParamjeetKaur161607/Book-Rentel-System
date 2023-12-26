<?php
class abc{
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	if(isset($_POST['submit'])){
	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	

	//Load Composer's autoloader
	require '/vendor/autoload.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try{
		$mail->isSMTP();// Set mailer to use SMTP
		$mail->CharSet = "utf-8";// set charset to utf8
		$mail->SMTPAuth = true;// Enable SMTP authentication
		$mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted

		$mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
		$mail->Port = 587;// TCP port to connect to
		// $mail->SMTPOptions = array(
		//     'ssl' => array(
		//         'verify_peer' => false,
		//         'verify_peer_name' => false,
		//         'allow_self_signed' => true
		//     )
		// );
		$mail->isHTML(true);// Set email format to HTML

		$mail->Username = '161607paramjeetkaur@gmail.com';// SMTP username
		$mail->Password = 'ebaf yafx ftsl snlx';// SMTP password

		$mail->setFrom('161607paramjeetkaur@gmail.com', 'Param');//Your application NAME and EMAIL
		$mail->Subject = 'Test Test';//Message subject
		$mail->MsgHTML('HTML code');// Message body
		$mail->addAddress('paramjeetkaur161607@gmail.com', 'Paramjeet');// Target email

		$mail->send();
		echo 'Message has been sent';
	}
	catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <button name="submit">send mail</button>
    </form>
</body>
</html>