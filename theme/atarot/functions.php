<?php

/** inove options */
class iNoveOptions {

	static function getOptions() {
		$options = get_option('inove_options');
		if (!is_array($options)) {
			$options['description'] = '';
			$options['keywords'] = '';
			$options['google_cse'] = false;
			$options['google_cse_cx'] = '';
			$options['menu_type'] = 'pages';
			$options['notice'] = false;
			$options['notice_content'] = '';
			$options['showcase_registered'] = false;
			$options['showcase_commentator'] = false;
			$options['showcase_visitor'] = false;
			$options['showcase_caption'] = false;
			$options['showcase_title'] = '';
			$options['showcase_content'] = '';
			$options['categories'] = true;
			$options['tags'] = true;
			$options['feed'] = false;
			$options['feed_url'] = '';
			$options['feed_email'] = false;
			$options['feed_url_email'] = '';
			update_option('inove_options', $options);
		}
		return $options;
	}

	static function add() {
		if(isset($_POST['inove_save'])) {
			$options = iNoveOptions::getOptions();

			// meta
			$options['description'] = stripslashes($_POST['description'] ?? '');
			$options['keywords'] = stripslashes($_POST['keywords'] ?? '');

			// google custom search engine
			$options['google_cse'] = !empty($_POST['google_cse']);
			$options['google_cse_cx'] = stripslashes($_POST['google_cse_cx'] ?? '');

			// menu
			$options['menu_type'] = stripslashes($_POST['menu_type'] ?? 'pages');

			// notice
			$options['notice'] = !empty($_POST['notice']);
			$options['notice_content'] = stripslashes($_POST['notice_content'] ?? '');

			// showcase
			$options['showcase_registered'] = !empty($_POST['showcase_registered']);
			$options['showcase_commentator'] = !empty($_POST['showcase_commentator']);
			$options['showcase_visitor'] = !empty($_POST['showcase_visitor']);
			$options['showcase_caption'] = !empty($_POST['showcase_caption']);
			$options['showcase_title'] = stripslashes($_POST['showcase_title'] ?? '');
			$options['showcase_content'] = stripslashes($_POST['showcase_content'] ?? '');

			// categories & tags
			$options['categories'] = !empty($_POST['categories']);
			$options['tags'] = !empty($_POST['tags']);

			// feed
			$options['feed'] = !empty($_POST['feed']);
			$options['feed_url'] = stripslashes($_POST['feed_url'] ?? '');
			$options['feed_email'] = !empty($_POST['feed_email']);
			$options['feed_url_email'] = stripslashes($_POST['feed_url_email'] ?? '');

			update_option('inove_options', $options);

		} else {
			iNoveOptions::getOptions();
		}

		add_theme_page("Current Theme Options", "Current Theme Options", 'edit_themes', basename(__FILE__), array('iNoveOptions', 'display'));
	}

