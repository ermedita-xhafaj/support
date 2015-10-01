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

session_start();

// Get all the required files and functions      
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');

// Are we in maintenance mode?
hesk_check_maintenance();

// Are we in "Knowledgebase only" mode?
hesk_check_kb_only();

// What should we do?
$action = hesk_REQUEST('a');

switch ($action)
{
	case 'add':
		hesk_session_start();
        print_add_ticket();
	    break;

	case 'forgot_tid':
		hesk_session_start();
        forgot_tid();
	    break;

	default:
		print_start();
}

// Print footer
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();

/*** START FUNCTIONS ***/

function print_add_ticket()
{
	global $hesk_settings, $hesklang;

	// Auto-focus first empty or error field
	define('AUTOFOCUS', true);

	// Pre-populate fields
	// Customer name
	if ( isset($_REQUEST['name']) )
	{
		$_SESSION['c_name'] = $_REQUEST['name'];
	}

	// Customer email address
	if ( isset($_REQUEST['email']) )
	{
		$_SESSION['c_email']  = $_REQUEST['email'];
		$_SESSION['c_email2'] = $_REQUEST['email'];
	}

	// Category ID
	if ( isset($_REQUEST['catid']) )
	{
		$_SESSION['c_category'] = intval($_REQUEST['catid']);
	}
	if ( isset($_REQUEST['category']) )
	{
		$_SESSION['c_category'] = intval($_REQUEST['category']);
	}

	// Priority
	if ( isset($_REQUEST['priority']) )
	{
		$_SESSION['c_priority'] = intval($_REQUEST['priority']);
	}

	// Subject
	if ( isset($_REQUEST['subject']) )
	{
		$_SESSION['c_subject'] = $_REQUEST['subject'];
	}

	// Message
	if ( isset($_REQUEST['message']) )
	{
		$_SESSION['c_message'] = $_REQUEST['message'];
	}

	// Custom fields
	foreach ($hesk_settings['custom_fields'] as $k=>$v)
	{
		if ($v['use'] && isset($_REQUEST[$k]) )
		{
			$_SESSION['c_'.$k] = $_REQUEST[$k];
		}
	}

	// Varibles for coloring the fields in case of errors
	if ( ! isset($_SESSION['iserror']))
	{
		$_SESSION['iserror'] = array();
	}

	if ( ! isset($_SESSION['isnotice']))
	{
		$_SESSION['isnotice'] = array();
	}

    if ( ! isset($_SESSION['c_category']) && ! $hesk_settings['select_cat'])
    {
    	$_SESSION['c_category'] = 0;
    }

	// Tell header to load reCaptcha API if needed
	if ($hesk_settings['recaptcha_use'] == 2)
	{
		define('RECAPTCHA',1);
	}

	// Print header
	$hesk_settings['tmp_title'] = $hesk_settings['hesk_title'] . ' - ' . $hesklang['submit_ticket'];
require_once(HESK_PATH . 'inc/header.inc.php');
?>
	<nav class="row navbar navbar-default" id="showTopBar-indexPhp">
	<div class="menu-wrapper">
		<div class="container showTopBar"><?php hesk_showTopBar($hesk_settings['hesk_title']); ?></div>
	</div><!-- end showTopBar-indexPhp -->
	</nav>
	<nav class="row navbar userMenu">
      <div class="container">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<li id="userMenu-home"><a href="index.php"><?php echo $hesklang['main_page']; ?></a></li>
			<li id="userMenu-submitTicket"><a href="index.php?a=add"><?php echo $hesklang['submit_tick']; ?></a></li>
			<li id="client-username"><a href="client_profile.php"><?php echo $hesklang['hello']; ?><?php if (isset($_SESSION['id']['user']) && $_SESSION['id']['user'] ) {echo $_SESSION['id']['user']; }?></a></li>
			<li id="userMenu-logout"><a href="logout.php"><?php echo $hesklang['logout']; ?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
<div class="container siteUrl-title-indexPhp">
<div class="form-inline">
<span><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller" style="text-decoration: none;"><?php echo $hesk_settings['site_title']; ?></a> &gt;
<a href="<?php echo $hesk_settings['hesk_url']; ?>" class="smaller"><?php echo 'Help Desk'; ?></a>
&gt; <?php echo $hesklang['submit_ticket']; ?></span>
</div>
</div><!-- end siteUrl-title-indexPhp -->
<br/>
<br/>

<!--</td>
</tr>-->

<!--start in this page end in line 947
<tr>
<td>-->

<?php

// This will handle error, success and notice messages
hesk_handle_messages();
?>

<div class="container form-inline" id="view-submitTicket"> 
<img src="img/existingticket.jpg" alt="existingticket"/><span><?php echo $hesklang['submit_ticket']; ?></span></div>

<br/>
<div class="conatiner col-sm-8 col-sm-offset-2 form-submit-support-request">
	<div>
		&nbsp;
	<div>
			<!-- START FORM -->

			<p><?php echo $hesklang['use_form_below']; ?> <font class="important"> *</font></p><br/>

			<form method="post" action="submit_ticket.php?submit=1" name="form1" enctype="multipart/form-data"  autocomplete="off">

			<!-- Contact info -->
			<div class="form-group contact-info-support-request">
				<div class="form-inline" style="margin-bottom: 5px;">
					<label class="col-sm-2 control-label" for="name-contact-info-support-request"><?php echo $hesklang['name']; ?>: <font class="important">*</font></label>
					<input type="text" class="form-control contact-support-request" id="name-contact-info-support-request" name="name" size="40" maxlength="30" value="<?php  if (isset($_SESSION['id']['user'])) {echo $_SESSION['id']['user'];} ?>" <?php if (in_array('name',$_SESSION['iserror'])) {echo ' class="isError" ';} ?> readonly>
				</div>

				<div class="form-inline" style="margin-bottom: 5px;">
					<label class="col-sm-2 control-label" for="email-contact-info-support-request"><?php echo $hesklang['email']; ?>: <font class="important">*</font></label>
					<input type="text" class="form-control contact-support-request" id="email-contact-info-support-request" name="email" size="40" maxlength="1000" value="<?php if (isset($_SESSION['id']['email'])) {echo $_SESSION['id']['email']; }?>" <?php if (in_array('email',$_SESSION['iserror'])) {echo ' class="isError" ';} elseif (in_array('email',$_SESSION['isnotice'])) {echo ' class="isNotice" ';} ?> <?php if($hesk_settings['detect_typos']) { echo ' onblur="Javascript:hesk_suggestEmail(0)"'; } ?> readonly>
				</div>

				<?php
				if ($hesk_settings['confirm_email'])
				{
					?>
					<div class="form-inline" style="margin-bottom: 5px;">
						<label class="col-sm-2 control-label" for="confemail-contact-info-support-request"><?php echo $hesklang['confemail']; ?>: <font class="important">*</font></label>
						<input type="text" class="form-control contact-support-request" id="confemail-contact-info-support-request" name="email2" size="40" maxlength="1000" value="<?php if (isset($_SESSION['c_email2'])) {echo stripslashes(hesk_input($_SESSION['c_email2']));} ?>" <?php if (in_array('email2',$_SESSION['iserror'])) {echo ' class="isError" ';} ?> />
					</div>
					<?php
				} // End if $hesk_settings['confirm_email']
				?>
			</div><!-- end contact-info-support-request -->

			<?php hesk_load_database_functions();
				hesk_dbConnect();
			?>
			
			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label" for="select-cont"><?php echo $hesklang['contract'] ?>: <font class="important">*</font></label>
				<select class="form-control" required="required" title="Required field" id="select-cont" name="contract_name" style="width: 336px;">
					<option></option>
					<?php
						$res_client = hesk_dbQuery('SELECT contract_Id FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contractforclient` WHERE `client_Id`='.$_SESSION["id"]["id"] );
						$i=1;
						while ($row_client = mysqli_fetch_array($res_client)) 
						{
						$result_contract = hesk_dbQuery('SELECT id, contract_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts` WHERE id='.$row_client['contract_Id']);
						$cont_result = mysqli_fetch_array($result_contract);
							echo 
								'<option value="' .$cont_result['id'] .'">' .$cont_result['contract_name'] .'</option>';
								}
				
					?>		
				</select>
				<?php  
						
				?>
			</div>
				<?php
					$result_client = hesk_dbQuery('SELECT contract_Id FROM `'.hesk_dbEscape($hesk_settings['db_pfix'])."contractforclient` WHERE `client_Id`='".$_SESSION["id"]["id"]."' LIMIT 1" ); 
					$row_client = mysqli_fetch_array($result_client);
					$result_client = hesk_dbQuery('SELECT company_id FROM `'.hesk_dbEscape($hesk_settings['db_pfix'])."contracts` WHERE `id`='".$row_client['contract_Id']."' LIMIT 1" ); 
					
				if ($row_client = mysqli_fetch_array($result_client)) 
				{
					$result_company = hesk_dbQuery('SELECT id, company_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies` WHERE id='.$row_client['company_id']);
					$company_result = mysqli_fetch_array($result_company);
				
					echo '<input type="hidden" class="form-control"  name="company_name" value="'.$company_result['id'].'" size="40" maxlength="1000" />';
				}
			?>
			<!-- Department and priority -->
			<?php
			$is_table = 0;
			// Get categories

			$res = hesk_dbQuery("SELECT `id`, `categ_impro_id`, `name` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` WHERE `type`='0' AND `active`='1' ORDER BY `cat_order` ASC");

			/*if (hesk_dbNumRows($res) == 1)
			{
				// Only 1 public category, no need for a select box
				$row = hesk_dbFetchAssoc($res);
				echo '<input type="hidden" name="category" value="'.$row['id'].'" />';
			}
			/*elseif (hesk_dbNumRows($res) < 1)
			{
				// No public categories, set it to default one
				echo '<input type="hidden" name="category" value="1" />';
			}*/
			/*else
			{*/
				// List available categories
				$is_table = 1;
				?>
				<div class="form-group department-priority-support-request"> <!-- start table here end in line 304 -->
					<div class="form-inline" style="margin-bottom: 5px;">
						<label class="col-sm-2 control-label" for="category-department-priority-support-request"><?php echo $hesklang['category']; ?>: <font class="important">*</font></label>
						<select class="form-control contact-support-request" required="required" title="Required field" id="category-department-priority-support-request" name="category" <?php if (in_array('category',$_SESSION['iserror'])) {echo ' class="isError" ';} ?> >
						<option></option>
						<?php
						// Show the "Click to select"?
						if ($hesk_settings['select_cat'])
						{
							echo '<option value="">'.$hesklang['select'].'</option>';
						}
						// List categories
						while ($row = hesk_dbFetchAssoc($res))
						{
							echo '<option value="' . $row['id'] . '"' . (($_SESSION['c_category'] == $row['id']) ? ' selected="selected"' : '') . '>' . $row['name'] . '</option>';
						}
						?>
						</select>
					</div>
					<?php
				/*}*/

				/* Can customer assign urgency? */
				if ($hesk_settings['cust_urgency'])
				{
					if ( ! $is_table)
					{
						echo '<div class="form-group department-priority-support-request">';
						$is_table = 1;
					}
					?>
					<div class="form-inline" style="margin-bottom: 5px;">
						<label class="col-sm-2 control-label" for="priority-department-priority-support-request"><?php echo $hesklang['priority']; ?>: <font class="important">*</font></label>
						<select class="form-control contact-support-request" required="required" title="Required field" id="priority-department-priority-support-request" name="priority" <?php if (in_array('priority',$_SESSION['iserror'])) {echo ' class="isError" ';} ?> >
						<option></option>
						<?php
						// Show the "Click to select"?
						if ($hesk_settings['select_pri'])
						{
							echo '<option value="">'.$hesklang['select'].'</option>';
						}
						?>
						<option value="3" <?php if(isset($_SESSION['c_priority']) && $_SESSION['c_priority']==3) {echo 'selected="selected"';} ?>><?php echo $hesklang['low']; ?></option>
						<option value="2" <?php if(isset($_SESSION['c_priority']) && $_SESSION['c_priority']==2) {echo 'selected="selected"';} ?>><?php echo $hesklang['medium']; ?></option>
						<option value="1" <?php if(isset($_SESSION['c_priority']) && $_SESSION['c_priority']==1) {echo 'selected="selected"';} ?>><?php echo $hesklang['high']; ?></option>
						</select>
					</div>
					<?php
				}

			/* Need to close the table? */
			if ($is_table)
			{
				echo '</div> <br/><br/>';
			}
			?>
			<!-- START CUSTOM BEFORE -->
			<?php

			/* custom fields BEFORE comments */

			$print_table = 0;

			foreach ($hesk_settings['custom_fields'] as $k=>$v)
			{
				if ($v['use'] && $v['place']==0)
				{
					if ($print_table == 0)
					{
						echo '<div class="custom-before-support-request">';	/* start table in line 317-486*/
						$print_table = 1;
					}

					$v['req'] = $v['req'] ? '<font class="important">*</font>' : '';

					if ($v['type'] == 'checkbox')
					{
						$k_value = array();
						if (isset($_SESSION["c_$k"]) && is_array($_SESSION["c_$k"]))
						{
							foreach ($_SESSION["c_$k"] as $myCB)
							{
								$k_value[] = stripslashes(hesk_input($myCB));
							}
						}
					}
					elseif (isset($_SESSION["c_$k"]))
					{
						$k_value  = stripslashes(hesk_input($_SESSION["c_$k"]));
					}
					else
					{
						$k_value  = '';
					}

					switch ($v['type'])
					{
						/* Radio box */
						case 'radio':														/*start tr in line 348-375*/
							echo '
							<div class="form-inline ">
							<label>'.$v['name'].': '.$v['req'].'</label>
							';

							$options = explode('#HESK#',$v['value']);
							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';

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

								echo '<label><input type="radio" name="'.$k.'" value="'.$option.'" '.$checked.' '.$cls.' /> '.$option.'</label><br />';
							}

							echo '
							</div>
							';
						break;

						/* Select drop-down box */
						case 'select':

							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';
																												/*start tr in line 382-414*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							<select name="'.$k.'" '.$cls.'>';

							// Show "Click to select"?
							$v['value'] = str_replace('{HESK_SELECT}', '', $v['value'], $num);
							if ($num)
							{
								echo '<option value="">'.$hesklang['select'].'</option>';
							}

							$options = explode('#HESK#',$v['value']);

							foreach ($options as $option)
							{
								if ($k_value == $option)
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

							echo '</select>
							</div>
							';
						break;

						/* Checkbox */
						case 'checkbox':														/*start tr in line 418-444*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							';

							$options = explode('#HESK#',$v['value']);
							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';

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

								echo '<label><input type="checkbox" name="'.$k.'[]" value="'.$option.'" '.$checked.' '.$cls.' /> '.$option.'</label><br />';
							}

							echo '
							</div>
							';
						break;

						/* Large text box */
						case 'textarea':
							$size = explode('#',$v['value']);
							$size[0] = empty($size[0]) ? 5 : intval($size[0]);
							$size[1] = empty($size[1]) ? 30 : intval($size[1]);

							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';
																										/*start tr in line 454-460*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							<textarea name="'.$k.'" rows="'.$size[0].'" cols="'.$size[1].'" '.$cls.'>'.$k_value.'</textarea>
							</div>
							';
						break;

						/* Default text input */
						default:
							if (strlen($k_value) != 0)
							{
								$v['value'] = $k_value;
							}

							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';
																									/*start tr in line 471-477*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							<input type="text" name="'.$k.'" size="40" maxlength="'.$v['maxlen'].'" value="'.$v['value'].'" '.$cls.' />
							</div>
							';
					}
				}
			}

			/* If table was started we need to close it */
			if ($print_table)
			{
				echo '</div> <br/><br/>';		/*end custom-before-support-request table*/
				$print_table = 0;
			}
			?>
			<!-- END CUSTOM BEFORE -->

			<!-- ticket info -->
			<div class="form-group">
				<div  class="form-inline" style="padding-right: 0px; margin-bottom: 5px;">
					<label class="col-sm-2 control-label" for="subject-ticket-info-support-request"><?php echo $hesklang['subject']; ?>: <font class="important">*</font></label>
					<input class="form-control contact-support-request" required="required" title="Required field" type="text" id="subject-ticket-info-support-request" name="subject" size="40" maxlength="40" value="<?php if (isset($_SESSION['c_subject'])) {echo stripslashes(hesk_input($_SESSION['c_subject']));} ?>" <?php if (in_array('subject',$_SESSION['iserror'])) {echo ' class="isError" ';} ?> />
				</div>
				<div class="form-inline" style="margin-bottom: 5px;">
					<div>
						<label class="col-sm-2 control-label" for="message-ticket-info-support-request" ><?php echo $hesklang['message']; ?>: <font class="important">*</font></label>
						<textarea class="form-control contact-support-request" required="required" title="Required field" id="message-ticket-info-support-request" name="message" rows="12" cols="60" <?php if (in_array('message',$_SESSION['iserror'])) {echo ' class="isError" ';} ?> ><?php if (isset($_SESSION['c_message'])) {echo stripslashes(hesk_input($_SESSION['c_message']));} ?></textarea>
					</div>
				</div>
			</div><!-- ticket-info-support-request -->

			<!-- START CUSTOM AFTER -->
			<?php
			/* custom fields AFTER comments */
			$print_table = 0;

			foreach ($hesk_settings['custom_fields'] as $k=>$v)
			{
				if ($v['use'] && $v['place'])
				{
					if ($print_table == 0)
					{																				/*start table in line 534-705*/
						echo '
						<br/><br/>
						<div class="custom-after-support-request">
						';
						$print_table = 1;
					}

					$v['req'] = $v['req'] ? '<font class="important">*</font>' : '';

					if ($v['type'] == 'checkbox')
					{
						$k_value = array();
						if (isset($_SESSION["c_$k"]) && is_array($_SESSION["c_$k"]))
						{
							foreach ($_SESSION["c_$k"] as $myCB)
							{
								$k_value[] = stripslashes(hesk_input($myCB));
							}
						}
					}
					elseif (isset($_SESSION["c_$k"]))
					{
						$k_value  = stripslashes(hesk_input($_SESSION["c_$k"]));
					}
					else
					{
						$k_value  = '';
					}


					switch ($v['type'])
					{
						/* Radio box */
						case 'radio':																/*start tr in line 567-594*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							';

							$options = explode('#HESK#',$v['value']);
							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';

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

								echo '<label><input type="radio" name="'.$k.'" value="'.$option.'" '.$checked.' '.$cls.' /> '.$option.'</label><br />';
							}

							echo '
							</div>
							';
						break;

						/* Select drop-down box */
						case 'select':

							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';
																										/*start tr in line 601-633*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							<select name="'.$k.'" '.$cls.'>';

							// Show "Click to select"?
							$v['value'] = str_replace('{HESK_SELECT}', '', $v['value'], $num);
							if ($num)
							{
								echo '<option value="">'.$hesklang['select'].'</option>';
							}

							$options = explode('#HESK#',$v['value']);

							foreach ($options as $option)
							{
								if ($k_value == $option)
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

							echo '</select>
							</div>
							';
						break;

						/* Checkbox */
						case 'checkbox':																	/*start tr in line 637-663*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							';

							$options = explode('#HESK#',$v['value']);
							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';

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

								echo '<label><input type="checkbox" name="'.$k.'[]" value="'.$option.'" '.$checked.' '.$cls.' /> '.$option.'</label><br />';
							}

							echo '
							</div>
							';
						break;

						/* Large text box */
						case 'textarea':
							$size = explode('#',$v['value']);
							$size[0] = empty($size[0]) ? 5 : intval($size[0]);
							$size[1] = empty($size[1]) ? 30 : intval($size[1]);

							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';
																													/*start tr in line 673-679*/
							echo '
							<div class="form-inline">
							<label>'.$v['name'].': '.$v['req'].'</label>
							<textarea name="'.$k.'" rows="'.$size[0].'" cols="'.$size[1].'" '.$cls.'>'.$k_value.'</textarea>
							</div>
							';
						break;

						/* Default text input */
						default:
							if (strlen($k_value) != 0)
							{
								$v['value'] = $k_value;
							}

							$cls = in_array($k,$_SESSION['iserror']) ? ' class="isError" ' : '';
																											/*start tr in line 690-696*/
							echo '
							<div>
							<label>'.$v['name'].': '.$v['req'].'</label>
							<input type="text" name="'.$k.'" size="40" maxlength="'.$v['maxlen'].'" value="'.$v['value'].'" '.$cls.' />
							</div>
							';
					}
				}
			}

			/* If table was started we need to close it */
			if ($print_table)
			{
				echo '</div>';			/*end custom-after-support-request*/
				$print_table = 0;
			}
			?>
			<!-- END CUSTOM AFTER -->

			<?php
			/* attachments */
			if ($hesk_settings['attachments']['use'])
			{
			?>
			<br/><br/>

			<div class="form-group">
				<div class="form-inline">
					<label class="col-sm-2 control-label" style="vertical-align: top;"><?php echo $hesklang['attachments']; ?>:</label>
					<div class="form-group contact-support-request">
						<?php
						for ($i=1;$i<=$hesk_settings['attachments']['max_number'];$i++)
						{
							$cls = ($i == 1 && in_array('attachments',$_SESSION['iserror'])) ? ' class="isError" ' : '';
							echo '<input type="file" name="attachment['.$i.']" size="50" '.$cls.' style="margin-bottom: 10px;"/>';
						}
						?>
						<a href="file_limits.php" target="_blank" onclick="Javascript:hesk_window('file_limits.php',250,500);return false;"><?php echo $hesklang['ful']; ?></a>
					</div>
				</div>
			</div><!-- end attachments-support-request -->
			<?php
			}

			if ($hesk_settings['question_use'] || $hesk_settings['secimg_use'])
			{
				?>

				<br/><br/>

				<!-- Security checks -->
				<div class="security-checks-support-request">
				<?php
				if ($hesk_settings['question_use'])
				{
					?>
					<div class="form-inline">
						<label class="col-sm-2 control-label" style="text-align:right;vertical-align:top" width="150"><?php echo $hesklang['verify_q']; ?> <font class="important">*</font></label>

						<?php
						$value = '';
						if (isset($_SESSION['c_question']))
						{
							$value = stripslashes(hesk_input($_SESSION['c_question']));
						}
						$cls = in_array('question',$_SESSION['iserror']) ? ' class="isError" ' : '';
						echo $hesk_settings['question_ask'].'<br /><input class="form-control" type="text" name="question" size="20" value="'.$value.'" '.$cls.'  />';
						?><br />&nbsp;

					</div>
					<?php
				}

				if ($hesk_settings['secimg_use'])
				{
					?>
					<div class="form-inline">
						<label class="col-sm-2 control-label" style="text-align:right;vertical-align:top" width="150"><?php echo $hesklang['verify_i']; ?> <font class="important">*</font></label>

						<?php
						// SPAM prevention verified for this session
						if (isset($_SESSION['img_verified']))
						{
							echo '<img src="'.HESK_PATH.'img/success.png" width="16" height="16" border="0" alt="" style="vertical-align:text-bottom" /> '.$hesklang['vrfy'];
						}
						// Not verified yet, should we use Recaptcha?
						elseif ($hesk_settings['recaptcha_use'] == 1)
						{
							?>
							<script type="text/javascript">
							var RecaptchaOptions = {
							theme : '<?php echo ( isset($_SESSION['iserror']) && in_array('mysecnum',$_SESSION['iserror']) ) ? 'red' : 'white'; ?>',
							custom_translations : {
								visual_challenge : "<?php echo hesk_slashJS($hesklang['visual_challenge']); ?>",
								audio_challenge : "<?php echo hesk_slashJS($hesklang['audio_challenge']); ?>",
								refresh_btn : "<?php echo hesk_slashJS($hesklang['refresh_btn']); ?>",
								instructions_visual : "<?php echo hesk_slashJS($hesklang['instructions_visual']); ?>",
								instructions_context : "<?php echo hesk_slashJS($hesklang['instructions_context']); ?>",
								instructions_audio : "<?php echo hesk_slashJS($hesklang['instructions_audio']); ?>",
								help_btn : "<?php echo hesk_slashJS($hesklang['help_btn']); ?>",
								play_again : "<?php echo hesk_slashJS($hesklang['play_again']); ?>",
								cant_hear_this : "<?php echo hesk_slashJS($hesklang['cant_hear_this']); ?>",
								incorrect_try_again : "<?php echo hesk_slashJS($hesklang['incorrect_try_again']); ?>",
								image_alt_text : "<?php echo hesk_slashJS($hesklang['image_alt_text']); ?>",
							},
							};
							</script>
							<?php
							require(HESK_PATH . 'inc/recaptcha/recaptchalib.php');
							echo recaptcha_get_html($hesk_settings['recaptcha_public_key'], null, true);
						}
						// Use reCaptcha API v2?
						elseif ($hesk_settings['recaptcha_use'] == 2)
						{
							?>
							<div class="g-recaptcha" data-sitekey="<?php echo $hesk_settings['recaptcha_public_key']; ?>"></div>
							<?php
						}
						// At least use some basic PHP generated image (better than nothing)
						else
						{
							$cls = in_array('mysecnum',$_SESSION['iserror']) ? ' class="isError" ' : '';

							echo $hesklang['sec_enter'].'<br />&nbsp;<br /><img src="print_sec_img.php?'.rand(10000,99999).'" width="150" height="40" alt="'.$hesklang['sec_img'].'" title="'.$hesklang['sec_img'].'" border="1" name="secimg" style="vertical-align:text-bottom" /> '.
							'<a href="javascript:void(0)" onclick="javascript:document.form1.secimg.src=\'print_sec_img.php?\'+ ( Math.floor((90000)*Math.random()) + 10000);"><img src="img/reload.png" height="24" width="24" alt="'.$hesklang['reload'].'" title="'.$hesklang['reload'].'" border="0" style="vertical-align:text-bottom" /></a>'.
							'<br />&nbsp;<br /><input type="text" name="mysecnum" size="20" maxlength="5" '.$cls.' />';
						}
						?>

					</div>
					<?php
				}
				?>
				</div><!-- end security-checks-support-request -->

			<?php
			}
			?>

			<!-- Submit -->
			<?php
			/*if ($hesk_settings['submit_notice'])
			{
				?>

				<br/><br/>

				<div align="center">
				<div class="submit-notice-support-request">
					<div>
						<div>

						<b><?php echo $hesklang['before_submit']; ?></b>
						<ul>
						<li><?php echo $hesklang['all_info_in']; ?>.</li>
						<li><?php echo $hesklang['all_error_free']; ?>.</li>
						</ul>


						<b><?php echo $hesklang['we_have']; ?>:</b>
						<ul>
						<li><?php echo hesk_htmlspecialchars($_SERVER['REMOTE_ADDR']).' '.$hesklang['recorded_ip']; ?></li>
						<li><?php echo $hesklang['recorded_time']; ?></li>
						</ul>

						<div class="col-sm-7 col-sm-offset-5"><input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
						<input type="submit" value="<?php echo $hesklang['sub_ticket']; ?>" class="btn btn-default submit-ticket-btn" /></div>

						</div>
					</div>
				</div><!-- end submit-notice-support-request -->
				</div>
				<?php
			} // End IF submit_notice
			else
			{*/
				?>

		</div>
		&nbsp;
	</div>

				
				<div class="else-submit-notice-support-request">
					<div class="col-sm-7 col-sm-offset-5">
					<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
					<input type="submit" value="<?php echo $hesklang['sub_ticket']; ?>" class="btn btn-default submit-ticket-btn"  />
					</div>
				</div><!-- end else-submit-notice-support-request -->
				<?php
			/*}*/ // End ELSE submit_notice
			?>

			<!-- Do not delete or modify the code below, it is used to detect simple SPAM bots -->
			<input type="hidden" name="hx" value="3" /><input type="hidden" name="hy" value="" />
			<!-- >
			<input type="text" name="phone" value="3" />
			< -->

			</form>
		<!-- END FORM -->
</div><!-- end form-submit-support-request -->	

		
<!-- Go back -->
<div class="container"><a href="javascript:history.go(-1)"> <button type="submit" class="btn btn-default goback-btn"><?php echo $hesklang['back'] ?></button></a></div>


<?php
hesk_cleanSessionVars('iserror');
hesk_cleanSessionVars('isnotice');

} // End print_add_ticket()

/*header("location: login.php");*/

function print_start()
{
	global $hesk_settings, $hesklang;

	// Connect to database
	hesk_load_database_functions();
	hesk_dbConnect();

	/* Print header */
	require_once(HESK_PATH . 'inc/header.inc.php');
	?>
	
	<nav class="row navbar navbar-default" id="showTopBar-indexPhp">
		<div class="menu-wrapper">
			<div class="container showTopBar"><?php hesk_showTopBar($hesk_settings['hesk_title']); ?></div>
		</div>
	</nav>
	
<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']):?>
	<nav class="row navbar userMenu">
      <div class="container">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">		  	
			<li id="userMenu-home"><a href="index.php"><?php echo $hesklang['main_page']; ?></a></li>
			<li id="userMenu-submitTicket"><a href="index.php?a=add"><?php echo $hesklang['submit_tick']; ?></a></li>
			<li id="client-username"><a href="client_profile.php"><?php echo $hesklang['hello']; ?><?php if (isset($_SESSION['id']['user']) && $_SESSION['id']['user'] ) {echo $_SESSION['id']['user']; }?></a></li>
			<li id="userMenu-logout"><a href="logout.php"><?php echo $hesklang['logout']; ?></a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
<?php endif; ?>	

	<br/>
	<div class="container siteUrl-title-indexPhp">
		<div class="form-inline">
			<span><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller" style="text-decoration: none;"><?php echo $hesk_settings['site_title']; ?></a> &gt;
			<?php echo 'Help Desk'; ?></span>
		</div>
	</div><!-- end siteUrl-title-indexPhp -->

<br/>
<br/>


<!--</td>
</tr>-->

<!--start in this page end somewhere....
<tr>
<td>-->

	<?php

	// Service messages
	$res = hesk_dbQuery('SELECT `title`, `message`, `style` FROM `'.hesk_dbEscape($hesk_settings['db_pfix'])."service_messages` WHERE `type`='0' ORDER BY `order` ASC");
	while ($sm=hesk_dbFetchAssoc($res))
	{
		hesk_service_message($sm);
	}
	
	?>

	
<!-- start session login -->	

<?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']):?>
	<div class="col-sm-12 form-group submit-view-existing-ticket">
		<div class="col-sm-4 col-sm-offset-2 conatiner submit-ticket-col">
				<!-- START SUBMIT -->
				<div class="submit-ticket" id="gradient">
					<a style="text-decoration: none" href="index.php?a=add">
						<div class="form-inline">
							&nbsp;
							<img src="img/newticket.jpg" alt="newticket"/>
							<div class="form-group">
								<span><b><?php echo $hesklang['sub_support']; ?></b></span>
							</div>
							&nbsp;
						</div>
					</a>
				</div><!-- end submit-ticket -->
				<!-- END SUBMIT -->
		</div>
	</div><!-- end submit-view-existing-ticket -->
<!-- start form login-->

<?php $sql = hesk_dbQuery("SELECT  id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets`"); ?>
<?php $sql_description = hesk_dbQuery("SELECT subject, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets`"); ?>
<?php $sql_category = hesk_dbQuery("SELECT name, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories`"); ?>
<?php $sql_client = hesk_dbQuery("SELECT user, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."clients`"); ?>

	<div class="col-sm-8 col-sm-offset-2 filter-ticket-client" id="filter-ticket-client"> <!-- Krijojme nje div per filtrat -->
		<form method="post" action="">
				<datalist id="ticket_id_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql)){
					echo '<option value='.$tmp["id"].'>';
				}
					?>
				</datalist>
				<input placeholder="Search by ID" type="text" list="ticket_id_list" name="search_by_ID_ticket" <?php if(isset($_POST["search_by_ID_ticket"])) echo "value='".$_POST["search_by_ID_ticket"]."'" ?> class="form-control-1" />
				<datalist id="ticket_desc_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql_description)){
					echo '<option value='.$tmp["subject"].'>';
				}
					?>
				</datalist>
				<input placeholder="Search by subject" type="text" list="ticket_desc_list" name="search_by_description_ticket" <?php if(isset($_POST["search_by_description_ticket"])) echo "value='".$_POST["search_by_description_ticket"]."'" ?>  class="form-control-1" />
				
				<datalist id="ticket_klient_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql_client)){
					echo '<option value='.$tmp["user"].'>';
				}
					?>
				</datalist>
				<input placeholder="Search by client" type="text" list="ticket_klient_list" name="search_by_client_open_ticket" <?php if(isset($_POST["search_by_client_open_ticket"])) echo "value='".$_POST["search_by_client_open_ticket"]."'" ?> class="form-control-1" />

			<?php echo "<select class='form-control-1' name='search_by_ticket_category' id='ticket_cat_list'>"; // list box select command
				echo"<option value=''>Select category</option>";
					while ($tmp = hesk_dbFetchAssoc($sql_category))
					{
						if(isset($_POST["search_by_ticket_category"])&& $_POST["search_by_ticket_category"]==$tmp['id']){
							echo "<option selected=selected value=$tmp[id]> $tmp[name] </option>"; 
						} else {
							echo "<option value=$tmp[id]> $tmp[name] </option>"; 
						}
					}
						echo "</select>";
				?>
			<?php echo "<select class='form-control-1' name='search_by_ticket_status' id='ticket_status_list'>"; // list box select command
				echo"<option value=''>Select status</option>";
						echo "<option value='0'"; if(isset($_POST["search_by_ticket_status"])&& $_POST["search_by_ticket_status"]=='0') echo "selected=selected"; echo "> NEW </option>"; 
						echo "<option value='1'";if(isset($_POST["search_by_ticket_status"])&& $_POST["search_by_ticket_status"]=='1') echo "selected=selected"; echo "> WAITING REPLY </option>"; 
						echo "<option value='2'";if(isset($_POST["search_by_ticket_status"])&& $_POST["search_by_ticket_status"]=='2') echo "selected=selected"; echo "> REPLIED</option>"; 
						echo "<option value='3'";if(isset($_POST["search_by_ticket_status"])&& $_POST["search_by_ticket_status"]=='3') echo "selected=selected"; echo "> RESOLVED</option>"; 
						echo "<option value='4'";if(isset($_POST["search_by_ticket_status"])&& $_POST["search_by_ticket_status"]=='4') echo "selected=selected"; echo "> IN PROGRESS</option>"; 
						echo "<option value='5'";if(isset($_POST["search_by_ticket_status"])&& $_POST["search_by_ticket_status"]=='5') echo "selected=selected"; echo "> ON HOLD</option>";  
				echo "</select>";
				?>
			<input name="submitbutton_tickets" type="submit" class="btn btn-default execute-btn" value="Search"/>
			<button name="clearbutton_tickets" onclick="deleteticket_client();return false;" class="btn btn-default filter-ticket-btn" value="">Clear</button>
		</form>
	</div> <!--end div i filtrave -->		
<div class="print_ticket_for_client">
<?php require(HESK_PATH . 'inc/print_tickets_client.inc.php'); ?>
</div>

<?php else: ?>
	<div class="container">
		<div class="container col-sm-5 user-login-help-staf">
			<div class="form-group user-login">
			<?php
			$login_form = <<<EOD
				<form class="container form-signin" method="post" action="login.php">
					<div class="form-signin-heading">Login</div>
					<div class="form-group">
						<div class="form-inline signin-username">
							<label for="inputUser">{$hesklang['username']}:</label><br/>
							<input name="user" required="required" title="Required field" type="text" id="inputUser" class="form-control" required autofocus style="width: 301px;">
						</div>
						<div class="form-inline signin-password">
							<label for="inputPassword">{$hesklang['pass']}:</label><br/>
							<input name="pass" type="password" id="inputPassword" class="form-control" required style="width: 301px;">
						</div>
						<div class="checkbox signin-remember">
							<label><input type="checkbox" value="remember-me" /> {$hesklang['remember_user']}</label>
						</div>
						<div>
							<button class="btn btn-default login-user-btn" type="submit">{$hesklang['click_login']}</button>
						</div>
					</div>
				</form>
EOD;
				$msg = (isset($_SESSION['message']) ? $_SESSION['message'] : null);			//GET the message
				if($msg!=''){ 
				echo '<div>'.$msg.'</div>';
				unset($_SESSION['message']); 						//If message is set echo it
				}			
				echo $login_form;
				?>
			</div>
			<!--
			<div class="form-inline top-latest-kb-button">
			<a href="http://localhost/support/knowledgebase.php#tab_home" target="_blank"><button type="submit" class="btn btn-default" id="top-kb-button" onmouseover="hesk_btn(this,'btn btn-defaultover');" onmouseout="hesk_btn(this,'btn btn-default');">Top Knowledgebase <br/> articles</button></a>
			<a href="http://localhost/support/knowledgebase.php#tab_profile" target="_blank"><button type="submit" class="btn btn-default" id="latest-kb-button" onmouseover="hesk_btn(this,'btn btn-defaultover');" onmouseout="hesk_btn(this,'btn btn-default');">Latest Knowledgebase <br/> articles</button></a>
			</div>
			-->
		</div>		
		<div class="col-sm-7 help-staf"><img src="img/help.jpg" alt="help" /></div>
	</div>
<?php endif; ?>	

<?php

} // End print_start()


function forgot_tid()
{
	global $hesk_settings, $hesklang;

	require(HESK_PATH . 'inc/email_functions.inc.php');

	$email = hesk_validateEmail( hesk_POST('email'), 'ERR' ,0) or hesk_process_messages($hesklang['enter_valid_email'],'ticket.php?remind=1');

	if ( isset($_POST['open_only']) )
	{
    	$hesk_settings['open_only'] = $_POST['open_only'] == 1 ? 1 : 0;
	}

	/* Prepare ticket statuses */
	$my_status = array(
	    0 => $hesklang['open'],
	    1 => $hesklang['wait_staff_reply'],
	    2 => $hesklang['wait_cust_reply'],
	    3 => $hesklang['closed'],
	    4 => $hesklang['in_progress'],
	    5 => $hesklang['on_hold'],
	);

	/* Get ticket(s) from database */
	hesk_load_database_functions();
	hesk_dbConnect();

    // Get tickets from the database
	$res = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'tickets` FORCE KEY (`statuses`) WHERE ' . ($hesk_settings['open_only'] ? "`status` IN ('0','1','2','4','5') AND " : '') . ' ' . hesk_dbFormatEmail($email) . ' ORDER BY `status` ASC, `lastchange` DESC ');

	$num = hesk_dbNumRows($res);
	if ($num < 1)
	{
		if ($hesk_settings['open_only'])
        {
        	hesk_process_messages($hesklang['noopen'],'ticket.php?remind=1&e='.$email);
        }
        else
        {
        	hesk_process_messages($hesklang['tid_not_found'],'ticket.php?remind=1&e='.$email);
        }
	}

	$tid_list = '';
	$name = '';

    $email_param = $hesk_settings['email_view_ticket'] ? '&e='.rawurlencode($email) : '';

	while ($my_ticket=hesk_dbFetchAssoc($res))
	{
		$name = $name ? $name : hesk_msgToPlain($my_ticket['name'], 1, 0);
$tid_list .= "
$hesklang[trackID]: "	. $my_ticket['trackid'] . "
$hesklang[subject]: "	. hesk_msgToPlain($my_ticket['subject'], 1, 0) . "
$hesklang[status]: "	. $my_status[$my_ticket['status']] . "
$hesk_settings[hesk_url]/ticket.php?track={$my_ticket['trackid']}{$email_param}
";
	}

	/* Get e-mail message for customer */
	$msg = hesk_getEmailMessage('forgot_ticket_id','',0,0,1);
	$msg = str_replace('%%NAME%%',			$name,												$msg);
	$msg = str_replace('%%NUM%%',			$num,												$msg);
	$msg = str_replace('%%LIST_TICKETS%%',	$tid_list,											$msg);
	$msg = str_replace('%%SITE_TITLE%%',	hesk_msgToPlain($hesk_settings['site_title'], 1),	$msg);
	$msg = str_replace('%%SITE_URL%%',		$hesk_settings['site_url'],							$msg);

    $subject = hesk_getEmailSubject('forgot_ticket_id');

	/* Send e-mail */
	hesk_mail($email, $subject, $msg);

	/* Show success message */
	$tmp  = '<b>'.$hesklang['tid_sent'].'!</b>';
	$tmp .= '<br />&nbsp;<br />'.$hesklang['tid_sent2'].'.';
	$tmp .= '<br />&nbsp;<br />'.$hesklang['check_spambox'];
	hesk_process_messages($tmp,'ticket.php?e='.$email,'SUCCESS');
	exit();

    } // End forgot_tid()

?>
