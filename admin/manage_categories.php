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
hesk_checkPermission('can_man_cat');

// Possible priorities
$priorities = array(
	3 => array('value' => 3, 'text' => $hesklang['low'],		'formatted' => $hesklang['low']),
	2 => array('value' => 2, 'text' => $hesklang['medium'],		'formatted' => '<font class="medium">'.$hesklang['medium'].'</font>'),
	1 => array('value' => 1, 'text' => $hesklang['high'],		'formatted' => '<font class="important">'.$hesklang['high'].'</font>'),
	0 => array('value' => 0, 'text' => $hesklang['critical'],	'formatted' => '<font class="critical">'.$hesklang['critical'].'</font>'),
);

/* What should we do? */
if ( $action = hesk_REQUEST('a') )
{
	if ($action == 'linkcode')       {generate_link_code();}
	elseif ( defined('HESK_DEMO') )  {hesk_process_messages($hesklang['ddemo'], 'manage_categories.php', 'NOTICE');}
	elseif ($action == 'new')        {new_cat();}
	elseif ($action == 'rename')     {rename_cat();}
	elseif ($action == 'remove')     {remove();}
	elseif ($action == 'order')      {order_cat();}
	elseif ($action == 'autoassign') {toggle_autoassign();}
	elseif ($action == 'type')       {toggle_type();}
	elseif ($action == 'priority')   {change_priority();}
}

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');

/* Print main manage users page */
require_once(HESK_PATH . 'inc/show_admin_nav.inc.php');
?>

<!--</td>
</tr>-->

<!-- start in this page end somewhere...
<tr>
<td>-->

