<?php
	$options = get_option('inove_options');

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

<!-- sidebar START -->
<div id="sidebar">
<!--<div class="headingBg">
<h2>Informace</h2>
</div>-->
<!-- sidebar north START -->
<div id="northsidebar" class="sidebar">
	<!-- showcase -->
	<?php if( $options['showcase_content'] && (
		($options['showcase_registered'] && $user_ID) || 
		($options['showcase_commentator'] && !$user_ID && isset($_COOKIE['comment_author_'.COOKIEHASH])) || 
		($options['showcase_visitor'] && !$user_ID && !isset($_COOKIE['comment_author_'.COOKIEHASH]))
	) ) : ?>
		<div class="widget">
			<?php if($options['showcase_caption']) : ?>
				<h3><?php if($options['showcase_title']){echo($options['showcase_title']);}else{_e('Showcase', 'inove');} ?></h3>
			<?php endif; ?>
			<div class="content">
				<?php echo($options['showcase_content']); ?>
			</div>
		</div>
	<?php endif; ?>

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('north_sidebar') ) : ?>

	<!-- posts -->
	<?php
		if (is_single()) {
			$posts_widget_title = 'Nejnovější příspěvky';
		} else {
			$posts_widget_title = 'Náhodné příspěvky';
		}
	?>

	<div class="widget widget_categories">
		<h3><?php echo $posts_widget_title; ?></h3>
		<ul>
			<?php
				if (is_single()) {
					$posts = get_posts('numberposts=10&orderby=post_date');
				} else {
					$posts = get_posts('numberposts=5&orderby=rand');
				}
				foreach($posts as $post) {
					setup_postdata($post);
					echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
				}
				$post = $posts[0];
			?>
		</ul>
	</div>

	<!-- recent comments -->
	<?php if( function_exists('wp_recentcomments') ) : ?>
		<div class="widget">
			<h3>Recent Comments</h3>
			<ul>
				<?php wp_recentcomments('limit=5&length=16&post=false&smilies=true'); ?>
			</ul>
		</div>
	<?php endif; ?>

	<!-- tag cloud -->
	<?php if (!is_single()) : ?>
		<div id="tag_cloud" class="widget">
			<h3><?php _e('Tag Cloud'); ?></h3>
			<?php wp_tag_cloud('smallest=8&largest=16'); ?>
		</div>
	<?php endif; ?>

<?php endif; ?>
</div>
<!-- sidebar north END -->

<div id="centersidebar">

	<!-- sidebar east START -->
	<div id="eastsidebar" class="sidebar">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('east_sidebar') ) : ?>

		<!-- categories -->
		<div class="widget widget_categories">
			<h3><?php _e('Categories'); ?></h3>
			<ul>
				<?php wp_list_categories('sort_column=name&optioncount=0&depth=1'); ?>
			</ul>
		</div>

	<?php endif; ?>
	</div>
	<!-- sidebar east END -->

	<!-- sidebar west START -->
	<div id="westsidebar" class="sidebar">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('west_sidebar') ) : ?>

		<!-- archives -->
		<div class="widget widget_archive">
			<h3><?php _e('Archives'); ?></h3>
			<ul>
				<?php wp_get_archives('type=monthly'); ?>
			</ul>
		</div>

	<?php endif; ?>
	</div>
	<!-- sidebar west END -->
	<div class="fixed"></div>
</div>

<!-- sidebar south START -->
<div id="southsidebar" class="sidebar">
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('south_sidebar') ) : ?>

	<!-- meta -->
	<div class="widget">
		<h3><?php _e('Meta'); ?></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
		</ul>
	</div>

<?php endif; ?>
</div>
<!-- sidebar south END -->
</div>
<!-- sidebar END -->
