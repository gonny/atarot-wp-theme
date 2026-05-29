<?php
/*
Template Name: karty-zobrazeni
*/
?>
<?php if(!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['random'])):
	get_header();
	$options = get_option('inove_options'); 
?>

			<!-- heading START -->
  		<div id="heading"><h1><?php the_title(); ?></h1></div>
  			<!-- heading END-->
  			<!-- innerContent START-->
        <div id="innerContent">

<?php if (have_posts()) : the_post(); update_post_caches($posts); endif;?>

	<div class="post" id="post-<?php the_ID(); ?>">
<? endif; //end if ?>
		<div class="content">
		<?php
			require(dirname(__FILE__)."/../../plugins/karty/content/card_show.php");
		?>
         <div class="fixed"></div>
		</div>

<?php  
if(!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['random'])):

	echo "</div>";
	get_footer(); 
endif; 
?>