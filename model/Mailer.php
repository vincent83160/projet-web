<?php

class Mailer
{
    private $to;
    private $subject;
    private $message;
    private $headers;

    public function __construct($to, $subject, $message, $from)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = nl2br($message);
        $this->headers = "From: " . $from . "\r\n";
        $this->headers .= "Reply-To: " . $from . "\r\n";
        $this->headers .= "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    }

    public function send()
    {
        // Activer le rapport d'erreurs et afficher les erreurs
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        mail($this->to, $this->subject, $this->message, $this->headers);
    }
}
