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

define('IN_SCRIPT',1);
define('HESK_PATH','./');
define('HESK_NO_ROBOTS',1);

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');

// Are we in maintenance mode?
hesk_check_maintenance();

hesk_load_database_functions();
session_start();

$hesk_error_buffer = array();
$do_remember = '';
$display = 'none';

/* Was this accessed by the form or link? */
$is_form = isset($_GET['f']) ? 1 : 0;

/* Get the tracking ID */
$trackingID = hesk_cleanID();

/* Email required to view ticket? */
$my_email = hesk_getCustomerEmail(1);

/* A message from ticket reminder? */
if ( ! empty($_GET['remind']) )
{
    $display = 'block';
	print_form();
}

/* Any errors? Show the form */
if ($is_form)
{
	if ( empty($trackingID) )
    {
    	$hesk_error_buffer[] = $hesklang['eytid'];
    }

    if ($hesk_settings['email_view_ticket'] && empty($my_email) )
    {
    	$hesk_error_buffer[] = $hesklang['enter_valid_email'];
    }

    $tmp = count($hesk_error_buffer);
    if ($tmp == 1)
    {
    	$hesk_error_buffer = implode('',$hesk_error_buffer);
		hesk_process_messages($hesk_error_buffer,'NOREDIRECT');
        print_form();
    }
    elseif ($tmp == 2)
    {
    	$hesk_error_buffer = $hesklang['pcer'].'<br /><br /><ul><li>'.$hesk_error_buffer[0].'</li><li>'.$hesk_error_buffer[1].'</li></ul>';
		hesk_process_messages($hesk_error_buffer,'NOREDIRECT');
        print_form();
    }
}
elseif ( empty($trackingID) || ( $hesk_settings['email_view_ticket'] && empty($my_email) ) )
{
	print_form();
}

/* Connect to database */
hesk_dbConnect();

/* Limit brute force attempts */
//hesk_limitBfAttempts();         //Ermedita - reply ticket pa limit

/* Get ticket info */
$res = hesk_dbQuery( "SELECT `t1`.* , `t2`.name AS `repliername` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` AS `t1` LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."users` AS `t2` ON `t1`.`replierid` = `t2`.`id` WHERE `trackid`='".hesk_dbEscape($trackingID)."' LIMIT 1");

/* Ticket found? */
if (hesk_dbNumRows($res) != 1)
{
	/* Ticket not found, perhaps it was merged with another ticket? */
	$res = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` WHERE `merged` LIKE '%#".hesk_dbEscape($trackingID)."#%' LIMIT 1");

	if (hesk_dbNumRows($res) == 1)
	{
    	/* OK, found in a merged ticket. Get info */
     	$ticket = hesk_dbFetchAssoc($res);

		/* If we require e-mail to view tickets check if it matches the one from merged ticket */
		if ( hesk_verifyEmailMatch($ticket['trackid'], $my_email, $ticket['email'], 0) )
        {
        	hesk_process_messages( sprintf($hesklang['tme'], $trackingID, $ticket['trackid']) ,'NOREDIRECT','NOTICE');
            $trackingID = $ticket['trackid'];
        }
        else
        {
        	hesk_process_messages( sprintf($hesklang['tme1'], $trackingID, $ticket['trackid']) . '<br /><br />' . sprintf($hesklang['tme2'], $ticket['trackid']) ,'NOREDIRECT','NOTICE');
            $trackingID = $ticket['trackid'];
            print_form();
        }
	}
    else
    {
    	/* Nothing found, error out */
	    hesk_process_messages($hesklang['ticket_not_found'],'NOREDIRECT');
	    print_form();
    }
}
else
{
	/* We have a match, get ticket info */
	$ticket = hesk_dbFetchAssoc($res);

	/* If we require e-mail to view tickets check if it matches the one in database */
	hesk_verifyEmailMatch($trackingID, $my_email, $ticket['email']);
}

/* Ticket exists, clean brute force attempts */
hesk_cleanBfAttempts();

