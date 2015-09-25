<?php
/*******************************************************************************
*  Title: Help Desk Software HESK
*  Version: 2.6.2 from 18th March 2015
*  Author: Klemen Stirn
*  Website: http://www.hesk.com
********************************************************************************
*  COPYRIGHT AND TRADEMARK NOTICE
*  Copyright 2005-2015 Klemen Stirn. All Rights Reserved.
*  HESK is a registered trademark of Klemen Stirn.

*  The HESK may be used and modified free of charge by anyone
*  AS LONG AS COPYRIGHT NOTICES AND ALL THE COMMENTS REMAIN INTACT.
*  By using this code you agree to indemnify Klemen Stirn from any
*  liability that might arise from it's use.

*  Selling the code for this program, in part or full, without prior
*  written consent is expressly forbidden.

*  Using this code, in part or full, to create derivate work,
*  new scripts or products is expressly forbidden. Obtain permission
*  before redistributing this software over the Internet or in
*  any other medium. In all cases copyright and header must remain intact.
*  This Copyright is in full effect in any country that has International
*  Trade Agreements with the United States of America or
*  with the European Union.

*  Removing any of the copyright notices without purchasing a license
*  is expressly forbidden. To remove HESK copyright notice you must purchase
*  a license for this script. For more information on how to obtain
*  a license please visit the page below:
*  https://www.hesk.com/buy.php
*******************************************************************************/

/* Check if this is a valid include */
if (!defined('IN_SCRIPT')) {die('Invalid attempt');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo (isset($hesk_settings['tmp_title']) ? $hesk_settings['tmp_title'] : $hesk_settings['hesk_title']); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $hesklang['ENCODING']; ?>" />
	<link href="<?php echo HESK_PATH; ?>bootstrap/css/bootstrap-responsive.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo HESK_PATH; ?>bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo HESK_PATH; ?>hesk_style.css" type="text/css" rel="stylesheet" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script language="Javascript" type="text/javascript" src="<?php echo HESK_PATH; ?>bootstrap/js/bootstrap.min.js"></script>
	<script language="Javascript" type="text/javascript" src="<?php echo HESK_PATH; ?>hesk_javascript.js"></script>
	<script language="Javascript" type="text/javascript" src="<?php echo HESK_PATH; ?>/js/custom.js"></script>
	
	<!-- Bootstrap multi select
	<script type="text/javascript" src= "<?php echo HESK_PATH; ?>/bootstrap-multiselect/js/jquery-2.1.0.min.js"></script> -->
	<script type="text/javascript" src= "<?php echo HESK_PATH; ?>/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>
	<link rel="stylesheet" href="<?php echo HESK_PATH; ?>/bootstrap-multiselect/css/bootstrap-multiselect.css" type="text/css"/>
	
    <?php
	/* Prepare Javascript that browser should load on page load */
    $onload = "javascript:var i=new Image();i.src='" . HESK_PATH . "img/orangebtnover.gif';var i2=new Image();i2.src='" . HESK_PATH . "img/greenbtnover.gif';";

	/* Tickets shouldn't be indexed by search engines */
	if (defined('HESK_NO_ROBOTS'))
	{
		?>
		<meta name="robots" content="noindex, nofollow" />
		<?php
	}

	/* If page requires calendar include calendar Javascript and CSS */
	if (defined('CALENDAR'))
	{
		?>
		<script language="Javascript" type="text/javascript" src="<?php echo HESK_PATH; ?>inc/calendar/tcal.php"></script>
		<link href="<?php echo HESK_PATH; ?>inc/calendar/tcal.css" type="text/css" rel="stylesheet" />
		<?php
	}

	/* If page requires WYSIWYG editor include TinyMCE Javascript */
	if (defined('WYSIWYG') && $hesk_settings['kb_wysiwyg'])
	{
		?>
		<script type="text/javascript" src="<?php echo HESK_PATH; ?>inc/tiny_mce/3.5.11/tiny_mce.js"></script>
		<?php
	}

	/* If page requires tabs load tabs Javascript and CSS */
	if (defined('LOAD_TABS'))
	{
		?>
		<link href="<?php echo HESK_PATH; ?>inc/tabs/tabber.css" type="text/css" rel="stylesheet" />
		<?php
	}

	/* If page requires timer load Javascript */
	if (defined('TIMER'))
	{
		?>
		<script language="Javascript" type="text/javascript" src="<?php echo HESK_PATH; ?>inc/timer/hesk_timer.js"></script>
		<?php

        /* Need to load default time or a custom one? */
        if ( isset($_SESSION['time_worked']) )
        {
        	$t = hesk_getHHMMSS($_SESSION['time_worked']);
			$onload .= "load_timer('time_worked', " . $t[0] . ", " . $t[1] . ", " . $t[2] . ");";
            unset($t);
        }
        else
        {
        	$onload .= "load_timer('time_worked', 0, 0, 0);";
        }

		/* Autostart timer? */
		if ( ! empty($_SESSION['autostart']) )
		{
			$onload .= "ss();";
		}
	}

	// Use ReCaptcha API v2?
	if (defined('RECAPTCHA'))
	{
		echo '<script src="https://www.google.com/recaptcha/api.js?hl='.$hesklang['RECAPTCHA'].'" async defer></script>';
	}
	?>
</head>
<body onload="<?php echo $onload; unset($onload); ?>">

<?php
include(HESK_PATH . 'header.txt');
?>

<div  class="container-fluid wrapper">
