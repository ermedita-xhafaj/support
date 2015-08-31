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
define('HESK_PATH','../');

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/admin_functions.inc.php');
hesk_load_database_functions();

hesk_session_start();
hesk_dbConnect();
hesk_isLoggedIn();

/* Check permissions for this feature */
hesk_checkPermission('can_view_tickets');
hesk_checkPermission('can_edit_tickets');

/* Ticket ID */
$trackingID = hesk_cleanID() or die($hesklang['int_error'].': '.$hesklang['no_trackID']);

$is_reply = 0;
$tmpvar = array();

/* Get ticket info */
$result = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` WHERE `trackid`='".hesk_dbEscape($trackingID)."' LIMIT 1");
if (hesk_dbNumRows($result) != 1)
{
	hesk_error($hesklang['ticket_not_found']);
}
$ticket = hesk_dbFetchAssoc($result);

// Demo mode
if ( defined('HESK_DEMO') )
{
	$ticket['email']	= 'hidden@demo.com';
}

/* Is this user allowed to view tickets inside this category? */
hesk_okCategory($ticket['category']);

if ( hesk_isREQUEST('reply') )
{
	$tmpvar['id'] = intval( hesk_REQUEST('reply') ) or die($hesklang['id_not_valid']);

	$result = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."replies` WHERE `id`='{$tmpvar['id']}' AND `replyto`='".intval($ticket['id'])."' LIMIT 1");
	if (hesk_dbNumRows($result) != 1)
    {
    	hesk_error($hesklang['id_not_valid']);
    }
    $reply = hesk_dbFetchAssoc($result);
    $ticket['message'] = $reply['message'];
    $is_reply = 1;
}

