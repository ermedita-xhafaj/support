<?php
/*******************************************************************************
*  Title: Help Desk Software HESK
*  Version: 2.6.4 from 22nd June 2015
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

// This SQL code will be used to retrieve results
$sql_final = "SELECT
`id`,
`trackid`,
`name`,
`email`,
`category`,
`company_ticket_id`,
`contract_ticket_id`,
`priority`,
`subject`,
LEFT(`message`, 400) AS `message`,
`dt`,
`lastchange`,
`firstreply`,
`closedat`,
`status`,
`openedby`,
`firstreplyby`,
`closedby`,
`replies`,
`staffreplies`,
`owner`,
`time_worked`,
`lastreplier`,
`replierid`,
`archive`,
`locked`
";

foreach ($hesk_settings['custom_fields'] as $k=>$v)
{
	if ($v['use'])
	{
		$sql_final .= ", `".$k."`";
	}
}

$sql_final.= " FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` WHERE ";

// This code will be used to count number of results
$sql_count = "SELECT COUNT(*) FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."tickets` WHERE ";

// This is common SQL for both queries
$sql = "";

//FILTRAT//////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST['submitbutton_tickets'])){
			if (!empty($_POST['search_by_ID_ticket'])) {
				$sql .= " `id`=".$_POST['search_by_ID_ticket'];
			}
			elseif (!empty($_POST['search_by_description_ticket'])) {
				$sql .= " `subject`='".$_POST['search_by_description_ticket']."'";
			}
			elseif (!empty($_POST['search_by_ticket_category'])) {
				$sql .= " `category`=".$_POST['search_by_ticket_category'];
			}
			elseif (!empty($_POST['search_by_ticket_status']) || $_POST['search_by_ticket_status']=='0') {
				$sql .= " `status`='".$_POST['search_by_ticket_status']."'";
			}
			elseif (!empty($_POST['search_by_client_open_ticket'])) {
				$sql .= " `name`='".$_POST['search_by_client_open_ticket']."'";
			} else{
				$sql .= "'1'='1'";
			}
		}
//////////////////////////////////////////////////////////////////////////////////////////////


// Some default settings
$archive = array(1=>0,2=>0);
$s_my = array(1=>1,2=>1);
$s_ot = array(1=>1,2=>1);
$s_un = array(1=>1,2=>1);


// --> TICKET Contract
$contract = intval( hesk_GET('contract_ticket_id', 0) );

// --> TICKET Company
$company = intval( hesk_GET('company_ticket_id', 0) );


// --> TICKET CATEGORY
$category = intval( hesk_GET('category', 0) );

// Make sure user has access to this category
if ($category)
{
	$sql .= " `category`='{$category}' ";
}
// No category selected, show only allowed categories
else
{	if(empty($_POST)){
		$sql .= '1=1';
	}
}


//check if admin
if(!$_SESSION['isadmin']){

$res = hesk_dbQuery('SELECT contractId FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'userforcontract` WHERE userId='.$_SESSION['id']);
	if($res_user = mysqli_fetch_all($res)){
		foreach($res_user as $user){
			$ticket_staff[] = $user[0];
		}
		$ticket_staff1 = implode($ticket_staff,',');

		$sql .= " AND contract_ticket_id IN(".$ticket_staff1.")";
	} else {
		$sql .= " AND contract_ticket_id IN(0)";
	}
}

// Show only tagged tickets?
if ( ! empty($_GET['archive']) )
{
	$archive[1]=1;
	$sql .= " AND `archive`='1' ";
}

// Ticket owner preferences
$fid = 1;
require(HESK_PATH . 'inc/assignment_search.inc.php');

// --> TICKET STATUS
$possible_status = array(
0 => 'NEW',
1 => 'WAITING REPLY',
2 => 'REPLIED',
3 => 'RESOLVED (CLOSED)',
4 => 'IN PROGRESS',
5 => 'ON HOLD',
);

$status = $possible_status;

// Process statuses unless overridden with "s_all" variable
if ( ! hesk_GET('s_all') )
{
	foreach ($status as $k => $v)
	{
		if (empty($_GET['s'.$k]))
		{
			unset($status[$k]);
	    }
	}
}

// How many statuses are we pulling out of the database?
$tmp = count($status);

// Do we need to search by status?
if ( $tmp < count($possible_status) )
{
	// If no statuses selected, show default (all except RESOLVED)
	if ($tmp == 0)
	{
		$status = $possible_status;
		unset($status[3]);
	}
	if(empty($_POST)){
		// Add to the SQL
		$sql .= " AND `status` IN ('" . implode("','", array_keys($status) ) . "') ";
		}
	
}

// --> TICKET PRIORITY
$possible_priority = array(
0 => 'CRITICAL',
1 => 'HIGH',
2 => 'MEDIUM',
3 => 'LOW',
);

$priority = $possible_priority;

foreach ($priority as $k => $v)
{
	if (empty($_GET['p'.$k]))
    {
    	unset($priority[$k]);
    }
}

// How many priorities are we pulling out of the database?
$tmp = count($priority);

// Create the SQL based on the number of priorities we need
if ($tmp == 0 || $tmp == 4)
{
	// Nothing or all selected, no need to modify the SQL code
    $priority = $possible_priority;
}
else
{
	// A custom selection of priorities
	$sql .= " AND `priority` IN ('" . implode("','", array_keys($priority) ) . "') ";
}
/*unset($_POST['submitbutton_tickets']);
var_dump($_POST);
if(empty($_POST)){*/
// That's all the SQL we need for count

$sql_count .= $sql;
$sql = $sql_final . $sql;
/*}
else{
	echo "No search results!";
	echo "<br/>".$sql;
	//exit();
}*/
// Prepare variables used in search and forms
require(HESK_PATH . 'inc/prepare_ticket_search.inc.php');

// List tickets?
if (!isset($_SESSION['hide']['ticket_list']))
{
	$href = 'show_tickets.php';
	require(HESK_PATH . 'inc/ticket_list.inc.php');
}
