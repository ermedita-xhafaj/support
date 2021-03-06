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

check_contract_expiry();

/* What should we do? */
if ( $action = hesk_REQUEST('a') )
{
	if ($action == 'remove')     {remove_contract();}
}


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

if(isset($_POST['active'])){
	$value_active = hesk_input( hesk_POST('active') );
}
else {
	$value_active = '';
}

if(isset($_POST['lastchange'])){
	$value['lastchange'] = hesk_date($value['lastchange'], true);
}
else {
	$value['lastchange'] = '';
}

if(isset($_POST['staff_id'])){
	$value_staff_id = hesk_input( hesk_POST('staff_id') );
}
else {
	$value_staff_id = '';
}

if(isset($_POST['sla'])){
	$value_sla = hesk_input( hesk_POST('sla') );
}
else {
	$value_sla = '';
}

if(isset($_POST['priority'])){
	$value_priority = hesk_input( hesk_POST('priority') );
}
else {
	$value_priority = '';
	
}if(isset($_POST['reply_time'])){
	$value_reply_time = hesk_input( hesk_POST('reply_time') );
}
else {
	$value_reply_time = '';
	
}if(isset($_POST['resolved_time'])){
	$value_resolved_time = hesk_input( hesk_POST('resolved_time') );
}
else {
	$value_resolved_time = '';
}

if(!empty($value_contract_name) && !empty($value_company_id) && !empty($value_project_id) && !empty($value_starting_date) && !empty($value_ending_date) && !empty($value_sla) && !empty($value_priority) && !empty($value_reply_time) && !empty($value_resolved_time)){

	 if(isset($_POST['action']) && $_POST['action'] == 'save') {
	if((date("Y-m-d") >= hesk_dbEscape($value_starting_date)) && (date("Y-m-d") <= hesk_dbEscape($value_ending_date)) )
	{


		$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` (
			`id`,
			`contract_name`,
			`company_id`,
			`project_id`,
			`starting_date`,
			`ending_date`,
			`created_by`,
			`sla`,
			`priority`,
			`reply_time`,
			`resolved_time`,
			`active`
			) VALUES (
			'".hesk_dbEscape($value_id)."',
			'".hesk_dbEscape($value_contract_name)."',
			'".hesk_dbEscape($value_company_id)."',
			'".hesk_dbEscape($value_project_id)."',
			'".hesk_dbEscape($value_starting_date)."',
			'".hesk_dbEscape($value_ending_date)."',
			'".hesk_dbEscape($_SESSION['id'])."',
			'".hesk_dbEscape($value_sla)."',
			'".hesk_dbEscape($value_priority)."',
			'".hesk_dbEscape($value_reply_time)."',
			'".hesk_dbEscape($value_resolved_time)."',
			'".hesk_dbEscape(1)."'
			)" );
			$id = hesk_dbInsertID();
			foreach($_POST['staff_id'] as $staff){
				$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` (
					`userId`, `contractId`) VALUES('".hesk_dbEscape($staff)."', '".$id."')" );
			}
		}
	else{
		
		$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` (
			`id`,
			`contract_name`,
			`company_id`,
			`project_id`,
			`starting_date`,
			`ending_date`,
			`created_by`,
			`sla`,
			`priority`,
			`reply_time`,
			`resolved_time`,
			`active`
			) VALUES (
			'".hesk_dbEscape($value_id)."',
			'".hesk_dbEscape($value_contract_name)."',
			'".hesk_dbEscape($value_company_id)."',
			'".hesk_dbEscape($value_project_id)."',
			'".hesk_dbEscape($value_starting_date)."',
			'".hesk_dbEscape($value_ending_date)."',
			'".hesk_dbEscape($_SESSION['id'])."',
			'".hesk_dbEscape($value_sla)."',
			'".hesk_dbEscape($value_priority)."',
			'".hesk_dbEscape($value_reply_time)."',
			'".hesk_dbEscape($value_resolved_time)."',
			'".hesk_dbEscape(0)."'
			)" );
			$id = hesk_dbInsertID();
			foreach($_POST['staff_id'] as $staff){
				$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` (
					`userId`, `contractId`) VALUES('".hesk_dbEscape($staff)."', '".$id."')" );
			}			
		
	}}
}

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print admin navigation */
require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');

