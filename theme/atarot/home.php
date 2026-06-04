<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>
<!-- heading START -->

<div id="heading"><h2>Vítejte na magických stránkách Atarot</h2></div>
<!-- heading END-->
<!-- innerContent START-->
<div id="innerContent">
  <?php if ($options['notice'] && $options['notice_content']) : ?>
  <div class="post" id="notice">
    <div class="content"> <?php echo($options['notice_content']); ?>
      <div class="fixed"></div>
    </div>
  </div>
  <?php endif; ?>
  <div>
    <?php
 $lastposts = get_posts('numberposts=10');
// print_r($lastposts);
if(!empty($lastposts))
{
 foreach($lastposts as $post) :
    setup_postdata($post);
 ?>
 <div class="post" id="post-<?php the_ID(); ?>">
     <h2><a class="title" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<!--<div class="info">
				<div class="act author">
            <? //edit_post_link(__('Edit'), '<span class="editpost">', '</span>'); ?>
				  <?php //the_time(__('j. F  Y | H:i')); echo " - ";  the_author_posts_link();
					//edit_post_link(__('Edit'), '<span class="editpost">', '</span>'); ?>
				</div>
				<div class="fixed"></div>
			</div>-->
         	<div class="home">
				<?php the_content(__('Read more...', 'inove')); ?>
                <div class="fixed"></div>
            </div>
            <!--<div class="under">
            <span class="categories"><?php //the_category(', '); ?></span>
            </div>-->
            
		</div>
    <?php endforeach; 
}?>
  </div>
</div>
<!--
https://codex.wordpress.org/Template_Hierarchy
https://codex.wordpress.org/Category:Template_Tags
https://codex.wordpress.org/Function_Reference
-->
<?php get_footer(); ?>
