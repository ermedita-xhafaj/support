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


function hesk_profile_tab($session_array='userdata',$is_profile_page=true, $action = "")
{
	global $hesk_settings, $hesklang, $can_reply_tickets, $can_view_tickets, $can_view_unassigned, $default_userdata;
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
					if ($_SESSION['isadmin'] )
					{
						if(!isset($_SESSION['userdata']['checked'])){$_SESSION['userdata']['checked']="";}
						
						if ($_SESSION['userdata']['checked'] == 'admin') {
						?>
							<label><input class="te-drejtat" id="administratori" type="radio" name="isadmin" value="1" checked /> <b><?php echo $hesklang['administrator'].'</b> '.$hesklang['admin_can']; ?></label><br />
							<label><input class="te-drejtat" id="stafi" type="radio" name="isadmin" value="0" /> <b><?php echo $hesklang['astaff'].'</b> '.$hesklang['staff_can']; ?></label><br/>
							<label><input class="te-drejtat" id="klient" type="radio" name="isclient" value="1" /> <?php echo $hesklang['aclient'] ?></label>
						<?php
						}elseif ($_SESSION['userdata']['checked'] == 'staff') {
						?>
							<label><input class="te-drejtat" id="administratori" type="radio" name="isadmin" value="1" /> <b><?php echo $hesklang['administrator'].'</b> '.$hesklang['admin_can']; ?></label><br />
							<label><input class="te-drejtat" id="stafi" type="radio" name="isadmin" value="0"  checked /> <b><?php echo $hesklang['astaff'].'</b> '.$hesklang['staff_can']; ?></label><br/>
							<label><input class="te-drejtat" id="klient" type="radio" name="isclient" value="1" /> <?php echo $hesklang['aclient'] ?></label>
						<?php	
						}elseif ($_SESSION['userdata']['checked'] == 'client') {
						?>
							<label><input class="te-drejtat" id="administratori" type="radio" name="isadmin" value="1" /> <b><?php echo $hesklang['administrator'].'</b> '.$hesklang['admin_can']; ?></label><br />
							<label><input class="te-drejtat" id="stafi" type="radio" name="isadmin" value="0" /> <b><?php echo $hesklang['astaff'].'</b> '.$hesklang['staff_can']; ?></label><br/>
							<label><input class="te-drejtat" id="klient" type="radio" name="isclient" value="1" checked /> <?php echo $hesklang['aclient'] ?></label>
						<?php
						} else {
						?>
						<label><input class="te-drejtat" id="administratori" type="radio" name="isadmin" value="1" <?php if (isset($_GET['a']) && $_GET['a']=="edit") echo "checked" ; ?> /> <b><?php echo $hesklang['administrator'].'</b> '.$hesklang['admin_can']; ?></label><br />
						<label><input class="te-drejtat" id="stafi" type="radio" name="isadmin" value="0"  <?php if (isset($_GET['a']) && $_GET['a']=="editb") echo "checked" ; ?> /> <b><?php echo $hesklang['astaff'].'</b> '.$hesklang['staff_can']; ?></label><br/>
						<label><input class="te-drejtat" id="klient" type="radio" name="isclient" value="1" <?php if(isset($_GET['a']) && $_GET['a']=="editc") echo "checked" ; ?> /> <?php echo $hesklang['aclient'] ?></label>
						<?php
						}
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
			<li class="<?php if(!isset($_GET['a'])) echo "hidden"; ?>" id="project_users-info"><a href="#project_users" aria-controls="project_users" role="tab" data-toggle="tab"><?php echo $hesklang['project']; ?></a></li>
			<li class="<?php if(!isset($_GET['a']) || ($_GET['a']=="editc") ) echo "hidden"; ?>" id="preferences-info"><a href="#preferences" aria-controls="preferences" role="tab" data-toggle="tab"><?php echo $hesklang['pref']; ?></a></li>
			<li class="<?php if(!isset($_GET['a']) || ($_GET['a']=="editc") ) echo "hidden"; ?>" id="notifications-info"><a href="#notifications" aria-controls="notifications" role="tab" data-toggle="tab"><?php echo $hesklang['notn']; ?></a></li>
		</ul>
			<!-- PROFILE INFO -->
		<div role="tabpanel" class="tab-pane active" id="p-info">

			&nbsp;<br />

			<div class="profile-information">
			<div class="form-inline" id="profile-information-row">
			<label class="col-sm-2 control-label" for="profile-information-name"><?php echo $hesklang['real_name']; ?>: <font class="important">*</font></label>
			<input class="form-control" required="required" title="Required field" type="text" id="profile-information-name" name="name" size="40" maxlength="50" value="<?php if(isset($_SESSION[$session_array]['name'])) {echo $_SESSION[$session_array]['name'];} ?>"/>
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-email"><?php echo $hesklang['email']; ?>: <font class="important">*</font></label>
				<input class="form-control" required="required" title="Required field" type="email" id="profile-information-email" name="email" size="40" maxlength="255" value="<?php if(isset($_SESSION[$session_array]['email'])) {echo $_SESSION[$session_array]['email']; } ?>"/>
			</div>
			
			<?php
			if ( ! $is_profile_page || $_SESSION['isadmin'])
			{
			?>
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label control-label" for="profile-information-username"><?php echo $hesklang['username']; ?>: <font class="important">*</font></label>
				<input class="form-control" required="required" title="Required field" type="text" id="profile-information-username" name="user" size="40" maxlength="20" value="<?php if(isset($_SESSION[$session_array]['user'])) {echo $_SESSION[$session_array]['user']; } ?>" />
			</div>
			<?php
			}else{?>
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label control-label" for="profile-information-username"><?php echo $hesklang['username']; ?>: <font class="important">*</font></label>
				<input class="form-control" required="required" title="Required field" type="text" id="profile-information-username" name="user" size="40" maxlength="20" value="<?php if(isset($_SESSION[$session_array]['user'])) {echo $_SESSION[$session_array]['user']; } ?>" readonly>
			</div>
			<?php }
			?>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-address"><?php echo 'Address'; ?>:</label>
				<input class="form-control" type="text" id="profile-information-adress" name="address" size="40" maxlength="255" value="<?php if(isset($_SESSION[$session_array]['address'])) {echo $_SESSION[$session_array]['address']; } ?>"/>
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-phonenumber"><?php echo 'Phone Number'; ?>:</label>
				<input class="form-control" type="number" min="0" id="profile-information-phonenumber" name="phonenumber" size="40" maxlength="255" value="<?php if(isset($_SESSION[$session_array]['phonenumber'])) {echo $_SESSION[$session_array]['phonenumber']; } ?>"/>
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-poz_detyres"><?php echo 'Pozicioni Detyres'; ?></label>
				<input class="form-control" type="text" id="profile-information-poz_detyres" name="poz_detyres" size="40" maxlength="255" value="<?php if(isset($_SESSION[$session_array]['poz_detyres'])) {echo $_SESSION[$session_array]['poz_detyres']; } ?>"/>
			</div>
			
			<!--shtohim fushen "Active" kur celim nje departament -->
			<div class="clearfix"></div>
			<div class="form-inline project-row1" id="profile-information-row">
				<label class="col-sm-2 control-label"><?php echo $hesklang['def_act']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="checkbox" name="prof_active" value="1" <?php if(isset($_SESSION[$session_array]['active']) && $_SESSION[$session_array]['active']=="1") {echo "checked"; } ?> />

			</div>
			
			<?php if (!isset($_GET['a']))
			{ ?>
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="newpass"><?php echo $is_profile_page ? $hesklang['new_pass'] : $hesklang['pass']; ?>:</label>
				<input class="form-control" type="password" required="required" title="Required field" id="newpass" name="newpass" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.newpass2.pattern = this.value;" autocomplete="off" size="40" onkeyup="javascript:hesk_checkPassword(this.value)" />
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="newpass2"><?php echo $hesklang['confirm_pass']; ?>:</label>
				<input class="form-control" required="required" title="Required field" type="password" id="newpass2" name="newpass2" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" autocomplete="off" size="40" />
			</div>
			<?php } else { ?>
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-newpass"><?php echo $is_profile_page ? $hesklang['new_pass'] : $hesklang['pass']; ?>:</label>
				<input class="form-control" type="password" id="newpass" name="newpass" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Must have at least 6 characters' : ''); if(this.checkValidity()) form.newpass2.pattern = this.value;" autocomplete="off" size="40" onkeyup="javascript:hesk_checkPassword(this.value)" />
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-confirmpass"><?php echo $hesklang['confirm_pass']; ?>:</label>
				<input class="form-control" type="password" id="newpass2" name="newpass2" pattern="^\S{6,}$" onchange="this.setCustomValidity(this.validity.patternMismatch ? 'Please enter the same Password as above' : '');" autocomplete="off" size="40" />
				</div>
			<?php } ?>
			<div class="form-inline" id="profile-information-pwdst-row">
				<label class="col-sm-2 control-label"><?php echo $hesklang['pwdst']; ?>:</label>
				<label style="vertical-align: top;">
				<div class="form-control" style="width: 336px;">
					<div id="progressBar" style="font-size: 1px; height: 20px; width: 0px; border: 1px solid white;"></div>
				</div>
				</label>
			</div>
			
			<div class="form-inline <?php if(!isset($_GET['a']) || $_GET['a'] !=="editc") echo "hidden"; ?>" id="show-hide-kompani">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['company']; ?>:<font class="important">*</font></label>
						<select class="form-control" id="select_company_manage_users" name="company_id" style="width: 336px;">
							<option></option>
							<?php
							
								$res_comp = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies` ');
								while ($row_comp = mysqli_fetch_array($res_comp)) 
								{
									if($row_comp['active'] == 1){
										$temp_data = array();
										$data_contract = hesk_dbQuery('SELECT id FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts` WHERE active=1 AND company_id ='.$row_comp['id']);
										while ($row_contract = mysqli_fetch_array($data_contract)) 
											{
												$temp_data[] = $row_contract['id'] ;
											}
										if(isset($_SESSION[$session_array]['company_id']) && $_SESSION[$session_array]['company_id']==$row_comp['id']) {	
										echo 
											'<option value="' .$row_comp['id'] .'" contracts = "'.implode($temp_data, ",") . '" selected="selected">' .$row_comp['company_name'] .'</option>';
										}else {echo 
											'<option value="' .$row_comp['id'] .'" contracts = "'.implode($temp_data, ",") . '" >' .$row_comp['company_name'] .'</option>';}
									}else {
										if(isset($_SESSION[$session_array]['company_id']) && $_SESSION[$session_array]['company_id']==$row_comp['id']) {	
										echo 
											'<option  selected="selected" disabled>' .$row_comp['company_name'] .'</option>';
										}
									}
								}
							?>		
						</select>
			</div>
				
			<br/>
			
			<div class="form-inline <?php if(!isset($_GET['a']) || $_GET['a'] !=="editc") echo "hidden"; ?>" id="show-hide-kontrata">
				<label class="col-sm-2 control-label" for="select-kontrata"><?php echo $hesklang['contract']; ?>:<font class="important">*</font></label>
				<select class="multiple form-control" multiple="multiple" id="select-kontrata" name="contract_id[]" style="width: 336px;">
					<option></option>
					<?php
						$res_contract = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts` ');
						$temp = array();
						if(isset($_GET["id"])) {
							$res_contract_client = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contractforclient` WHERE client_Id='.hesk_dbEscape($_GET["id"]));
							while ($row_contract_data = mysqli_fetch_array($res_contract_client)){
								$temp[] = $row_contract_data['contract_Id'];
							} 
						}
						while ($row_contract = mysqli_fetch_array($res_contract)) 
						{
							if($row_contract['active'] == 1){
								if(isset($_SESSION[$session_array]['contract_id']) && in_array($row_contract['id'], $temp)) {	
									echo '<option value="' .$row_contract['id'] .'" selected="selected">' .$row_contract['contract_name'] .'</option>';
								}else {
									echo '<option value="' .$row_contract['id'] .'" >' .$row_contract['contract_name'] .'</option>';
								}
							}else{
									if(isset($_SESSION[$session_array]['contract_id']) && in_array($row_contract['id'], $temp)) {	
									echo '<option selected="selected" disabled>' .$row_contract['contract_name'] .'</option>';
								}
							}
						}
					?>		
				</select>
			</div>
			
			