<div class="container tab-content manage-config-tab">
	<ul id="tabs" class="nav nav-tabs manage-config" data-tabs="tabs">
		<li class="active" id="configuration-info"><a href="#config-info" aria-controls="config-info" role="tab" data-toggle="tab"><?php echo $hesklang['categ_pri']; ?></a></li>
		<li id="department-info"><a href="#dep-info" aria-controls="dep-info" role="tab" data-toggle="tab"><?php echo $hesklang['dep']; ?></a></li>
		<li id="company-info"><a href="#comp-info" aria-controls="comp-info" role="tab" data-toggle="tab"><?php echo $hesklang['comp'] ?></a></li>
		<li id="project-info"><a href="#proj-info" aria-controls="proj-info" role="tab" data-toggle="tab"><?php echo $hesklang['proj'] ?></a></li>
	</ul>
	
	
	<div role="tabpanel" class="tab-pane active" id="config-info">
	
	<script language="Javascript" type="text/javascript"><!--
	function confirm_delete()
	{
	if (confirm('<?php echo hesk_makeJsString($hesklang['confirm_del_cat']); ?>')) {return true;}
	else {return false;}
	}
	//-->
	</script>

	<?php
	/* This will handle error, success and notice messages */
	hesk_handle_messages();
	?>

	<div class="container manage-categories-title"><?php echo $hesklang['proj']; ?> [<a href="javascript:void(0)" onclick="javascript:alert('<?php echo hesk_makeJsString($hesklang['cat_intro']); ?>')">?</a>]</div>

	<div class="table-responsive container">
		<table class="table table-bordered manage-categories-table">
			<tr>
			<th class="admin_white" style="white-space:nowrap;width:1px;"><b><i>&nbsp;<?php echo $hesklang['id']; ?>&nbsp;</i></b></th>
			<th class="admin_white" style="text-align:left"><b><i>&nbsp;<?php echo $hesklang['cat_name']; ?>&nbsp;</i></b></th>
			<th class="admin_white" style="text-align:left"><b><i>&nbsp;<?php echo $hesklang['priority']; ?>&nbsp;</i></b></th>
			<th class="admin_white" style="white-space:nowrap;width:1px;"><b><i>&nbsp;<?php echo $hesklang['not']; ?>&nbsp;</i></b></th>
			<th class="admin_white" style="text-align:left"><b><i>&nbsp;<?php echo $hesklang['graph']; ?>&nbsp;</i></b></th>
			<th class="admin_white" style="width:100px"><b><i>&nbsp;<?php echo $hesklang['opt']; ?>&nbsp;</i></b></th>
			</tr>

			<?php
			/* Get number of tickets per category */
			$tickets_all   = array();
			$tickets_total = 0;

			$res = hesk_dbQuery('SELECT COUNT(*) AS `cnt`, `category` FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'tickets` GROUP BY `category`');
			while ($tmp = hesk_dbFetchAssoc($res))
			{
				$tickets_all[$tmp['category']] = $tmp['cnt'];
				$tickets_total += $tmp['cnt'];
			}

			/* Get list of categories */
			$res = hesk_dbQuery("SELECT * FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` ORDER BY `cat_order` ASC");
			$options='';

			$i=1;
			$j=0;
			$num = hesk_dbNumRows($res);

			while ($mycat=hesk_dbFetchAssoc($res))
			{
				$j++;

				if (isset($_SESSION['selcat2']) && $mycat['id'] == $_SESSION['selcat2'])
				{
					$color = 'admin_green';
					unset($_SESSION['selcat2']);
				}
				else
				{
					$color = $i ? 'admin_white' : 'admin_gray';
				}

				$tmp   = $i ? 'White' : 'Blue';
				$style = 'class="option'.$tmp.'OFF" onmouseover="this.className=\'option'.$tmp.'ON\'" onmouseout="this.className=\'option'.$tmp.'OFF\'"';
				$i     = $i ? 0 : 1;

				/* Number of tickets and graph width */
				$all = isset($tickets_all[$mycat['id']]) ? $tickets_all[$mycat['id']] : 0;
				$width_all = 0;
				if ($tickets_total && $all)
				{
					$width_all  = round(($all / $tickets_total) * 100);
				}

				/* Deleting category with ID 1 (default category) is not allowed */
				if ($mycat['id'] == 1)
				{
					$remove_code=' <img src="../img/blank.gif" width="16" height="16" alt="" style="padding:3px;border:none;" />';
				}
				else
				{
					$remove_code=' <a href="manage_categories.php?a=remove&amp;catid='.$mycat['id'].'&amp;token='.hesk_token_echo(0).'" onclick="return confirm_delete();"><img src="../img/delete.png" width="16" height="16" alt="'.$hesklang['remove'].'" title="'.$hesklang['remove'].'" '.$style.' /></a>';
				}

				/* Is category private or public? */
				if ($mycat['type'])
				{
					$type_code = '<a href="manage_categories.php?a=type&amp;s=0&amp;catid='.$mycat['id'].'&amp;token='.hesk_token_echo(0).'"><img src="../img/private.png" width="16" height="16" alt="'.$hesklang['cat_private'].'" title="'.$hesklang['cat_private'].'" '.$style.' /></a>';
				}
				else
				{
					$type_code = '<a href="manage_categories.php?a=type&amp;s=1&amp;catid='.$mycat['id'].'&amp;token='.hesk_token_echo(0).'"><img src="../img/public.png" width="16" height="16" alt="'.$hesklang['cat_public'].'" title="'.$hesklang['cat_public'].'" '.$style.' /></a>';
				}

				/* Is auto assign enabled? */
				if ($hesk_settings['autoassign'])
				{
					if ($mycat['autoassign'])
					{
						$autoassign_code = '<a href="manage_categories.php?a=autoassign&amp;s=0&amp;catid='.$mycat['id'].'&amp;token='.hesk_token_echo(0).'"><img src="../img/autoassign_on.png" width="16" height="16" alt="'.$hesklang['aaon'].'" title="'.$hesklang['aaon'].'" '.$style.' /></a>';
					}
					else
					{
						$autoassign_code = '<a href="manage_categories.php?a=autoassign&amp;s=1&amp;catid='.$mycat['id'].'&amp;token='.hesk_token_echo(0).'"><img src="../img/autoassign_off.png" width="16" height="16" alt="'.$hesklang['aaoff'].'" title="'.$hesklang['aaoff'].'" '.$style.' /></a>';
					}
				}
				else
				{
					$autoassign_code = '';
				}

				$options .= '<option value="'.$mycat['id'].'" ';
				$options .= (isset($_SESSION['selcat']) && $mycat['id'] == $_SESSION['selcat']) ? ' selected="selected" ' : '';
				$options .= '>'.$mycat['name'].'</option>';

				echo '
				<tr>
				<td class="'.$color.'">'.$mycat['id'].'</td>
				<td class="'.$color.'">'.$mycat['name'].'</td>
				<td class="'.$color.'" width="1" style="white-space: nowrap;">'.$priorities[$mycat['priority']]['formatted'].'&nbsp;</td>
				<td class="'.$color.'" style="text-align:center"><a href="show_tickets.php?category='.$mycat['id'].'&amp;s_all=1&amp;s_my=1&amp;s_ot=1&amp;s_un=1" alt="'.$hesklang['list_tickets_cat'].'" title="'.$hesklang['list_tickets_cat'].'">'.$all.'</a></td>
				<td class="'.$color.'" width="1">
				<div class="progress-container" style="width: 160px" title="'.sprintf($hesklang['perat'],$width_all.'%').'">
				<div style="width: '.$width_all.'%;float:left;"></div>
				</div>
				</td>
				<td class="'.$color.'" style="text-align:center; white-space:nowrap;">
				<a href="Javascript:void(0)" onclick="Javascript:hesk_window(\'manage_categories.php?a=linkcode&amp;catid='.$mycat['id'].'&amp;p='.$mycat['type'].'\',\'200\',\'500\')"><img src="../img/code' . ($mycat['type'] ? '_off' : '') . '.png" width="16" height="16" alt="'.$hesklang['geco'].'" title="'.$hesklang['geco'].'" '.$style.' /></a>
				' . $autoassign_code . '
				' . $type_code . ' ';

				if ($num > 1)
				{
					if ($j == 1)
					{
						echo'<img src="../img/blank.gif" width="16" height="16" alt="" style="padding:3px;border:none;" /> <a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=15&amp;token='.hesk_token_echo(0).'"><img src="../img/move_down.png" width="16" height="16" alt="'.$hesklang['move_dn'].'" title="'.$hesklang['move_dn'].'" '.$style.' /></a>';
					}
					elseif ($j == $num)
					{
						echo'<a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=-15&amp;token='.hesk_token_echo(0).'"><img src="../img/move_up.png" width="16" height="16" alt="'.$hesklang['move_up'].'" title="'.$hesklang['move_up'].'" '.$style.' /></a> <img src="../img/blank.gif" width="16" height="16" alt="" style="padding:3px;border:none;" />';
					}
					else
					{
						echo'
						<a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=-15&amp;token='.hesk_token_echo(0).'"><img src="../img/move_up.png" width="16" height="16" alt="'.$hesklang['move_up'].'" title="'.$hesklang['move_up'].'" '.$style.' /></a>
						<a href="manage_categories.php?a=order&amp;catid='.$mycat['id'].'&amp;move=15&amp;token='.hesk_token_echo(0).'"><img src="../img/move_down.png" width="16" height="16" alt="'.$hesklang['move_dn'].'" title="'.$hesklang['move_dn'].'" '.$style.' /></a>
						';
					}
				}

				echo $remove_code.'</td>
				</tr>
				';

			} // End while

			?>
		</table>
	</div>

	<?php
	if ($hesk_settings['cust_urgency'])
	{
		hesk_show_notice($hesklang['cat_pri_info'] . ' ' . $hesklang['cpri']);
	}
	?>

	<div class="container add-cat-title"><?php echo $hesklang['add_cat']; ?></div>
	<div class="manage-categories-add-new-category">
		<div>	
		<!-- CONTENT -->
			<form action="manage_categories.php" method="post">
				<div class="form-inline category-row" id="name-category-row"><div class="col-sm-3"><label for="category-name"><?php echo $hesklang['cat_name']; ?></label>(<?php echo $hesklang['max_chars']; ?>)<b>:</b></div> <input class="form-control" type="text" id="category-name" name="name" size="40" maxlength="40"
				<?php
					if (isset($_SESSION['catname']))
					{
						echo ' value="'.hesk_input($_SESSION['catname']).'" ';
					}
				?>	/></div>
		
				<div class="form-inline category-row"><div class="col-sm-3"><label for="category-priority"><?php echo $hesklang['def_pri']; ?></label>[<a href="javascript:void(0)" onclick="javascript:alert('<?php echo hesk_makeJsString($hesklang['cat_pri']); ?>')">?</a></b>]</div> 
				<select class="form-control" id="category-priority" name="priority">
				<?php
				// Default priority: low
				if ( ! isset($_SESSION['cat_priority']) )
				{
					$_SESSION['cat_priority'] = 3;
				}

				// List possible priorities
				foreach ($priorities as $value => $info)
				{
					echo '<option value="'.$value.'"'.($_SESSION['cat_priority'] == $value ? ' selected="selected"' : '').'>'.$info['text'].'</option>';
				}
				?>
				</select></div>

				<div class="form-inline category-row"><b><label class="col-sm-3"><?php echo $hesklang['opt']; ?>:</b></label>
				
					<?php
					if ($hesk_settings['autoassign'])
					{
						?>
						<div class="form-group options-category-row">
							<label><input type="checkbox" name="autoassign" value="Y" <?php if ( ! isset($_SESSION['cat_autoassign']) || $_SESSION['cat_autoassign'] == 1 ) {echo 'checked="checked"';} ?>  /> <?php echo $hesklang['cat_aa']; ?></label><br/>
						<?php
					}
					?>
							<label><input type="checkbox" name="type" value="Y" <?php if ( isset($_SESSION['cat_type']) && $_SESSION['cat_type'] == 1 ) {echo 'checked="checked"';} ?> /> <?php echo $hesklang['cat_type']; ?></label>
						</div>	
				</div>
			
				<div class="container">
					<input type="hidden" name="a" value="new" />
					<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
					<input type="submit" value="<?php echo $hesklang['create_cat']; ?>" class="btn btn-default create-cat-btn" />
				</div>
			</form>	
		<!-- END CONTENT -->
		</div><!-- end manage-categories-add-new-category -->

	<div id="hr_for_category"><hr/></div>

	<div class="container ren-cat-title"><?php echo $hesklang['ren_cat']; ?></div>
	<div>
		
		<!-- CONTENT -->
			<form action="manage_categories.php" method="post">
				<div class="form-group old-new-name-category">
					<div class="form-inline new-name-category-row">
						<label class="col-sm-3 control-label" for="old-name-category"><?php echo $hesklang['oln']; ?></label>
						<select  class="form-control" id="old-name-category" name="catid"><?php echo $options; ?></select>
					</div>
					
					<div class="form-inline">
						<label class="col-sm-3 control-label" for="new-name-category"><?php echo $hesklang['nen']; ?></label>
						<input class="form-control" type="text" id="new-name-category" name="name" size="40" maxlength="40" <?php if (isset($_SESSION['catname2'])) {echo ' value="'.hesk_input($_SESSION['catname2']).'" ';} ?> />
					</div>
				</div><!-- end old-new-name-category -->			
				
				<div class="container">
					<input type="hidden" name="a" value="rename" />
					<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
					<input type="submit" value="<?php echo $hesklang['ren_cat']; ?>" class="btn btn-default rename-cat-btn" />
				</div>
			</form>
		<!-- END CONTENT -->
	</div> <!-- end manage-categories-rename-category -->
	</div>

	<div class="container set-cat-pri-title"><?php echo $hesklang['ch_cat_pri']; ?></div>
	<div class="manage-categories-set-category-priority">
		
		<!-- CONTENT -->
			<form action="manage_categories.php" method="post">
					<div class="form-group manage-category-priority">
						<div class="form-inline manage-category-row">
							<label class="col-sm-3 control-label" for="set-category"><?php echo $hesklang['category']; ?>:</label>
							<select class="form-control" id="set-category" name="catid"><?php echo $options; ?></select>
						</div>
					
						<div class="form-inline">
							<label class="col-sm-3 control-label" for="set-priority"><?php echo $hesklang['priority']; ?>:</label>
							<select class="form-control" id="set-priority" name="priority">
								<?php
								// Default priority: low
								if ( ! isset($_SESSION['cat_ch_priority']) )
								{
									$_SESSION['cat_ch_priority'] = 3;
								}

								// List possible priorities
								foreach ($priorities as $value => $info)
								{
									echo '<option value="'.$value.'"'.($_SESSION['cat_ch_priority'] == $value ? ' selected="selected"' : '').'>'.$info['text'].'</option>';
								}
								?>
							</select>
						</div>
					</div><!-- end manage-category-priority-->	
					<div class="container">
						<input type="hidden" name="a" value="priority" />
						<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
						<input type="submit" value="<?php echo $hesklang['ch_cat_pri']; ?>" class="btn btn-default set-cat-pri-btn" />
					</div>
			</form>
		<!-- END CONTENT -->
	</div><!-- end manage-categories-set-category-priority -->
	</div> <!-- config-info -->
		
	<div role="tabpanel" class="tab-pane" id="dep-info">
				<?php
			if(isset($_POST['id'])){
				$valuedep_id = hesk_input( hesk_POST('id') );
			}
			else {
				$valuedep_id = '';
			}
			
			if(isset($_POST['department_code'])){
				$valuedep_department_code = hesk_input( hesk_POST('department_code') );
			}
			else {
				$valuedep_department_code = '' ;
			}
			
			if(isset($_POST['department_name'])){
				$valuedep_department_name = hesk_input( hesk_POST('department_name') );
			}
			else {
				$valuedep_department_name = '' ;
			}
			
			if(isset($_POST['department_manager'])){
				$valuedep_department_manager = hesk_input( hesk_POST('department_manager') );
			}
			else {
				$valuedep_department_manager = '' ;
			}
			
			if(isset($_POST['active'])){
				$valuedep_active = hesk_input( hesk_POST('active') );
			}
			else {
				$valuedep_active = '' ;
			}

			var_dump($_POST);
			if(!empty($valuedep_department_code) && !empty($valuedep_department_name) && !empty($valuedep_department_manager))
			{	
				
				$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."departments` (
						`department_code`,
						`department_name`,
						`department_manager`
						) VALUES (
						'".hesk_dbEscape($valuedep_department_code)."',
						'".hesk_dbEscape($valuedep_department_name)."',
						'".hesk_dbEscape($valuedep_department_manager)."'
						)" );
			}
		?>
		<div class="container manage-project-title"><?php echo $hesklang['manage_department']; ?></div>
		<div class="table-responsive container">
			<table class="table table-bordered manage-projects-table">
				<tr>
					<th style="text-align:left"><b><i><?php echo $hesklang['dep_code']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['dep_name']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['dep_manager']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['active'] ?></i></b></th>
				</tr>

				<?php
				$res_dep = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'departments`');
					$i=1;
					while ($row_dep = mysqli_fetch_array($res_dep)) 
					{
						echo '<tr>
							<td>' .$row_dep['department_code'] .'</td>
							<td>' .$row_dep['department_name'] .'</td>
							<td>' .$row_dep['department_manager'] .'</td>
							<td>' .$row_dep['active'] .'</td>
							</tr>';
						}
				?>		
			</table>
		</div>

		<div class="container create-project-title"><?php echo $hesklang['create_department']; ?></div>
		<div class="create-projects">
			<form method="POST" action="manage_categories.php#tab_dep-info" name="form2">
				<div class="">
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['dep_code'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="department_code" size="40" maxlength="50" value=" <?php echo $valuedep_department_code; ?>" />
					</div>
					
					<div class="form-inline" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['dep_name'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="department_name" size="40" maxlength="50" value=" <?php echo $valuedep_department_name; ?>" />
					</div>
				
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['dep_manager'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="department_manager" size="40" maxlength="50" value=" <?php echo $valuedep_department_manager; ?>" />
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
	</div>
		
	<div role="tabpanel" class="tab-pane" id="comp-info">
		<?php
			if(isset($_POST['id'])){
				$valuecomp_id = hesk_input( hesk_POST('id') );
			}
			else {
				$valuecomp_id = '';
			}
			
			if(isset($_POST['company_name'])){
				$valuecomp_company_name = hesk_input( hesk_POST('company_name') );
			}
			else {
				$valuecomp_company_name = '' ;
			}
			
			if(isset($_POST['email'])){
				$valuecomp_email = hesk_input( hesk_POST('email') );
			}
			else {
				$valuecomp_email = '' ;
			}
			
			if(isset($_POST['web_page'])){
				$valuecomp_web_page = hesk_input( hesk_POST('web_page') );
			}
			else {
				$valuecomp_web_page = '' ;
			}
			
			if(isset($_POST['address'])){
				$valuecomp_address = hesk_input( hesk_POST('address') );
			}
			else {
				$valuecomp_address = '' ;
			}
			
			if(isset($_POST['state'])){
				$valuecomp_state = hesk_input( hesk_POST('state') );
			}
			else {
				$valuecomp_state = '' ;
			}
			
			if(isset($_POST['city'])){
				$valuecomp_city = hesk_input( hesk_POST('city') );
			}
			else {
				$valuecomp_city = '' ;
			}
			
			if(isset($_POST['zip_code'])){
				$valuecomp_zip_code = hesk_input( hesk_POST('zip_code') );
			}
			else {
				$valuecomp_zip_code = '' ;
			}
			
			if(isset($_POST['telephone'])){
				$valuecomp_telephone = hesk_input( hesk_POST('telephone') );
			}
			else {
				$valuecomp_telephone = '' ;
			}

			var_dump($_POST);
			if(!empty($valuecomp_company_name) && !empty($valuecomp_email) && !empty($valuecomp_web_page) && !empty($valuecomp_address) && !empty($valuecomp_state) && !empty($valuecomp_city) &&  !empty($valuecomp_zip_code) && !empty($valuecomp_telephone))
			{	
				
				$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."companies` (
						`company_name`,
						`email`,
						`web_page`,
						`address`,
						`state`, 
						`city`, 
						`zip_code`, 
						`telephone`
						) VALUES (
						'".hesk_dbEscape($valuecomp_company_name)."',
						'".hesk_dbEscape($valuecomp_email)."',
						'".hesk_dbEscape($valuecomp_web_page)."',
						'".hesk_dbEscape($valuecomp_address)."',
						'".hesk_dbEscape($valuecomp_state)."',
						'".hesk_dbEscape($valuecomp_city)."',
						'".hesk_dbEscape($valuecomp_zip_code)."',
						'".hesk_dbEscape($valuecomp_telephone)."'
						)" );
			}
		?>
		<div class="container manage-project-title"><?php echo $hesklang['manage_company']; ?></div>
		<div class="table-responsive container">
			<table class="table table-bordered manage-projects-table">
				<tr>
					<th style="text-align:left"><b><i><?php echo $hesklang['id']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['company_name']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['email']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['web_page'] ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['address'] ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['state']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['city']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['zip_code']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['telephone']; ?></i></b></th>
				</tr>

				<?php
				$res_comp = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies`');
					$i=1;
					while ($row_comp = mysqli_fetch_array($res_comp)) 
					{
						echo '<tr>
							<td>' .$row_comp['id'] .'</td>
							<td>' .$row_comp['company_name'] .'</td>
							<td>' .$row_comp['email'] .'</td>
							<td>' .$row_comp['web_page'] .'</td>
							<td>' .$row_comp['address'] .'</td>
							<td>' .$row_comp['state'] .'</td>
							<td>' .$row_comp['city'] .'</td>
							<td>' .$row_comp['zip_code'] .'</td>
							<td>' .$row_comp['telephone'] .'</td>
							</tr>';
						}
				?>		
			</table>
		</div>

		<div class="container create-project-title"><?php echo $hesklang['create_company']; ?></div>
		<div class="create-projects">
			<form method="POST" action="manage_categories.php#tab_comp-info" name="form">
				<div class="">
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['company_name'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="company_name" size="40" maxlength="50" value=" <?php echo $valuecomp_company_name; ?>" />
					</div>
					
					<div class="form-inline" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['email'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="email" id="" name="email" size="40" maxlength="50" value=" <?php echo $valuecomp_email; ?>" />
					</div>
				
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['web_page'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="web_page" size="40" maxlength="50" value=" <?php echo $valuecomp_web_page; ?>" />
					</div>
					
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['address'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="address" size="40" maxlength="50" value=" <?php echo $valuecomp_address; ?>" />
					</div>
					
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['state'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="state" size="40" maxlength="50" value=" <?php echo $valuecomp_state; ?>" />
					</div>
					
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['city'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="city" size="40" maxlength="50" value=" <?php echo $valuecomp_city; ?>" />
					</div>
					
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['zip_code'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="zip_code" size="40" maxlength="50" value=" <?php echo $valuecomp_zip_code; ?>" />
					</div>
					
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['telephone'] ?>: <font class="important">*</font></label>
						<input class="form-control" required type="text" id="" name="telephone" size="40" maxlength="50" value=" <?php echo $valuecomp_telephone; ?>" />
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
	</div>
	
	
	
	<div role="tabpanel" class="tab-pane" id="proj-info">
		<?php
			if(isset($_POST['id'])){
				$valueproj_id = hesk_input( hesk_POST('id') );
			}
			else {
				$valueproj_id = '';
			}
			
			if(isset($_POST['project_name'])){
				$valueproj_project_name = hesk_input( hesk_POST('project_name') );
			}
			else {
				$valueproj_project_name = '';
			}
			
			if(isset($_POST['project_manager'])){
				$valueproj_project_manager = hesk_input( hesk_POST('project_manager') );
			}
			else {
				$valueproj_project_manager = '';
			}
			
			if(isset($_POST['company_id'])){
				$valueproj_company_id = hesk_input( hesk_POST('company_id') );
			}
			else {
				$valueproj_company_id = '';
			}
			
			if(isset($_POST['active'])){
				$valueproj_active = hesk_input( hesk_POST('active') );
			}
			else {
				$valueproj_active = '';
			}

			if(!empty($valueproj_project_name) && !empty($valueproj_project_manager) && !empty($valueproj_company_id))
			{
				$sql = hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."projects` (
						`project_name`,
						`project_manager`,
						`company_id`
						) VALUES (
						'".hesk_dbEscape($valueproj_project_name)."',
						'".hesk_dbEscape($valueproj_project_manager)."',
						'".hesk_dbEscape($valueproj_company_id)."'
						)" );
			}
		?>
		<div class="container manage-project-title"><?php echo $hesklang['manage_project']; ?></div>
		<div class="table-responsive container">
			<table class="table table-bordered manage-projects-table">
				<tr>
					<th style="text-align:left"><b><i><?php echo $hesklang['id']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['project_name']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['project_manager']; ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['company_name'] ?></i></b></th>
					<th style="text-align:left"><b><i><?php echo $hesklang['active']; ?></i></b></th>
				</tr>

				<?php
				$res_proj = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects`');
					$i=1;
					while ($row_proj = mysqli_fetch_array($res_proj)) 
					{
						$result_company_proj = hesk_dbQuery('SELECT company_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'companies` WHERE id='.$row_proj['company_id']);
						$company_resultproj = mysqli_fetch_array($result_company_proj);

						echo '<tr>
							<td>' .$row_proj['id'] .'</td>
							<td>' .$row_proj['project_name'] .'</td>
							<td>' .$row_proj['project_manager'] .'</td>
							<td>' .$company_resultproj['company_name'] .'</td>
							<td>' .$row_proj['active'] .'</td>
							</tr>';
						}
				?>		
			</table>
		</div>

		<div class="container create-project-title"><?php echo $hesklang['create_project']; ?></div>
		<div class="create-projects">
			<form method="post" action="manage_categories.php#tab_proj-info" name="form1">
				<div class="">
					<div class="form-inline project-row1" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['project_name'] ?>: <font class="important">*</font></label>
						<input class="form-control" type="text" id="" name="project_name" size="40" maxlength="50" value=" <?php echo $valueproj_project_name; ?>" />
					</div>
					
					<div class="form-inline" id="project_row">
						<label class="col-sm-2 control-label"><?php echo $hesklang['project_manager'] ?>: <font class="important">*</font></label>
						<input class="form-control" type="text" id="" name="project_manager" size="40" maxlength="50" value=" <?php echo $valueproj_project_manager; ?>" />
					</div>
					
					<div class="form-inline" id="project_row">
						<label class="col-sm-2 control-label" for=""><?php echo $hesklang['company_name']; ?></label>
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

					<!--<div class="form-inline" id="project_row">
						<label class="col-sm-2 control-label"><?php /*echo $hesklang['active'];*/ ?>: <font class="important">*</font></label>
						<div class="radio">
							<label><input type="radio" name="optionsRadios" id="optionsRadios1" value="option1">Yes</label>
							<label><input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">No</label>
						</div>
					</div>-->
				</div>
				
				<!-- Submit -->
				<div class="container">
					<input type="hidden" name="action" value="save" />
					<input type="hidden" name="token" value="" />
					<input type="submit" value="<?php echo $hesklang['save_changes'] ?>" class="btn btn-default contract-submit-btn"/>
				</div>
			</form>
		</div>
	</div>

