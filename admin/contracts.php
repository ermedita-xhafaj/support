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
require(HESK_PATH . 'inc/profile_functions.inc.php');
hesk_load_database_functions();

hesk_session_start();
hesk_dbConnect();
hesk_isLoggedIn();

if(isset($_POST['id'])){
	$value_id = hesk_input( hesk_POST('id') );
}
else {
	$value_id = '';
}

if(isset($_POST['contract_name'])){
	$value_contract_name = hesk_input( hesk_POST('contract_name') );
}
else {
	$value_contract_name = '';
}

if(isset($_POST['company_id'])){
	$value_company_id = hesk_input( hesk_POST('company_id') );
}
else {
	$value_company_id = '';
}

if(isset($_POST['project_id'])){
	$value_project_id = hesk_input( hesk_POST('project_id') );
}
else {
	$value_project_id = '';
}

if(isset($_POST['staff_id'])){
	$value_staff_id = hesk_input( hesk_POST('staff_id') );
}
else {
	$value_staff_id = '';
}

if(isset($_POST['starting_date'])){
	$value_starting_date = hesk_input( hesk_POST('starting_date') );
}
else {
	$value_starting_date = '';
}

if(isset($_POST['ending_date'])){
	$value_ending_date = hesk_input( hesk_POST('ending_date') );
}
else {
	$value_ending_date = '';
}

if(isset($_POST['created_by'])){
	$value_created_by = hesk_input( hesk_POST('created_by') );
}
else {
	$value_created_by = '';
}

if(isset($_POST['ending_date_info'])){
	$value_ending_date_info = hesk_input( hesk_POST('ending_date_info') );
}
else {
	$value_ending_date_info = '';
}

if(isset($_POST['active'])){
	$value_active = hesk_input( hesk_POST('active') );
}
else {
	$value_active = '';
}

if(!empty($value_contract_name) && !empty($value_company_id) && !empty($value_project_id) && !empty($value_staff_id) && !empty($value_starting_date) && !empty($value_ending_date))
	{
	 if(isset($_POST['action']) && $_POST['action'] == 'save') {
		$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` (
			`id`,
			`contract_name`,
			`company_id`,
			`project_id`,
			`staff_id`,
			`starting_date`,
			`ending_date`,
			`created_by`,
			`ending_date_info`,
			`active`
			) VALUES (
			'".hesk_dbEscape($value_id)."',
			'".hesk_dbEscape($value_contract_name)."',
			'".hesk_dbEscape($value_company_id)."',
			'".hesk_dbEscape($value_project_id)."',
			'".hesk_dbEscape($value_staff_id)."',
			'".hesk_dbEscape($value_starting_date)."',
			'".hesk_dbEscape($value_ending_date)."',
			'".hesk_dbEscape($value_created_by)."',
			'".hesk_dbEscape($value_ending_date_info)."',
			'".hesk_dbEscape($value_active)."'
			)" );
		}
	}


/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print admin navigation */
require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');

?>

<div class="container manage-contract-title"><?php echo $hesklang['manage_contracts']; ?></div>
<div class="table-responsive container">
	<table class="table table-bordered manage-contracts-table">
		<tr>
			<th style="text-align:left"><b><i><?php echo $hesklang['id']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['contract_name']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['company']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['project'] ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['staffname'] ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['starting_date']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['ending_date']; ?></i></b></th>
			<th class="hidden endingdate_head" style="text-align:left"><b><i><?php echo $hesklang['ending_date_info']; ?></i></b></th>
			<th class="hidden createdby_head" style="text-align:left"><b><i><?php echo $hesklang['created_by']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['opt']; ?></i></b></th>
		</tr>
<script language="Javascript" type="text/javascript"><!--
function confirm_delete()
{
if (confirm('<?php echo addslashes($hesklang['sure_remove_user']); ?>')) {return true;}
else {return false;}
}
//-->
</script>
		<?php
	if(isset($_POST['action']) && $_POST['action'] == 'update')
	{
	$value_contract_name = hesk_input( hesk_POST('contract_name') );
	$value_company_id = hesk_input( hesk_POST('company_id') );
	$value_project_id = hesk_input( hesk_POST('project_id') );
	$value_staff_id = hesk_input( hesk_POST('staff_id') );
	$value_starting_date = hesk_input( hesk_POST('starting_date') );
	$value_ending_date = hesk_input( hesk_POST('ending_date') );

	$query = hesk_dbQuery(
		"UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` SET
		`contract_name`='".hesk_dbEscape($value_contract_name)."',
		`company_id`='".hesk_dbEscape($value_company_id)."',
		`project_id`='".hesk_dbEscape($value_project_id)."',
		`staff_id`='".hesk_dbEscape($value_staff_id)."',
		`starting_date`='".hesk_dbEscape($value_starting_date)."',
		`ending_date`='".hesk_dbEscape($value_ending_date)."'
		WHERE `id`='".intval($value_id)."' LIMIT 1"
		);
		
	}
		$res = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts`');
			$i=1;
			while ($row = mysqli_fetch_array($res)) 
			{
				$result_company_contract = hesk_dbQuery('SELECT company_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies` WHERE id='.$row['company_id']);
				$company_result = mysqli_fetch_array($result_company_contract);
				
				$result_project_contract = hesk_dbQuery('SELECT project_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects` WHERE id='.$row['project_id']);
				$project_result = mysqli_fetch_array($result_project_contract);
				
				$result_staff_cont = hesk_dbQuery('SELECT name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users` WHERE id='.$row['staff_id']);
				$staff_result = mysqli_fetch_array($result_staff_cont);
				
				/* Edit contract*/
				$edit_code = '<span><a href="http://localhost/support/admin/contracts.php?a=edit&amp;id='.$row['id'] .'#tab_edit-cont"><button class="new_class btn btn-default btn-xs">'.$hesklang['edit'].'</button></a></span>';
				
				/* Deleting contract with ID */
				$res_delete = "DELETE FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` WHERE `id`='".intval($value_id)."'";
				if ($value_id == 1)
				{
					$remove_code = '';
				}
				else
				{
					$remove_code = '<span> <a href="http://localhost/support/admin/contracts.php?a=remove&amp;id='.$value_id .'&amp;token='.hesk_token_echo(0).'" onclick="return confirm_delete();"><button class="btn btn-default btn-xs">'.$hesklang['remove'].'</button></a></span>';
				}
				
				echo '<tr>
					<td>' .$row['id'] .'</td>
					<td>' .$row['contract_name'] .'</td>
					<td>' .$company_result['company_name'] .'</td>
					<td>' .$project_result['project_name'] .'</td>
					<td>' .$staff_result['name'] .'</td>
					<td>' .$row['starting_date'] .'</td>
					<td>' .$row['ending_date'] .'</td>
					<td class="hidden endingdate_info">' .$row['ending_date'] .'</td>
					<td class="hidden createdby_info">' .$staff_result['name'] .'</td>
					<td><div class="form-inline">' .$edit_code .$remove_code .'</div></td>
					</tr>';
				}
			
		?>		
	</table>
