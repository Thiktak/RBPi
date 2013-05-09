<?php

$code = $get_error = isset($_GET['error']) ? intval($_GET['error']) : null;

$errors = array();

$errors['401'] = array('Authorization required', 'This server could not verify that you are authorized to access the document requested.<br />Either you supplied the wrong credentials (e.g., bad password), or your browser doesn\'t understand how to supply the credentials required.');
$errors['403'] = array('Forbidden', 'You don\'t have permission to access <em>[REQUEST_URI]</em> on this server.');
$errors['404'] = array('Not Found', 'The requested URL <em>[REQUEST_URI]</em> was not found on this server.');
$errors['406'] = array('Not Acceptable', 'The requested file exists but cannot be used as the client system doesn\'t understand the format the file is configured for.');
$errors['408'] = array('Request Timed Out', 'The server took longer than its allowed time to process the request. Often caused by heavy net traffic.');
$errors['500'] = array('Internal Server Error', 'The server encountered an internal error or misconfiguration and was unable to complete your request.<br />Please contact the server administrator, <a href="mailto:[SERVER_ADMIN]"><em>[SERVER_ADMIN]</em></a> and inform them of the time the error occurred, and anything you might have done that may have caused the error.<br />More information about this error may be available in the server error log.');
$errors['503'] = array('Service Unavailable', 'The service or file that is being requested is not currently available.');

if( isset($errors[$get_error]) )
    list($title, $message) = $errors[$get_error];
else
    list($code, $title, $message) = array('\\o/', 'Unknown error', 'Hum ... It\'s strangeberry, no ?');

$message = preg_replace_callback('`\[([A-Z_]+)\]`', function($m) {
    return isset($_SERVER[$m[1]]) ? $_SERVER[$m[1]] : $m[1];
}, $message);

?><!DOCTYPE html>
<html>
  <head>
    <title><?php echo $code; ?> - <?php echo $title; ?></title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="<?php echo BASEDIR_RBPI; ?>/_index/style.css">
  </head>
  <body class="error">
    <div id="error-links">
      <a href="../" class="pi">Up</a>
      <a href="/" class="ppi">/</a>
    </div>
    <div id="error-global">
      <header id="error-header">
        <hgroup>
          <h1 class="pi"><?php echo $code; ?></h1>
          <h2 class="ppi"><?php echo $title; ?></h2>
        </hgroup>
      </header>
      <div id="error-content">
        <?php echo $message; ?>
        <?php echo $_SERVER['SERVER_SIGNATURE']; ?>
      </div>
    </div>
  </body>
</html>