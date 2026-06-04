<?php get_header(); ?>
<?php $options = get_option('inove_options'); ?>

			<!-- heading START -->
  		<div id="heading"><h1><?php the_title(); ?></h1></div>
  			<!-- heading END-->
  			<!-- innerContent START-->
        <div id="innerContent">
        
<?php if (have_posts()) : the_post(); ?>
	<div id="postpath">
		 <?php the_category(', '); ?>
		 &gt; <?php the_title(); ?>
	</div>

	<div class="post single" id="post-<?php the_ID(); ?>">
		<div class="content">
			<?php 
                $str = apply_filters('the_content', get_the_content());
                if(!in_array(get_the_id(), array(335,1108,1525,1482)))
                {
                    preg_match_all("@<p.*?</p>@iS", $str ,$matches);
                    $i = 4;
                    $count = 0;
                    $adg = atarot_get_adsense_markup();
                    $adf = '<div class="reklama af" id="adaf"><script type="text/javascript">//<![CDATA[
document.write(\'<\'+\'iframe width="468" height="60" frameborder="0" style="width:468;height:60;border:none" scrolling="no" src="https://ad.adfox.cz/utf/ppcbe?js=0&amp;charset=utf&amp;format=ffffffffffff3366ff00000033996658&amp;partner=6974&amp;stranka=\'+location.href+\'"><\'+\'/iframe>\'); //]]></script></div>';
                    $m = sizeof($matches[0])-1;
                    while($i < $m && $count < 3)
                    {
                        $ad = $adg; //($ad == $adg) ? $adf : $adg;
                        if(!strpos($matches[0][$i],"http"))
                        {
                            $str = str_replace($matches[0][$i], $matches[0][$i]."$ad", $str);
                            $i += 9;
                            $count++;
                        }
                        else
                        {
                            $str = str_replace($matches[0][$i-1], $matches[0][$i-1]."$ad", $str);
                            $i += 10;
                            $count++;
                        }
                        $i++;
                    }
                    /*for($i = 6; $i < sizeof($matches[0]); $i+=6)
                    {
                        $str = str_replace($matches[0][$i], $matches[0][$i]."<hr /><div class=\"innerAd\">Advertisemenet $i</div><hr />", $str);
                    } */  
                }
                echo $str;

			?>
         <div class="fixed"></div>
      <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			<p class="act author">
				<?php _e("Author:"); echo " "; the_author_posts_link();?>
      </p><br /><br />
      <div class="boxcaption"><p class="under">
      			<?php if ($options['categories']) : ?><span class="categories"><?php the_category(', '); ?></span><?php endif; ?>
				<?php if ($options['tags']) : ?><span class="tags"><?php the_tags('', ', ', ''); ?></span><?php endif; ?>
		      </p><div class="fixed"></div></div>
              
		<div class="box">
      <div class="info">
			<span class="date"><?php the_time(__('j. F  Y H:i')); ?></span>
			<div class="act">
				<?php edit_post_link(__('Edit'), '<span class="editpost">', '</span>'); ?>
			</div>
<!--            <cite><?php //echo strtoupper(get_the_author_lastname()).", ". get_the_author_firstname().". "; the_title(); echo "[online]."; the_time(__('j. F  Y')); the_modified_time(__('j. F  Y')); echo "[cit. ".date("Y-m-d")."] Dostupný z WWW: &lt;".get_permalink()."&gt;";?>
            </cite>
-->            </div>
			<div class="fixed"></div>
		</div>
		</div>
	</div>
<?php else : ?>
	<div class="errorbox">
		<?php _e('Sorry, no posts matched your criteria.', 'inove'); ?>
	</div>
<?php endif; ?>

<!-- related posts START -->
<?php
	// when related posts with title
	if(function_exists('wp23_related_posts')) {
		echo '<div id="related_posts">';
		wp23_related_posts();
		echo '</div>';
		echo '<div class="fixed"></div>';
	}
	/*
	// when related posts without title
	if(function_exists('wp23_related_posts')) {
		echo '<div class="boxcaption">';
		echo '<h3>Related Posts</h3>';
		echo '</div>';
		echo '<div id="related_posts" class="box">';
		wp23_related_posts();
		echo '</div>';
		echo '<div class="fixed"></div>';
	}
	*/
?>
<!-- related posts END -->

<?php
	// Support comments for WordPress 2.7 or higher
	if (function_exists('wp_list_comments')) {
		comments_template('', true);
	} else {
		comments_template();
	}
?>
<div id="postnavi">
	<span class="prev"><?php next_post_link('%link') ?></span>
	<span class="next"><?php previous_post_link('%link') ?></span>
	<div class="fixed"></div>
</div>
</div>

<?php get_footer(); ?>
