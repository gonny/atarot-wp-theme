<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>
			<!-- heading START -->
  		<div id="heading"><h1><?php printf(__('Search results for &#8216;%1$s&#8217;', 'inove'), esc_html(get_search_query())); ?></h1></div>
  			<!-- heading END-->
  			<!-- innerContent START-->
        <div id="innerContent">

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a class="title" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="info">
				<span class="date"><?php the_time(__('F jS, Y', 'inove')) ?></span>
				<div class="act">
					<span class="comments"><?php comments_popup_link(__('No comments', 'inove'), __('1 comment', 'inove'), __('% comments', 'inove')); ?></span>
					<?php edit_post_link(__('Edit', 'inove'), '<span class="editpost">', '</span>'); ?>
					<div class="fixed"></div>
				</div>
				<div class="fixed"></div>
			</div>
			<div class="content">
				<?php the_content(__('Read more...', 'inove')); ?>
				<p class="under">
					<span class="categories"><?php the_category(', '); ?></span>
					<span class="tags"><?php the_tags('', ', ', ''); ?></span>
				</p>
				<div class="fixed"></div>
			</div>
		</div>
	<?php endwhile; ?>

<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<div id="pagenavi">
	<?php if(function_exists('wp_pagenavi')) : ?>
		<?php wp_pagenavi() ?>
	<?php else : ?>
		<span class="newer"><?php previous_posts_link(__('Newer Entries', 'inove')); ?></span>
		<span class="older"><?php next_posts_link(__('Older Entries', 'inove')); ?></span>
	<?php endif; ?>
	<div class="fixed"></div>
</div>
</div>
<?php get_footer(); ?>