/* Remember email address? */
if ($is_form)
{
	if ( ! empty($_GET['r']) )
	{
		setcookie('hesk_myemail', $my_email, strtotime('+1 year'));
		$do_remember = ' checked="checked" ';
	}
	elseif ( isset($_COOKIE['hesk_myemail']) )
	{
		setcookie('hesk_myemail', '');
	}
}

/* Set last replier name */
if ($ticket['lastreplier'])
{
	if (empty($ticket['repliername']))
	{
		$ticket['repliername'] = $hesklang['staff'];
	}
}
else
{
	$ticket['repliername'] = $ticket['name'];
}

/* Get category name and ID */
$result = hesk_dbQuery("SELECT `name` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` WHERE `id`='".intval($ticket['category'])."' LIMIT 1");

/* If this category has been deleted use the default category with ID 1 */
if (hesk_dbNumRows($result) != 1)
{
	$result = hesk_dbQuery("SELECT `name` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` WHERE `id`='1' LIMIT 1");
}

$category = hesk_dbFetchAssoc($result);

/* Get replies */
$result  = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."replies` WHERE `replyto`='".intval($ticket['id'])."' ORDER BY `id` ".($hesk_settings['new_top'] ? 'DESC' : 'ASC') );
$replies = hesk_dbNumRows($result);
$unread_replies = array();

// Demo mode
if ( defined('HESK_DEMO') )
{
	$ticket['email'] = 'hidden@demo.com';
}

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');
?>

<nav class="row navbar navbar-default" id="showTopBar-indexPhp">
	<div class="menu-wrapper">
		<div class="container showTopBar"><?php hesk_showTopBar($hesk_settings['hesk_title']); ?></div>
	</div>
</nav>

	<nav class="row navbar userMenu">
      <div class="container">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<li id="userMenu-home"><a href="index.php"><?php echo $hesklang['main_page']; ?></a></li>
			<li id="userMenu-submitTicket"><a href="index.php?a=add">Submit Ticket</a></li>
			<li id="client-username"><a href="client_profile.php">Hello, <?php if (isset($_SESSION['id']['user']) && $_SESSION['id']['user'] ) {echo $_SESSION['id']['user']; }?></a></li>
			<li id="userMenu-logout"><a href="logout.php">Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>	
<!--$hesklang['cid'].': '.$trackingID-->
<br/>
<div class="container siteUrl-title-ticketPhp">
	<div class="form-inline">
		<span><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller"><?php echo $hesk_settings['site_title']; ?></a> &gt;
		<a href="<?php echo $hesk_settings['hesk_url']; ?>" class="smaller"><?php echo $hesk_settings['hesk_title']; ?></a>
		&gt; <?php echo $hesklang['your_ticket']; ?></span>
	</div>
</div><!-- end siteUrl-title-ticketPhp -->

<br/>


<?php
/* This will handle error, success and notice messages */
hesk_handle_messages();

/*
* If the ticket has been reopened by customer:
* - show the "Add a reply" form on top
* - and ask them why the form has been reopened
*/
if (isset($_SESSION['force_form_top']))
{
    hesk_printCustomerReplyForm(1);
    echo ' <p>&nbsp;</p> ';

    unset($_SESSION['force_form_top']);
}
?>

<br/>

<div class="container col-sm-8 col-sm-offset-2 ticket-name"><h3><?php echo $ticket['name']; ?></h3></div>

