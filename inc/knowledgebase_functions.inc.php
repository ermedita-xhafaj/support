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

/*** FUNCTIONS ***/

function hesk_kbArticleContentPreview($txt)
{
	global $hesk_settings;

	// Strip HTML tags
	$txt = strip_tags($txt);

	// If text is larger than article preview length, shorten it
	if (strlen($txt) > $hesk_settings['kb_substrart'])
	{
		// The quick but not 100% accurate way (number of chars displayed may be lower than the limit)
		return substr($txt, 0, $hesk_settings['kb_substrart']) . '...';

		// If you want a more accurate, but also slower way, use this instead
		// return hesk_htmlentities( substr( hesk_html_entity_decode($txt), 0, $hesk_settings['kb_substrart'] ) ) . '...';
	}

	return $txt;
} // END hesk_kbArticleContentPreview()


function hesk_kbTopArticles($how_many, $index = 1, $show = TRUE)
{	
	global $hesk_settings, $hesklang;

	// Index page or KB main page?
	if ($index)
	{
		// Disabled?
		if ( ! $hesk_settings['kb_index_popart'])
		{
			return true;
		}

		// Show title in italics
		$font_weight = 'i';
	}
	else
	{
		// Disabled?
		if ( ! $hesk_settings['kb_popart'])
		{
			return true;
		}

		// Show title in bold
		$font_weight = 'b';

		// Print a line for spacing
		echo '<br/><br/>';
	}
	?>
<div class="tab-content">	
  
	<ul id="tabs" class="nav nav-tabs top-lt-kb" data-tabs="tabs">
        <li class="active" id="topkb"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo $hesklang['popart']; ?></a></li>
        <li id="latestkb"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"> <?php echo $hesklang['latart']; ?></a></li>
        <?php if($show){ ?>
		<li id="kb-details"><a href="knowledgebase.php"><?php echo $hesklang['viewkb']; ?></a></li>
        <?php } ?>
	</ul>	


	<?php
    /* Get list of articles from the database */
    $res = hesk_dbQuery("SELECT `t1`.`id`,`t1`.`subject`,`t1`.`views` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_articles` AS `t1`
			LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` AS `t2` ON `t1`.`catid` = `t2`.`id`
			WHERE `t1`.`type`='0' AND `t2`.`type`='0'
			ORDER BY `t1`.`sticky` DESC, `t1`.`views` DESC, `t1`.`art_order` ASC LIMIT ".intval($how_many));

	/* We have some results, print them out */
	?>
    <div role="tabpanel" class="tab-pane active" id="home">
		<table class="table">
			<?php
			while ($article = hesk_dbFetchAssoc($res))
			{
				echo '<tbody>
				<tr>
				<td width="90%"><img src="img/article_text.jpg" width="16" height="16" border="0" alt="" style="vertical-align:middle" />
				&nbsp;<span class="top-kb-views1"><a href="knowledgebase.php?article=' . $article['id'] . '">' . $article['subject'] . '</a></span></td>
				';

				if ($hesk_settings['kb_views'])
				{
					echo '<td><span class="top-kb-views2">' .$article['views'] .'</span></td>';
					echo '<td>' .'<img src="img/views.jpg" alt="views">' .'</td>';
				}

				echo '
				</tr>
				</tbody>
				';
			}
			?>
		</table>
    </div>
    <?php
} // END hesk_kbTopArticles()


function hesk_kbLatestArticles($how_many, $index = 1)
{
	global $hesk_settings, $hesklang;

	// Index page or KB main page?
	if ($index)
	{
		// Disabled?
		if ( ! $hesk_settings['kb_index_latest'])
		{
			return true;
		}

		// Show title in italics
		$font_weight = 'i';
	}
	else
	{
		// Disabled?
		if ( ! $hesk_settings['kb_latest'])
		{
			return true;
		}

		// Show title in bold
		$font_weight = 'b';

		// Print a line for spacing if we don't show popular articles
		if (  ! $hesk_settings['kb_popart'])
		{
			echo '<br/><br/>';
		}
	}
	?>

	<?php
    /* Get list of articles from the database */
    $res = hesk_dbQuery("SELECT `t1`.`id`,`t1`.`subject`,`t1`.`dt` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_articles` AS `t1`
			LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` AS `t2` ON `t1`.`catid` = `t2`.`id`
			WHERE `t1`.`type`='0' AND `t2`.`type`='0'
			ORDER BY `t1`.`dt` DESC LIMIT ".intval($how_many));

	/* If no results found end here */
	if (hesk_dbNumRows($res) == 0)
	{
		echo '<div class="container noarticles"><i>'.$hesklang['noa'].'</i><br />&nbsp;</div></div>';
        return true;
	}

	/* We have some results, print them out */
	?>
	<div role="tabpanel" class="tab-pane" id="profile">
		<table class="table">
	<?php

	while ($article = hesk_dbFetchAssoc($res))
	{
		echo '<tbody>
			<tr>
			<td width="84%"><img src="img/article_text.jpg" width="16" height="16" border="0" alt="" style="vertical-align:middle" />
		&nbsp;<span class="latest-kb-date-added1"><a href="knowledgebase.php?article=' . $article['id'] . '">' . $article['subject'] . '</a></span></td>
		';

		if ($hesk_settings['kb_date'])
		{
			echo '<td><span class="latest-kb-date-added2">' .hesk_date($article['dt'], true) .'</span></td>';
		}

		echo '
		</tr>
		</tbody>
		';
	}
	?>
		</table>
	</div>
    &nbsp;
	
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#tabs').tab();
    });
</script>  
	
</div>


    <?php
} // END hesk_kbLatestArticles()


function hesk_kbSearchLarge($admin = '')
{
	global $hesk_settings, $hesklang;

	if ($hesk_settings['kb_search'] != 2)
	{
		return '';
	}

    $action = $admin ? 'knowledgebase_private.php' : 'knowledgebase.php';

	?>

	<form class="form-inline" id="kbformsearch" action="<?php echo $action; ?>" method="get" name="searchform">
		 <button type="button" class="form-control btn" id="buttonhelp">
          <span class="glyphicon glyphicon-search"></span></button><input id="searchhelp" type="text" name="search" class="form-control" placeholder="<?php echo $hesklang['ask']; ?>"/>
	</form>
		
	<!-- START KNOWLEDGEBASE SUGGEST -->
	<!-- END KNOWLEDGEBASE SUGGEST -->

	<?php
} // END hesk_kbSearchLarge()


function hesk_kbSearchSmall()
{
	global $hesk_settings, $hesklang;

	if ($hesk_settings['kb_search'] != 1)
	{
		return '';
	}
    ?>

	<td style="text-align:right" valign="top" width="300">
		<div style="display:inline;">
			<form for="searchfield-sfsmall" class="form-inline" action="knowledgebase.php" method="get" style="display: inline; margin: 0;">
			<input id="searchfield-sfsmall" type="text" name="search" class="form-control searchfield sfsmall" />
			<input type="submit" value="<?php echo $hesklang['search']; ?>" title="<?php echo $hesklang['search']; ?>" class="searchbutton sbsmall" />
			</form>
		</div>
	</td>

	<?php
} // END hesk_kbSearchSmall()


function hesk_detect_bots()
{
	$botlist = array('googlebot', 'msnbot', 'slurp', 'alexa', 'teoma', 'froogle',
	'gigabot', 'inktomi', 'looksmart', 'firefly', 'nationaldirectory',
	'ask jeeves', 'tecnoseek', 'infoseek', 'webfindbot', 'girafabot',
	'crawl', 'www.galaxy.com', 'scooter', 'appie', 'fast', 'webbug', 'spade', 'zyborg', 'rabaz',
	'baiduspider', 'feedfetcher-google', 'technoratisnoop', 'rankivabot',
	'mediapartners-google', 'crawler', 'spider', 'robot', 'bot/', 'bot-','voila');

	if ( ! isset($_SERVER['HTTP_USER_AGENT']))
    {
    	return false;
    }

    $ua = strtolower($_SERVER['HTTP_USER_AGENT']);

	foreach ($botlist as $bot)
    {
    	if (strpos($ua,$bot) !== false)
        {
        	return true;
        }
    }

	return false;
} // END hesk_detect_bots()
