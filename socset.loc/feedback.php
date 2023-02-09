<?php
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
$human = $_POST['human'];
$from = 'From: TangledDemo';
$to = 'delta.weell@gmail.com';
$subject = 'Hello';

$body = "From: $name\n E-Mail: $email\n Message:\n $message";

if ($_POST['submit'] && $human == '4') {
	if (mail($to, $subject, $body, $from)) {
		echo '<p>Your message has been sent!</p>';
	} else {
		echo '<p>Something went wrong, go back and try again!</p>';
	}
} else if ($_POST['submit'] && $human != '4') {
	echo '<p>You answered the anti-spam question incorrectly!</p>';
}
?>
<!-- <script language="JavaScript" type="text/javascript">
	function changeurl() {
		eval(self.location = "http://socset.loc/index%20page/index.php");
	}
	window.setTimeout("changeurl();", 3000);
</script> -->