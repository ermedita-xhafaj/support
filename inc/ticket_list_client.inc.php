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

/* List of staff */
if (!isset($admins))
{
	$admins = array();
	$res2 = hesk_dbQuery("SELECT `id`,`name` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."users` ORDER BY `name` ASC");
	while ($row=hesk_dbFetchAssoc($res2))
	{
		$admins[$row['id']]=$row['name'];
	}
}

/* List of categories */
$hesk_settings['categories'] = array();
$res2 = hesk_dbQuery('SELECT `id`, `name` FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'categories`');
while ($row=hesk_dbFetchAssoc($res2))
{
	$hesk_settings['categories'][$row['id']] = $row['name'];
}

/* Current MySQL time */
$mysql_time = hesk_dbTime();

/* Get number of tickets and page number */
$result = hesk_dbQuery($sql_count);
$total  = hesk_dbResult($result);

if ($total > 0)
{
	

	/* We have the full SQL query now, get tickets */
	//$sql .= " LIMIT ".hesk_dbEscape($limit_down)." , ".hesk_dbEscape($maxresults)." ";
	$result = hesk_dbQuery($sql_final);

	/* Print the table with tickets */
	$random=rand(10000,99999);
	?>

	<form name="form1" action="delete_tickets.php" method="post">

    <?php
    if (empty($group))
    {
		hesk_print_list_head();
    }

	$i = 0;
	$checkall = '<input type="checkbox" name="checkall" value="2" onclick="hesk_changeAll()" />';

    $group_tmp = '';
	$is_table = 0;
	$space = 0;
	/*var_dump($result);*/
	while ($ticket=hesk_dbFetchAssoc($result))
	{
		// Are we grouping tickets?
		/*if ($group)
        {
			require(HESK_PATH . 'inc/print_group.inc.php');
        }*/

		// Determine line color
		if ($i) {$color="admin_gray"; $i=0;}
		else {$color="admin_white"; $i=1;}

		// Set owner (needed for row title)
		$owner = '';
        $first_line = '(' . $hesklang['unas'] . ')'." \n\n";
		if ($ticket['owner'] == $_SESSION['id'])
		{
			$owner = '<span class="assignedyou" title="'.$hesklang['tasy2'].'">*</span> ';
            $first_line = $hesklang['tasy2'] . " \n\n";
		}
		elseif ($ticket['owner'])
		{
        	if (!isset($admins[$ticket['owner']]))
            {
            	$admins[$ticket['owner']] = $hesklang['e_udel'];
            }
			$owner = '<span class="assignedother" title="'.$hesklang['taso3'] . ' ' . $admins[$ticket['owner']] .'">*</span> ';
            $first_line = $hesklang['taso3'] . ' ' . $admins[$ticket['owner']] . " \n\n";
		}

		// Prepare ticket priority
		switch ($ticket['priority'])
		{
			case 0:
				$ticket['priority']='<img src="img/flag_critical.png" width="16" height="16" alt="'.$hesklang['priority'].': '.$hesklang['critical'].'" title="'.$hesklang['priority'].': '.$hesklang['critical'].'" border="0" />';
                $color = 'admin_critical';
				break;
			case 1:
				$ticket['priority']='<img src="img/flag_high.png" width="16" height="16" alt="'.$hesklang['priority'].': '.$hesklang['high'].'" title="'.$hesklang['priority'].': '.$hesklang['high'].'" border="0" />';
				break;
			case 2:
				$ticket['priority']='<img src="img/flag_medium.png" width="16" height="16" alt="'.$hesklang['priority'].': '.$hesklang['medium'].'" title="'.$hesklang['priority'].': '.$hesklang['medium'].'" border="0" />';
				break;
			default:
				$ticket['priority']='<img src="img/flag_low.png" width="16" height="16" alt="'.$hesklang['priority'].': '.$hesklang['low'].'" title="'.$hesklang['priority'].': '.$hesklang['low'].'" border="0" />';
		}		

		// Set message (needed for row title)
		$ticket['message'] = $first_line . substr(strip_tags($ticket['message']),0,200).'...';

		// Start ticket row
		/*echo '
		<tr title="'.$ticket['message'].'">
		<td><input type="checkbox" name="id[]" value="'.$ticket['id'].'" />&nbsp;</td>
		';*/

		echo '<td>'.$ticket['id'].'</td>';


		// Print last modified

			switch ($hesk_settings['updatedformat'])
			{
	        	case 1:
					$ticket['lastchange'] = hesk_formatDate($ticket['lastchange']);
					break;
				case 2:
					$ticket['lastchange'] = hesk_time_lastchange($ticket['lastchange']);
					break;
				default:
					$ticket['lastchange'] = hesk_time_since( strtotime($ticket['lastchange']) );
			}
			echo '<td>'.$ticket['lastchange'].'</td>';



		// Print customer name

			echo '<td>'.$ticket['name'].'</td>';

		// Print subject and link to the ticket page

			echo '<td>'.($ticket['archive'] ? '<img src="img/tag.png" width="16" height="16" alt="'.$hesklang['archived'].'" title="'.$hesklang['archived'].'"  border="0" /> ' : '').$owner.'<a href="admin_ticket.php?track='.$ticket['trackid'].'&amp;Refresh='.$random.'">'.$ticket['subject'].'</a></td>';
		

		// Print ticket status

			switch ($ticket['status'])
			{
				case 0:
					$ticket['status']='<span class="open">'.$hesklang['open'].'</span>';
					break;
				case 1:
					$ticket['status']='<span class="waitingreply">'.$hesklang['wait_reply'].'</span>';
					break;
				case 2:
					$ticket['status']='<span class="replied">'.$hesklang['replied'].'</span>';
					break;
				case 4:
					$ticket['status']='<span class="inprogress">'.$hesklang['in_progress'].'</span>';
					break;
				case 5:
					$ticket['status']='<span class="onhold">'.$hesklang['on_hold'].'</span>';
					break;
				default:
					$ticket['status']='<span class="resolved">'.$hesklang['closed'].'</span>';
			}
			echo '<td>'.$ticket['status'].'&nbsp;</td>';
		


		// Print custom fields
		foreach ($hesk_settings['custom_fields'] as $key => $value)
		{
			if ($value['use'] )
			echo '<td>'.$ticket[$key].'</td>';
		}

		// End ticket row
		/*echo '</tr>';*/
		
		// End ticket row
		echo '
		<td>'.$ticket['priority'].'&nbsp;</td>
		</tr>
		'; /*comment for flag priority*/

	} // End while
	?>
	</table>
</div>

	</form>
	<?php

} // END ticket list if total > 0
else
{
    if (isset($is_search) || $href == 'find_tickets.php')
    {
        hesk_show_notice($hesklang['no_tickets_crit']);
    }
    else
    {
        echo '<p>&nbsp;<br />&nbsp;<b><i>'.$hesklang['no_tickets_open'].'</i></b><br />&nbsp;</p>';
    }
}

function hesk_print_list_head()
{
	global $hesk_settings, $href, $query, $sort_possible, $hesklang;
	?>
	<div class="container table-reponsive ticket-list">
	<table class="table table-bordered table-striped">
	<tr>
	<!--<th class="admin_white"><input type="checkbox" name="checkall" value="2" onclick="hesk_changeAll(this)" /></th> -->
	<?php
	

	foreach ($hesk_settings['ticket_list'] as $field)
	{	/*var_dump($field);*/
		echo '<th class="admin_white">'.$field.'</th>';
	}
	?>
	<th class="admin_white"><a href="<?php echo $href . '?' . $query . $sort_possible['priority'] . '&amp;sort='; ?>priority"><img src="img/sort_priority_<?php echo (($sort_possible['priority']) ? 'asc' : 'desc'); ?>.png" width="16" height="16" alt="<?php echo $hesklang['sort_by'].' '.$hesklang['priority']; ?>" title="<?php echo $hesklang['sort_by'].' '.$hesklang['priority']; ?>" border="0" /></a></th>
	</tr>
	<?php
} // END hesk_print_list_head()


function hesk_time_since($original)
{
	global $hesk_settings, $hesklang, $mysql_time;

    /* array of time period chunks */
    $chunks = array(
        array(60 * 60 * 24 * 365 , $hesklang['abbr']['year']),
        array(60 * 60 * 24 * 30 , $hesklang['abbr']['month']),
        array(60 * 60 * 24 * 7, $hesklang['abbr']['week']),
        array(60 * 60 * 24 , $hesklang['abbr']['day']),
        array(60 * 60 , $hesklang['abbr']['hour']),
        array(60 , $hesklang['abbr']['minute']),
        array(1 , $hesklang['abbr']['second']),
    );

	/* Invalid time */
    if ($mysql_time < $original)
    {
    	// DEBUG return "T: $mysql_time (".date('Y-m-d H:i:s',$mysql_time).")<br>O: $original (".date('Y-m-d H:i:s',$original).")";
        return "0".$hesklang['abbr']['second'];
    }

    $since = $mysql_time - $original;

    // $j saves performing the count function each time around the loop
    for ($i = 0, $j = count($chunks); $i < $j; $i++) {

        $seconds = $chunks[$i][0];
        $name = $chunks[$i][1];

        // finding the biggest chunk (if the chunk fits, break)
        if (($count = floor($since / $seconds)) != 0) {
            // DEBUG print "<!-- It's $name -->\n";
            break;
        }
    }

    $print = "$count{$name}";

    if ($i + 1 < $j) {
        // now getting the second item
        $seconds2 = $chunks[$i + 1][0];
        $name2 = $chunks[$i + 1][1];

        // add second item if it's greater than 0
        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
            $print .= "$count2{$name2}";
        }
    }
    return $print;
} // END hesk_time_since()


function hesk_time_lastchange($original)
{
	global $hesk_settings, $hesklang;

	// Save time format setting so we can restore it later
	$copy = $hesk_settings['timeformat'];

	// We need this time format for this function
	$hesk_settings['timeformat'] = 'Y-m-d H:i:s';

	// Get HESK time-adjusted start of today if not already
	if ( ! defined('HESK_TIME_TODAY') )
	{
		// Adjust for HESK time and define constants for alter use
		define('HESK_TIME_TODAY',		date('Y-m-d 00:00:00', hesk_date(NULL, false, false, false) ) );
		define('HESK_TIME_YESTERDAY',	date('Y-m-d 00:00:00', strtotime(HESK_TIME_TODAY)-86400) ) ;
	}

	// Adjust HESK time difference and get day name
	$ticket_time = hesk_date($original, true);

	if ($ticket_time >= HESK_TIME_TODAY)
	{
		// For today show HH:MM
		$day = substr($ticket_time, 11, 5);
	}
	elseif ($ticket_time >= HESK_TIME_YESTERDAY)
	{
		// For yesterday show word "Yesterday"
		$day = $hesklang['r2'];
	}
	else
	{
		// For other days show DD MMM YY
		list($y, $m, $d) = explode('-', substr($ticket_time, 0, 10) );
		$day = '<span>' . $d . ' ' . $hesklang['ms'.$m] . ' ' . substr($y, 2) . '</span>';
	}

	// Restore original time format setting
	$hesk_settings['timeformat'] = $copy;

	// Return value to display
	return $day;

} // END hesk_time_lastchange()
