<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require  '../vendor/autoload.php';

function clean_input($input)
{
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

function generateRandomString($length = 8) 
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[random_int(0, $charactersLength - 1)];
  }
  return $randomString;
}

function send_email($to, $subject, $body) 
{
  $mail = new PHPMailer(); // create a new object
  $mail->IsSMTP(); // enable SMTP
  $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true; // authentication enabled
  $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
  $mail->Host = "smtp-relay.sendinblue.com";
  $mail->Port = 587; // or 587
  $mail->IsHTML(true);
  $mail->Username = "mytesting1122@gmail.com";
  $mail->Password = 'MyfkqI0gTzwBXdN6';
  $mail->SetFrom("info@race.com", "Racing");
  $mail->Subject = $subject;
  $mail->Body = $body;
  $mail->AddAddress($to);

  if(!$mail->Send()) {
    return "Mailer Error: " . $mail->ErrorInfo;
  } else {
    return true;
  }
}

function proper_date($date, $format = "d-m-Y") {
	$date = date_create($date);
	return date_format($date, $format);
}