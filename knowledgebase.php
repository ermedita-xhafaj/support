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
define('HESK_PATH','./');

/* Get all the required files and functions */
require(HESK_PATH . 'hesk_settings.inc.php');
require(HESK_PATH . 'inc/common.inc.php');

// Are we in maintenance mode?
hesk_check_maintenance();

// Load Knowledgebase-related functions
hesk_load_database_functions();

/* Is Knowledgebase enabled? */
if (!$hesk_settings['kb_enable'])
{
	hesk_error($hesklang['kbdis']);
}

/* Connect to database */
hesk_dbConnect();

/* Rating? */
if (isset($_GET['rating']))
{
	// Detect and block robots
    if (hesk_detect_bots())
    {
		?><div>
		<html>
		<head>
		<meta name="robots" content="noindex, nofollow">
		</head>
		<body>
		</body>
		</html>
		<?php
    }

	// Rating
	$rating = intval( hesk_GET('rating') );

	// Rating value may only be 1 or 5
	if ($rating != 1 && $rating != 5)
	{
		die($hesklang['attempt']);
	}

	// Article ID
    $artid = intval( hesk_GET('id', 0) ) or die($hesklang['kb_art_id']);

    // Check cookies for already rated, rate and set cookie if not already
    $_COOKIE['hesk_kb_rate'] = hesk_COOKIE('hesk_kb_rate');

    if (strpos($_COOKIE['hesk_kb_rate'],'a'.$artid.'%')===false)
    {
		// Update rating, make sure it's a public article in a public category
		hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_articles` AS `t1`
					LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` AS `t2` ON t1.`catid` = t2.`id`
					SET `rating`=((`rating`*`votes`)+{$rating})/(`votes`+1), t1.`votes`=t1.`votes`+1
					WHERE t1.`id`='{$artid}' AND t1.`type`='0' AND t2.`type`='0'
					");
    }

    setcookie('hesk_kb_rate', $_COOKIE['hesk_kb_rate'].'a'.$artid.'%', time()+2592000);
    header('Location: knowledgebase.php?article='.$artid.'&rated=1');
    exit();
}

/* Any category ID set? */
$catid = intval( hesk_GET('category', 1) );
$artid = intval( hesk_GET('article', 0) );

if (isset($_GET['search']))
{
	$query = hesk_input( hesk_GET('search') );
}
else
{
	$query = 0;
}

$hesk_settings['kb_link'] = ($artid || $catid != 1 || $query) ? '<a href="knowledgebase.php" class="smaller">'.$hesklang['kb_text'].'</a>' : $hesklang['kb_text'];

