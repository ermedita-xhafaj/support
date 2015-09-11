<?php 
define('IN_SCRIPT',1);
define('HESK_PATH','./');

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/admin_functions.inc.php');
require(HESK_PATH . 'inc/profile_functions.inc.php');
hesk_load_database_functions();

session_start();
hesk_dbConnect();


$_SESSION['new']['token']="";
$_SESSION['token']="";

/* Update profile? */
if ( isset($_POST['action']) && $_POST['action']=="update")
{
	// Demo mode
	if ( defined('HESK_DEMO') )
	{
		hesk_process_messages($hesklang['sdemo'], 'client_profile.php', 'NOTICE');
	}

	// Update profile
	update_profile();
}
else
{
	$res = hesk_dbQuery('SELECT * FROM `'.hesk_dbEscape($hesk_settings['db_pfix'])."clients` WHERE `user` = '".intval($_SESSION['user'])."' LIMIT 1");
	$tmp = hesk_dbFetchAssoc($res);

	if (is_array($tmp) || is_object($tmp))
	{
		foreach ($tmp as $k=>$v)
		{
			if ($k == 'pass')
			{
				if ($v == '499d74967b28a841c98bb4baaabaad699ff3c079')
				{
					define('WARN_PASSWORD',true);
				}
				continue;
			}
			
			$_SESSION['new'][$k]=$v;
		}
	}
}

if ( ! isset($_SESSION['new']['username']))
{
	$_SESSION['new']['username'] = '';
}

/* Print header */
require_once(HESK_PATH . 'inc/header.inc.php');
?>

	<nav class="row navbar navbar-default" id="showTopBar-indexPhp">
		<div class="menu-wrapper">
			<div class="container showTopBar"><?php hesk_showTopBar($hesk_settings['hesk_title']); ?></div>
		</div>
	</nav>
	<nav class="row navbar userMenu">
      <div class="container">
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
			<li id="userMenu-home"><a href="index.php">Home</a></li>
			<li id="userMenu-submitTicket"><a href="index.php?a=add">Submit Ticket</a></li>
			<li id="client-username"><a href="client_profile.php">Hello, <?php if (isset($_SESSION['id']['user'])) {echo $_SESSION['id']['user']; }?></a></li>
			<li id="userMenu-logout"><a href="logout.php">Log Out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	
<?php	
hesk_handle_messages();

if (defined('WARN_PASSWORD'))
{
	hesk_show_notice($hesklang['chdp2'],'<span class="important">'.$hesklang['security'].'</span>');
}
?>