</div> <!-- manage-config-tab -->
<?php
require_once(HESK_PATH . 'inc/footer.inc.php');
exit();


/*** START FUNCTIONS ***/

function change_priority()
{
	global $hesk_settings, $hesklang, $priorities;

	/* A security check */
	hesk_token_check('POST');

	$_SERVER['PHP_SELF'] = 'manage_categories.php?catid='.intval( hesk_POST('catid') );

	$catid = hesk_isNumber( hesk_POST('catid'), $hesklang['choose_cat_ren'], $_SERVER['PHP_SELF']);
	$_SESSION['selcat'] = $catid;
	$_SESSION['selcat2'] = $catid;

	$priority = intval( hesk_POST('priority', 3));
	if ( ! array_key_exists($priority, $priorities) )
	{
		$priority = 3;
	}

	hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` SET `priority`='{$priority}' WHERE `id`='".intval($catid)."' LIMIT 1");

    hesk_cleanSessionVars('cat_ch_priority');

	hesk_process_messages($hesklang['cat_pri_ch'].' '.$priorities[$priority]['formatted'],$_SERVER['PHP_SELF'],'SUCCESS');
} // END change_priority()


function generate_link_code() {
	global $hesk_settings, $hesklang;
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML; 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title><?php echo $hesklang['genl']; ?></title>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $hesklang['ENCODING']; ?>" />
<link href="<?php echo HESK_PATH; ?>bootstrap/css/bootstrap.css" type="text/css" rel="stylesheet" />
<style type="text/css">
body
{
        margin:5px 5px;
        padding:0;
        background:#fff;
        color: black;
        font : 68.8%/1.5 Verdana, Geneva, Arial, Helvetica, sans-serif;
}

p
{
        color : black;
        font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
        font-size: 1.0em;
}
h3
{
        color : #AF0000;
        font-family : Verdana, Geneva, Arial, Helvetica, sans-serif;
        font-weight: bold;
        font-size: 1.0em;
}
</style>
</head>
<body>

<div style="text-align:center">

<h3><?php echo $hesklang['genl']; ?></h3>

<?php
if ( ! empty($_GET['p']) )
{
	echo '<p>&nbsp;<br />' . $hesklang['cpric'] . '<br />&nbsp;</p>';
}
else
{
	?>
	<p><i><?php echo $hesklang['genl2']; ?></i></p>

	<textarea rows="3" cols="50" onfocus="this.select()"><?php echo $hesk_settings['hesk_url'].'/index.php?a=add&amp;catid='.intval( hesk_GET('catid') ); ?></textarea>
	<?php
}
?>

<p align="center"><a href="#" onclick="Javascript:window.close()"><?php echo $hesklang['cwin']; ?></a></p>

</div>

</body>

</html>
	<?php
    exit();
}


function new_cat()
{
	global $hesk_settings, $hesklang;

	/* A security check */
	hesk_token_check('POST');

    /* Options */
    $_SESSION['cat_autoassign'] = hesk_POST('autoassign') == 'Y' ? 1 : 0;
    $_SESSION['cat_type'] = hesk_POST('type') == 'Y' ? 1 : 0;

	// Default priority
	$_SESSION['cat_priority'] = intval( hesk_POST('priority', 3) );
	if ($_SESSION['cat_priority'] < 0 || $_SESSION['cat_priority'] > 3)
	{
		$_SESSION['cat_priority'] = 3;
	}

    /* Category name */
	$catname = hesk_input( hesk_POST('name') , $hesklang['enter_cat_name'], 'manage_categories.php');

    /* Do we already have a category with this name? */
	$res = hesk_dbQuery("SELECT `id` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` WHERE `name` LIKE '".hesk_dbEscape( hesk_dbLike($catname) )."' LIMIT 1");
    if (hesk_dbNumRows($res) != 0)
    {
		$_SESSION['catname'] = $catname;
		hesk_process_messages($hesklang['cndupl'],'manage_categories.php');
    }

	/* Get the latest cat_order */
	$res = hesk_dbQuery("SELECT `cat_order` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` ORDER BY `cat_order` DESC LIMIT 1");
	$row = hesk_dbFetchRow($res);
	$my_order = $row[0]+10;

	hesk_dbQuery("INSERT INTO `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` (`name`,`cat_order`,`autoassign`,`type`, `priority`) VALUES ('".hesk_dbEscape($catname)."','".intval($my_order)."','".intval($_SESSION['cat_autoassign'])."','".intval($_SESSION['cat_type'])."','{$_SESSION['cat_priority']}')");

    hesk_cleanSessionVars('catname');
    hesk_cleanSessionVars('cat_autoassign');
    hesk_cleanSessionVars('cat_type');
    hesk_cleanSessionVars('cat_priority');

    $_SESSION['selcat2'] = hesk_dbInsertID();

	hesk_process_messages(sprintf($hesklang['cat_name_added'],'<i>'.stripslashes($catname).'</i>'),'manage_categories.php','SUCCESS');
} // End new_cat()


