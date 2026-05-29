<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>
			<!-- heading START -->
  		<div id="heading">
      	<h3>
        	<?php
	// If this is a category archive
	if (is_category()) {
		printf( __('Archive for the &#8216;%1$s&#8217; Category', 'inove'), single_cat_title('', false) );
	// If this is a tag archive
	} elseif(is_tag()) {
		printf( __('Posts Tagged &#8216;%1$s&#8217;', 'inove'), single_tag_title('', false) );
	// If this is a daily archive
	} elseif (is_day()) {
		printf( __('Archive for %1$s', 'inove'), get_the_time(__('F jS, Y', 'inove')) );
	// If this is a monthly archive
	} elseif (is_month()) {
		printf( __('Archive for %1$s', 'inove'), get_the_time(__('F, Y', 'inove')) );
	// If this is a yearly archive
	} elseif (is_year()) {
		printf( __('Archive for %1$s', 'inove'), get_the_time(__('Y', 'inove')) );
	// If this is an author archive
	} elseif (is_author()) {
		_e('Author Archive', 'inove');
	// If this is a paged archive
	} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
		_e('Blog Archives', 'inove');
	}
	?></h3>
     </div>
 			<!-- heading END-->
  			<!-- innerContent START-->
        <div id="innerContent">
<?php if (have_posts()) : ?>
    
	<?php 
    echo '<div class="reklama af" id="adaf"><script type="text/javascript"><!--
    google_ad_client = "ca-pub-7383489556823532";/* 468x60, vytvořeno 10.10.09 */google_ad_slot = "6155031655";google_ad_width = 468;google_ad_height = 60;//--></script>
    <script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js"></script></div>';
//    echo '<div class="reklama gg" id="adgg"><script type="text/javascript"><!--
//google_ad_client = "pub-7383489556823532"; /* Multiple Reading 468x60 */ google_ad_slot = "2805343663"; google_ad_width = 468; google_ad_height = 60;
//--></script><script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script></div>';
    while (have_posts()) : the_post(); update_post_caches($posts); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a class="title" href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<div class="home">
            <div class="info">
				<span class="date"><?php the_time(__('j. F  Y H:i')) ?></span>
				<div class="act">
				<!--<span class="comments"><?php //comments_popup_link(__('No comments', 'inove'), __('1 comment', 'inove'), __('% comments', 'inove')); ?></span>-->
               <div class="act author"><?php edit_post_link(__('Edit'), '<span class="editpost">', '</span>'); ?>
					<?php _e("Author"); echo ": "; the_author_posts_link(); ?></div>
					<div class="fixed"></div>
				</div>
				<div class="fixed"></div>
			</div>
         	
				<?php the_content(__('Read more...', 'inove')); ?>
                <div class="under alignleft">
                    <span class="categories alignleft"><?php the_category(', '); ?></span>
                    <span class="tags alignleft"><?php the_tags('', ', ', ''); ?></span>
                </div>
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
		<?php wp_pagenavi(); ?>
	<?php else : ?>
		<span class="newer"><?php previous_posts_link(__('Newer Entries', 'inove')); ?></span>
		<span class="older"><?php next_posts_link(__('Older Entries', 'inove')); ?></span>
	<?php endif; ?>
	<div class="fixed"></div>
</div>
</div>
<?php get_footer(); ?>