<div class="conatiner col-sm-8 col-sm-offset-2 start-helpDesk-ticket">
	<div class="row ticket-head-info">
		<div>
			&nbsp;
			<div>
				<!-- START TICKET HEAD -->

				<div class="container ticket-head-info">
					<?php

					if ($hesk_settings['sequential'])
					{
						echo '<div class="row">
						<label class="col-sm-2">'.$hesklang['seqid'].': </label>
						<span>' .$ticket['id'].'</span>
						</div>';
					}
					else
					{
						echo '<div class="row">
						<label class="col-sm-2">'.$hesklang['seqid'].': </label>
						<span>'.$ticket['id'].'</span>
						</div>';
					}

					echo '
					<div class="row">
					<label class="col-sm-2">'.$hesklang['ticket_status'].': </label>
					<span>';

					$close_link = $hesk_settings['custclose'] ? ' [<a class="" href="change_status.php?track='.$trackingID.$hesk_settings['e_query'].'&amp;s=3&amp;Refresh='.rand(10000,99999).'&amp;token='.hesk_token_echo(0).'">'.$hesklang['close_action'].'</a>]' : '';

					switch ($ticket['status'])
					{
						case 0:
							echo '<font class="open">'.$hesklang['open'].'</font>' . $close_link;
							break;
						case 1:
							echo '<font class="replied">'.$hesklang['wait_staff_reply'].'</font>' . $close_link;
							break;
						case 2:
							echo '<font class="waitingreply">'.$hesklang['wait_cust_reply'].'</font>' . $close_link;
							break;
						case 4:
							echo '<font class="inprogress">'.$hesklang['in_progress'].'</font>' . $close_link;
							break;
						case 5:
							echo '<font class="onhold">'.$hesklang['on_hold'].'</font>' . $close_link;
							break;
						default:
							echo '<font class="resolved">'.$hesklang['closed'].'</font>';
							if ($ticket['locked'] != 1 && $hesk_settings['custopen'])
							{
								echo ' [<a href="change_status.php?track='.$trackingID.$hesk_settings['e_query'].'&amp;s=2&amp;Refresh='.rand(10000,99999).'&amp;token='.hesk_token_echo(0).'">'.$hesklang['open_action'].'</a>]';
							}
					}

					echo '</span>
					</div>
					<div class="row">
					<label class="col-sm-2">'.$hesklang['created_on'].': </label>
					<span>'.hesk_date($ticket['dt'], true).'</span>
					</div>
					<div class="row">
					<label class="col-sm-2">'.$hesklang['last_update'].': </label>
					<span>'.hesk_date($ticket['lastchange'], true).'</span>
					</div>
					<div class="row">
					<label class="col-sm-2">'.$hesklang['last_replier'].': </label>
					<span>'.$ticket['repliername'].'</span>
					</div>
					<div class="row">
					<label class="col-sm-2">'.$hesklang['category'].': </label>
					<span>'.$category['name'].'</span>
					</div>
					<div class="row">
					<label class="col-sm-2">'.$hesklang['replies'].': </label>
					<span>'.$replies.'</span>
					</div>
					';

					if ($hesk_settings['cust_urgency'])
					{
						echo '
						<div class="row">
						<label class="col-sm-2">'.$hesklang['priority'].': </label>
						<span>';
						if ($ticket['priority']==0) {echo '<font class="critical">'.$hesklang['critical'].'</font>';}
						elseif ($ticket['priority']==1) {echo '<font class="important">'.$hesklang['high'].'</font>';}
						elseif ($ticket['priority']==2) {echo '<font class="medium">'.$hesklang['medium'].'</font>';}
						else {echo $hesklang['low'];}
						echo '
						</span>
						</div>
						';
					}

					?>
				</div><!-- end ticket-head-info -->

				<!-- END TICKET HEAD -->
			</div>
			&nbsp;
		</div>
	</div><!-- end ticket-head-info-ticketPhp -->

<hr />
<?php
// Print "Submit a reply" form?
if ($ticket['locked'] != 1 && $ticket['status'] != 3 && $hesk_settings['reply_top'] == 1)
{
	hesk_printCustomerReplyForm();
}
?>