?>

<div class="container manage-contract-title"><?php echo $hesklang['manage_contracts']; ?></div>
<?php $sql = hesk_dbQuery("SELECT contract_name, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts`"); ?>
<?php $sql_project = hesk_dbQuery("SELECT project_name, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."projects`"); ?>
<?php $sql_company = hesk_dbQuery("SELECT company_name, id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."companies`"); ?>
	<div class="container filter_contracts" id="filter-contracts"> <!-- Krijojme nje div per filtrat -->
		<form method="post" autocomplete="off">
				<datalist id="contract_name_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql)){ ?>
					<option value="<?php echo $tmp["contract_name"]; ?>" >
				<?php }
					?>
				</datalist>
			<input placeholder="Search by contract" type="text" list="contract_name_list" name="search_by_contract_name" <?php if(isset($_POST["search_by_contract_name"])) echo "value='".$_POST["search_by_contract_name"]."'" ?> class="form-control-1 contract_name_list_style" />
			
			<datalist id="project_name_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql_project)){ ?>
					<option value="<?php echo $tmp["project_name"]; ?>" >
				<?php }
					?>
				</datalist>
			<input placeholder="Search by project" type="text" list="project_name_list" name="search_by_project_name" <?php if(isset($_POST["search_by_project_name"])) echo "value='".$_POST["search_by_project_name"]."'" ?> class="form-control-1 contract_name_list_style" />
			
			<datalist id="company_name_list">
				<?php while ($tmp = hesk_dbFetchAssoc($sql_company)){ ?>
					<option value="<?php echo $tmp["company_name"]; ?>" >
				<?php }
					?>
				</datalist>
			<input placeholder="Search by company" type="text" list="company_name_list" name="search_by_company_name" <?php if(isset($_POST["search_by_company_name"])) echo "value='".$_POST["search_by_company_name"]."'" ?> class="form-control-1 contract_name_list_style" />
			<select id="cat_status" name="search_by_contract_status" class="form-control-1 contract_name_list_style">
				<option value="">Select status</option>
				<option value="1" <?php if(isset($_POST["search_by_contract_status"])&& $_POST["search_by_contract_status"]=='1') echo "selected=selected"; ?> >Active</option>
				<option value="0"<?php if(isset($_POST["search_by_contract_status"])&& $_POST["search_by_contract_status"]=='0')  echo "selected=selected"; ?> >Inactive</option>
			</select>
			<input name="submitbutton_contracts" type="submit" class="btn btn-default execute-btn" value="Search"/>
			<button name="clearbutton_contracts" onclick="deletecontracts_admin();return false;" class="btn btn-default filter-ticket-btn" value="">Clear</button>
		</form>
	</div> <!--end div i filtrave -->
