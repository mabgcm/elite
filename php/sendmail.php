<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer library

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set your Gmail email address and password
    $emailAddress = 'gmail@gmail.com';
    $emailPassword = 'Ma2301li.';

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 2; // Set to 2 for debugging (0 for production use)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->Username = $emailAddress;
        $mail->Password = $emailPassword;

        // Recipients
        $mail->setFrom($emailAddress);
        $mail->addAddress($emailAddress); // Send the email to your own address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';

        // Retrieve form data
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        // Compose the email body
        $mail->Body = "Name: $name<br>Email: $email<br>Subject: $subject<br>Message: $message";

        // Send the email
        $mail->send();
        echo 'Message has been sent successfully!';
    } catch (Exception $e) {
        // Log the error to a file
        $errorLog = 'error.log';
        if (file_put_contents($errorLog, 'Error: ' . $mail->ErrorInfo . PHP_EOL, FILE_APPEND) !== false) {
            // Display a generic error message to the user
            echo 'Something went wrong, try refreshing and submitting the form again.';
        } else {
            // If there was an issue writing to the error log file
            echo 'An error occurred. Please contact the site administrator.';
        }
    }
}
?>