<div class="container"><?php echo $hesklang['req_marked_with']; ?> <font class="important">*</font></div>
<div class="container tab-content profile-functions-tab">
	<ul id="tabs" class="nav nav-tabs profile-functions" data-tabs="tabs">
		<li class="active" id="profile-info"><a href="#p-info" aria-controls="p-info" role="tab" data-toggle="tab"><?php echo $hesklang['pinfo']; ?></a></li>
		<li id="signature-info"><a href="#signature" aria-controls="signature" role="tab" data-toggle="tab"><?php echo $hesklang['sig']; ?></a></li>
		<li id="contract-client"><a href="#cont_client" aria-controls="cont_client" role="tab" data-toggle="tab"><?php echo $hesklang['contract'] .' & ' .$hesklang['project']; ?></a></li>
	</ul>
			<!-- PROFILE INFO -->
	<div role="tabpanel" class="tab-pane active" id="p-info">

			&nbsp;<br />
			
	<form method="post" action="client_profile.php" name="form1">
		<div class="profile-information">
			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label" for="profile-information-name"><?php echo $hesklang['real_name']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="profile-information-name" name="name" size="40" maxlength="50" value="<?php if (isset($_SESSION['id']['name'])){echo $_SESSION['id']['name']; }?>" />
			
			</div>
			
			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label" for="profile-information-email"><?php echo $hesklang['email']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="profile-information-email" name="email" size="40" maxlength="255" value="<?php if (isset($_SESSION['id']['email'])) {echo $_SESSION['id']['email']; }?>" />
			</div>

			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label control-label" for="profile-information-username"><?php echo $hesklang['username']; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="profile-information-username" name="user" size="40" maxlength="20" value="<?php if (isset($_SESSION['id']['user'])) {echo $_SESSION['id']['user']; }?>" />
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-address"><?php echo 'Address'; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="profile-information-adress" name="address" size="40" maxlength="255" value="<?php if(isset($_SESSION['id']['address'])) {echo $_SESSION['id']['address']; } ?>"/>
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-phonenumber"><?php echo 'Phone Number'; ?>: <font class="important">*</font></label>
				<input class="form-control" type="number" id="profile-information-phonenumber" name="phonenumber" size="40" maxlength="255" value="<?php if(isset($_SESSION['id']['phonenumber'])) {echo $_SESSION['id']['phonenumber']; } ?>"/>
			</div>
			
			<div class="form-inline" id="profile-information-row">
				<label class="col-sm-2 control-label" for="profile-information-poz_detyres"><?php echo 'Pozicioni Detyres'; ?>: <font class="important">*</font></label>
				<input class="form-control" type="text" id="profile-information-poz_detyres" name="poz_detyres" size="40" maxlength="255" value="<?php if(isset($_SESSION['id']['poz_detyres'])) {echo $_SESSION['id']['poz_detyres']; } ?>"/>
			</div>

			<input type="hidden" name="userid" value="<?php echo $_SESSION['id']['id']; ?>" />
			
			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label" for="profile-information-newpass"><?php echo $hesklang['new_pass']; ?>:</label>
				<input class="form-control" type="password" id="profile-information-newpass" name="newpass" autocomplete="off" size="40" value="<?php echo isset($_SESSION['cleanpass']) ? $_SESSION['cleanpass'] : ''; ?>" onkeyup="javascript:hesk_checkPassword(this.value)" />
			</div>
			
			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label" for="profile-information-confirmpass"><?php echo $hesklang['confirm_pass']; ?>:</label>
				<input class="form-control" type="password" id="profile-information-confirmpass" name="newpass2" autocomplete="off" size="40" value="<?php echo isset($_SESSION['cleanpass']) ? $_SESSION['cleanpass'] : ''; ?>" />
			</div>
			
			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label"><?php echo $hesklang['pwdst']; ?>:</label>
				<label style="vertical-align: top;">
					<div class="form-control" style="width: 336px;">
						<div id="progressBar" style="font-size: 1px; height: 20px; width: 0px; border: 1px solid white;"></div>
					</div>
				</label>
			</div>
			<br/>
		</div><!-- end profile-information -->
	</div>
		
	<!-- SIGNATURE -->
	<div role="tabpanel" class="tab-pane" id="signature">
		<br/>
		<div class="form-inline signature-profile-func">
			<label class="control-label col-sm-3"><?php echo $hesklang['signature_max']; ?>:</label>
			<div class="form-group">
				<textarea class="form-control" name="signature" rows="10" cols="60" value="<?php if (isset($_SESSION['id']['signature'])) {echo $_SESSION['id']['signature']; }?>"></textarea><br />
				<?php echo $hesklang['sign_extra']; ?>
			</div>
		</div><!-- end signature-profile-func -->
		<br />	
	</div>
	<!-- SIGNATURE -->	
			
	<!-- contract & project -->
	<div role="tabpanel" class="tab-pane" id="cont_client">
		<div class="project_contract_table">
			<table class="table table-bordered">
				<tr>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['id']; ?></i></b></th>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['name']; ?></i></b></th>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['contract']; ?></i></b></th>
				<th class="admin_white" style="text-align:left"><b><i><?php echo $hesklang['project']; ?></i></b></th>
				</tr>

				<?php
				$result_cl = hesk_dbQuery('SELECT id, name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'clients` WHERE `contract_id` ="'.intval($_SESSION['id']['user']).'" ');
					$i=1;
					while ($row_cl = mysqli_fetch_array($result_cl)) 
					{
						$res_contract = hesk_dbQuery("SELECT contract_Id FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."contractforclient` WHERE `client_Id`='".$row_cl['id']."'");
						$contract_string= "";
						$project_cl_string= "";
						while ($row_cont = mysqli_fetch_array($res_contract))
						{
							$contract_client = hesk_dbQuery('SELECT contract_name, project_id FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'contracts` WHERE `id` ="'.$row_cont["contract_Id"].'"');
							$contract = mysqli_fetch_array($contract_client);
							$contract_string .= $contract['contract_name']."<br/>";
							$project_id = isset($contract['project_id'])?$contract['project_id']:"";
							if(!empty($project_id)){
								$project_staff = hesk_dbQuery('SELECT project_name FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'projects` WHERE `id` ="'.$project_id.'"');
								$project = mysqli_fetch_array($project_staff);
								$project_cl_string .= $project['project_name']."<br/>";
							}
						}
						echo '<tr>
						<td class="$color">' .$row_cl['id'] .'</td>
						<td class="$color">' .$row_cl['name'] .'</td>
						<td class="$color">' .$contract_string .'</td>
						<td class="$color">' .$project_cl_string .'</td>
						</tr>';
						}
						
				?>				
			</table>
		</div>
	</div>
	<!-- contract & project -->	