</div>

<?php if($value_id) {
	$is_edit = true;
} else {
	$is_edit = false;
}

$value_ending_date = true;
$hesk_settings['active'] = 1;
?>
<div class="container tab-content manage-contract-tab">
	<ul id="tabs" class="nav nav-tabs manage-contract" data-tabs="tabs">
		<li class="new_class <?php if(!$is_edit){ ?>active<?php } ?>" id="create-contract-info"><a href="#create-cont" aria-controls="create-cont" role="tab" data-toggle="tab"><?php echo $hesklang['create_contract']; ?></a></li>
		<li class="new_class <?php if($is_edit){ ?>active<?php } ?>" id="edit-contract-info"><a href="#edit-cont" aria-controls="edit-cont" role="tab" data-toggle="tab"><?php echo $hesklang['edit_contract']; ?></a></li>
	</ul>
	
	<div role="tabpanel" class="tab-pane <?php if(!$is_edit){ ?>active<?php } ?>" id="create-cont">
		<div class="create-contract">
			<form method="post" action="contracts.php#tab_create-cont" name="form">
				<div class="">
					<div class="form-inline contr-row1" id="contract_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['contract_name'] ?>: <font class="important">*</font></label>
						<input class="form-control" required="required" title="Required field" type="text" id="" name="contract_name" size="40" maxlength="50" value="" />
					</div>
					
					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['company']; ?>:<font class="important">*</font></label>
						<select class="form-control" required="required" title="Required field" id="" name="company_id" style="width: 336px;">
							<option></option>
							<?php
								$res_comp = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies`');
								$i=1;
								while ($row_comp = mysqli_fetch_array($res_comp)) 
								{
									echo 
									'<option value="' .$row_comp['id'] .'">' .$row_comp['company_name'] .'</option>';
								}
							?>		
						</select>
					</div>

					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['project']; ?>:<font class="important">*</font></label>
						<select class="form-control" required="required" title="Required field" id="" name="project_id" style="width: 336px;">
							<option></option>
							<?php
								$res_project = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects`');
								$i=1;
								while ($row_project = mysqli_fetch_array($res_project)) 
								{
									echo 
									'<option value="' .$row_project['id'] .'">' .$row_project['project_name'] .'</option>';
								}
							?>		
						</select>
					</div>
					
					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['staffname'] ?>:<font class="important">*</font></label>
						<select class="form-control" required="required" title="Required field" id="" name="staff_id" style="width: 336px;">
							<option></option>
							<?php
								$res_staff = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users`');
								$i=1;
								while ($row_staff = mysqli_fetch_array($res_staff)) 
								{
									echo 
									'<option value="' .$row_staff['id'] .'">' .$row_staff['name'] .'</option>';
								}
							?>		
						</select>
					</div>

					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['starting_date']; ?>: <font class="important">*</font></label>
						<input class="form-control" required="required" title="Required field" type="date" id="" name="starting_date" size="40" maxlength="50" value="" />
					</div>

					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['ending_date']; ?>: <font class="important">*</font></label>
						<input class="form-control" required="required" title="Required field" type="date" id="" name="ending_date" size="40" maxlength="50" value="" />
					</div>
					
					<?php if( !($value_ending_date == $value_active) && $hesk_settings['active']) {?>
					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['active']; ?></label>
						<input type="checkbox" name="active" value="Y" checked="checked"/>
					</div>
					<?php } ?>
				</div>
				
				<!-- Submit -->
				<div class="container">
					<input type="hidden" name="action" value="save" />
					<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
					<input type="submit" value="<?php echo $hesklang['save_changes'] ?>" class="btn btn-default contract-submit-btn"/>
				</div>
			</form>
		</div>
	</div>

	<?php
	$value_id = '';
	$value_contract_name = '';
	$value_company_id = '';
	$value_project_id = '';
	$value_staff_id = '';
	$value_starting_date = '';
	$value_ending_date = '';
	$value_created_by = '';
	$value_ending_date_info = '';
	$value_active = '';
	
	
if(isset($_GET['id'])) {
	$res = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix'])."contracts` WHERE `id` = '".$_GET['id']."' LIMIT 1");
	if(mysqli_num_rows($res)==1){	
		$row = mysqli_fetch_array($res);
		$value_id = $row['id'];
		$value_contract_name = $row['contract_name'];
		$value_company_id = $row['company_id'];
		$value_project_id = $row['project_id'];
		$value_staff_id = $row['staff_id'];
		$value_starting_date = $row['starting_date'];
		$value_ending_date = $row['ending_date'];		
	}
	
}
 
