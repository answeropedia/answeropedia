<?php

class AbstractMailer
{
    private $moderator_email = 'alexander.gomzyakov@gmail.com';

    protected function send_email($to_email, $subject, $message)
    {
        $header = 'From: OctoAnswers <no_reply@octoanswers.com>'."\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=UTF-8\r\n";

        $sent = mail($to_email, $subject, $message, $header);
        if (!$sent) {
            throw new Exception("Server couldn't send the email.", 0);
        } else {
            return true;
        }
    }
}