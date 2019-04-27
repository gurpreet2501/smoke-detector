<?php 
namespace App\Libs; 
use App\Models;
use App\Libs\Notifications\Factory as Resp;
use Illuminate\Support\Facades\Hash;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/**
* 
*/
class Email
{
	
	function __construct()
	{
		
	}

	public static function send($subject,$body,$template,$to){


		try {
			$mail = new PHPMailer(true);   
		    //Server settings
		    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp.mandrillapp.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'Notes Cart';                 // SMTP username
		    $mail->Password = 'qtRm2TiWFGJp7bJZBidn7g';                           // SMTP password
		    // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 587;                                    // TCP port to connect to

		    //Recipients
		    $mail->setFrom('gurpreet@theheavenhomes.com', 'Gurpreet Singh');
		    $mail->addAddress($to, 'Developer Gurpreet');     // Add a recipient
		    // $mail->addReplyTo('info@example.com', 'Information');
		    // $mail->addCC('cc@example.com');
		    // $mail->addBCC('bcc@example.com');

		    //Attachments
		    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = $subject;
		    $mail->Body    = $body;
		    $mail->AltBody = '';
		   
		    $t = $mail->send();
		   
		    
		    return true;
		    
		} catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}

	}

}