<!-- TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES -->
<div class="row ticket-info-name-dt-email-message">
	<div>
		&nbsp;
		<div>
		<!-- START TICKET REPLIES -->

			<div class="container">

				<?php
				if ($hesk_settings['new_top'])
				{
					$i = hesk_printCustomerTicketReplies() ? 0 : 1;
				}
				else
				{
					$i = 1;
				}

				/* Make sure original message is in correct color if newest are on top */
				$color = $i ? 'class="ticketalt"' : 'class="ticketrow"';
				?>

				<div>
					<!--<div <?php echo $color; ?>>-->

						<div class="name-dt-email-info">
									<div class="row">
										<label class="col-sm-2 tickettd"><?php echo $hesklang['date']; ?>:</label>
										<span class="tickettd"><?php echo hesk_date($ticket['dt'], true); ?></span>
										<span id="print-ticketPhp">
											<?php echo hesk_getCustomerButtons($i); ?>
										</span>
									</div>
									<div class="row">
										<label class="col-sm-2 tickettd"><?php echo $hesklang['name']; ?>:</label>
										<span class="tickettd"><?php echo $ticket['name']; ?></span>
									</div>
									<div class="row">
										<label class="col-sm-2 tickettd"><?php echo $hesklang['email']; ?>:</label>
										<span class="tickettd"><?php echo $ticket['email']; ?></span>
									</div><!-- end name-dt-email-table -->
						</div><!-- end name-dt-email-info -->

					<?php
					/* custom fields before message */
					$print_table = 0;
					$myclass = ' class="tickettd"';

					foreach ($hesk_settings['custom_fields'] as $k=>$v)
					{
						if ($v['use'] && $v['place']==0)
						{
							if ($print_table == 0)
							{
								echo '<div class="custom-fields-before-message">';
								$print_table = 1;
							}

							echo '
							<div class="row">
							<label class="col-sm-2" '.$myclass.'>'.$v['name'].':</label>
							<span'.$myclass.'>'.$ticket[$k].'</span>
							</div>
							';
						}
					}
					if ($print_table)
					{
						echo '</div>';						/*end custom-fields-before-message*/
					}
					?>
					<div class="form-inline" id="message_client_ticket">
						<label class="col-sm-2 control-label"><?php echo $hesklang['message']; ?>:</label>
						<span id="msg-ticketReplies" class="form-control" style="width: 443px; height: 123px;"><?php echo $ticket['message']; ?></span>
					</div>

					<?php
					/* custom fields after message */
					$print_table = 0;
					$myclass = 'class="tickettd"';

					foreach ($hesk_settings['custom_fields'] as $k=>$v)
					{
						if ($v['use'] && $v['place'])
						{
							if ($print_table == 0)
							{
								echo '<div class="custom-fields-after-message">';
								$print_table = 1;
							}

							echo '
							<div class="row">
							<label class="col-sm-2" '.$myclass.'>'.$v['name'].':</label>
							<span '.$myclass.'>'.$ticket[$k].'</span>
							</div>
							';
						}
					}
					if ($print_table)
					{
						echo '</div>';						/*end custom-fields-after-message*/
					}

					/* Print attachments */
					hesk_listAttachments($ticket['attachments'], $i);
					?>

					
				</div>

				<?php
				if ( ! $hesk_settings['new_top'])
				{
					hesk_printCustomerTicketReplies();
				}
				?>

		</div>

		<!-- END TICKET REPLIES -->
		</div>
		&nbsp;
	</div>
</div><!-- end ticket-info-name-dt-email-message -->
</div>

<!-- TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES TICKET REPLIES -->
<?php
/* Print "Submit a reply" form? */
if ($ticket['locked'] != 1 && $ticket['status'] != 3 && ! $hesk_settings['reply_top'])
{
	hesk_printCustomerReplyForm();
}

/* If needed update unread replies as read for staff to know */
if ( count($unread_replies) )
{
	hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."replies` SET `read` = '1' WHERE `id` IN ('".implode("','", $unread_replies)."')");
}

/* Clear unneeded session variables */
hesk_cleanSessionVars('ticket_message');
require_once(HESK_PATH . 'inc/footer.inc.php');

/*** START FUNCTIONS ***/

