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

/* Make sure the install folder is deleted */
if (is_dir(HESK_PATH . 'install')) {die('Please delete the <b>install</b> folder from your server for security reasons then refresh this page!');}

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/admin_functions.inc.php');
hesk_load_database_functions();

hesk_session_start();
hesk_dbConnect();
hesk_isLoggedIn();

define('CALENDAR',1);
define('MAIN_PAGE',1);

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

<?php

/* This will handle error, success and notice messages */
hesk_handle_messages();

/* Print tickets? */
if (hesk_checkPermission('can_view_tickets',0))
{
	?>
<?php $sql = hesk_dbQuery("SELECT  id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets`"); ?>
<?php $sql_description = hesk_dbQuery("SELECT subject, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets`"); ?>
<?php $sql_category = hesk_dbQuery("SELECT name, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories`"); ?>
<?php $sql_client = hesk_dbQuery("SELECT user, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."clients`"); ?>

	<div style="float:right; padding:5px 17px 20px;"> <!-- Krijojme nje div per filtrat -->
		<form method="post" action="">
			<?php echo "<select class='form-control-1' name='search_by_ID' id='ID_list'>"; // list box select command
				echo"<option style='color:#ccc' value=''>Select by ID</option>";
					while ($tmp = hesk_dbFetchAssoc($sql))
					{
						echo "<option value=$tmp[id]> $tmp[id] </option>"; 
					}
						echo "</select>";
				?>
				<datalist id="ticket_desc_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql_description)){
					echo '<option value='.$tmp["subject"].'>';
				}
					?>
				</datalist>
				<input placeholder="Select by subject" type="text" list="ticket_desc_list" name="search_by_description_ticket" class="form-control-1" />
				
				<datalist id="ticket_klient_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql_client)){
					echo '<option value='.$tmp["user"].'>';
				}
					?>
				</datalist>
				<input placeholder="Select by client" type="text" list="ticket_klient_list" name="search_by_client_open_ticket" class="form-control-1" />

			<?php echo "<select class='form-control-1' name='search_by_ticket_category' id='ticket_cat_list'>"; // list box select command
				echo"<option value=''>Select category</option>";
					while ($tmp = hesk_dbFetchAssoc($sql_category))
					{
						echo "<option value=$tmp[id]> $tmp[name] </option>"; 
					}
						echo "</select>";
				?>
			<?php echo "<select class='form-control-1' name='search_by_ticket_status' id='ticket_status_list'>"; // list box select command
				echo"<option value=''>Select status</option>";
						echo "<option value='0'> NEW </option>"; 
						echo "<option value='1'> WAITING REPLY </option>"; 
						echo "<option value='2'> REPLIED </option>"; 
						echo "<option value='3'> RESOLVED </option>"; 
						echo "<option value='4'> IN PROGRESS </option>"; 
						echo "<option value='5'> ON HOLD </option>"; 
				echo "</select>";
				?>
			<input name="submitbutton_tickets" type="submit" class="btn btn-default execute-btn" value="Search"/>
		</form>
	</div> <!--end div i filtrave -->	
	<?php
	if ( ! isset($_SESSION['hide']['ticket_list']) )
    {
        echo '<br/><br/>
        <div class="container open-new-ticket">
        <div class="form-inline col-sm-10"><img src="../img/open-tickets.png" alt="open-tickets" /><span id="openTicket">'.$hesklang['open_tickets'].'</span></div>
        <span class="col-sm-2 newTicket"><a href="new_ticket.php"><button type="submit" class="btn btn-default new-ticket-btn">'.$hesklang['nti'].'</button></a></span>
		</div>
        ';
	}

	/* Reset default settings? */
	if ( isset($_GET['reset']) && hesk_token_check() )
	{
		$res = hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."users` SET `default_list`='' WHERE `id` = '".intval($_SESSION['id'])."' LIMIT 1");
        $_SESSION['default_list'] = '';
	}
	/* Get default settings */
	else
	{
		parse_str($_SESSION['default_list'],$defaults);
		$_GET = isset($_GET) && is_array($_GET) ? array_merge($_GET, $defaults) : $defaults;
	}

	/* Print the list of tickets */
	require(HESK_PATH . 'inc/print_tickets.inc.php');



    /* Print forms for listing and searching tickets */
	require(HESK_PATH . 'inc/show_search_form.inc.php');
}
else
{
	echo '<p><i>'.$hesklang['na_view_tickets'].'</i></p>';
}


/* Clean unneeded session variables */
hesk_cleanSessionVars('hide');

require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
