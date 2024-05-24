<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['email'])) {
        require_once 'lib/swift_required.php';

        $transport = Swift_SmtpTransport::newInstance('smtp.mailtrap.io', 2525, 'tls')
            ->setUsername('c37ef4508c01e6')
            ->setPassword('25db67cf9f349e');

        $mailer = Swift_Mailer::newInstance($transport);

        $messageText = '';
        foreach ($_POST as $key => $value)
            $messageText .= ucfirst($key).": ".$value."\n\n";

        $message = Swift_Message::newInstance('A message from Form')
            ->setFrom(array($_POST['email'] => $_POST['name']))
            ->setTo(array('lifeofrence@gmail.com' => 'John Doe'))
            ->setBody($messageText);

        try {
            echo $mailer->send($message) ? 'Message sent successfully' : 'Message failed to send';
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        exit;
    }
} else {
    echo "Method Not Allowed";
    exit;
}
?>
