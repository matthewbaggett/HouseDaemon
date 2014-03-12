<?php

function send_mail($to, $subject, $message){
  global $mailer_transport, $mailer_from;
  // Create the Mailer using your created Transport
  $mailer = Swift_Mailer::newInstance($mailer_transport);

  // Create a message
  $o_message = Swift_Message::newInstance($subject)
    ->setFrom($mailer_from)
    ->setTo($to)
    ->setBody($message)
  ;

  // Send the message
  $result = $mailer->send($o_message);
  if($result > 0){
    return true;
  }
  return false;
}