function print_form()
{
	global $hesk_settings, $hesklang;
    global $hesk_error_buffer, $my_email, $trackingID, $do_remember, $display;

	/* Print header */
	$hesk_settings['tmp_title'] = $hesk_settings['hesk_title'] . ' - ' . $hesklang['view_ticket'];
	require_once(HESK_PATH . 'inc/header.inc.php');
?>

<nav class="row navbar navbar-default" id="showTopBar-indexPhp">
	<div class="menu-wrapper">
		<div class="container showTopBar"><?php hesk_showTopBar($hesk_settings['hesk_title']); ?></div>
	</div>
</nav>

	<nav class="row navbar userMenu">
      <div class="container">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<li id="userMenu-home"><a href="index.php"><?php echo $hesklang['main_page']; ?></a></li>
			<li id="userMenu-submitTicket"><a href="index.php?a=add">Submit Ticket</a></li>
			<li id="client-username"><a href="client_profile.php">Hello, <?php if (isset($_SESSION['id']['user']) && $_SESSION['id']['user'] ) {echo $_SESSION['id']['user']; }?></a></li>
			<li id="userMenu-logout"><a href="logout.php">Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>	
<?php /*hesk_showTopBar($hesklang['view_ticket']); */?>	 <!-- show view-ticket-title -->

<div class="container siteUrl-title-view-ticket-ticketPhp">
	<div class="form-inline">
		<span class="smaller"><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller"><?php echo $hesk_settings['site_title']; ?></a> &gt;
		<a href="<?php echo $hesk_settings['hesk_url']; ?>" class="smaller"><?php echo $hesk_settings['hesk_title']; ?></a>
		&gt; <?php echo $hesklang['view_ticket']; ?></span>
	</div>
</div>


<br/><br/><br/>

<?php
/* This will handle error, success and notice messages */
hesk_handle_messages();
?>
<div class="form-group existing-ticket" align="center">
	<div class="form-inline">
		<img src="img/existingticket.jpg" alt="existingticket"/>
		<label class="control-label"><?php echo $hesklang['view_existing']; ?></a></label>
	</div>
	<br/>
	<div class="view-existing-ticket-ticketPhp">
		<form action="ticket.php" method="get" name="form2">
			<div class="form-group">
				&nbsp;
				&nbsp;
				<div class="form-inline">
					&nbsp;	
					<label class="control-label" for="ticket-tracking-search"><?php echo $hesklang['ticket_trackID']; ?>:</label><br/> <br /><input class="form-control" id="ticket-tracking-search" type="text" name="track" maxlength="20" size="35" value="<?php echo $trackingID; ?>" /><br />&nbsp;		
				</div>
				<?php
					$tmp = '';
					if ($hesk_settings['email_view_ticket'])
						{
							$tmp = 'document.form1.email.value=document.form2.e.value;';
				?>
				<div class="form-group">
					&nbsp;
					<?php echo $hesklang['email']; ?>: <br /><input type="text" name="e" size="35" value="<?php echo $my_email; ?>" /><br />&nbsp;<br />
						<label for="ticket-trackingId"><input type="checkbox" id="ticket-trackingId" name="r" value="Y" <?php echo $do_remember; ?> /> <?php echo $hesklang['rem_email']; ?></label><br />&nbsp;		
				</div>
				<?php
						}
				?>
				<div class="form-group">
					&nbsp;
						<input id="button-tid" type="submit" value="<?php echo $hesklang['view_ticket']; ?>" class="btn btn-default" /><input type="hidden" name="Refresh" value="<?php echo rand(10000,99999); ?>"><input type="hidden" name="f" value="1">
				</div>
				<div class="form-group forgot-tid">
					&nbsp;<br /><a href="Javascript:void(0)" onclick="javascript:hesk_toggleLayerDisplay('forgot');<?php echo $tmp; ?>"><?php echo $hesklang['forgot_tid'];?></a>				
				</div>
			</div>
		</form>
		&nbsp;
					
		<div id="forgot" class="forgot-ticketId" style="display: <?php echo $display; ?>;">
			<form action="index.php" method="post" name="form1">
				<div class="form-inline forgotTicketId"><br />&nbsp;<br /><?php echo $hesklang['tid_mail']; ?><br /><br/>
					<input class="form-control" type="text" name="email" size="35" value="<?php echo $my_email; ?>" /><input type="hidden" name="a" value="forgot_tid" />
				</div><br />&nbsp;<br />
				<div class="form-group tickeIdRadio">
					<input type="radio" name="open_only" value="1" <?php echo $hesk_settings['open_only'] ? 'checked="checked"' : ''; ?> /><label id="tickeIdRadio"><?php echo $hesklang['oon1']; ?></label><br />
					<input type="radio" name="open_only" value="0" <?php echo ! $hesk_settings['open_only'] ? 'checked="checked"' : ''; ?> /><label id="tickeIdRadio"><?php echo $hesklang['oon2']; ?></label><br />&nbsp;<br />
				</div>
				<input  id="button-forgot-tid" type="submit" value="<?php echo $hesklang['tid_send']; ?>" class="btn btn-default" />
			</form> <br/>
		</div>
	</div><!-- end view-existing-ticket-ticketPhp -->
</div>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
} // End print_form()


