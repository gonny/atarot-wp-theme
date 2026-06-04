<div id="sidebar-left">
<!-- menu START -->
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('menu_sidebar') ) : ?>
<div id="menu">
	<?php 
    $categs = get_categories('orderby=order&order=ASC&hide_empty=1&hierarchical=1');
    $order = array();
	foreach($categs as $cat)
	{
		if($cat->category_parent == 0)
		{
			$categories1[$cat->cat_ID]['main'] = $cat;
            $order[$cat->term_order] = $cat->cat_ID;
		}
		else
		{
			$categories1[$cat->category_parent]['sub'][] = $cat;
		}
		
	}
	unset($categs);
echo "<ul>";
foreach($order as $o)
{
    $cat = $categories1[$o];
    //print_r($categories1[$o]);
    echo "<li><h2><a href=\"".get_category_link($cat['main']->cat_ID)."\">".$cat['main']->name."</a></h2>";
    unset($categories1[$o]['main']);
    echo "<ul>";
    if(!empty($categories1[$o]['sub']))
    {
        foreach($categories1[$o]['sub'] as $sub)
        {
	        echo "<li><h3><a href=\"".get_category_link($sub->cat_ID)."\">".$sub->name."</a></h3></li>\n";
        //	$wpdb->show_errors();
        }
    }
	$sql = ("SELECT $wpdb->posts.* FROM $wpdb->posts 
	 	LEFT JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) 
		INNER JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id) 
			WHERE 1=1 
				AND $wpdb->term_taxonomy.taxonomy = 'category' 
				AND $wpdb->term_taxonomy.term_id IN ('".$cat['main']->cat_ID."') 
				AND $wpdb->posts.post_type = 'post' 
				AND ($wpdb->posts.post_status = 'publish') 
					ORDER BY $wpdb->posts.post_date DESC LIMIT 0, 5");
	$posty = $wpdb->get_results($sql);

//	$posty = get_posts('category='.$cat['main']->cat_ID);
	if(!empty($posty))
	{
		foreach($posty as $p)
		{
			echo "<li><h3><a href=\"".get_permalink($p->ID)."\">".$p->post_title."</a></h3></li>\n";
		}
	}
	echo "</ul>";
	echo "</li>";
}
//wp_list_bookmarks();
unset($categories1,$posty);

if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('menu_sidebar_dole') ) : 
endif;
echo "</ul>"; ?>
</div>
<?php endif; 

//wp_list_categories('orderby=order&hide_empty=1&hierarchical=1');
?>
<!-- menu END -->

<p class="center" style="display:none">
 <a href="https://www.toplist.cz/stat/241246">
                <script type="text/javascript"><!--

document.write ('<img src="https://toplist.cz/count.asp?id=241246&amp;logo=mc&amp;http='+escape(document.referrer)+'&amp;amp;wi='+escape(window.screen.width)+'&amp;he='+escape(window.screen.height)+'&amp;cd='+escape(window.screen.colorDepth)+'&amp;t='+escape(document.title)+'" width="88" height="60" border="0" alt="TOPlist" />');
//-->
                </script>
                </a>
    </p>

</div>