?>

	<!-- Edit Contract-->
	<div role="tabpanel" class="tab-pane <?php if($is_edit){ ?>active<?php } ?>" id="edit-cont">
		<div class="edit-contract">
		<form method="post" action="contracts.php?a=edit&id=<?php echo$_GET['id'];?>#tab_edit-cont" name="form2">
				<div class="">
					<input type="hidden" name="id" value="<?php echo $value_id; ?>"/>
					<div class="form-inline contr-row1" id="contract_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['contract_name'] ?>: <font class="important">*</font></label>
						<input class="form-control" required="required" title="Required field" type="text" id="" name="contract_name" size="40" maxlength="50" value=" <?php echo $value_contract_name ?> " />
					</div>
					
					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['company']; ?>:<font class="important">*</font></label>
						<select class="form-control" required="required" title="Required field" id="" name="company_id" style="width: 336px;">
							<option></option>
							<?php
								$res_comp = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies`');
								$i=1;
								while ($row_comp = mysqli_fetch_array($res_comp)) 
								{
									echo 
									'<option value="' .$row_comp['id'] .'">' .$row_comp['company_name'] .'</option>';
								}
							?>		
						</select>
					</div>

					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['project']; ?>:<font class="important">*</font></label>
						<select class="form-control" required="required" title="Required field" id="" name="project_id" style="width: 336px;">
							<option></option>
							<?php
								$res_project = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects`');
								$i=1;
								while ($row_project = mysqli_fetch_array($res_project)) 
								{
									echo 
									'<option value="' .$row_project['id'] .'">' .$row_project['project_name'] .'</option>';
								}
							?>		
						</select>
					</div>
					
					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['staffname'] ?>:<font class="important">*</font></label>
						<select class="form-control" required="required" title="Required field" id="" name="staff_id" style="width: 336px;">
							<option></option>
							<?php
								$res_staff = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users`');
								$i=1;
								while ($row_staff = mysqli_fetch_array($res_staff)) 
								{
									echo 
									'<option value="' .$row_staff['id'] .'">' .$row_staff['name'] .'</option>';
								}
							?>		
						</select>
					</div>

					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['starting_date']; ?>: <font class="important">*</font></label>
						<input class="form-control" required="required" title="Required field" type="date" id="" name="starting_date" size="40" maxlength="50" value="<?php echo $value_starting_date; ?>" />
					</div>

					<div class="form-inline" id="contract_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['ending_date']; ?>: <font class="important">*</font></label>
						<input class="form-control" required="required" title="Required field" type="date" id="" name="ending_date" size="40" maxlength="50" value="<?php echo $value_ending_date; ?>" />
					</div>
				</div>
				
				<!-- Submit -->
				<div class="container">
					<input type="hidden" name="action" value="update" />
					<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
					<input type="submit" value="<?php echo $hesklang['update_profile'] ?>" class="btn btn-default contract-submit-btn"/>
				</div>
			</form>

		</div>
	</div>
</div>

<?php

/* Print footer */
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
