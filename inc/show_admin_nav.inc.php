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

$num_mail = hesk_checkNewMail();
$num_mail = $num_mail ? '<b>'.$num_mail.'</b>' : 0;
?>

<div class="row navbar navbar-default" id="showTopBar-indexPhp" role="navigation">
	<div class="menu-wrapper">
		<div class="container showTopBar"><?php hesk_showTopBar($hesk_settings['hesk_title']); ?></div>
	</div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse adminMenu">
	<div class="container">
		<ul class="nav nav-pills nav-justified" id="admin-nav-menu">
			<li><a href="admin_main.php"><?php echo $hesklang['tickets']; ?><span class="sr-only">(current)</span></a></li>
			
			<li><a href="contracts.php"><?php echo $hesklang['menu_contracts']; ?></a></li>
			
			<?php 
				if(hesk_checkPermission('can_man_cat',0)){
				echo '<li><a href="manage_categories.php">' .$hesklang['menu_cat'] .'</a></li>';
				}
				
				if(hesk_checkPermission('can_man_users',0)){
				echo '<li><a href="manage_users.php">' .$hesklang['menu_users'] .'</a></li>';
				}
				
				/*if(hesk_checkPermission('can_man_canned',0)){
				echo '<li><a href="manage_canned.php">' .$hesklang['menu_can'] .'</a></li>';
				}
				elseif(hesk_checkPermission('can_man_ticket_tpl',0)){
				echo '<li><a href="manage_ticket_templates.php">' .$hesklang['menu_can'] .'</a></li>';
				}*/
				
				if (hesk_checkPermission('can_run_reports',0)){
				echo '<li><a href="reports.php">' .$hesklang['reports'] .'</a></li>';
				}
				elseif(hesk_checkPermission('can_export',0)){
				echo '<li><a href="export.php">' .$hesklang['reports'] .'</a></li>';
				}
			?>
			
				<li><a href="profile.php"><?php echo $hesklang['menu_profile']; ?></a></li>
				
				<li><a href="mail.php"><?php echo $hesklang['menu_msg']; ?>(<?php echo $num_mail; unset($num_mail); ?>)</a></li>
			
			<?php	
				if($hesk_settings['kb_enable']){ 
					if (hesk_checkPermission('can_man_kb',0)){
					echo '<li><a href="manage_knowledgebase.php">' .$hesklang['menu_kb'] .'</a></li>';
					}
					else {
					echo '<li><a href="knowledgebase_private.php">' .$hesklang['menu_kb'] .'</a></li>';
					}
				}
				
				/*if(hesk_checkPermission('can_ban_emails',0)){
				echo '<li><a href="banned_emails.php">' . $hesklang['tools'] .'</a></li>';
				}
				elseif(hesk_checkPermission('can_ban_ips',0)){
				echo '<li><a href="banned_ips.php">' .$hesklang['tools'] .'</a></li>';
				}
				elseif(hesk_checkPermission('can_service_msg',0)){
				echo '<li><a href="service_messages.php">' .$hesklang['tools'] .'</a></li>';
				}*/
				
				if(hesk_checkPermission('can_man_settings',0)){
				echo '<li><a href="admin_settings.php">' .$hesklang['settings'] .'</a></li>';
				}
			?>
						
			<li><a href="index.php?a=logout&amp;token=<?php echo hesk_token_echo(); ?>"><?php echo $hesklang['logout']; ?></a></li>
			<!-- Collect the nav links, forms, and other content for toggling -->
		</ul>
		</div>

    </div><!-- /.navbar-collapse -->
</div>