</div>
		<br/>
		<!-- Submit -->
	<div class="container col-sm-8 col-sm-offset-4">
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="token" value="<?php hesk_token_echo(); ?>" />
		<input type="submit" value="<?php echo $hesklang['update_profile']; ?>" class="btn btn-default client-submit-btn"/>
	</div>
	</form>
 <br/>
<!-- Go back -->
<div class="container"><a href="javascript:history.go(-1)"> <button type="submit" class="btn btn-default goback-btn"><?php echo $hesklang['back'] ?></button></a></div>
	
<?php
	require_once(HESK_PATH . 'inc/footer.inc.php');
	exit();


/*** START FUNCTIONS ***/

function update_profile() {
	global $hesk_settings, $hesklang, $can_view_unassigned;

	/* A security check */
	hesk_token_check('POST');

    $sql_pass = '';
    $sql_username = '';
    $hesk_error_buffer = '';

	$newvar['new']['name']  = hesk_input( hesk_POST('name') ) or $hesk_error_buffer .= '<li>' . $hesklang['enter_your_name'] . '</li>';
	$newvar['new']['email'] = hesk_validateEmail( hesk_POST('email'), 'ERR', 0) or $hesk_error_buffer = '<li>' . $hesklang['enter_valid_email'] . '</li>';
	$newvar['new']['signature'] = hesk_input( hesk_POST('signature') );
	$newvar['new']['user'] = hesk_input( hesk_POST('user') );
	$newvar['new']['address'] = hesk_input( hesk_POST('address') );
	$newvar['new']['phonenumber'] = hesk_input( hesk_POST('phonenumber') );
	$newvar['new']['poz_detyres'] = hesk_input( hesk_POST('poz_detyres') );

	/* Signature */
	if (strlen($newvar['new']['signature'])>1000)
    {
		$hesk_error_buffer .= '<li>' . $hesklang['signature_long'] . '</li>';
    }

	
	$sql_username =  ",user='" . hesk_dbEscape($newvar['new']['user']) . "'";
	
	
	/* Change password? */
    $newpass = hesk_input( hesk_POST('newpass') );
    $passlen = strlen($newpass);
	if ($passlen > 0)
	{
        /* At least 5 chars? */
        if ($passlen < 5)
        {
        	$hesk_error_buffer .= '<li>' . $hesklang['password_not_valid'] . '</li>';
        }
        /* Check password confirmation */
        else
        {
        	$newpass2 = hesk_input( hesk_POST('newpass2') );

			if ($newpass != $newpass2)
			{
				$hesk_error_buffer .= '<li>' . $hesklang['passwords_not_same'] . '</li>';
			}
            else
            {
				$v = hesk_Pass2Hash($newpass);
				if ($v == '499d74967b28a841c98bb4baaabaad699ff3c079')
				{
					define('WARN_PASSWORD',true);
				}
				$sql_pass = ',`pass`=\''.$v.'\'';
            }
        }
	}
	$id = hesk_input( hesk_POST('userid') );
	
    /* Any errors? */
    if (strlen($hesk_error_buffer))
    {
		/* Process the session variables */
		$newvar['new'] = hesk_stripArray($newvar['new']);

		$hesk_error_buffer = $hesklang['rfm'].'<br /><br /><ul>'.$hesk_error_buffer.'</ul>';
		//hesk_process_messages($hesk_error_buffer,'NOREDIRECT');
    }
    //else
    //{			
			$query = "UPDATE ".hesk_dbEscape($hesk_settings['db_pfix'])."clients SET 
			name='".hesk_dbEscape($newvar['new']['name'])."', 
			email='".hesk_dbEscape($newvar['new']['email'])."', 
			user='".hesk_dbEscape($newvar['new']['user'])."',
			address='".hesk_dbEscape($newvar['new']['address'])."',
			phonenumber='".hesk_dbEscape($newvar['new']['phonenumber'])."',
			poz_detyres='".hesk_dbEscape($newvar['new']['poz_detyres'])."',
			signature='".hesk_dbEscape($newvar['new']['signature'])."'
			$sql_pass
			WHERE id=".$id." LIMIT 1";
			
		/* Update database */
		$result = hesk_dbQuery($query);

		/* Process the session variables */
		$newvar['new'] = hesk_stripArray($newvar['new']);
		$tmp = $_SESSION['id']['id'];
		$_SESSION['id'] = $newvar['new'];
		$_SESSION['id']['id'] = $tmp;

        /* Update session variables */
        /*foreach ($newvar['new'] as $k => $v)
        {
        	$_SESSION[$k] = $v;
        }*/
        unset($newvar['new']);
		
		hesk_cleanSessionVars('as_notify');

	    hesk_process_messages($hesklang['profile_updated_success'],'client_profile.php','SUCCESS');
   // }
} // End update_profile()

?>