<div class="table-responsive container">
	<table class="table table-bordered manage-contracts-table add-pagination">
		<tr>
			<th style="text-align:left"><b><i><?php echo $hesklang['id']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['contract_name']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['company']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['project'] ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['staffname'] ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['email'] ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['starting_date']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['ending_date']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['desc_sla']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['priority']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['reply_time']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['resolved_time']; ?></i></b></th>
			<th class="hidden endingdate_head" style="text-align:left"><b><i><?php echo $hesklang['last_modified']; ?></i></b></th>
			<th class="hidden createdby_head" style="text-align:left"><b><i><?php echo $hesklang['created_by']; ?></i></b></th>
			<th style="text-align:left"><b><i><?php echo $hesklang['active']; ?></i></b></th>
			<?php if($_SESSION['isadmin']){ echo '<th style="text-align:left"><b><i>' .$hesklang['opt'] .'</i></b></th>'; } ?>
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
	$value_sla = hesk_input( hesk_POST('sla') );
	$value_priority = hesk_input( hesk_POST('priority') );
	$value_reply_time = hesk_input( hesk_POST('reply_time') );
	$value_resolved_time = hesk_input( hesk_POST('resolved_time') );
	$value['lastchange'] = hesk_date($value['lastchange'], true);
	$query = hesk_dbQuery(
		"UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` SET
		`contract_name`='".hesk_dbEscape($value_contract_name)."',
		`company_id`='".hesk_dbEscape($value_company_id)."',
		`project_id`='".hesk_dbEscape($value_project_id)."',
		`starting_date`='".hesk_dbEscape($value_starting_date)."',
		`ending_date`='".hesk_dbEscape($value_ending_date)."',
		`sla`='".hesk_dbEscape($value_sla)."',
		`priority`='".hesk_dbEscape($value_priority)."',
		`reply_time`='".hesk_dbEscape($value_reply_time)."',
		`resolved_time`='".hesk_dbEscape($value_resolved_time)."',
		`lastchange`=NOW()
		WHERE `id`='".intval($value_id)."' "
		);


	$query2 = hesk_dbQuery("DELETE FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` WHERE `contractId`='".intval($value_id)."'");

	foreach($_POST['staff_id'] as $staff){
		$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` (
			`userId`, 
			`contractId`
			)
			VALUES(
			'".hesk_dbEscape($staff)."', 
			'".$value_id."'
			)" );
	}
		//$flag = hesk_dbQuery('SELECT id FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts` where active = 1');


	}
	if($_SESSION['isadmin']){
		$res = hesk_dbQuery("SELECT 
		C.id, 
		C.contract_name,
		CO.company_name,
		C.active,
		P.project_name,
		S.name as staff_name,
		C.starting_date,
		C.ending_date,
		C.sla,
		C.priority,
		C.reply_time,
		C.resolved_time,
		C.lastchange,
		CB.name AS created_by 
		FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` AS C
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."users` AS S ON C.staff_id=S.Id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."users` AS CB ON C.created_by=CB.Id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."companies` AS CO on C.company_id=CO.id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."projects` AS P on C.project_id=P.id
		ORDER BY `id`");	
	
	$custom_filters = "SELECT 
		C.id, 
		C.contract_name,
		CO.company_name,
		C.active,
		P.project_name,
		S.name as staff_name,
		C.starting_date,
		C.ending_date,
		C.sla,
		C.priority,
		C.reply_time,
		C.resolved_time,
		C.lastchange,
		CB.name AS created_by 
		FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` AS C
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."users` AS S ON C.staff_id=S.Id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."users` AS CB ON C.created_by=CB.Id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."companies` AS CO on C.company_id=CO.id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."projects` AS P on C.project_id=P.id";
		
	//FILTRAT NGA ERMEDITA 
		if (isset($_POST['submitbutton_contracts'])){
			if (!empty($_POST['search_by_contract_name'])) {
				$res = hesk_dbQuery($custom_filters.' WHERE C.contract_name ="'.$_POST['search_by_contract_name'].'"');
			}
			elseif (!empty($_POST['search_by_project_name'])) {
				$res = hesk_dbQuery($custom_filters.' WHERE P.project_name ="'.$_POST['search_by_project_name'].'"');
			}
			elseif (!empty($_POST['search_by_company_name'])) {
				$res = hesk_dbQuery($custom_filters.' WHERE CO.company_name ="'.$_POST['search_by_company_name'].'"');
			}
			elseif($_POST['search_by_contract_status'] === '0' || $_POST['search_by_contract_status'] === '1'){
				$res = hesk_dbQuery($custom_filters.' WHERE C.active ='.$_POST['search_by_contract_status']);
			}
		}
	}
	else{

		$res = hesk_dbQuery("SELECT 
		C.id, 
		C.contract_name,
		CO.company_name,
		UFC.contractId,
		C.active,
		P.project_name,
		S.name as staff_name,
		C.starting_date,
		C.ending_date,
		C.sla,
		C.priority,
		C.reply_time,
		C.resolved_time,
		C.lastchange,
		CB.name AS created_by 
		FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` AS C
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."users` AS S ON C.staff_id=S.Id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."users` AS CB ON C.created_by=CB.Id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."companies` AS CO on C.company_id=CO.id
		LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."projects` AS P on C.project_id=P.id
		RIGHT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` AS UFC on UFC.contractId=C.id
		WHERE UFC.userId=".hesk_dbEscape($_SESSION['id'])."
		ORDER BY `id`");
		}
			$i=1;
			while ($row = mysqli_fetch_array($res)) 
			{
				/*$result_company_contract = hesk_dbQuery('SELECT company_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies` WHERE id='.$row['company_id']);
				$company_result = mysqli_fetch_array($result_company_contract);
				*/
				/*$result_project_contract = hesk_dbQuery('SELECT project_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects` WHERE id='.$row['project_id']);
				$project_result = mysqli_fetch_array($result_project_contract);
				*/
				/*$result_staff_cont = hesk_dbQuery('SELECT name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users` WHERE id='.$row['staff_id']);
				$staff_result = mysqli_fetch_array($result_staff_cont);
				*/
				/* Edit contract*/
				$edit_code = '<span class="new_class"><a href="http://localhost/support/admin/contracts.php?a=edit&amp;id='.$row['id'] .'#tab_edit-cont"><img src="../img/edit.png" width="16" height="16" alt="'.$hesklang['edit'].'" title="'.$hesklang['edit'].'" /></a></span>';
				
				/* Deleting contract with ID */
				/*$res_delete = "DELETE FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` WHERE `id`='".intval($value_id)."'";*/
				if ($value_id == 1)
				{
					$remove_code = '<img src="../img/blank.gif" width="16" height="16" alt="" style="padding:3px;border:none;" />';
				}
				else
				{
					$remove_code = '<span> <a href="http://localhost/support/admin/contracts.php?a=remove&amp;id='.$row['id'] .'&amp;token='.hesk_token_echo(0).'" onclick="return confirm_delete();"><img src="../img/delete.png" width="16" height="16" alt="'.$hesklang['remove'].'" title="'.$hesklang['remove'].'" /></a></span>';
				}
				
				if($row['priority'] == 1) $a="High"; 
				elseif ($row['priority'] == 2) $a="Medium";
				elseif ($row['priority'] == 3) $a="Low";
				else $a="";
				
				/* Select multiple users from staff */
				$staff = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` WHERE `contractId`='".$row['id']."'");
				$staff_string= "";
				while ($row1 = mysqli_fetch_array($staff)){
					$staff_user = hesk_dbQuery('SELECT name, email FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users` WHERE `id` ="'.$row1["userId"].'"');
					$user = mysqli_fetch_array($staff_user);
					$staff_string .= $user['name']."<br/>";
				}
				if($row['active']){
					echo '<tr>
						<td>' .$row['id'] .'</td>
						<td>' .$row['contract_name'] .'</td>
						<td>' .$row['company_name'] .'</td>
						<td>' .$row['project_name'] .'</td>
						<td>' .$staff_string .'</td>
						<td>' .$user['email'] .'</td>
						<td>' .$row['starting_date'] .'</td>
						<td>' .$row['ending_date'] .'</td>
						<td>' .$row['sla'] .'</td>
						<td>' .$a .'</td>
						<td>' .$row['reply_time'] .'</td>
						<td>' .$row['resolved_time'] .'</td>
						<td class="hidden last_modified">' .$row['lastchange'] .'</td>
						<td class="hidden createdby_info">' .$row['created_by'] .'</td>						
						<td> <input type="checkbox" name="expiry_date" value="' .$row['active'] .'" onclick="return false" checked="checked" ></td>';
						if($_SESSION['isadmin']){ echo '<td><div class="form-inline">' .$edit_code .$remove_code .'</div></td>'; }
						echo '</tr>';
					}
					else{
						echo '<tr>
						<td>' .$row['id'] .'</td>
						<td>' .$row['contract_name'] .'</td>
						<td>' .$row['company_name'] .'</td>
						<td>' .$row['project_name'] .'</td>
						<td>' .$staff_string .'</td>
						<td>' .$user['email'] .'</td>
						<td>' .$row['starting_date'] .'</td>
						<td>' .$row['ending_date'] .'</td>
						<td>' .$row['sla'] .'</td>
						<td>' .$a .'</td>
						<td>' .$row['reply_time'] .'</td>
						<td>' .$row['resolved_time'] .'</td>
						<td class="hidden last_modified">' .$row['ending_date'] .'</td>
						<td class="hidden createdby_info">' .$row['created_by'] .'</td>	
						<td> <input type="checkbox" name="expiry_date" value="' .$row['active'] .'" onclick="return false"></td>';
						if($_SESSION['isadmin']){ echo '<td><div class="form-inline">' .$edit_code .$remove_code .'</div></td>'; }
						echo '</tr>';
					}
				}
			
		?>		
	</table>
</div>

<?php $total1 = mysqli_num_rows($res); ?>
<!-- Tabi navigimit te faqeve -->
<nav class="text-center">
  <ul class="pagination">
    <li class="prev-pag-list">
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
	<?php for($i=0; $i<ceil($total1/5); $i++): ?>
		<li class="contract-list" data-item="<?php echo $i; ?>" ><a href="#"><?php echo $i+1; ?></a></li>
	<?php endfor; ?>
    <li class="next-pag-list">
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav> <!-- end-->
<?php if(isset($_GET['id'])) {
	$is_edit = true;
} else {
	$is_edit = false;
}

?>

<?php
function remove_contract(){
	
	global $hesk_settings, $hesklang;
	hesk_token_check();
	$_SERVER['PHP_SELF'] = 'contracts.php#tab_edit-cont';
	
	$con = intval( hesk_GET('id'));
	
	hesk_dbQuery("DELETE FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contracts` WHERE NOT EXISTS
	(SELECT NULL FROM`".hesk_dbEscape($hesk_settings['db_pfix'])."contractforclient` as `cc` WHERE `cc`.`contract_Id`='".intval($con)."') && `id`='".intval($con)."' LIMIT 1");
	if (hesk_dbAffectedRows() != 1)
    {
    	hesk_error("$hesklang[con_req].");
    }

    hesk_process_messages($hesklang['con_removed_db'],$_SERVER['PHP_SELF'],'SUCCESS');
}
?>
<?php if ($_SESSION['isadmin']) {?>
<div class="container">
	<div class="tab-content manage-contract-tab">
		<ul id="tabs" class="nav nav-tabs manage-contract" data-tabs="tabs">
			<li class="new_class active" id="create-contract-info"><a href="#create-cont" aria-controls="create-cont" role="tab" data-toggle="tab"><?php echo $hesklang['create_contract']; ?></a></li>
			<li class="new_class <?php if(!isset($_GET['id'])) echo " hidden"; ?>" id="edit-contract-info"><a href="#edit-cont" aria-controls="edit-cont" role="tab" data-toggle="tab"><?php echo $hesklang['edit_contract']; ?></a></li>
		</ul>
		
		<div role="tabpanel" class="tab-pane active" id="create-cont">
			<div class="create-contract">
				<form method="post" action="contracts.php#tab_create-cont" name="form">
					<div class="">
						<div class="form-inline contr-row1" id="contract_row">
							<label class="col-xs-6 col-sm-3 control-label"><?php echo $hesklang['contract_name'] ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" type="text" id="" name="contract_name" size="40" maxlength="50" value="" />
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3 control-label" for=""><?php echo $hesklang['company']; ?>:<font class="important">*</font></label>
							<select class="form-control" required="required" title="Required field" id="" name="company_id" style="width: 336px;">
								<option></option>
								<?php
									$res_comp = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies` WHERE active=1 ');
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
							<label class="col-xs-6 col-sm-3 control-label" for=""><?php echo $hesklang['project']; ?>:<font class="important">*</font></label>
							<select class="form-control" required="required" title="Required field" id="" name="project_id" style="width: 336px;">
								<option></option>
								<?php
									$res_project = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects` WHERE active=1');
									$i=1;
									while ($row_project = mysqli_fetch_array($res_project)) 
									{
										echo 
										'<option value="' .$row_project['id'] .'">' .$row_project['project_name'] .'</option>';
									}
								?>		
							</select>
						</div>
						
						<div class="form-inline" id="contract_staff" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3 control-label" for=""><?php echo $hesklang['staffname'] ?>:<font class="important">*</font></label>
							<select class="multiple form-control" multiple="multiple" required="required" title="Required field" id="" name="staff_id[]">
								<option></option>
								<?php
									$res_staff = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users` WHERE active=1');
									$i=1;
									while ($row_staff = mysqli_fetch_array($res_staff))
									{
										echo
										'<option value="' .$row_staff['id'] .'">' .$row_staff['name'] .'</option>';
									}
								?>
							</select>
						</div>

						<div class="form-inline" id="contract_email_contact" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3 control-label" for=""><?php echo $hesklang['email'] ?>:<font class="important">*</font></label>
							<select class="multiple form-control" multiple="multiple" required="required" title="Required field" id="" name="email[]">
								<option></option>
								<?php
									$res_staff = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'users` WHERE active=1');
									$i=1;
									while ($row_staff = mysqli_fetch_array($res_staff))
									{
										echo
										'<option value="' .$row_staff['id'] .'" style="display:none;">' .$row_staff['email'] .'</option>';
									}
											?>
							</select>
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3 control-label"><?php echo $hesklang['starting_date']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" type="date" id="" name="starting_date" size="40" maxlength="50" style="width: 336px;" value="" />
						</div>

						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3 control-label"><?php echo $hesklang['ending_date']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" type="date" id="" name="ending_date" size="40" maxlength="50" style="width: 336px;" value="" />
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3 control-label"><?php echo $hesklang['desc_sla']; ?>: <font class="important">*</font></label>
							<textarea class="form-control" required="required" title="Required field" id="" name="sla" rows="12" cols="60"></textarea>
						</div>
						
						<div class="form-inline" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3 control-label" for=""><?php echo $hesklang['priority']; ?>: <font class="important">*</font></label>
							<select class="form-control" required="required" title="Required field" id="" name="priority" style="width: 336px;">
							<option></option>
							<option value="3"><?php echo $hesklang['low']; ?></option>
							<option value="2"><?php echo $hesklang['medium']; ?></option>
							<option value="1"><?php echo $hesklang['high']; ?></option>
							</select>
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3 control-label"><?php echo $hesklang['reply_time']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" id="" name="reply_time" type="date" size="40" maxlength="50" style="width: 336px;" value="" />
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3 control-label"><?php echo $hesklang['resolved_time']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" id="" name="resolved_time" type="date" size="40" maxlength="50" style="width: 336px;" value="" />
						</div>
					</div>
					
					<!-- Submit -->
					<div class="container">
						<input type="hidden" name="action" value="save" />
						<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
						<input type="submit" value="<?php echo $hesklang['save_changes'] ?>" id="new-contract-submit-btn" class="btn btn-default contract-submit-btn"/>
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
		$value_sla = '';
		$value_priority = '';
		$value_reply_time = '';
		$value_resolved_time = '';
		$value_created_by = '';
		$value['lastchange'] = '';
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
			$value_active = $row['active'];
			$value_sla = $row['sla'];
			$value_priority = $row['priority'];
			$value_reply_time = $row['reply_time'];
			$value_resolved_time = $row['resolved_time'];
			$value['lastchange'] = hesk_date($value['lastchange'], true);		
		}

	}

	?>

		<!-- Edit Contract-->
		<div role="tabpanel" class="tab-pane" id="edit-cont">
			<div class="edit-contract">
			<form method="post" action="contracts.php" name="form2">
						<input type="hidden" name="id" value="<?php echo $value_id; ?>"/>
						<div class="form-inline contr-row1" id="contract_row">
							<label class="col-xs-6 col-sm-3  control-label"><?php echo $hesklang['contract_name'] ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" type="text" id="" name="contract_name" size="40" maxlength="50" value=" <?php echo $value_contract_name ?> " />
						</div>
						
						<div class="form-inline" id="contract_row" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3  control-label" for=""><?php echo $hesklang['company']; ?>:<font class="important">*</font></label>
							<select class="form-control" required="required" title="Required field" id="" name="company_id" style="width: 336px;">
								<option></option>
								<?php
									$res_comp = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies`');
									$i=1;
									while ($row_comp = mysqli_fetch_array($res_comp)) 
									{
										if($row_comp['active'] == 1)
										{
											if($value_company_id == $row_comp['id']) 
											{
												echo 
												'<option value="' .$row_comp['id'] .'" selected="selected">' .$row_comp['company_name'] .'</option>';
											}else 
											{
												echo '<option value="' .$row_comp['id'] .'">' .$row_comp['company_name'] .'</option>';
											}
										}else
										{
											if($value_company_id == $row_comp['id']) { echo '<option selected="selected" disabled>' .$row_comp['company_name'] .'</option>';}
										}
									}
								?>		
							</select>
						</div>

						<div class="form-inline" id="contract_row" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3  control-label" for=""><?php echo $hesklang['project']; ?>:<font class="important">*</font></label>
							<select class="form-control" required="required" title="Required field" id="" name="project_id" style="width: 336px;">
								<option></option>
								<?php
									$res_project = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects` ');
									$i=1;
									while ($row_project = mysqli_fetch_array($res_project)) 
									{
										if($row_project['active'] == 1)
										{
											if($value_project_id == $row_project['id']) 
											{
											echo '<option value="' .$row_project['id'] .'" selected="selected">' .$row_project['project_name'] .'</option>';
											}else
											{
												echo'<option value="' .$row_project['id'] .'">' .$row_project['project_name'] .'</option>';
											}
										}else
										{
										if($value_project_id == $row_project['id']) { echo '<option selected="selected" disabled>' .$row_project['project_name'] .'</option>';}
										}
									}
								?>		
							</select>
						</div>
						
						<div class="form-inline" id="edit_contract_staff" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3  control-label" for=""><?php echo $hesklang['staffname'] ?>:<font class="important">*</font></label>
							<select class="multiple form-control" multiple="multiple" required="required" title="Required field" id="" name="staff_id[]" style="width: 336px;">
								<option></option>
								<?php
									$res_staff = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."users`");
									if(isset($_GET['id'])){
										$current_staff = hesk_dbQuery("SELECT userId FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` WHERE `contractId`='".$_GET['id']."'");
										$staff1 = array();
										
										while ($row_staff = mysqli_fetch_array($current_staff)){
											$staff1[] = $row_staff['userId'];
										}
										$i=1;
										while ($row_staff = mysqli_fetch_array($res_staff)) 
										{ 
											if($row_staff['active'] == 1) {
												if(in_array($row_staff['id'], $staff1)){
													echo '<option value="' .$row_staff['id'] .'" selected="selected">' .$row_staff['name'] .'</option>';
												} else{
													echo '<option value="' .$row_staff['id'] .'">' .$row_staff['name'] .'</option>';
												}
											}else{
												if(in_array($row_staff['id'], $staff1)){
													echo '<option selected="selected" disabled>' .$row_staff['name'] .'</option>';}
											}
										}
									}
								?>		
							</select>      				
						</div>

						<div class="form-inline" id="edit_contract_email_contact" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3  control-label" for=""><?php echo $hesklang['email'] ?>:<font class="important">*</font></label>
							<select class="multiple form-control" multiple="multiple" required="required" title="Required field" id="" name="email[]" style="width: 336px;">
								<option></option>
								<?php
									$res_staff = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."users` ");
									if(isset($_GET['id'])){
										$current_staff = hesk_dbQuery("SELECT userId FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."userforcontract` WHERE `contractId`='".$_GET['id']."'");
										$staff1 = array();
										
										while ($row_staff = mysqli_fetch_array($current_staff)){
											$staff1[] = $row_staff['userId'];
										}
										$i=1;
										while ($row_staff = mysqli_fetch_array($res_staff)) 
										{
											if($row_staff['active'] == 1) {
												if(in_array($row_staff['id'], $staff1)){
													echo '<option value="' .$row_staff['id'] .'" selected="selected">' .$row_staff['email'] .'</option>';}
													else{
													echo '<option value="' .$row_staff['id'] .'" >' .$row_staff['email'] .'</option>';} 
											}else{
												if(in_array($row_staff['id'], $staff1)){
													echo '<option selected="selected" disabled>' .$row_staff['email'] .'</option>';
													}
											}
										}
									}
											?>
							</select>
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3  control-label"><?php echo $hesklang['starting_date']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" type="date" id="" name="starting_date" size="40" maxlength="50"  style="width: 336px;" value="<?php echo $value_starting_date; ?>" />
						</div>

						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3  control-label"><?php echo $hesklang['ending_date']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" type="date" id="" name="ending_date" size="40" maxlength="50"  style="width: 336px;" value="<?php echo $value_ending_date; ?>" />
						</div>
						
						<div class="clearfix"></div>
						<div class="form-inline project-row1" id="project_row">
							<label class="col-xs-6 col-sm-3  control-label"><?php echo $hesklang['def_act']; ?>: <font class="important">*</font></label>
							<?php ?>
							<input class="form-control" type="checkbox" name="con_active" value="1" <?php if($value_active=='1') echo "checked"; ?> />
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3  control-label"><?php echo $hesklang['desc_sla']; ?>: <font class="important">*</font></label>
							<textarea class="form-control" required="required" title="Required field" id="" name="sla" rows="12" cols="60"></textarea>
						</div>
					
						<div class="form-inline" style="margin-bottom: 5px;">
							<label class="col-xs-6 col-sm-3  control-label" for=""><?php echo $hesklang['priority']; ?>: <font class="important">*</font></label>
							<select class="form-control" required="required" title="Required field" id="" name="priority" style="width: 336px;">
							<option></option>
							<option value="3" <?php if($value_priority == 3) {echo 'selected="selected"';} ?>><?php echo $hesklang['low']; ?></option>
							<option value="2" <?php if($value_priority == 2) {echo 'selected="selected"';} ?>><?php echo $hesklang['medium']; ?></option>
							<option value="1" <?php if($value_priority == 1) {echo 'selected="selected"';} ?>><?php echo $hesklang['high']; ?></option>
							</select>
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3  control-label"><?php echo $hesklang['reply_time']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" id="" name="reply_time" type="date" size="40" maxlength="50" style="width: 336px;" value="<?php echo $value_reply_time; ?>" />
						</div>
						
						<div class="form-inline" id="contract_row">
							<label class="col-xs-6 col-sm-3  control-label"><?php echo $hesklang['resolved_time']; ?>: <font class="important">*</font></label>
							<input class="form-control" required="required" title="Required field" id="" name="resolved_time" type="date" size="40" maxlength="50" style="width: 336px;" value="<?php echo $value_resolved_time; ?>" />
						</div>

					<!-- Submit -->
					<div class="container">
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
						<input type="submit" value="<?php echo $hesklang['update_profile'] ?>" id="edit-contract-submit-btn" class="btn btn-default contract-submit-btn"/>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>
<?php } ?>
<?php

/* Print footer */
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();
?>