	static function display() {
		$options = iNoveOptions::getOptions();
?>

<form action="#" method="post" enctype="multipart/form-data" name="inove_form" id="inove_form">
	<div class="wrap">
		<h2><?php _e('Current Theme Options', 'inove'); ?></h2>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Meta', 'inove'); ?></th>
					<td>
						<?php _e('Description:', 'inove'); ?>
						<br/>
						<input type="text" name="description" id="description" class="code" style="width:98%;" value="<?php echo($options['description']); ?>">
						<br/>
						<?php _e('Keywords:', 'inove'); ?> <small><?php _e('( Separate keywords with commas )', 'inove'); ?></small>
						<br/>
						<input type="text" name="keywords" id="keywords" class="code" style="width:98%;" value="<?php echo($options['keywords']); ?>">
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Search', 'inove'); ?></th>
					<td>
						<label>
							<input name="google_cse" type="checkbox" value="checkbox" <?php if($options['google_cse']) echo "checked='checked'"; ?> />
							 <?php _e('Using google custom search engine.', 'inove'); ?>
						</label>
						<br/>
						<?php _e('CX:', 'inove'); ?>
						 <input type="text" name="google_cse_cx" id="google_cse_cx" class="code" size="40" value="<?php echo($options['google_cse_cx']); ?>">
						<br/>
						<?php _e('Find <code>name="cx"</code> in the <strong>Search box code</strong> of <a href="https://www.google.com/coop/cse/">Google Custom Search Engine</a>, and type the <code>value</code> here.<br/>For example: <code>014782006753236413342:1ltfrybsbz4</code>', 'inove'); ?>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Menubar', 'inove'); ?></th>
					<td>
						<label style="margin-right:20px;">
							<input name="menu_type" type="radio" value="pages" <?php if($options['menu_type'] != 'categories') echo "checked='checked'"; ?> />
							 <?php _e('Show pages as menu.', 'inove'); ?>
						</label>
						<label>
							<input name="menu_type" type="radio" value="categories" <?php if($options['menu_type'] == 'categories') echo "checked='checked'"; ?> />
							 <?php _e('Show categories as menu.', 'inove'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Notice', 'inove'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'inove'); ?></small>
					</th>
					<td>
						<!-- notice START -->
						<label>
							<input name="notice" type="checkbox" value="checkbox" <?php if($options['notice']) echo "checked='checked'"; ?> />
							 <?php _e('This notice bar will display at the top of posts on homepage.', 'inove'); ?>
						</label>
						<br />
						<label>
							<textarea name="notice_content" id="notice_content" cols="50" rows="10" style="width:98%;font-size:12px;" class="code"><?php echo($options['notice_content']); ?></textarea>
						</label>
						<!-- notice END -->
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<?php _e('Showcase', 'inove'); ?>
						<br/>
						<small style="font-weight:normal;"><?php _e('HTML enabled', 'inove'); ?></small>
					</th>
					<td>
						<!-- showcase START -->
						<label><?php _e('This showcase will display at the top of sidebar.', 'inove'); ?></label>
						<br/>
						<label><?php _e('Who can see?', 'inove'); ?></label>
						<label style="margin-left:10px;">
							<input name="showcase_registered" type="checkbox" value="checkbox" <?php if($options['showcase_registered']) echo "checked='checked'"; ?> />
							 <?php _e('Registered Users', 'inove'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_commentator" type="checkbox" value="checkbox" <?php if($options['showcase_commentator']) echo "checked='checked'"; ?> />
							 <?php _e('Commentator', 'inove'); ?>
						</label>
						<label style="margin-left:10px;">
							<input name="showcase_visitor" type="checkbox" value="checkbox" <?php if($options['showcase_visitor']) echo "checked='checked'"; ?> />
							 <?php _e('Visitors', 'inove'); ?>
						</label>
						<br/>
						<label>
							<input name="showcase_caption" type="checkbox" value="checkbox" <?php if($options['showcase_caption']) echo "checked='checked'"; ?> />
							 <?php _e('Title:', 'inove'); ?>
						</label>
						 <input type="text" name="showcase_title" id="showcase_title" class="code" size="40" value="<?php echo($options['showcase_title']); ?>">
						<br/>
						<label>
							<textarea name="showcase_content" id="showcase_content" cols="50" rows="10" style="width:98%;font-size:12px;" class="code"><?php echo($options['showcase_content']); ?></textarea>
						</label>
						<!-- showcase END -->
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Categories & Tags', 'inove'); ?></th>
					<td>
						<label style="margin-right:20px;">
							<input name="categories" type="checkbox" value="checkbox" <?php if($options['categories']) echo "checked='checked'"; ?> />
							 <?php _e('Show categories on posts.', 'inove'); ?>
						</label>
						<label>
							<input name="tags" type="checkbox" value="checkbox" <?php if($options['tags']) echo "checked='checked'"; ?> />
							 <?php _e('Show tags on posts.', 'inove'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><?php _e('Feed', 'inove'); ?></th>
					<td>
						<label>
							<input name="feed" type="checkbox" value="checkbox" <?php if($options['feed']) echo "checked='checked'"; ?> />
							 <?php _e('Custom feed.', 'inove'); ?>
						</label>
						<br/>
						<?php _e('URL:', 'inove'); ?> <input type="text" name="feed_url" id="feed_url" class="code" size="60" value="<?php echo($options['feed_url']); ?>">
						<br/>
						<label>
							<input name="feed_email" type="checkbox" value="checkbox" <?php if($options['feed_email']) echo "checked='checked'"; ?> />
							 <?php _e('Email feed.', 'inove'); ?>
						</label>
						<br/>
						<?php _e('URL:', 'inove'); ?> <input type="text" name="feed_url_email" id="feed_url_email" class="code" size="60" value="<?php echo($options['feed_url_email']); ?>">
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit">
			<input class="button-primary" type="submit" name="inove_save" value="<?php _e('Save Changes', 'inove'); ?>" />
		</p>
	</div>

</form>

<?php
	}
}

// register functions
add_action('admin_menu', array('iNoveOptions', 'add'));

function atarot_theme_setup() {
	add_theme_support('title-tag');
	add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));
	add_theme_support('yoast-seo-breadcrumbs');
}
add_action('after_setup_theme', 'atarot_theme_setup');

function atarot_has_yoast_seo() {
	return function_exists('yoast_breadcrumb');
}

function atarot_normalize_https_url($url) {
	$url = trim((string) $url);
	if ($url === '') {
		return '';
	}

	if (!preg_match('#^https?://#i', $url)) {
		return 'https://' . ltrim($url, '/');
	}

	return preg_replace('#^http://#i', 'https://', $url);
}

function atarot_get_feed_url() {
	$options = get_option('inove_options');
	if (!empty($options['feed']) && !empty($options['feed_url'])) {
		return atarot_normalize_https_url($options['feed_url']);
	}

	return get_bloginfo('rss2_url');
}

function atarot_render_breadcrumbs() {
	if (!atarot_has_yoast_seo() || is_front_page() || is_home()) {
		return;
	}

	yoast_breadcrumb('<div id="breadcrumbs" class="breadcrumbs">', '</div>');
}

function atarot_get_adsense_markup($slot = '6155031655', $extra_class = 'gg') {
	return '<div class="reklama ' . esc_attr($extra_class) . '" id="ad-' . esc_attr($slot) . '"><ins class="adsbygoogle" style="display:block" data-ad-client="ca-pub-7383489556823532" data-ad-slot="' . esc_attr($slot) . '" data-ad-format="horizontal" data-full-width-responsive="true"></ins><script>(adsbygoogle = window.adsbygoogle || []).push({});</script></div>';
}

function atarot_output_adsense_loader() {
	echo '<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7383489556823532" crossorigin="anonymous"></script>';
}
add_action('wp_head', 'atarot_output_adsense_loader', 1);

function atarot_output_analytics() {
	?>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-P2DC7FS9TX"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', 'G-P2DC7FS9TX');
</script>
	<?php
}
add_action('wp_head', 'atarot_output_analytics', 2);


/** l10n */
function theme_init(){
	load_theme_textdomain('inove', get_template_directory() . '/languages');
}
add_action ('init', 'theme_init');

/** widgets */
if( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'menu_sidebar',
		'id' => 'sidebar-1',
		'before_widget' => '<div id="menu">',
		'after_widget' => '</div>',
		'before_title' => '<ul><li><h3>',
		'after_title' => '</h3></li></ul>'
	));
	register_sidebar(array(
		'name' => 'north_sidebar',
		'id' => 'sidebar-2',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'south_sidebar',
		'id' => 'sidebar-3',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'west_sidebar',
		'id' => 'sidebar-4',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'east_sidebar',
		'id' => 'sidebar-5',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'links_sidebar',
		'id' => 'sidebar-6',
		'before_widget' => '<div id="links" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
    register_sidebar(array(
        'name' => 'menu_sidebar_dole',
        'id' => 'sidebar-7',
        'before_widget' => '<li>',
        'after_widget' => '',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));
    
    
}

/** Comments */
if (function_exists('wp_list_comments')) {
	// comment count
	add_filter('get_comments_number', 'comment_count', 0);
	function comment_count( $commentcount ) {
		$post_id = get_the_ID();
		if (!$post_id) {
			return $commentcount;
		}
		$_comments = get_comments('post_id=' . $post_id);
		$comments_by_type = separate_comments($_comments);
		return count($comments_by_type['comment']);
	}
}

// custom comments
function custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if (empty($commentcount)) {
		$commentcount = 0;
	}

	// E-mail autora prispevku (nahrazuje odstranenou get_the_author_email()).
	$post_author_email = '';
	$current_post = get_post($comment->comment_post_ID);
	if ($current_post) {
		$post_author_email = get_the_author_meta('user_email', $current_post->post_author);
	}
	$is_admin_comment = ($post_author_email && $comment->comment_author_email === $post_author_email);
?>
	<li class="comment <?php echo $is_admin_comment ? 'admincomment' : 'regularcomment'; ?>" id="comment-<?php comment_ID() ?>">
		<div class="author">
			<div class="pic">
				<?php if (function_exists('get_avatar') && get_option('show_avatars')) { echo get_avatar($comment, 32); } ?>
			</div>
			<div class="name">
				<?php if (get_comment_author_url()) : ?>
					<a id="commentauthor-<?php comment_ID() ?>" href="<?php comment_author_url() ?>">
				<?php else : ?>
					<span id="commentauthor-<?php comment_ID() ?>">
				<?php endif; ?>

				<?php comment_author(); ?>

				<?php if(get_comment_author_url()) : ?>
					</a>
				<?php else : ?>
					</span>
				<?php endif; ?>
			</div>
		</div>

		<div class="info">
			<div class="date">
				<?php printf( __('%1$s at %2$s', 'inove'), get_comment_time(__('F jS, Y', 'inove')), get_comment_time(__('H:i', 'inove')) ); ?>
					 | <a href="#comment-<?php comment_ID() ?>"><?php printf('#%1$s', ++$commentcount); ?></a>
			</div>
			<div class="act">
				<a href="javascript:void(0);" onclick="MGJS_CMT.reply('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'comment');"><?php _e('Reply', 'inove'); ?></a> | 
				<a href="javascript:void(0);" onclick="MGJS_CMT.quote('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'commentbody-<?php comment_ID() ?>', 'comment');"><?php _e('Quote', 'inove'); ?></a>
				<?php
					if (function_exists("qc_comment_edit_link")) {
						qc_comment_edit_link('', ' | ', '', __('Edit', 'inove'));
					}
					edit_comment_link(__('Advanced edit', 'inove'), ' | ', '');
				?>
			</div>
			<div class="fixed"></div>
			<div class="content">
				<?php if ($comment->comment_approved == '0') : ?>
					<p><small><?php _e('Your comment is awaiting moderation.', 'inove'); ?></small></p>
				<?php endif; ?>

				<div id="commentbody-<?php comment_ID() ?>">
					<?php comment_text(); ?>
				</div>
			</div>
		</div>
		<div class="fixed"></div>
	</li>
<?php
}
?>
