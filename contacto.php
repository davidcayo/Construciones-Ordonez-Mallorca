<?php if (!isset($_SESSION)) session_start();

if(!$_POST) exit();

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

// Configuration option.
// Enter the $email $address that you want to emails to be sent to.
// Example $address = "joe.doe@yourdomain.com";

$address = "victorpa_7@hotmail.com";

///////////////////////////////////////////////////////////////////////////
//
// Do not edit the following lines
//
///////////////////////////////////////////////////////////////////////////

$postValues = array();
foreach ( $_POST as $name => $value ) {
	$postValues[$name] = trim( $value );
}
extract( $postValues );

// Important Variables
$posted_verify = isset( $postValues['verify'] ) ? md5( $postValues['verify'] ) : '';
$session_verify = !empty($_SESSION['jigowatt']['html5-contact-form']['verify']) ? $_SESSION['jigowatt']['html5-contact-form']['verify'] : '';

$error = '';

///////////////////////////////////////////////////////////////////////////
//
// Begin verification process
//
// You may add or edit lines in here.
//
// To make a field not required, simply delete the entire if statement for that field.
// You will also have to remove required="required" from the input field, on https://construccionesordonezmallorca.es.
//
///////////////////////////////////////////////////////////////////////////


////////////////////////
// Email field is required
if(empty($email)) {
	$error = 'Attention! Please enter a valid email address.';
} else if(!isEmail($email)) {
	$error = 'Attention! You have enter an invalid e-mail address, try again.';
}
////////////////////////


////////////////////////
// Comments field is required
if(empty($comments)) {
	$error = 'Attention! Please enter your message.';
}
////////////////////////


// End verification.
///////////////////////////////////////////////////////////////////////////


if (!empty($error)) {
	echo '<div class="error_message">' . $error . '</div>';
	exit;
}

 // Configuration option.
 // i.e. The standard $subject will appear as, "You've been contacted by John Doe."

 // Example, $e_subject = $name . ' has contacted you via Your Website.';
//  $e_subject = "You've been contacted by $name";
//  $subject = "You've been contacted by $name";


 // Configuration option.
 // You can change $this if you feel that you need to.
 // Developers, you may wish to add more fields to the form, in which case you must be sure to add them here.


 $subject = "Has sido contactado por $name";
 $e_affair = "Asunto: " . $affair . PHP_EOL . PHP_EOL;
 $e_body = "Has sido contactado por $name con el siguiente mensaje:" . PHP_EOL ;
 $e_content = "Mensaje:" . PHP_EOL . $comments . PHP_EOL . PHP_EOL;
 $e_reply = "Puedes contactarte con $name por via email a: $email.";

 if (!empty($phone)) $e_reply .= " or via phone $phone.";

 if (!empty($website)) $e_reply .= " Their website address is $website.";

 $msg = wordwrap($e_body . $e_affair .  $e_content . $e_reply, 70);

 $headers = "From: $email" . PHP_EOL;
 $headers .= "Reply-To: $email" . PHP_EOL;
 $headers .= "MIME-Version: 1.0" . PHP_EOL;
 $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
 $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

 /* ini_set('SMTP', "server.com");
 ini_set('smtp_port', "25");
 ini_set('sendmail_from', "email@domain.com"); */

 if(mail($address, $subject, $msg, $headers)) {

	 // Email has sent successfully, echo a success page.
	 header("Location: mensaje.html");
	
 } else {

	 echo 'ERROR! Please ensure PHP Mail() is correctly configured on this server.';

 }

function isEmail($email) { // Email address verification, do not edit.

	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));

} ?>