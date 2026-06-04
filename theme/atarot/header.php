<?php
	//error_reporting(E_ALL);
?>
<!DOCTYPE html>

<?php
	$options = get_option('inove_options');
	$yoast_seo_active = function_exists('yoast_breadcrumb');
	$description = '';
	if (is_home()) {
		$home_menu = 'current_page_item';
	} else {
		$home_menu = 'page_item';
	}
	$feed = atarot_get_feed_url();
?>
<html <?php language_attributes(); ?>>
<head profile="https://gmpg.org/xfn/11">
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />

	<?php if (!$yoast_seo_active) : ?>
	<?php
		if (is_home()) { 
			$description = $options['description'];
		} else if (is_single()) {
			$description = strip_tags($post->post_title);
		} else if (is_category()) {
			$description = category_description();
		} else if (is_page()) {
			$customMeta = get_post_custom($wp_query->post->ID);
			$description = isset($customMeta['popis']) ? $customMeta['popis'][0] : '';
		}
	?>
	<?php if ($description !== '') : ?>
	<meta name="description" content="<?php echo esc_attr(wp_strip_all_tags($description)); ?>" />
	<?php endif; ?>
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
	<meta name="author" content="<?php echo esc_attr(get_bloginfo('name')); ?>" />
	<?php wp_head(); ?>
</head>

<?php flush(); ?>

<body <?php body_class(); ?>>
<?php if (function_exists('wp_body_open')) { wp_body_open(); } ?>
<!-- wrap START -->
<div id="wrap">
<!-- container START -->
<div id="container">

<!-- header START -->
<header id="header">
	<div id="caption">
		<?php if (is_front_page()) : ?>
		<h1 id="title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h1>
		<?php else : ?>
		<p id="title"><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></p>
		<?php endif; ?>
		<div id="tagline"><?php bloginfo('description'); ?></div>
	</div>

	<!-- navigation START -->
	<nav id="navigation" aria-label="<?php esc_attr_e('Primary navigation', 'inove'); ?>">
		<ul id="menus">
			<li class="<?php echo($home_menu); ?>"><a class="home" title="<?php _e('Home', 'inove'); ?>" href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'inove'); ?></a></li>
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
				<form action="https://www.google.com/cse" method="get" role="search">
					<div class="content">
						<input type="text" class="textfield" name="q" size="24" aria-label="<?php esc_attr_e('Search', 'inove'); ?>" />
						<input type="hidden" name="cx" value="<?php echo esc_attr($options['google_cse_cx']); ?>" />
						<input type="hidden" name="ie" value="UTF-8" />
						<a class="switcher" ><?php _e('Switcher', 'inove'); ?></a>
					</div>
				</form>
			<?php else : ?>
				<form action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
					<div class="content">
						<input type="text" class="textfield" name="s" size="24" value="<?php echo esc_attr(get_search_query()); ?>" aria-label="<?php esc_attr_e('Search', 'inove'); ?>" />
						<a class="switcher" ><?php _e('Switcher', 'inove'); ?></a>
					</div>
				</form>
			<?php endif; ?>
		</div>
		<!-- searchbox END -->

		<div class="fixed"></div>
	</nav>
	<!-- navigation END -->

	<div class="fixed"></div>
</header>
<!-- header END -->

<!-- content START -->
<div id="content">
	<?php atarot_render_breadcrumbs(); ?>
	<?php get_sidebar('left'); ?>
    <!-- main START -->
    <main id="main">