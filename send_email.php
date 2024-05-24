<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = trim($_POST['message']);

    // Check if inputs are not empty
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: contact.php?message=Please fill in all fields.");
        exit;
    }

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?message=Invalid email format.");
        exit;
    }

    //TEST SMTP Configuration 
    // $mail = new PHPMailer;
    // $mail->isSMTP();
    // $mail->Host = 'smtp.mailtrap.io';  // SMTP host
    // $mail->SMTPAuth = true;
    // $mail->Username = 'c37ef4508c01e6'; // SMTP username
    // $mail->Password = '25db67cf9f349e'; // SMTP password
    // $mail->SMTPSecure = 'tls'; // Enable TLS encryption, 'ssl' also accepted
    // $mail->Port = 2525; // TCP port to connect to

     //LIVE SMTP Configuration
     $mail = new PHPMailer;
     $mail->isSMTP();
     $mail->Host = 'mail.takcontinentalestate.com';  // SMTP host
     $mail->SMTPAuth = true;
     $mail->Username = 'info@takcontinentalestate.com'; // SMTP username
     $mail->Password = 'vV,-d.~7)q3a'; // SMTP password
     $mail->SMTPSecure = 'ssl'; // Enable TLS encryption, 'ssl' also accepted
     $mail->Port = 465; // TCP port to connect to

    
    // Set the recipient email address
    $to1 = "info@takcontinentalestate.com"; // Replace with your email

    // Set the email subject
    $subject = "Message from $name";

    // Customized Email content
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Message:\n$message\n";

    // Email headers
    $mail->setFrom($email, $name);
    $mail->addAddress($to1);
    $mail->Subject = $subject;
    $mail->Body = $email_content;

    // Send email
    if ($mail->send()) {
        // Redirect back with success message
        header("Location: contact.php?message=Email sent successfully.");
        exit;
    } else {
        // Redirect back with error message
        header("Location: contact.php?message=Error sending email: " . $mail->ErrorInfo);
        exit;
    }
} else {
    // If form not submitted, redirect back to form
    header("Location: contact.php?message=Method not allowed.");
    exit;
}
?>