if (isset($_POST['save']))
{
	/* A security check */
	hesk_token_check('POST');

	$hesk_error_buffer = array();

    if ($is_reply)
    {
		$tmpvar['message'] = hesk_input( hesk_POST('message') ) or $hesk_error_buffer[]=$hesklang['enter_message'];

	    if (count($hesk_error_buffer))
	    {
	    	$myerror = '<ul>';
		    foreach ($hesk_error_buffer as $error)
		    {
		        $myerror .= "<li>$error</li>\n";
		    }
	        $myerror .= '</ul>';
	    	hesk_error($myerror);
	    }

		$tmpvar['message'] = hesk_makeURL($tmpvar['message']);
		$tmpvar['message'] = nl2br($tmpvar['message']);

    	hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."replies` SET `message`='".hesk_dbEscape($tmpvar['message'])."' WHERE `id`='".intval($tmpvar['id'])."' AND `replyto`='".intval($ticket['id'])."' LIMIT 1");
    }
    else
    {
		$tmpvar['name']    = hesk_input( hesk_POST('name') ) or $hesk_error_buffer[]=$hesklang['enter_your_name'];
		$tmpvar['email']   = hesk_validateEmail( hesk_POST('email'), 'ERR', 0) or $hesk_error_buffer[]=$hesklang['enter_valid_email'];
		$tmpvar['subject'] = hesk_input( hesk_POST('subject') ) or $hesk_error_buffer[]=$hesklang['enter_ticket_subject'];
		$tmpvar['message'] = hesk_input( hesk_POST('message') ) or $hesk_error_buffer[]=$hesklang['enter_message'];

		// Demo mode
		if ( defined('HESK_DEMO') )
		{
			$tmpvar['email'] = 'hidden@demo.com';
		}

	    if (count($hesk_error_buffer))
	    {
	    	$myerror = '<ul>';
		    foreach ($hesk_error_buffer as $error)
		    {
		        $myerror .= "<li>$error</li>\n";
		    }
	        $myerror .= '</ul>';
	    	hesk_error($myerror);
	    }

		$tmpvar['message'] = hesk_makeURL($tmpvar['message']);
		$tmpvar['message'] = nl2br($tmpvar['message']);

		foreach ($hesk_settings['custom_fields'] as $k=>$v)
		{
			if ($v['use'] && isset($_POST[$k]))
		    {
	        	if (is_array($_POST[$k]))
	            {
					$tmpvar[$k]='';
					foreach ($_POST[$k] as $myCB)
					{
						$tmpvar[$k] .= ( is_array($myCB) ? '' : hesk_input($myCB) ) . '<br />';
					}
					$tmpvar[$k]=substr($tmpvar[$k],0,-6);
	            }
	            else
	            {
		    		$tmpvar[$k]=hesk_makeURL(nl2br(hesk_input($_POST[$k])));
	            }
			}
		    else
		    {
		    	$tmpvar[$k] = '';
		    }
		}

		hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` SET
		`name`='".hesk_dbEscape($tmpvar['name'])."',
		`email`='".hesk_dbEscape($tmpvar['email'])."',
		`subject`='".hesk_dbEscape($tmpvar['subject'])."',
		`message`='".hesk_dbEscape($tmpvar['message'])."',
		`custom1`='".hesk_dbEscape($tmpvar['custom1'])."',
		`custom2`='".hesk_dbEscape($tmpvar['custom2'])."',
		`custom3`='".hesk_dbEscape($tmpvar['custom3'])."',
		`custom4`='".hesk_dbEscape($tmpvar['custom4'])."',
		`custom5`='".hesk_dbEscape($tmpvar['custom5'])."',
		`custom6`='".hesk_dbEscape($tmpvar['custom6'])."',
		`custom7`='".hesk_dbEscape($tmpvar['custom7'])."',
		`custom8`='".hesk_dbEscape($tmpvar['custom8'])."',
		`custom9`='".hesk_dbEscape($tmpvar['custom9'])."',
		`custom10`='".hesk_dbEscape($tmpvar['custom10'])."',
		`custom11`='".hesk_dbEscape($tmpvar['custom11'])."',
		`custom12`='".hesk_dbEscape($tmpvar['custom12'])."',
		`custom13`='".hesk_dbEscape($tmpvar['custom13'])."',
		`custom14`='".hesk_dbEscape($tmpvar['custom14'])."',
		`custom15`='".hesk_dbEscape($tmpvar['custom15'])."',
		`custom16`='".hesk_dbEscape($tmpvar['custom16'])."',
		`custom17`='".hesk_dbEscape($tmpvar['custom17'])."',
		`custom18`='".hesk_dbEscape($tmpvar['custom18'])."',
		`custom19`='".hesk_dbEscape($tmpvar['custom19'])."',
		`custom20`='".hesk_dbEscape($tmpvar['custom20'])."'
		WHERE `id`='".intval($ticket['id'])."' LIMIT 1");
    }

    unset($tmpvar);
    hesk_cleanSessionVars('tmpvar');

    hesk_process_messages($hesklang['edt2'],'admin_ticket.php?track='.$trackingID.'&Refresh='.mt_rand(10000,99999),'SUCCESS');
}

$ticket['message'] = hesk_msgToPlain($ticket['message'],0,0);

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print admin navigation */
require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');
?>

<!--
</td>
</tr>-->

<!-- start in this page end somewhere...
<tr>
<td>-->

<br/>


<div class="container"><a href="admin_ticket.php?track=<?php echo $trackingID; ?>&amp;Refresh=<?php echo mt_rand(10000,99999); ?>" class="smaller"><?php echo $hesklang['ticket'].' '.$trackingID; ?></a> &gt;
<?php echo $hesklang['edtt']; ?></div>

<br/><br/>

<div class="container edtt-title"><?php echo $hesklang['edtt']; ?></div>
<div class="edit-post-table">
	<div class="container">	
		<form method="post" action="edit_post.php" name="form1">

		<?php
		/* If it's not a reply edit all the fields */
		if (!$is_reply)
		{
			?>
			<br />

			<div>
				<div class="form-group edit-post-info-table">
					<div class="form-inline edit-post-info-row">
						<label class="col-sm-2" for="edit-post-subject"><?php echo $hesklang['subject']; ?>: </label>
						<input class="form-control" type="text" id="edit-post-subject" name="subject" size="40" maxlength="40" style="margin-right: 15px;" value="<?php echo $ticket['subject'];?>" />
					</div>
					
					<div class="form-inline edit-post-info-row">
						<label class="col-sm-2" for="edit-post-name"><?php echo $hesklang['name']; ?>: </label>
						<input class="form-control" type="text" id="edit-post-name" name="name" size="40" maxlength="30" value="<?php echo $ticket['name'];?>" />
					</div>
					
					<div class="form-inline">
						<label class="col-sm-2" for="edit-post-email"><?php echo $hesklang['email']; ?>: </label>
						<input class="form-control" type="text" id="edit-post-email" name="email" size="40" maxlength="1000" value="<?php echo $ticket['email'];?>" />
					</div>

					<?php
					foreach ($hesk_settings['custom_fields'] as $k=>$v)
					{
						if ($v['use'])
						{
							$k_value  = $ticket[$k];

							if ($v['type'] == 'checkbox')
							{
								$k_value = explode('<br />',$k_value);
							}

							switch ($v['type'])
							{
								/* Radio box */
								case 'radio':
									echo$v['name'].': ';

									$options = explode('#HESK#',$v['value']);

									foreach ($options as $option)
									{

										if (strlen($k_value) == 0 || $k_value == $option)
										{
											$k_value = $option;
											$checked = 'checked="checked"';
										}
										else
										{
											$checked = '';
										}

										echo '<label><input type="radio" name="'.$k.'" value="'.$option.'" '.$checked.' /> '.$option.'</label><br />';
									}

								break;

								/* Select drop-down box */
								case 'select':
									echo $v['name'].': <select name="'.$k.'">';

									// Show "Click to select"?
									$v['value'] = str_replace('{HESK_SELECT}', '', $v['value'], $num);
									if ($num)
									{
										echo '<option value="">'.$hesklang['select'].'</option>';
									}

									$options = explode('#HESK#',$v['value']);

									foreach ($options as $option)
									{

										if (strlen($k_value) == 0 || $k_value == $option)
										{
											$k_value = $option;
											$selected = 'selected="selected"';
										}
										else
										{
											$selected = '';
										}

										echo '<option '.$selected.'>'.$option.'</option>';
									}

									echo '</select>';
								break;

								/* Checkbox */
								case 'checkbox':
									echo $v['name'].': ';

									$options = explode('#HESK#',$v['value']);

									foreach ($options as $option)
									{

										if (in_array($option,$k_value))
										{
											$checked = 'checked="checked"';
										}
										else
										{
											$checked = '';
										}

										echo '<label><input type="checkbox" name="'.$k.'[]" value="'.$option.'" '.$checked.' /> '.$option.'</label><br />';
									}

								break;

								/* Large text box */
								case 'textarea':
									$size = explode('#',$v['value']);
									$size[0] = empty($size[0]) ? 5 : intval($size[0]);
									$size[1] = empty($size[1]) ? 30 : intval($size[1]);
									$k_value = hesk_msgToPlain($k_value,0,0);

									echo $v['name'].': <textarea name="'.$k.'" rows="'.$size[0].'" cols="'.$size[1].'">'.$k_value.'</textarea>';
								break;

								/* Default text input */
								default:
									if (strlen($k_value) != 0)
									{
										$k_value = hesk_msgToPlain($k_value,0,0);
										$v['value'] = $k_value;
									}
									echo $v['name'].': <input type="text" name="'.$k.'" size="40" maxlength="'.$v['maxlen'].'" value="'.$v['value'].'" />';
							}
						}
					}
					?>
				</div><!-- end edit-post-info-table -->
			</div>
			<?php
		}
		?>

		<div class="form-inline">
			<label class="col-sm-2"><?php echo $hesklang['message']; ?>:</label>
			<textarea class="form-control" name="message" rows="12" cols="60"><?php echo $ticket['message']; ?></textarea>
		</div>

		<div class="container">
		<input type="hidden" name="save" value="1" /><input type="hidden" name="track" value="<?php echo $trackingID; ?>" />
		<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
		<?php
		if ($is_reply)
		{
			?>
			<input type="hidden" name="reply" value="<?php echo $tmpvar['id']; ?>" />
			<?php
		}
		?>
		<input type="submit" value="<?php echo $hesklang['save_changes']; ?>" class="btn btn-default save-changes-btn" /></div>

		</form>
		<br/>
	</div>
</div><!-- end edit-post-table -->

<br/>

<div class="container"><a href="javascript:history.go(-1)"><input class="btn btn-default goback-btn" type="submit" value="<?php echo $hesklang['back']; ?>" /></a></div>

<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