function hesk_printCustomerReplyForm($reopen=0)
{
	global $hesklang, $hesk_settings, $trackingID, $my_email;

	// Already printed?
	if (defined('REPLY_FORM'))
	{
		return '';
	}

	?>

<br />

<div class="col-sm-8 col-sm-offset-2" id="addreply-title"><?php echo $hesklang['add_reply']; ?></div>
<br/>
<div class="conatiner col-sm-8 col-sm-offset-2 start-helpDesk-ticket">
	<div class="row add-reply-ticket-ticketPhp">
			<br/>
			<div class="container">
				<form method="post" action="reply_ticket.php" enctype="multipart/form-data">
					<div class="form-inline">
						<label class="col-sm-2 control-label addreply-message"><?php echo $hesklang['message']; ?>: <span class="important">*</span></label>
						<textarea class="form-control" name="message" rows="12" cols="60" style="width: 443px; height: 246px;"><?php if (isset($_SESSION['ticket_message'])) {echo stripslashes(hesk_input($_SESSION['ticket_message']));} ?></textarea>
					</div>					
	<br/>						
					<?php
					/* attachments */
					if ($hesk_settings['attachments']['use'])
					{
					?>

				<div class="form-group attachments-support-request">
					<div class="form-inline">
						<label class="col-sm-2 control-label addreply-attachments"><?php echo $hesklang['attachments']; ?>:</label>
						<div class="form-group">
							<?php
							for ($i=1;$i<=$hesk_settings['attachments']['max_number'];$i++)
							{
								
								echo '<input type="file" name="attachment['.$i.']" size="50" ' .' style="margin-bottom: 10px;"/>';
							}
							?>
							<a href="file_limits.php" target="_blank" onclick="Javascript:hesk_window('file_limits.php',250,500);return false;"><?php echo $hesklang['ful']; ?></a>
						</div>
					</div>
				</div><!-- end attachments-support-request -->
				
	<br/><br/>
					<?php
					}
					if (isset($_SESSION['ticket_message'])) {echo stripslashes(hesk_input($_SESSION['ticket_message']));}
					?>


					<p align="center">
					<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
					<input type="hidden" name="orig_track" value="<?php echo $trackingID; ?>" />
					<?php
					if ($hesk_settings['email_view_ticket'])
					{
						echo '<input type="hidden" name="e" value="' . $my_email . '" />';
					}
					if ($reopen)
					{
						echo '<input type="hidden" name="reopen" value="1" />';
					}
					?>
					<input type="submit" value="<?php echo $hesklang['submit_reply']; ?>" class="btn btn-default" id="submit-addReply" /></p>

				</form>

			</div>
	</div><!-- end add-reply-ticket-ticketPhp -->
</div>


	<?php

    // Make sure the form is only printed once per page
    define('REPLY_FORM', true);

} // End hesk_printCustomerReplyForm()