<br/>

    <!-- START MENU LINKS -->
		<div class="container menu-links-header">

			<div class="form-inline" id="admin-box-menu">

				<a href="admin_main.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-home"><label id="main-page"><?php echo $hesklang['tickets']; ?></label></button></a>

				<a href="contracts.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-contracts"><label id="menu-profile"><?php echo $hesklang['menu_contracts']; ?></label></button></a>
				
				<?php
					if (hesk_checkPermission('can_man_cat',0))
					{
						echo '
						<a href="manage_categories.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-categories"><label id="menu-cat">'.$hesklang['menu_cat'].'</label></button></a>
						';
					}
					
					if (hesk_checkPermission('can_man_users',0))
					{
						echo '
						<a href="manage_users.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-users"><label id="menu-users">'.$hesklang['menu_users'].'</label></button></a>
						';
					}
					
					/*if (hesk_checkPermission('can_man_canned',0))
					{
						echo '
						<a href="manage_canned.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-canned"><label id="menu-can">'.$hesklang['menu_can'].'</label></button></a>
						';
					}
					elseif (hesk_checkPermission('can_man_ticket_tpl',0))
					{
						echo '
						<a href="manage_ticket_templates.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-canned"><label id="menu-can">'.$hesklang['menu_can'].'</label></button></a>
						';
					}*/
					
					if (hesk_checkPermission('can_run_reports',0))
					{
						echo '
						<a href="reports.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-reports"><label id="menu-reports">'.$hesklang['reports'].'</label></button></a>
						';
					}
					elseif (hesk_checkPermission('can_export',0))
					{
						echo '
						<a href="export.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-reports"><label id="menu-reports">'.$hesklang['reports'].'</label></button></a>
						';
					}
				?>

				<a href="profile.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-profile"><label id="menu-profile"><?php echo $hesklang['menu_profile']; ?></label></button></a>

				<a href="mail.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-mail"><label id="menu-msg"><?php echo $hesklang['menu_msg']; ?></label></button></a>

				<?php
					if ($hesk_settings['kb_enable'])
					{
						if (hesk_checkPermission('can_man_kb',0))
						{
							echo '
							<a href="manage_knowledgebase.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-kb"><label id="menu-kb">'.$hesklang['menu_kb'].'</label></button></a>
							';
						}
						else
						{
							echo '
							<a href="knowledgebase_private.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-kb"><label id="menu-kb">'.$hesklang['menu_kb'].'</label></button></a>
							';
						}
					}
					
					/*if (hesk_checkPermission('can_ban_emails',0))
					{
						echo '
						<a href="banned_emails.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-tools"><label id="menu-tools">'.$hesklang['tools'].'</label></button></a>
						';
					}
					elseif (hesk_checkPermission('can_ban_ips',0))
					{
						echo '
						<a href="banned_ips.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-tools"><label id="menu-tools">'.$hesklang['tools'].'</label></button></a>
						';
					}
					elseif (hesk_checkPermission('can_service_msg',0))
					{
						echo '
						<a href="service_messages.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-tools"><label id="menu-tools">'.$hesklang['tools'].'</label></button></a>
						';
					}*/
					
					if (hesk_checkPermission('can_man_settings',0))
					{
						echo '
						<a href="admin_settings.php"><button type="submit" class="btn btn-default ico-button" id="ico-button-settings"><label id="menu-settings">'.$hesklang['settings'].'</label></button></a>
						';
					}
				?>
				
				<a href="index.php?a=logout&amp;token=<?php echo hesk_token_echo(); ?>"><button type="submit" class="btn btn-default ico-button" id="ico-button-logout"><label id="menu-logout"><?php echo $hesklang['logout']; ?></label></button></a>
			</div>
		</div><!-- end menu-links-header -->
    <!-- END MENU LINKS -->


<?php
// Show a notice if we are in maintenance mode
if ( hesk_check_maintenance(false) )
{
	echo '<br />';
	hesk_show_notice($hesklang['mma2'], $hesklang['mma1'], false);
}

// Show a notice if we are in "Knowledgebase only" mode
if ( hesk_check_kb_only(false) )
{
	echo '<br />';
	hesk_show_notice($hesklang['kbo2'], $hesklang['kbo1'], false);
}
?>