if ($hesk_settings['kb_search'] && $query)
{
    hesk_kb_search($query);
}
elseif ($artid)
{
	// Get article from DB, make sure that article and category are public
	$result  = hesk_dbQuery("SELECT t1.*, t2.`name` AS `cat_name`
							FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_articles` AS `t1`
							LEFT JOIN `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` AS `t2` ON `t1`.`catid` = `t2`.`id`
							WHERE `t1`.`id` = '{$artid}'
							AND `t1`.`type` = '0'
							AND `t2`.`type` = '0'
                            ");

    $article = hesk_dbFetchAssoc($result) or hesk_error($hesklang['kb_art_id']);
    hesk_show_kb_article($artid);
}
else
{
	hesk_show_kb_category($catid);
}

require_once(HESK_PATH . 'inc/footer.inc.php');
exit();		/*comment dt 26/6/2015 */


/*** START FUNCTIONS ***/

function hesk_kb_header($kb_link) {
	global $hesk_settings, $hesklang;
	?>
	
<nav class="row navbar navbar-default" id="showTopBar-indexPhp">
	<div class="menu-wrapper">
		<div class="container showTopBar"><?php hesk_showTopBar($hesk_settings['hesk_title']); ?></div>
	</div><!-- end showTopBar-indexPhp -->
</nav>

	<div class="container siteUrl-title-knowledgebasePhp">
		<div class="col-sm-12">
			<span><a href="<?php echo $hesk_settings['site_url']; ?>" class="smaller"><?php echo $hesk_settings['site_title']; ?></a> &gt;
			<a href="<?php echo $hesk_settings['hesk_url']; ?>" class="smaller"><?php echo $hesk_settings['hesk_title']; ?></a>
			&gt; <?php echo $kb_link; ?></span>

			<?php
			/* Print small search box */
			hesk_kbSearchSmall();
			?>
		</div>
	</div>
	
<br/><br/>

<div class="container" id="showKnowledgebase">
	<img src="img/knowledgebase.png" alt="knowledgebase"/><span><?php echo $hesklang['kb_text']; ?></span>
</div>
	
<br/><br/>
<!--	
</td>
</tr>-->

<!-- start in this page end somewhere...
<tr>
<td>-->

    <?php
    /* Print large search box */
    /*hesk_kbSearchLarge();*/

} // END hesk_kb_header()


function hesk_kb_search($query) {
	global $hesk_settings, $hesklang;

    define('HESK_NO_ROBOTS',1);

	/* Print header */
    $hesk_settings['tmp_title'] = $hesklang['sr'] . ': ' . substr(hesk_htmlspecialchars(stripslashes($query)),0,20);
	require_once(HESK_PATH . 'inc/header.inc.php');
	hesk_kb_header($hesk_settings['kb_link']);

	$res = hesk_dbQuery('SELECT t1.`id`, t1.`subject`, LEFT(`t1`.`content`, '.max(200, $hesk_settings['kb_substrart'] * 2).') AS `content`, t1.`rating` FROM `'.hesk_dbEscape($hesk_settings['db_pfix']).'kb_articles` AS t1
    					LEFT JOIN `'.hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` AS t2 ON t1.`catid` = t2.`id`
						WHERE t1.`type`='0' AND t2.`type`='0' AND  MATCH(`subject`,`content`,`keywords`) AGAINST ('".hesk_dbEscape($query)."') LIMIT " . intval($hesk_settings['kb_search_limit']));
    $num = hesk_dbNumRows($res);

    ?>
	<div class="container serach_result_kb"><b><?php echo $hesklang['sr']; ?> (<?php echo $num; ?>)</b></div>

	<?php
	if ($num == 0)
	{
		echo '<div class="container"><i>'.$hesklang['nosr'].'</i></div>
        ';
        hesk_show_kb_category(1,1);
	}
    else
    {
?>

<div class="serach_result_kb_table">
        <?php
			while ($article = hesk_dbFetchAssoc($res))
			{
	            $txt = hesk_kbArticleContentPreview($article['content']);

	            if ($hesk_settings['kb_rating'])
	            {
	            	$alt = $article['rating'] ? sprintf($hesklang['kb_rated'], sprintf("%01.1f", $article['rating'])) : $hesklang['kb_not_rated'];
	                $rat = '<td width="1" valign="top"><img src="img/star_'.(hesk_round_to_half($article['rating'])*10).'.png" width="85" height="16" alt="'.$alt.'" border="0" style="vertical-align:text-bottom" /></td>';
	            }
	            else
	            {
	            	$rat = '';
	            }

				echo '
				<div id="content-kb">
	                <div class="form-inline">
	                <span class="col-sm-10"><img src="img/article_text.png" width="16" height="16" border="0" alt="" style="vertical-align:middle" />
					<a href="knowledgebase.php?article='.$article['id'].'">'.$article['subject'].'</a></span>'
	                .'<span>' .$rat.'</span>
	                </div>
	                <div class="form-inline">
	                <span class="col-sm-10"><img src="img/blank.gif" width="16" height="10" style="vertical-align:middle" alt="" /></span>
	                <span class="article_list">'.$txt.'</span>
	                </div><br/>
				</div>';
			}
	?>
</div>

    <div class="container"><a href="javascript:history.go(-1)"><button type="submit" class="btn btn-default goback-btn"><?php echo $hesklang['back']; ?></button></a></div>
    <?php
    } // END else

} // END hesk_kb_search()


function hesk_show_kb_article($artid)
{
	global $hesk_settings, $hesklang, $article;

	// Print header
    $hesk_settings['tmp_title'] = $article['subject'];
	require_once(HESK_PATH . 'inc/header.inc.php');
	hesk_kb_header($hesk_settings['kb_link']);

    // Update views by 1 - exclude known bots and reloads because of ratings
    if ( ! isset($_GET['rated']) && ! hesk_detect_bots())
    {
		hesk_dbQuery("UPDATE `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_articles` SET `views`=`views`+1 WHERE `id`={$artid} LIMIT 1");
    }

    echo '<div class="container subject-art">'.$article['subject'].'</div>'

    .'<div class="solution-knowledgebasePhp">'
	.'<div id="content-kb">' .$article['content'] .'</div></div><br/>';

    if ( ! empty($article['attachments']))
    {
		echo '<p><b>'.$hesklang['attachments'].':</b><br />';
		$att=explode(',',substr($article['attachments'], 0, -1));
		foreach ($att as $myatt)
        {
			list($att_id, $att_name) = explode('#', $myatt);
			echo '<img src="img/clip.png" width="16" height="16" alt="'.$att_name.'" style="align:text-bottom" /> <a href="download_attachment.php?kb_att='.$att_id.'" rel="nofollow">'.$att_name.'</a><br />';
		}
		echo '</p>';
    }

	// Article rating
	if ($hesk_settings['kb_rating'] && strpos( hesk_COOKIE('hesk_kb_rate'),'a'.$artid.'%')===false )
	{
		echo '
	    <div id="rating" class="col-sm-4 col-sm-offset-8 container rate">' .'<span id="rate-article">' .$hesklang['rart'] .'</span>'
			.'<a href="Javascript:void(0)" onclick="Javascript:window.location=\'knowledgebase.php?rating=5&amp;id='.$article['id'].'\'" rel="nofollow">' .'<button type="submit" class="btn btn-default rate-yes">' .$hesklang['yes'] .'</button></a>'
	        .'<a href="Javascript:void(0)" onclick="Javascript:window.location=\'knowledgebase.php?rating=1&amp;id='.$article['id'].'\'" rel="nofollow">' .'<button type="submit" class="btn btn-default rate-no">' .$hesklang['no'] .'</button></a>
	    </div><br/><br/>
        ';
	}

	// Related articles
	if ($hesk_settings['kb_related'])
	{
		require(HESK_PATH . 'inc/mail/email_parser.php');

		$query = hesk_dbEscape( $article['subject'] . ' ' . convert_html_to_text($article['content']) );

		// Get relevant articles from the database
		$res = hesk_dbQuery("SELECT t1.`id`, t1.`subject`, MATCH(`subject`,`content`,`keywords`) AGAINST ('{$query}') AS `score` FROM `".hesk_dbEscape($hesk_settings['db_pfix']).'kb_articles` AS t1 LEFT JOIN `'.hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` AS t2 ON t1.`catid` = t2.`id` WHERE t1.`type`='0' AND t2.`type`='0' AND MATCH(`subject`,`content`,`keywords`) AGAINST ('{$query}') LIMIT ".intval($hesk_settings['kb_related']+1));

		// Array with related articles
		$related_articles = array();

		while ($related = hesk_dbFetchAssoc($res))
		{
			// Get base match score from the first article
			if ( ! isset($base_score) )
			{
				$base_score = $related['score'];
			}

			// Ignore this article
			if ( $related['id'] == $artid )
			{
				continue;
			}

			// Stop when articles reach less than 10% of base score
			if ($related['score'] / $base_score < 0.10)
			{
				break;
			}

			// This is a valid related article
			$related_articles[$related['id']] = $related['subject'];
		}

		// Print related articles if we have any valid matches
		if ( count($related_articles) )
		{
			echo '<fieldset><legend>'.$hesklang['relart'].'</legend>';
			foreach ($related_articles as $id => $subject)
			{
				echo '<img src="img/article_text.jpg" width="16" height="16" border="0" alt="" style="vertical-align:middle;padding:2px;" /> <a href="knowledgebase.php?article='.$id.'">'.$subject.'</a><br />';
			}
			echo '</fieldset>';
		}
	}

    if ($article['catid']==1)
    {
    	$link = 'knowledgebase.php';
    }
    else
    {
    	$link = 'knowledgebase.php?category='.$article['catid'];
    }
    ?>
<br/><br/>

	<div class="container art-deails"><?php echo $hesklang['ad']; ?></div>
    <div class="container article-details-knowledgebasePhp">	
		<div class="form-group">
			<div class="row" style="padding-bottom: 5px;">
				<span class="col-sm-2"><?php echo $hesklang['aid']; ?>: </span>
				<span><?php echo $article['id']; ?></span>
			</div>
			
			<div class="row" style="padding-bottom: 5px;">
				<span class="col-sm-2"><?php echo $hesklang['category']; ?>: </span>
				<span><a href="<?php echo $link; ?>"><?php echo $article['cat_name']; ?></a></span>
			</div>

			<?php
			if ($hesk_settings['kb_date'])
			{
			?>
			<div class="row" style="padding-bottom: 5px;">
				<span class="col-sm-2"><?php echo $hesklang['dta']; ?>: </span>
				<span><?php echo hesk_date($article['dt'], true); ?></span>
			</div>
			<?php
			}

			if ($hesk_settings['kb_views'])
			{
			?>
			<div class="row" style="padding-bottom: 5px;" style="padding-bottom: 5px;">
				<span class="col-sm-2"><?php echo $hesklang['views']; ?>: </span>
				<span><?php echo (isset($_GET['rated']) ? $article['views'] : $article['views']+1); ?></span>
			</div>
			<?php
			}

			if ($hesk_settings['kb_rating'])
			{
				$alt = $article['rating'] ? sprintf($hesklang['kb_rated'], sprintf("%01.1f", $article['rating'])) : $hesklang['kb_not_rated'];
				echo '
				<div class="row">
				<span class="col-sm-2">'.$hesklang['rating'].' ('.$hesklang['votes'].'):</span>
				<span><img src="img/star_'.(hesk_round_to_half($article['rating'])*10).'.png" width="85" height="16" alt="'.$alt.'" title="'.$alt.'" border="0" style="vertical-align:text-bottom" /> ('.$article['votes'].')</span>
				</div><br/>
				';
			}
			?>
		</div>
    </div>

    <?php
    if (!isset($_GET['suggest']))
    {
    	?>
		<br/><div class="container"><a href="javascript:history.go(<?php echo isset($_GET['rated']) ? '-2' : '-1'; ?>)"><button type="submit" class="btn btn-default goback-btn"><?php echo $hesklang['back']; ?></button></a></div>
        <?php
    }
    else
    {
    	?>
        <p>&nbsp;</p>
        <?php
    }

} // END hesk_show_kb_article()


function hesk_show_kb_category($catid, $is_search = 0) {
	global $hesk_settings, $hesklang;

	$res = hesk_dbQuery("SELECT `name`,`parent` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` WHERE `id`='{$catid}' AND `type`='0' LIMIT 1");
    $thiscat = hesk_dbFetchAssoc($res) or hesk_error($hesklang['kb_cat_inv']);

    if ($is_search == 0)
    {
		/* Print header */
		$hesk_settings['tmp_title'] = $hesk_settings['hesk_title'] . ' - ' . hesk_htmlspecialchars($thiscat['name']);
		require_once(HESK_PATH . 'inc/header.inc.php');
		hesk_kb_header($hesk_settings['kb_link']);

		// If we are in "Knowledgebase only" mode show system messages
		if ($catid == 1 && hesk_check_kb_only(false) )
		{
			// Service messages
			$res = hesk_dbQuery('SELECT `title`, `message`, `style` FROM `'.hesk_dbEscape($hesk_settings['db_pfix'])."service_messages` WHERE `type`='0' ORDER BY `order` ASC");
			while ($sm=hesk_dbFetchAssoc($res))
			{
				hesk_service_message($sm);
			}
		}
    }

	if ($thiscat['parent'])
	{
		$link = ($thiscat['parent'] == 1) ? 'knowledgebase.php' : 'knowledgebase.php?category='.$thiscat['parent'];
		echo '<div class="container homepageh3">'.$hesklang['kb_cat'].': '.$thiscat['name'].'</div>
        <div class="container"><a href="javascript:history.go(-1)">' .'<button type="submit" class="btn btn-default goback-btn">' .$hesklang['back'] .'</button>' .'</a></div>
		';
	}

	$result = hesk_dbQuery("SELECT `id`,`name`,`articles` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_categories` WHERE `parent`='{$catid}' AND `type`='0' ORDER BY `cat_order` ASC");
	if (hesk_dbNumRows($result) > 0)
	{
        ?>

	<div class="container"><b><?php echo $hesklang['kb_cat_sub']; ?>:</b></div>
	<br/>
	<div class="container">

		<?php
		$per_col = $hesk_settings['kb_cols'];
		$i = 1;

		while ($cat = hesk_dbFetchAssoc($result))
		{

			if ($i == 1)
		    {
				echo '<div>';
		    }

			echo '
			<div class="form-group">
			<div class="form-inline"><img src="img/folder.gif" width="20" height="20" alt="" style="vertical-align:middle" /><a href="knowledgebase.php?category='.$cat['id'].'">'.$cat['name'].'</a></div>
			';

			/* Print most popular/sticky articles */
			if ($hesk_settings['kb_numshow'] && $cat['articles'])
		    {
		        $res = hesk_dbQuery("SELECT `id`,`subject` FROM `".hesk_dbEscape($hesk_settings['db_pfix'])."kb_articles` WHERE `catid`='{$cat['id']}' AND `type`='0' ORDER BY `sticky` DESC, `views` DESC, `art_order` ASC LIMIT " . (intval($hesk_settings['kb_numshow']) + 1) );
		        $num = 1;
				while ($art = hesk_dbFetchAssoc($res))
				{
					echo '
		            <div class="form-inline">
		            <img src="img/article_text.png" width="16" height="16" border="0" alt="" style="vertical-align:middle" />
		            <a href="knowledgebase.php?article='.$art['id'].'" class="article">'.$art['subject'].'</a>
		            </div>';

		            if ($num == $hesk_settings['kb_numshow'])
		            {
		            	break;
		            }
		            else
		            {
		            	$num++;
		            }
				}
		        if (hesk_dbNumRows($res) > $hesk_settings['kb_numshow'])
		        {
		        	echo '<div>&raquo; <a href="knowledgebase.php?category='.$cat['id'].'"><i>'.$hesklang['m'].'</i></a></div>';
		        }
		    }

			echo '
			</div>
			';

			if ($i == $per_col)
		    {
				echo '</div>';
		        $i = 0;
		    }
			$i++;
		}
		/* Finish the table if needed */
		if ($i != 1)
		{
			for ($j=1;$j<=$per_col;$j++)
		    {
				echo '';
				if ($i == $per_col)
			    {
					echo '</div>';
			        break;
			    }
		        $i++;
		    }
		}

		?>
	</div>

	<?php
	} // END if NumRows > 0
	
	    if ($catid == 1)
	{
		print "<div class='col-sm-8 col-sm-offset-2 conatiner kb-popart-latest'>";
        /* Get list of top articles */
        hesk_kbTopArticles($hesk_settings['kb_popart'], 0, false);

        /* Get list of latest articles */
        hesk_kbLatestArticles($hesk_settings['kb_latest'], 0);
		print "</div>";
	}
	
	?>
	
<?php

	} // END hesk_show_kb_category()
?>
