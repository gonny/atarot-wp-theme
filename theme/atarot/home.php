<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>
<!-- heading START -->

<div id="heading"><h2>Vítejte na magických stránkách Atarot</h2></div>
<!-- heading END-->
<!-- innerContent START-->
<div id="innerContent">
  <?php if (!empty($options['notice']) && !empty($options['notice_content'])) : ?>
  <div class="post" id="notice">
    <div class="content"> <?php echo($options['notice_content']); ?>
      <div class="fixed"></div>
    </div>
  </div>
  <?php endif; ?>
  <div>
    <?php
 $lastposts = get_posts('numberposts=10');
if(!empty($lastposts))
{
 foreach($lastposts as $lastpost) :
    setup_postdata($GLOBALS['post'] =& $lastpost);
 ?>
 <div class="post" id="post-<?php the_ID(); ?>">
     <h2><a class="title" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
         <div class="home">
				<?php the_content(__('Read more...', 'inove')); ?>
                <div class="fixed"></div>
            </div>
        
	</div>
    <?php endforeach; 
    wp_reset_postdata();
}?>
  </div>
</div>
<!--
https://codex.wordpress.org/Template_Hierarchy
https://codex.wordpress.org/Category:Template_Tags
https://codex.wordpress.org/Function_Reference
-->
<?php get_footer(); ?>
