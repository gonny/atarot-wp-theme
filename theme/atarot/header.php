<?php
    //error_reporting(E_ALL);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
	$options = get_option('inove_options');
	$yoast_seo_active = function_exists('yoast_breadcrumb');
	$description = '';
	$keywords = '';
	if (is_home()) {
		$home_menu = 'current_page_item';
	} else {
		$home_menu = 'page_item';
	}
	if($options['feed'] && $options['feed_url']) {
		if (substr(strtoupper($options['feed_url']), 0, 7) == 'HTTP://') {
			$feed = $options['feed_url'];
		} else {
			$feed = 'http://' . $options['feed_url'];
		}
	} else {
		$feed = get_bloginfo('rss2_url');
	}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<?php if (!$yoast_seo_active) : ?>
	<?php
		if (is_home()) { 
			$description = $options['description'];
			$keywords = $options['keywords'];
		} else if (is_single()) {
			$description = strip_tags($post->post_title);
			$tags = wp_get_post_tags($post->ID);
			foreach ($tags as $tag ) {
				$keywords = $keywords . $tag->name . ", ";
			}
		} else if (is_category()) {
			$description = category_description();
		} else if (is_page()) {
			$customMeta = get_post_custom($wp_query->post->ID);
			$description = isset($customMeta['popis']) ? $customMeta['popis'][0] : '';
		}
	?>
	<meta name="keywords" content="<?php echo esc_attr(strip_tags($keywords)); ?>" />
	<meta name="description" content="<?php echo esc_attr(strip_tags($description)); ?>" />
	<meta name="robots" content="all, follow" />
	<meta name="googlebot" content="index,follow,snippet" />
	<?php endif; ?>
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/my2.js"></script>
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all posts', 'inove'); ?>" href="<?php echo $feed; ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php _e('RSS 2.0 - all comments', 'inove'); ?>" href="<?php bloginfo('comments_rss2_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<!-- style -->
	<style type="text/css" media="screen">@import url( <?php bloginfo('stylesheet_url'); ?> );</style>
    <link rel="stylesheet" media="print" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/print.css" />
	<?php if (strtoupper(get_locale()) == 'ZH_CN') : ?><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/zh_CN.css" type="text/css" media="screen" /><?php endif; ?>
	<?php if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6')) : ?><link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie6.css" type="text/css" media="screen" /><?php endif; ?>

	<!-- script -->
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/util.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/menu.js"></script>
	<script type="text/javascript" src="http://apis.google.com/js/plusone.js">{lang: 'cs'}</script>
	<meta name="Author" content="<?php //$wp_query->post->post_author != '' ? the_author() : 'Atarot.cz'; ?> Atarot.cz" />
	<?php wp_head(); ?>
</head>

<?php flush(); ?>

<body>
<!-- wrap START -->
<div id="wrap">
<!-- container START -->
<div id="container">

<!-- header START -->
<div id="header">
	<div id="caption">
		<h1 id="title"><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></h1>
		<div id="tagline"><?php bloginfo('description'); ?></div>
	</div>

	<!-- navigation START -->
	<div id="navigation">
		<ul id="menus">
			<li class="<?php echo($home_menu); ?>"><a class="home" title="<?php _e('Home', 'inove'); ?>" href="<?php echo get_option('home'); ?>/"><?php _e('Home', 'inove'); ?></a></li>
			<?php
				if($options['menu_type'] == 'categories') {
					wp_list_categories('depth=2&title_li=0&orderby=name&show_count=0');
				} else {
					wp_list_pages('depth=2&title_li=0&sort_column=menu_order');
				}
			?>
			<li><a class="lastmenu" href="javascript:void(0);"></a></li>
		</ul>

		<!-- searchbox START -->
		<div id="searchbox">
			<?php if($options['google_cse'] && $options['google_cse_cx']) : ?>
				<form action="http://www.google.com/cse" method="get">
					<div class="content">
						<input type="text" class="textfield" name="q" size="24" />
						<input type="hidden" name="cx" value="<?php echo $options['google_cse_cx']; ?>" />
						<input type="hidden" name="ie" value="UTF-8" />
						<a class="switcher" ><?php _e('Switcher', 'inove'); ?></a>
					</div>
				</form>
			<?php else : ?>
				<form action="<?php bloginfo('home'); ?>" method="get">
					<div class="content">
						<input type="text" class="textfield" name="s" size="24" value="<?php //echo wp_specialchars($s, 1); ?>" />
						<a class="switcher" ><?php _e('Switcher', 'inove'); ?></a>
					</div>
				</form>
			<?php endif; ?>
		</div>
		<!-- searchbox END -->

		<div class="fixed"></div>
	</div>
	<!-- navigation END -->

	<div class="fixed"></div>
</div>
<!-- header END -->

<!-- content START -->
<div id="content">
	<?php atarot_render_breadcrumbs(); ?>
	<?php get_sidebar('left'); ?>
    <!-- main START -->
    <div id="main">