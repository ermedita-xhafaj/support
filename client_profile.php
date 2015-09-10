<?php 
define('IN_SCRIPT',1);
define('HESK_PATH','./');
include("inc/database.inc.php");

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');
require(HESK_PATH . 'inc/admin_functions.inc.php');
require(HESK_PATH . 'inc/profile_functions.inc.php');

session_start();
hesk_dbConnect();

/* Update profile? */
if ( ! empty($_POST['action']))
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
	</ul>
			<!-- PROFILE INFO -->
	<div role="tabpanel" class="tab-pane active" id="p-info">

			&nbsp;<br />
			
	<form method="post" action="client_profile.php" name="form1">
		<div class="profile-information">
			<div class="form-inline" style="margin-bottom: 5px;">
				<label class="col-sm-2 control-label" for="profile-information-name"><?php echo $hesklang['real_name']; ?>: <font class="important">*</font></label>
				<?php /*var_dump($_SESSION['id']['name']);*/ ?>
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
		
		&nbsp;<br/><br/>

		<div class="form-inline signature-profile-func">
			<label class="control-label col-sm-3"><?php echo $hesklang['signature_max']; ?>:</label>
			<div class="form-group">
				<textarea class="form-control" name="signature" rows="10" cols="60" value="<?php if (isset($_SESSION['id']['signature'])) {echo $_SESSION['id']['signature']; }?>"></textarea><br />
				<?php echo $hesklang['sign_extra']; ?>
			</div>
		</div><!-- end signature-profile-func -->

		&nbsp;<br />&nbsp;

	</div>
			<!-- SIGNATURE -->	
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

	$_SESSION['new']['name']  = hesk_input( hesk_POST('name') ) or $hesk_error_buffer .= '<li>' . $hesklang['enter_your_name'] . '</li>';
	$_SESSION['new']['email'] = hesk_validateEmail( hesk_POST('email'), 'ERR', 0) or $hesk_error_buffer = '<li>' . $hesklang['enter_valid_email'] . '</li>';
	$_SESSION['new']['signature'] = hesk_input( hesk_POST('signature') );
	$_SESSION['new']['user'] = hesk_input( hesk_POST('user') );

	/* Signature */
	if (strlen($_SESSION['new']['signature'])>1000)
    {
		$hesk_error_buffer .= '<li>' . $hesklang['signature_long'] . '</li>';
    }

	
	$sql_username =  ",user='" . hesk_dbEscape($_SESSION['new']['user']) . "'";
	
	
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
		$_SESSION['new'] = hesk_stripArray($_SESSION['new']);

		$hesk_error_buffer = $hesklang['rfm'].'<br /><br /><ul>'.$hesk_error_buffer.'</ul>';
		hesk_process_messages($hesk_error_buffer,'NOREDIRECT');
    }
    else
    {			
			$query = "UPDATE ".hesk_dbEscape($hesk_settings['db_pfix'])."clients SET 
			name='".hesk_dbEscape($_SESSION['new']['name'])."', 
			email='".hesk_dbEscape($_SESSION['new']['email'])."', 
			user='".hesk_dbEscape($_SESSION['new']['user'])."',
			signature='".hesk_dbEscape($_SESSION['new']['signature'])."'
			$sql_pass
			WHERE id=".$id." LIMIT 1";
			
		/* Update database */
		$result = hesk_dbQuery($query);

		/* Process the session variables */
		$_SESSION['new'] = hesk_stripArray($_SESSION['new']);

        /* Update session variables */
        foreach ($_SESSION['new'] as $k => $v)
        {
        	$_SESSION[$k] = $v;
        }
        unset($_SESSION['new']);
		
		hesk_cleanSessionVars('as_notify');

	    hesk_process_messages($hesklang['profile_updated_success'],'client_profile.php','SUCCESS');
    }
} // End update_profile()

?>









