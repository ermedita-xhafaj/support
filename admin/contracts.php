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

if(isset($_POST['client_id'])){
	$value_client_id = hesk_input( hesk_POST('client_id') );
}
else {
	$value_client_id = '';
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

if(!empty($value_contract_name) && !empty($value_company_id) && !empty($value_project_id) && !empty($value_staff_id) && !empty($value_starting_date) && !empty($value_ending_date) && !empty($value_created_by) && !empty($value_ending_date_info))
	{
		$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` (
			`contract_name`,
			`company_id`,
			`client_id`,
			`project_id`,
			`staff_id`,
			`starting_date`,
			`ending_date`,
			`created_by`,
			`ending_date_info`
			) VALUES (
			'".hesk_dbEscape($value_contract_name)."',
			'".hesk_dbEscape($value_company_id)."',
			'".hesk_dbEscape($value_client_id)."',
			'".hesk_dbEscape($value_project_id)."',
			'".hesk_dbEscape($value_staff_id)."',
			'".hesk_dbEscape($value_starting_date)."',
			'".hesk_dbEscape($value_ending_date)."',
			'".hesk_dbEscape($value_created_by)."',
			'".hesk_dbEscape($value_ending_date_info)."'
			)" );
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
			<!--<th style="text-align:left"><b><i><?php //echo $hesklang['aclient'] ?></i></b></th>-->
			<th style="text-align:left"><b><i><?php echo $hesklang['project'] ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['staffname'] ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['starting_date']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['ending_date']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['created_by']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['ending_date_info']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['active']; ?></i></b></th>
		</tr>

		<?php
		$res = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts`');
			$i=1;
			while ($row = mysqli_fetch_array($res)) 
			{
				$result_company_contract = hesk_dbQuery('SELECT company_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies` WHERE id='.$row['company_id']);
				$company_result = mysqli_fetch_array($result_company_contract);
			
				/*$result_client_contract = hesk_dbQuery('SELECT name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'clients` WHERE id='.$row['client_id']);
				$client_result = mysqli_fetch_array($result_client_contract);*/
				
				$result_project_contract = hesk_dbQuery('SELECT project_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects` WHERE id='.$row['project_id']);
				$project_result = mysqli_fetch_array($result_project_contract);
				
				$result_staff_cont = hesk_dbQuery('SELECT name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users` WHERE id='.$row['staff_id']);
				$staff_result = mysqli_fetch_array($result_staff_cont);
				echo '<tr>
					<td>' .$row['id'] .'</td>
					<td>' .$row['contract_name'] .'</td>
					<td>' .$company_result['company_name'] .'</td>'
					/*'<td>' .$client_result['name'] .'</td>'*/
					.'<td>' .$project_result['project_name'] .'</td>
					<td>' .$staff_result['name'] .'</td>
					<td>' .$row['starting_date'] .'</td>
					<td>' .$row['ending_date'] .'</td>
					<td>' .$row['created_by'] .'</td>
					<td>' .$row['ending_date_info'] .'</td>
					<td>' .$row['active'] .'</td>
					</tr>';
				}
			
		?>		
	</table>
</div>

<div class="container create-contract-title"><?php echo $hesklang['create_contract']; ?></div>
<div class="create-contract">
	<form method="post" action="contracts.php" name="form">
		<div class="">
			<div class="form-inline contr-row1" id="contract_row">
				<label class="col-sm-2 control-label"><?php echo $hesklang['contract_name'] ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="" name="contract_name" size="40" maxlength="50" value=" <?php echo $value_contract_name; ?>" />
			</div>
			
			<div class="form-inline" id="contract_row">
				<label class="col-sm-2 control-label" for=""><?php echo $hesklang['company']; ?>:<font class="important">*</font></label>
				<select class="form-control" id="" name="company_id" style="width: 336px;">
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

			<!--<div class="form-inline" id="contract_row">
				<label class="col-sm-2 control-label" for=""><?php /*echo $hesklang['aclient'];*/ ?></label>
				<select class="form-control" id="" name="client_id" style="width: 336px;">
					<option></option>
					<?php
						/*$res_cl = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'clients`');
						$i=1;
						while ($row_cl = mysqli_fetch_array($res_cl)) 
						{
							echo 
							'<option value="' .$row_cl['id'] .'">' .$row_cl['name'] .'</option>';
						}*/
					?>		
				</select>
			</div>-->

			<div class="form-inline" id="contract_row">
				<label class="col-sm-2 control-label" for=""><?php echo $hesklang['project']; ?>:<font class="important">*</font></label>
				<select class="form-control" id="" name="project_id" style="width: 336px;">
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
				<select class="form-control" id="" name="staff_id" style="width: 336px;">
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
				<input class="form-control" type="date" id="" name="starting_date" size="40" maxlength="50" value=" <?php echo $value_starting_date; ?>" />
			</div>

			<div class="form-inline" id="contract_row">
				<label class="col-sm-2 control-label"><?php echo $hesklang['ending_date']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="date" id="" name="ending_date" size="40" maxlength="50" value=" <?php echo $value_ending_date; ?>" />
			</div>

			<div class="form-inline" id="contract_row">
				<label class="col-sm-2 control-label"><?php echo $hesklang['created_by']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="" name="created_by" size="40" maxlength="50" value=" <?php echo $value_created_by; ?>" />
			</div>

			<div class="form-inline" id="contract_row">
				<label class="col-sm-2 control-label"><?php echo $hesklang['ending_date_info']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="date" id="" name="ending_date_info" size="40" maxlength="50" value=" <?php echo $value_ending_date_info; ?>" />
			</div>
		</div>
		
		<!-- Submit -->
		<div class="container">
			<input type="hidden" name="action" value="save" />
			<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
			<input type="submit" value="<?php echo $hesklang['save_changes'] ?>" class="btn btn-default contract-submit-btn"/>
		</div>
	</form>
</div>

<?php

/* Print footer */
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