<div id="options" class="<?php if(!isset($_GET['a']) || $_GET['a'] !=="editb") echo "hidden"; ?>">

			<div class="permissions-category-features">
				<!--<div class="form-inline">
					<label class="col-sm-2 control-label"><?php //echo $hesklang['allowed_cat']; ?>: <font class="important">*</font></label>
					<label>-->
					<?php
					/*foreach ($hesk_settings['categories'] as $catid => $catname)
					{
						echo '<label><input type="checkbox" name="categories[]" value="' . $catid . '" ';
						if ( in_array($catid,$_SESSION[$session_array]['categories']) )
						{
							echo ' checked="checked" ';
						}
						echo ' />' . $catname . '</label>';
					}*/
					?>
					<!--</label>
				</div>-->
				
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
	if ( !$is_profile_page)
	{
	?>		
			<!-- Projets for Users -->
			
	<div role="tabpanel" class="tab-pane" id="project_users">		
		<div class="project_contract_table">
			<table class="table table-bordered">
				<tr>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['id']; ?></i></b></th>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['name']; ?></i></b></th>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['contract']; ?></i></b></th>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['project']; ?></i></b></th>
				</tr>

				<?php
				if(isset($_GET['a']) && $_GET['a']=="edit")
				{
					$t1 = "users";
					$t2 = "userforcontract";
					$t3 = "userId";
					$t4 = "contractId";
				}else{
					$t1 = "clients";
					$t2 = "contractforclient";
					$t3 = "client_Id";
					$t4 = "contract_Id";
				}
				
				$result = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).$t1.'` WHERE id='.intval( hesk_GET('id' ) ).' ORDER BY `id` ');
					$i=1;
					while ($row = mysqli_fetch_array($result)) 
					{
						$staff = hesk_dbQuery('SELECT ' .$t3 .',' .$t4 .' FROM `' .hesk_dbEscape($hesk_settings['db_pfix']).$t2 .'` WHERE ' .$t3 .'=' .$row['id']);
						$staff_string= "";
						$project_string= "";
						while ($row1 = mysqli_fetch_array($staff))
						{
							$contract_staff = hesk_dbQuery('SELECT contract_name, project_id FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts` WHERE `id` ="'.$row1[$t4].'"');
							$contract = mysqli_fetch_array($contract_staff);
							$staff_string .= $contract['contract_name']."<br/>";
							$project_id = isset($contract['project_id'])?$contract['project_id']:"";
							if(!empty($project_id)){
								$project_staff = hesk_dbQuery('SELECT project_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects` WHERE `id` ="'.$project_id.'"');
								$project = mysqli_fetch_array($project_staff);
								$project_string .= $project['project_name']."<br/>";
							}
						}
						
						echo '<tr>
						<td class="$color">' .$row['id'] .'</td>
						<td class="$color">' .$row['name'] .'</td>
						<td class="$color">' .$staff_string .'</td>
						<td class="$color">' .$project_string .'</td>
						</tr>';
						}
				?>				
			</table>
		</div>
	</div>
	<?php
	}
	?>
			<!-- End Projets for Users -->

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
	if(isset($_SESSION[$session_array])){
		unset($_SESSION[$session_array]);
	}
} // END hesk_profile_tab()
