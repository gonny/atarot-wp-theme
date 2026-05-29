<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>
<!-- heading START -->

<div id="heading"><?php the_title(); ?></div>
<!-- heading END-->
<!-- innerContent START-->
<div id="innerContent">
  <?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
  <div class="post page" id="post-<?php the_ID(); ?>">
    <h2>
      <?php the_title(); ?>
    </h2>
    <div class="content">
      <?php the_content(); ?>
      <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
      <br />
      <div class="fixed"></div>
      <div class="messagebox">
        <div class="info home">
        	<span class="date">
          <?php the_time(__('j. F  Y H:i')); ?>
          </span>
          <div class="act">
            <?php edit_post_link(__('Edit'), '<span class="editpost">', '</span>'); ?>
             <span class="editpost"><?php _e("Author:"); echo " "; the_author_posts_link();?></span>
          </div>
        </div>
        <div class="fixed"></div>
      </div>
    </div>
  </div>
  <?php else : ?>
  <div class="errorbox">
    <?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
  </div>
  <?php endif; ?>
  <?php comments_template(); ?>
</div>
<?php get_footer(); ?>