function hesk_printCustomerTicketReplies()
{
	global $hesklang, $hesk_settings, $result, $reply, $trackingID, $unread_replies;

	$i = $hesk_settings['new_top'] ? 0 : 1;

	while ($reply = hesk_dbFetchAssoc($result))
	{
		if ($i) {$color = 'class="ticketrow"'; $i=0;}
		else {$color = 'class="ticketalt"'; $i=1;}

		/* Store unread reply IDs for later */
		if ($reply['staffid'] && ! $reply['read'])
		{
			$unread_replies[] = $reply['id'];
		}

		$reply['dt'] = hesk_date($reply['dt'], true);
		?>
		
		<br/>
		<div id="hr_for_ticket"><hr/></div>
		<br/>
		<div class="store-unread-reply-ids-later">
			<div <?php echo $color; ?>>
			<div class="row date-dt-second">
				<label class="col-sm-2"><?php echo $hesklang['date']; ?>:</label>
				<span><?php echo $reply['dt']; ?></span>
				<span id="getCustomerButtons-ticket.php-second">
					<?php /*echo hesk_getCustomerButtons($i);*/ ?>
				</span>
			</div>
			<div class="row name-ticket-second">
				<label class="col-sm-2"><?php echo $hesklang['name']; ?>:</label>
				<span><?php echo $reply['name']; ?></span>
			</div>
			<div class="row name-ticket-second">
				<label class="col-sm-2"><?php echo $hesklang['message']; ?>:</label>
				<span><?php echo $reply['message']; ?></span>
			</div>

				<?php

				/* Attachments */
				hesk_listAttachments($reply['attachments'],$i);

				/* Staff rating */
				if ($hesk_settings['rating'] && $reply['staffid'])
				{
					if ($reply['rating']==1)
					{
						echo '<p class="rate">'.$hesklang['rnh'].'</p>';
					}
					elseif ($reply['rating']==5)
					{
						echo '<p class="rate">'.$hesklang['rh'].'</p>';
					}
					else
					{
						echo '
						<div id="rating'.$reply['id'].'" class="rate">
						'.$hesklang['r'].'
						<a href="Javascript:void(0)" onclick="Javascript:hesk_rate(\'rate.php?rating=5&amp;id='.$reply['id'].'&amp;track='.$trackingID.'\',\'rating'.$reply['id'].'\')">'.strtolower($hesklang['yes']).'</a> /
						<a href="Javascript:void(0)" onclick="Javascript:hesk_rate(\'rate.php?rating=1&amp;id='.$reply['id'].'&amp;track='.$trackingID.'\',\'rating'.$reply['id'].'\')">'.strtolower($hesklang['no']).'</a>
						</div>
						';
					}
				}
				?>
	        </div>
        </div>
        <?php
	}

    return $i;

} // End hesk_printCustomerTicketReplies()


function hesk_listAttachments($attachments='', $white=1)
{
	global $hesk_settings, $hesklang, $trackingID;

	/* Attachments disabled or not available */
	if ( ! $hesk_settings['attachments']['use'] || ! strlen($attachments) )
    {
    	return false;
    }

    /* Style and mousover/mousout */
    $tmp = $white ? 'White' : 'Blue';
    $style = 'class="option'.$tmp.'OFF" onmouseover="this.className=\'option'.$tmp.'ON\'" onmouseout="this.className=\'option'.$tmp.'OFF\'"';

	/* List attachments */
	echo '<p><b>'.$hesklang['attachments'].':</b><br />';
	$att=explode(',',substr($attachments, 0, -1));
	foreach ($att as $myatt)
	{
		list($att_id, $att_name) = explode('#', $myatt);

		echo '
		<a href="download_attachment.php?att_id='.$att_id.'&amp;track='.$trackingID.$hesk_settings['e_query'].'"><img src="img/clip.png" width="16" height="16" alt="'.$hesklang['dnl'].' '.$att_name.'" title="'.$hesklang['dnl'].' '.$att_name.'" '.$style.' /></a>
		<a href="download_attachment.php?att_id='.$att_id.'&amp;track='.$trackingID.$hesk_settings['e_query'].'">'.$att_name.'</a><br />
        ';
	}
	echo '</p>';

    return true;
} // End hesk_listAttachments()


function hesk_getCustomerButtons($white=1)
{
	global $hesk_settings, $hesklang, $trackingID;

	$options = '';

    /* Style and mousover/mousout */
    $tmp = $white ? 'White' : 'Blue';
    $style = 'class="option'.$tmp.'OFF" onmouseover="this.className=\'option'.$tmp.'ON\'" onmouseout="this.className=\'option'.$tmp.'OFF\'"';

	/* Print ticket button */
    $options .= '<a href="print.php?track='.$trackingID.$hesk_settings['e_query'].'"><img src="img/print.png" width="16" height="16" alt="'.$hesklang['printer_friendly'].'" title="'.$hesklang['printer_friendly'].'" '.$style.' /></a> ';

    /* Return generated HTML */
    return $options;

} // END hesk_getCustomerButtons()
?>