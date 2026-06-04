<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>
<?php $user_ID = get_current_user_id(); ?>
			<!-- heading START -->
  		<div id="heading"><h1><?php the_title(); ?></h1></div>
  			<!-- heading END-->
  			<!-- innerContent START-->
        <div id="innerContent">

<?php if (have_posts()) : the_post(); ?>

	<div class="post" id="post-<?php the_ID(); ?>">
		<div class="info">
			<span class="date"><?php the_modified_time(__('F jS, Y', 'inove')); ?></span>
			<div class="act">
				<?php if ( get_comments_number() || comments_open() ) : ?>
					<span class="comments"><a href="#comments"><?php _e('Goto comments', 'inove'); ?></a></span>
					<span class="addcomment"><a href="#respond"><?php _e('Leave a comment', 'inove'); ?></a></span>
				<?php endif; ?>
				<?php if ( $user_ID ) : ?>
					<span class="editlinks"><a href="<?php echo get_option('home'); ?>/wp-admin/link-manager.php"><?php _e('Edit links', 'inove'); ?></a></span>
				<?php endif; ?>
				<?php edit_post_link(__('Edit', 'inove'), '<span class="editpost">', '</span>'); ?>
				<div class="fixed"></div>
			</div>
			<div class="fixed"></div>
		</div>
		<div class="content">
			<div class="boxcaption"><h3>Blogroll</h3></div>
			<div class="box linkcat">
				<ul><?php wp_list_bookmarks('title_li=&categorize=0&orderby=rand'); ?></ul>
				<div class="fixed"></div>
			</div>

			<?php the_content(); ?>
			<div class="fixed"></div>
		</div>
	</div>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<?php
	// Support comments for WordPress 2.7 or higher
	if (function_exists('wp_list_comments')) {
		comments_template('', true);
	} else {
		comments_template();
	}
?>
</div>
<?php get_footer(); ?>