function rename_cat()
{
	global $hesk_settings, $hesklang;

	/* A security check */
	hesk_token_check('POST');

    $_SERVER['PHP_SELF'] = 'manage_categories.php?catid='.intval( hesk_POST('catid') );

	$catid = hesk_isNumber( hesk_POST('catid'), $hesklang['choose_cat_ren'], $_SERVER['PHP_SELF']);
	$_SESSION['selcat'] = $catid;
    $_SESSION['selcat2'] = $catid;

	$catname = hesk_input( hesk_POST('name'), $hesklang['cat_ren_name'], $_SERVER['PHP_SELF']);
    $_SESSION['catname2'] = $catname;

	$res = hesk_dbQuery("SELECT `id` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` WHERE `name` LIKE '".hesk_dbEscape( hesk_dbLike($catname) )."' LIMIT 1");
    if (hesk_dbNumRows($res) != 0)
    {
    	$old = hesk_dbFetchAssoc($res);
        if ($old['id'] == $catid)
        {
        	hesk_process_messages($hesklang['noch'],$_SERVER['PHP_SELF'],'NOTICE');
        }
        else
        {
    		hesk_process_messages($hesklang['cndupl'],$_SERVER['PHP_SELF']);
        }
    }

	hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` SET `name`='".hesk_dbEscape($catname)."' WHERE `id`='".intval($catid)."' LIMIT 1");

    unset($_SESSION['selcat']);
    unset($_SESSION['catname2']);

    hesk_process_messages($hesklang['cat_renamed_to'].' <i>'.stripslashes($catname).'</i>',$_SERVER['PHP_SELF'],'SUCCESS');
} // End rename_cat()


function remove()
{
	global $hesk_settings, $hesklang;

	/* A security check */
	hesk_token_check();

    $_SERVER['PHP_SELF'] = 'manage_categories.php';

	$mycat = intval( hesk_GET('catid') ) or hesk_error($hesklang['no_cat_id']);
	if ($mycat == 1)
    {
    	hesk_process_messages($hesklang['cant_del_default_cat'],$_SERVER['PHP_SELF']);
    }

	hesk_dbQuery("DELETE FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` WHERE `id`='".intval($mycat)."' LIMIT 1");
	if (hesk_dbAffectedRows() != 1)
    {
    	hesk_error("$hesklang[int_error]: $hesklang[cat_not_found].");
    }

	hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` SET `category`=1 WHERE `category`='".intval($mycat)."'");

    hesk_process_messages($hesklang['cat_removed_db'],$_SERVER['PHP_SELF'],'SUCCESS');
} // End remove()


function order_cat()
{
	global $hesk_settings, $hesklang;

	/* A security check */
	hesk_token_check();

	$catid = intval( hesk_GET('catid') ) or hesk_error($hesklang['cat_move_id']);
	$_SESSION['selcat2'] = $catid;

	$cat_move=intval( hesk_GET('move') );

	hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` SET `cat_order`=`cat_order`+".intval($cat_move)." WHERE `id`='".intval($catid)."' LIMIT 1");
	if (hesk_dbAffectedRows() != 1)
    {
    	hesk_error("$hesklang[int_error]: $hesklang[cat_not_found].");
    }

	/* Update all category fields with new order */
	$res = hesk_dbQuery("SELECT `id` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` ORDER BY `cat_order` ASC");

	$i = 10;
	while ($mycat=hesk_dbFetchAssoc($res))
	{
	    hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` SET `cat_order`=".intval($i)." WHERE `id`='".intval($mycat['id'])."' LIMIT 1");
	    $i += 10;
	}

    header('Location: manage_categories.php');
    exit();
} // End order_cat()


function toggle_autoassign()
{
	global $hesk_settings, $hesklang;

	/* A security check */
	hesk_token_check();

	$catid = intval( hesk_GET('catid') ) or hesk_error($hesklang['cat_move_id']);
	$_SESSION['selcat2'] = $catid;

    if ( intval( hesk_GET('s') ) )
    {
		$autoassign = 1;
        $tmp = $hesklang['caaon'];
    }
    else
    {
        $autoassign = 0;
        $tmp = $hesklang['caaoff'];
    }

	/* Update auto-assign settings */
	$res = hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` SET `autoassign`='".intval($autoassign)."' WHERE `id`='".intval($catid)."' LIMIT 1");
	if (hesk_dbAffectedRows() != 1)
    {
        hesk_process_messages($hesklang['int_error'].': '.$hesklang['cat_not_found'],'./manage_categories.php');
    }

    hesk_process_messages($tmp,'./manage_categories.php','SUCCESS');

} // End toggle_autoassign()


function toggle_type()
{
	global $hesk_settings, $hesklang;

	/* A security check */
	hesk_token_check();

	$catid = intval( hesk_GET('catid') ) or hesk_error($hesklang['cat_move_id']);
	$_SESSION['selcat2'] = $catid;

    if ( intval( hesk_GET('s') ) )
    {
		$type = 1;
        $tmp = $hesklang['cpriv'];
    }
    else
    {
        $type = 0;
        $tmp = $hesklang['cpub'];
    }

	/* Update auto-assign settings */
	hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."categories` SET `type`='{$type}' WHERE `id`='".intval($catid)."' LIMIT 1");
	if (hesk_dbAffectedRows() != 1)
    {
        hesk_process_messages($hesklang['int_error'].': '.$hesklang['cat_not_found'],'./manage_categories.php');
    }

    hesk_process_messages($tmp,'./manage_categories.php','SUCCESS');

} // End toggle_type()
?>
