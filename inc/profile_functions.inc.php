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


function hesk_profile_tab($session_array='new',$is_profile_page=true)
{
	global $hesk_settings, $hesklang, $can_reply_tickets, $can_view_tickets, $can_view_unassigned;
	?>
	<!-- TABS -->
<div class="container tab-content profile-functions-tab">
			<?php if(!$is_profile_page){ ?>
			<div class="permissions">
				<div class="form-inline">
					<label class="col-sm-2 control-label"><?php echo $hesklang['atype']; ?>:</label>
					<div class="form-group">

					<?php
					/* Only administrators can create new administrator accounts */
					if ($_SESSION['isadmin'])
					{
						?>
						<label><input class="te-drejtat" id="administratori" type="radio" name="isadmin" value="1" <?php if ($_SESSION[$session_array]['isadmin']) echo 'checked="checked"'; ?> /> <b><?php echo $hesklang['administrator'].'</b> '.$hesklang['admin_can']; ?></label><br />
						<label><input class="te-drejtat" id="stafi" type="radio" name="isadmin" value="0"  <?php if (!$_SESSION[$session_array]['isadmin']) echo 'checked="checked"'; ?> /> <b><?php echo $hesklang['astaff'].'</b> '.$hesklang['staff_can']; ?></label><br/>
						<label><input class="te-drejtat" id="klient" type="radio" name="isclient" value="1" /> <?php echo $hesklang['aclient'] ?></label>
						<?php
					}
					else
					{
						echo '<b>'.$hesklang['astaff'].'</b> '.$hesklang['staff_can'];
					}
					?>

					</div>
				</div>
			</div><!-- end permissions -->
			<?php } ?>
		<ul id="tabs" class="nav nav-tabs profile-functions" data-tabs="tabs">
			<li class="active" id="profile-info"><a href="#p-info" aria-controls="p-info" role="tab" data-toggle="tab"><?php echo $hesklang['pinfo']; ?></a></li>
			<?php if(!$is_profile_page){ ?>
			<!--<li id="permissions-info"><a href="#permissions" aria-controls="permissions" role="tab" data-toggle="tab"><?php //echo $hesklang['permissions']; ?></a></li>-->
			<?php } ?>
			<li id="signature-info"><a href="#signature" aria-controls="signature" role="tab" data-toggle="tab"><?php echo $hesklang['sig']; ?></a></li>
			<li class="hidden" id="preferences-info"><a href="#preferences" aria-controls="preferences" role="tab" data-toggle="tab"><?php echo $hesklang['pref']; ?></a></li>
			<li class="hidden" id="notifications-info"><a href="#notifications" aria-controls="notifications" role="tab" data-toggle="tab"><?php echo $hesklang['notn']; ?></a></li>
		</ul>
			<!-- PROFILE INFO -->
		<div role="tabpanel" class="tab-pane active" id="p-info">

			&nbsp;<br />

			<div class="profile-information">
			<div class="form-inline" id="profile-information-row">
			<label class="col-sm-2 control-label" for="profile-information-name"><?php echo $hesklang['real_name']; ?>: <font class="important">*</font></label>
			<input class="form-control" type="text" id="profile-information-name" name="name" size="40" maxlength="50" />
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-email"><?php echo $hesklang['email']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="profile-information-email" name="email" size="40" maxlength="255" />
			</div>
			
			<?php
			if ( ! $is_profile_page || $_SESSION['isadmin'])
			{
			?>
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label control-label" for="profile-information-username"><?php echo $hesklang['username']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="profile-information-username" name="user" size="40" maxlength="20" />
			</div>
			<?php
			}
			?>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-newpass"><?php echo $is_profile_page ? $hesklang['new_pass'] : $hesklang['pass']; ?>:</label>
				<input class="form-control" type="password" id="profile-information-newpass" name="newpass" autocomplete="off" size="40" onkeyup="javascript:hesk_checkPassword(this.value)" />
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-confirmpass"><?php echo $hesklang['confirm_pass']; ?>:</label>
				<input class="form-control" type="password" id="profile-information-confirmpass" name="newpass2" autocomplete="off" size="40" />
			</div>
			
			<div class="form-inline" id="profile-information-pwdst-row">
				<label class="col-sm-2 control-label"><?php echo $hesklang['pwdst']; ?>:</label>
				<label style="vertical-align: top;">
				<div class="form-control" style="width: 336px;">
					<div id="progressBar" style="font-size: 1px; height: 20px; width: 0px; border: 1px solid white;"></div>
				</div>
				</label>
			</div>
			
			<div class="form-inline hidden" id="show-hide-kontrata">
				<label class="col-sm-2 control-label" for="select-kontrata">Kontrata:</label>
				<select class="form-control" id="select-kontrata" name="contract_id" style="width: 336px;">
					<option></option>
					<?php
						$res = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts`');
						$i=1;
						while ($row = mysqli_fetch_array($res)) {
						echo 
						'<option value="' .$row['id'] .'">' .$row['contract_name'] .'</option>'
						;}
				
					?>		
				</select>
			</div>
			
			
<div id="options" class="hidden">

			<div class="permissions-category-features">
				<div class="form-inline">
					<label class="col-sm-2 control-label"><?php echo $hesklang['allowed_cat']; ?>: <font class="important">*</font></label>
					<label>
					<?php
					foreach ($hesk_settings['categories'] as $catid => $catname)
					{
						echo '<label><input type="checkbox" name="categories[]" value="' . $catid . '" ';
						if ( in_array($catid,$_SESSION[$session_array]['categories']) )
						{
							echo ' checked="checked" ';
						}
						echo ' />' . $catname . '</label>';
					}
					?>
					</label>
				</div>
				
				<div class="form-inline" id="permissions-features">
				<label class="col-sm-2 control-label"><?php echo $hesklang['allow_feat']; ?>: <font class="important">*</font></label>
				<div class="form-group" style="vertical-align: top;">
				<?php
				foreach ($hesk_settings['features'] as $k)
				{
					echo '<label><input type="checkbox" name="features[]" value="' . $k . '" ';
					if (in_array($k,$_SESSION[$session_array]['features']))
					{
						echo ' checked="checked" ';
					}
					echo ' />' . $hesklang[$k] . '</label><br /> ';
				}
				?></div>
				&nbsp;
				
				</div>
			</div><!-- end permissions-category-features -->			
</div>			
			<?php
			if ( ! $is_profile_page && $hesk_settings['autoassign'])
			{
				?>
				<div class="form-inline hidden" id="show-hide-optionsClient">
				&nbsp;
				&nbsp;&nbsp;
				&nbsp;<label class="col-sm-6 control-label"><input type="checkbox" name="autoassign" value="Y" <?php if ( isset($_SESSION[$session_array]['autoassign']) && ! empty($_SESSION[$session_array]['autoassign']) ) {echo 'checked="checked"';} ?> /> <?php echo $hesklang['user_aa']; ?></label>
				</div>
				<?php
			}
			?>
			</div><!-- end profile-information -->


			</div>
			<!-- PROFILE INFO -->

			<?php
			if ( ! $is_profile_page)
			{
			?>
			<!-- PERMISSIONS -->
		<div role="tabpanel" class="tab-pane hidden" id="permissions">
			<div class="permissions hidden">
				<div class="form-inline">
					<label class="col-sm-2 control-label"><?php echo $hesklang['atype']; ?>:</label>
					<div class="form-group">

					<?php
					/* Only administrators can create new administrator accounts */
					if ($_SESSION['isadmin'])
					{
						?>
						<label><input type="radio" name="isadmin" value="1" onchange="Javascript:hesk_toggleLayerDisplay('options')" <?php if ($_SESSION[$session_array]['isadmin']) echo 'checked="checked"'; ?> /> <b><?php echo $hesklang['administrator'].'</b> '.$hesklang['admin_can']; ?></label><br />
						<label><input type="radio" name="isadmin" value="0" onchange="Javascript:hesk_toggleLayerDisplay('options')" <?php if (!$_SESSION[$session_array]['isadmin']) echo 'checked="checked"'; ?> /> <b><?php echo $hesklang['astaff'].'</b> '.$hesklang['staff_can']; ?></label>
						<?php
					}
					else
					{
						echo '<b>'.$hesklang['astaff'].'</b> '.$hesklang['staff_can'];
					}
					?>

					</div>
				</div>
			</div><!-- end permissions -->
		</div>
			<!-- PERMISSIONS -->
			<?php
			}
			?>

			<!-- SIGNATURE -->
		<div role="tabpanel" class="tab-pane" id="signature">		
			<div class="form-inline signature-profile-func">
				<label class="control-label col-sm-3"><?php echo $hesklang['signature_max']; ?>:</label>
				<div class="form-group">
					<textarea class="form-control" name="signature" rows="10" cols="60"><?php echo $_SESSION[$session_array]['signature']; ?></textarea><br />
					<?php echo $hesklang['sign_extra']; ?>
				</div>
			</div><!-- end signature-profile-func -->
		</div>
			<!-- SIGNATURE -->

			<?php
			if ( ! $is_profile_page || $can_reply_tickets )
			{
			?>
			<!-- PREFERENCES -->
		<div role="tabpanel" class="tab-pane" id="preferences">
			<div class="form-group preferences-profile-func">
				<div class="form-inline">
					<label class="col-sm-3 control-label"><?php echo $hesklang['aftrep']; ?>:</label>
					<div class="form-group" style="vertical-align: top;">
						<label><input type="radio" name="afterreply" value="0" <?php if (!$_SESSION[$session_array]['afterreply']) {echo 'checked="checked"';} ?>/> <?php echo $hesklang['showtic']; ?></label><br />
						<label><input type="radio" name="afterreply" value="1" <?php if ($_SESSION[$session_array]['afterreply'] == 1) {echo 'checked="checked"';} ?>/> <?php echo $hesklang['gomain']; ?></label><br />
						<label><input type="radio" name="afterreply" value="2" <?php if ($_SESSION[$session_array]['afterreply'] == 2) {echo 'checked="checked"';} ?>/> <?php echo $hesklang['shownext']; ?></label><br />
					</div>
				</div>

				<div class="form-inline preferences-profile-defaults">
					<label class="col-sm-3 control-label"><?php echo $hesklang['defaults']; ?>:</label>
					<div class="form-group" style="vertical-align: top;">
						<?php
						if ($hesk_settings['time_worked'])
						{
						?>
						<label><input type="checkbox" name="autostart" value="1" <?php if (!empty($_SESSION[$session_array]['autostart'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['autoss']; ?></label><br />
						<?php
						}
						?>
						<label><input type="checkbox" name="notify_customer_new" value="1" <?php if (!empty($_SESSION[$session_array]['notify_customer_new'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['pncn']; ?></label><br />
						<label><input type="checkbox" name="notify_customer_reply" value="1" <?php if (!empty($_SESSION[$session_array]['notify_customer_reply'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['pncr']; ?></label><br />
						<label><input type="checkbox" name="show_suggested" value="1" <?php if (!empty($_SESSION[$session_array]['show_suggested'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['pssy']; ?></label><br />
					</div>
				</div>
			</div><!-- end preferences-profile-func -->
		</div>
			<!-- PREFERENCES -->
			<?php
			}
			?>

			<!-- NOTIFICATIONS -->
		<div role="tabpanel" class="tab-pane" id="notifications">
			<div class="notif-mw"><?php echo $hesklang['nomw']; ?></div>
			<div class="notifications-profile-func">
				<div class="form-inline">
					<div>
					<?php
					if ( ! $is_profile_page || $can_view_tickets)
					{
						if ( ! $is_profile_page || $can_view_unassigned)
						{
							?>
							<label><input type="checkbox" name="notify_new_unassigned" value="1" <?php if (!empty($_SESSION[$session_array]['notify_new_unassigned'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['nwts']; ?> <?php echo $hesklang['unas']; ?></label><br />
							<?php
						}
						?>
						<label><input type="checkbox" name="notify_new_my" value="1" <?php if (!empty($_SESSION[$session_array]['notify_new_my'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['nwts']; ?> <?php echo $hesklang['s_my']; ?></label><br />

						<?php
						if ( ! $is_profile_page || $can_view_unassigned)
						{
							?>
							<label><input type="checkbox" name="notify_reply_unassigned" value="1" <?php if (!empty($_SESSION[$session_array]['notify_reply_unassigned'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['ncrt']; ?> <?php echo $hesklang['unas']; ?></label><br />
							<?php
						}
						?>
						<label><input type="checkbox" name="notify_reply_my" value="1" <?php if (!empty($_SESSION[$session_array]['notify_reply_my'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['ncrt']; ?> <?php echo $hesklang['s_my']; ?></label><br />

						<label><input type="checkbox" name="notify_assigned" value="1" <?php if (!empty($_SESSION[$session_array]['notify_assigned'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['ntam']; ?></label><br />
						<label><input type="checkbox" name="notify_note" value="1" <?php if (!empty($_SESSION[$session_array]['notify_note'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['ntnote']; ?></label><br />
						<?php
					}
					?>
					<label><input type="checkbox" name="notify_pm" value="1" <?php if (!empty($_SESSION[$session_array]['notify_pm'])) {echo 'checked="checked"';}?> /> <?php echo $hesklang['npms']; ?></label><br />
					</div>
				</div>
			</div><!-- end notifications-profile-func -->
		</div>
			<!-- NOTIFICATIONS -->
</div>
	<!-- TABS -->

	<script language="Javascript" type="text/javascript"><!--
	hesk_checkPassword(document.form1.newpass.value);
	//-->
	</script>

	<?php
} // END hesk_profile_tab()
