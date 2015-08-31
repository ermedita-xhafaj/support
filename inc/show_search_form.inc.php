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

if ( ! isset($status) )
{
	$status = array(
	0 => 'NEW',
	1 => 'WAITING REPLY',
	2 => 'REPLIED',
	#3 => 'RESOLVED (CLOSED)',
	4 => 'IN PROGRESS',
	5 => 'ON HOLD',
	);
}

if ( ! isset($priority) )
{
	$priority = array(
	0 => 'CRITICAL',
	1 => 'HIGH',
	2 => 'MEDIUM',
	3 => 'LOW',
	);
}

if ( ! isset($what) )
{
	$what = 'trackid';
}

if ( ! isset($owner_input) )
{
	$owner_input = 0;
}

if ( ! isset($date_input) )
{
	$date_input = '';
}

/* Can view tickets that are unassigned or assigned to others? */
$can_view_ass_others = hesk_checkPermission('can_view_ass_others',0);
$can_view_unassigned = hesk_checkPermission('can_view_unassigned',0);

/* Category options */
$category_options = '';
if ( isset($hesk_settings['categories']) && count($hesk_settings['categories']) )
{
	foreach ($hesk_settings['categories'] as $row['id'] => $row['name'])
	{
		$row['name'] = (strlen($row['name']) > 30) ? substr($row['name'],0,30) . '...' : $row['name'];
		$selected = ($row['id'] == $category) ? 'selected="selected"' : '';
		$category_options .= '<option value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
	}
}
else
{
	$res2 = hesk_dbQuery('SELECT `id`, `name` FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'categories` WHERE ' . hesk_myCategories('id') . ' ORDER BY `cat_order` ASC');
	while ($row=hesk_dbFetchAssoc($res2))
	{
		$row['name'] = (strlen($row['name']) > 30) ? substr($row['name'],0,30) . '...' : $row['name'];
		$selected = ($row['id'] == $category) ? 'selected="selected"' : '';
		$category_options .= '<option value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
	}
}

/* List of staff */
if ($can_view_ass_others && ! isset($admins) )
{
	$admins = array();
	$res2 = hesk_dbQuery("SELECT `id`,`name` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."users` ORDER BY `name` ASC");
	while ($row=hesk_dbFetchAssoc($res2))
	{
		$admins[$row['id']]=$row['name'];
	}
}

$more = empty($_GET['more']) ? 0 : 1;
$more2 = empty($_GET['more2']) ? 0 : 1;

#echo "SQL: $sql";
?>

<!-- ** START SHOW TICKET FORM ** -->
<div class="container form-inline show-tickets"><img src="../img/show-tickets.png" alt="show-tickets" /><span id="show-ticket-title"><?php echo $hesklang['show_tickets']; ?></span></div>
<div class="container col-sm-8 col-sm-offset-2 show-ticket-form">
	<div>
		<form name="showt" action="show_tickets.php" method="get">
			<div class="col-sm-12 show-ticket-form-status" id="show-ticket">
				<label id="form-status-title"><?php echo $hesklang['status']; ?></label>
				<label id="form-status"><input type="checkbox" name="s0" value="1" <?php if (isset($status[0])) {echo 'checked="checked"';} ?> /> <span class="open"><?php echo $hesklang['open']; ?></span></label>
				<label id="form-status"><input type="checkbox" name="s2" value="1" <?php if (isset($status[2])) {echo 'checked="checked"';} ?> /> <span class="replied"><?php echo $hesklang['replied']; ?></span></label>
				<label id="form-status"><input type="checkbox" name="s4" value="1" <?php if (isset($status[4])) {echo 'checked="checked"';} ?> /> <span class="inprogress"><?php echo $hesklang['in_progress']; ?></span></label>
				<label id="form-status"><input type="checkbox" name="s1" value="1" <?php if (isset($status[1])) {echo 'checked="checked"';} ?> /> <span class="waitingreply"><?php echo $hesklang['wait_reply']; ?></span></label>
				<label id="form-status"><input type="checkbox" name="s3" value="1" <?php if (isset($status[3])) {echo 'checked="checked"';} ?> /> <span class="resolved"><?php echo $hesklang['closed']; ?></span></label>
				<label><input type="checkbox" name="s5" value="1" <?php if (isset($status[5])) {echo 'checked="checked"';} ?>  /> <span class="onhold"><?php echo $hesklang['on_hold']; ?></span>
			</div><!-- end show-ticket-form-status-->
			
			<div class="col-sm-12 show-ticket-form-priority" id="show-ticket">
				<label id="form-priority-title"><?php echo $hesklang['priority']; ?></label>
				<label id="form-priority1"><input type="checkbox" name="p0" value="1" <?php if (isset($priority[0])) {echo 'checked="checked"';} ?> /> <span class="critical"><?php echo $hesklang['critical']; ?></span></label>
				<label id="form-priority2"><input type="checkbox" name="p2" value="1" <?php if (isset($priority[2])) {echo 'checked="checked"';} ?> /> <span class="medium"><?php echo $hesklang['medium']; ?></span></label>
				<label id="form-priority3"><input type="checkbox" name="p1" value="1" <?php if (isset($priority[1])) {echo 'checked="checked"';} ?> /> <span class="important" id="priority-important"><?php echo $hesklang['high']; ?></span></label>
				<label><input type="checkbox" name="p3" value="1" <?php if (isset($priority[3])) {echo 'checked="checked"';} ?> /> <span class="normal"><?php echo $hesklang['low']; ?></span></label>	
			</div>
			
			<div id="topSubmit" style="display:<?php echo $more ? 'none' : 'block' ; ?>">
				<input type="submit" value="<?php echo $hesklang['show_tickets']; ?>" class="btn btn-default show-ticket-btn"/>
				<a href="javascript:void(0)" onclick="Javascript:hesk_toggleLayerDisplay('divShow');Javascript:hesk_toggleLayerDisplay('topSubmit');document.showt.more.value='1';"><button type="submit" class="btn btn-default options-btn"><?php echo $hesklang['mopt']; ?></button></a>
			</div>

			<div id="divShow" style="display:<?php echo $more ? 'block' : 'none' ; ?>" id="show-ticket">
				<div class="col-sm-12 show-ticket-form-show" id="show-ticket">
					<label id="form-show-title"><?php echo $hesklang['show']; ?></label>
					<label id="form-show1"><input type="checkbox" name="s_my" value="1" <?php if ($s_my[1]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['s_my']; ?></label>
						<?php
							if ($can_view_unassigned)
								{
						?>
								<label id="form-show2"><input type="checkbox" name="s_un" value="1" <?php if ($s_un[1]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['s_un']; ?></label>
								<?php
								}
								?>
						<?php
							if ($can_view_ass_others)
								{
						?>
								<label id="form-show3"><input type="checkbox" name="s_ot" value="1" <?php if ($s_ot[1]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['s_ot']; ?></label>
								<?php
								}
								?>
					<label id="form-show4"><input type="checkbox" name="archive" value="1" <?php if ($archive[1]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['disp_only_archived']; ?></label>
				</div>

				<div class="col-sm-12 show-ticket-form-sortby" id="show-ticket">
					<label id="form-sortby-title"><?php echo $hesklang['sort_by']; ?></label>
						
							<?php
							array_unshift($hesk_settings['ticket_list'], 'priority');
							$hesk_settings['possible_ticket_list']['priority'] = $hesklang['priority'];

							$column = 1;

							foreach ($hesk_settings['ticket_list'] as $key)
							{
								if ($column == 1)
								{
									echo '<label id="form-sortby1">';
								}
								else
								{
									echo '<label id="form-sortby2">';
								}

								echo '<input type="radio" name="sort" value="'.$key.'" '.($sort == $key ? 'checked="checked"' : '').' /> '.$hesk_settings['possible_ticket_list'][$key].'</label>';

								if ($column == 3)
								{
									echo '</label>';
									$column = 1;
								}
								else
								{
									$column++;
								}
							}

							// End table if needed
							if ($column == 3)
							{
								echo '</div>';
							}
							elseif ($column == 2)
							{
							echo '';
							}
							?>
							
				</div>

				<div class="col-sm-12 show-ticket-form-groupby" id="show-ticket">
					<label id="form-groupby-title"><?php echo $hesklang['gb']; ?></label>
					<label id="form-groupby1"><input type="radio" name="g" value=""  <?php if ( ! $group) {echo 'checked="checked"';} ?> /> <?php echo $hesklang['dg']; ?></label>
					<label id="form-groupby2"><?php
						if ($can_view_unassigned || $can_view_ass_others)
							{
							?>
							<input type="radio" name="g" value="owner" <?php if ($group == 'owner') {echo 'checked="checked"';} ?> /> <?php echo $hesklang['owner']; ?>
							<?php
							}
							else
							{
								echo '&nbsp;';
							}
							?>
					</label>	
					<label id="form-groupby3"><input type="radio" name="g" value="category" <?php if ($group == 'category') {echo 'checked="checked"';} ?> /> <?php echo $hesklang['category']; ?></label>
					<label id="form-groupby4"><input type="radio" name="g" value="priority" <?php if ($group == 'priority') {echo 'checked="checked"';} ?> /> <?php echo $hesklang['priority']; ?></label>
				</div>

				<div class="col-sm-12 show-ticket-form-category" id="show-ticket">
					<label id="form-category-title"><?php echo $hesklang['category']; ?></label>
					<label>
						<select class="form-control" name="category" id="form-search-category">
							<option value="0" ><?php echo $hesklang['any_cat']; ?></option>
							<?php echo $category_options; ?>
						</select>
					</label>
				</div>

				<div class="col-sm-12 form-inline show-ticket-form-display" id="show-ticket">
					<label id="form-display-title"><?php echo $hesklang['display']; ?></label>
					<label id="form-display-input">
						<input class="form-control" type="text" name="limit" value="<?php echo $maxresults; ?>" size="4" /> <?php echo $hesklang['tickets_page']; ?>
					</label>
				</div>
				
				<div class="col-md-12 show-ticket-form-order" id="show-ticket">
					<label id="form-order-title"><?php echo $hesklang['order']; ?></label>
					<label id="form-order1"><input type="radio" name="asc" value="1" <?php if ($asc) {echo 'checked="checked"';} ?> /> <?php echo $hesklang['ascending']; ?></label>
					<label id="form-order2"><input type="radio" name="asc" value="0" <?php if (!$asc) {echo 'checked="checked"';} ?> /> <?php echo $hesklang['descending']; ?></label>
				</div>

				<div class="col-md-12 show-ticket-form-option" id="show-ticket">
					<label id="form-option-title"><?php echo $hesklang['opt']; ?></label>
					<label id="form-option1"><input type="checkbox" name="cot" value="1" <?php if ($cot) {echo 'checked="checked"';} ?> /> <?php echo $hesklang['cot']; ?></label>
					<label id="form-option2"><input type="checkbox" name="def" value="1" /> <?php echo $hesklang['def']; ?></label> (<a href="admin_main.php?reset=1&amp;token=<?php echo hesk_token_echo(0); ?>"><?php echo $hesklang['redv']; ?></a>)
				</div>

				<div><input type="submit" value="<?php echo $hesklang['show_tickets']; ?>" class="btn btn-default show-ticket-btn"/>
					<input type="hidden" name="more" value="<?php echo $more ? 1 : 0 ; ?>" /><a href="javascript:void(0)" onclick="Javascript:hesk_toggleLayerDisplay('divShow');Javascript:hesk_toggleLayerDisplay('topSubmit');document.showt.more.value='0';"><button type="submit" class="btn btn-default options-btn"><?php echo $hesklang['lopt']; ?></button></a>
				</div>
		</form>
	</div>
</div>
</div><!-- end show-ticket-form -->

<!-- ** END SHOW TICKET FORM ** -->


<!-- ** START SEARCH TICKETS FORM ** -->
<div class="container form-inline find-tickets"><img src="../img/show-tickets.png" alt="show-tickets" /><span id="find-ticket-title"><?php echo $hesklang['find_ticket_by']; ?></div>
<div class="container col-sm-8 col-sm-offset-2  start-search-tickets-form">
	<form action="find_tickets.php" method="get" name="findby" id="findby">
		<div class="col-sm-12 form-inline tickets-form" id="find-ticket">
			<label class="control-label" for="searchfor-ticket" id="searchfor-title"><?php echo $hesklang['s_for']; ?>:</label>
			<input class="form-control" id="searchfor-ticket" type="text" name="q" size="30" <?php if (isset($q)) {echo 'value="'.$q.'"';} ?> />
			<label class="control-label" for="searchin-ticket" id="searchin-title"><?php echo $hesklang['s_in']; ?>:</label>
			<select class="form-control" id="searchin-ticket" name="what">
				<option value="trackid" <?php if ($what=='trackid') {echo 'selected="selected"';} ?> ><?php echo $hesklang['trackID']; ?></option>
				<?php
					if ($hesk_settings['sequential'])
					{
				?>
						<option value="seqid" <?php if ($what=='seqid') {echo 'selected="selected"';} ?> ><?php echo $hesklang['seqid']; ?></option>
						<?php
					}
						?>
					<option value="name"    <?php if ($what=='name') {echo 'selected="selected"';} ?> ><?php echo $hesklang['name']; ?></option>
					<option value="email"	<?php if ($what=='email') {echo 'selected="selected"';} ?> ><?php echo $hesklang['email']; ?></option>
					<option value="subject" <?php if ($what=='subject') {echo 'selected="selected"';} ?> ><?php echo $hesklang['subject']; ?></option>
					<option value="message" <?php if ($what=='message') {echo 'selected="selected"';} ?> ><?php echo $hesklang['message']; ?></option>
					<?php
						foreach ($hesk_settings['custom_fields'] as $k=>$v)
						{
							$selected = ($what == $k) ? 'selected="selected"' : '';
							if ($v['use'])
								{
								$v['name'] = (strlen($v['name']) > 30) ? substr($v['name'],0,30) . '...' : $v['name'];
								echo '<option value="'.$k.'" '.$selected.'>'.$v['name'].'</option>';
								}
						}
					?>
					<option value="notes" <?php if ($what=='notes') {echo 'selected="selected"';} ?> ><?php echo $hesklang['notes']; ?></option>
			</select>		
		</div>
		<div class="col-sm-12 form-inline tickets-form-category" id="find-ticket">
			<label class="control-label" for="search-category" id="search-category-title"><?php echo $hesklang['category']; ?>:</label>
			<select class="form-control" id="search-category" name="category" style="width: 149px">
				<option value="0" ><?php echo $hesklang['any_cat']; ?></option>
				<?php echo $category_options; ?>
			</select>
		</div><!-- end tickets-form-category -->

				<div id="topSubmit2" style="display:<?php echo $more2 ? 'none' : 'block' ; ?>">
					<input type="submit" value="<?php echo $hesklang['find_ticket']; ?>" class="btn btn-default find-ticket-btn"/>
					<a href="javascript:void(0)" onclick="Javascript:hesk_toggleLayerDisplay('divShow2');Javascript:hesk_toggleLayerDisplay('topSubmit2');document.findby.more2.value='1';"><button type="submit" class="btn btn-default options-btn"><?php echo $hesklang['mopt']; ?></button></a>
				</div>

		<div id="divShow2" style="display:<?php echo $more2 ? 'block' : 'none' ; ?>">
			<div class="start-search-tickets-formtab">
				<?php
					if ($can_view_ass_others)
					{
				?>
					<div class="col-md-12 start-search-tickets-form-owner" id="find-ticket">
						<label class="control-label" for="search-owner" id="form-owner-title" ><?php echo $hesklang['owner']; ?>:</label>
						<label id="form-owner1">
							<select class="form-control" id="search-owner" name="owner">
								<option value="0" ><?php echo $hesklang['anyown']; ?></option>
								<?php
								foreach ($admins as $staff_id => $staff_name)
								{
									echo '<option value="'.$staff_id.'" '.($owner_input == $staff_id ? 'selected="selected"' : '').'>'.$staff_name.'</option>';
								}
								?>
							</select>
						</label>
					</div><!-- end start-search-tickets-form-owner -->
				<?php
					}
				?>

				<div class="col-md-12 start-search-tickets-form-date" id="find-ticket">
					<label id="form-date-title"><?php echo $hesklang['date']; ?></label>
					<label class="form-inline" for="dt" id="form-date1"><img src="../inc/calendar/img/cal.gif">
					<input type="text" name="dt" id="dt" size="10" class="tcal form-control" <?php if ($date_input) {echo 'value="'.$date_input.'"';} ?> /></label>
				</div><!-- end start-search-tickets-form-date -->
						
				<div class="col-md-12 start-search-tickets-form-searchwithin" id="find-ticket">
					<label id="form-searchwithin-title"><?php echo $hesklang['s_incl']; ?></label>
					<label id="form-searchwithin1"><input type="checkbox" name="s_my" value="1" <?php if ($s_my[2]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['s_my']; ?></label>
					<?php
						if ($can_view_ass_others)
							{
					?>
							<label id="form-searchwithin2"><input type="checkbox" name="s_ot" value="1" <?php if ($s_ot[2]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['s_ot']; ?></label>
						<?php
							}
							if ($can_view_unassigned)
							{
						?>
							<label id="form-searchwithin3"><input type="checkbox" name="s_un" value="1" <?php if ($s_un[2]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['s_un']; ?></label>
						<?php
							}
						?>	
					<label id="form-searchwithin4"><input type="checkbox" name="archive" value="1" <?php if ($archive[2]) echo 'checked="checked"'; ?> /> <?php echo $hesklang['disp_only_archived']; ?></label>
				</div>
						
				<div class="col-md-12 form-inline start-search-tickets-form-display" id="find-ticket">
					<label id="find-form-display-title" for="search-display"><?php echo $hesklang['display']; ?></label>
					<label id="find-form-display1"><input class="form-control" id="search-display" type="text" name="limit" value="<?php echo $maxresults; ?>" size="4" /> <?php echo $hesklang['results_page']; ?></label>
				</div>
			</div><!-- end start-search-tickets-formtab -->
			<br/>
			<div><input type="submit" value="<?php echo $hesklang['find_ticket']; ?>" class="btn btn-default find-ticket-btn"/>
				<input type="hidden" name="more2" value="<?php echo $more2 ? 1 : 0 ; ?>" /><a href="javascript:void(0)" onclick="Javascript:hesk_toggleLayerDisplay('divShow2');Javascript:hesk_toggleLayerDisplay('topSubmit2');document.findby.more2.value='0';"><button type="submit" class="btn btn-default options-btn"><?php echo $hesklang['lopt']; ?></button></a>
			</div>

		</div>

	</form>
</div><!-- end start-search-tickets-form -->

<!-- ** END SEARCH TICKETS FORM ** -->

