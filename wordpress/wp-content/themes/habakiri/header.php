<?php
/**
 * Version    : 1.2.0
 * Author     : inc2734
 * Author URI : http://2inc.org
 * Created    : April 17, 2015
 * Modified   : August 30, 2015
 * License    : GPLv2 or later
 * License URI: license.txt
 */
if (empty($_SERVER['HTTPS'])) {
    header( "HTTP/1.1 301 Moved Permanently" ); 
    header("Location: https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head prefix="og: http://ogp.me/ns# <?php echo ( is_single() || is_page() ) ? 'fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#' : 'fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#' ?>">
<!-- ここからTwitterCard -->
<meta name="twitter:site" content="@blueb">
<meta name="twitter:card" content="summary">
<!-- ここからOGP -->
<meta property="og:type" content="blog">
<?php
if (is_single()){//単一記事ページの場合
if(have_posts()): while(have_posts()): the_post();
//echo '<meta property="og:description" content=" '.get_post_meta($post->ID, _aioseop_description, true).' ">';echo "\n";//抜粋を表示
//echo '<meta name="twitter:description" content=" '.get_post_meta($post->ID, _aioseop_description, true).' ">';echo "\n";//抜粋を表示
echo '<meta property="og:description" content="'; echo get_the_date(); echo '">';echo "\n";//抜粋を表示
echo '<meta name="twitter:description" content="'; echo get_the_date(); echo '">';echo "\n";//抜粋を表示
endwhile; endif;
echo '<meta property="og:title" content="'; the_title(); echo '">';echo "\n";//単一記事タイトルを表示
echo '<meta property="og:url" content="'; the_permalink(); echo '">';echo "\n";//単一記事URLを表示
echo '<meta name="twitter:title" content="'; the_title(); echo '">';echo "\n";//単一記事タイトルを表示
echo '<meta name="twitter:url" content="'; the_permalink(); echo '">';echo "\n";//単一記事URLを表示
} else {//単一記事ページページ以外の場合（アーカイブページやホームなど）
echo '<meta property="og:description" content="'; bloginfo('description'); echo '">';echo "\n";//「一般設定」管理画面で指定したブログの説明文を表示
echo '<meta name="twitter:description" content="'; bloginfo('description'); echo '">';echo "\n";//「一般設定」管理画面で指定したブログの説明文を表示
echo '<meta property="og:title" content="'; bloginfo('name'); echo '">';echo "\n";//「一般設定」管理画面で指定したブログのタイトルを表示
echo '<meta name="twitter:title" content="'; bloginfo('name'); echo '">';echo "\n";//「一般設定」管理画面で指定したブログのタイトルを表示
echo '<meta property="og:url" content="'; bloginfo('url'); echo '">';echo "\n";//「一般設定」管理画面で指定したブログのURLを表示
echo '<meta name="twitter:url" content="'; bloginfo('url'); echo '">';echo "\n";//「一般設定」管理画面で指定したブログのURLを表示
}
$str = $post->post_content;
$searchPattern = '/<img.*?src=(["\'])(.+?)\1.*?>/i';//投稿にイメージがあるか調べる
if (is_single()){//単一記事ページの場合
if (has_post_thumbnail()){//投稿にサムネイルがある場合の処理
$image_id = get_post_thumbnail_id();
$image = wp_get_attachment_image_src( $image_id, 'full');
echo '<meta property="og:image" content="'.$image[0].'">';echo "\n";
echo '<meta name="twitter:image" content="'.$image[0].'">';echo "\n";
} else if ( preg_match( $searchPattern, $str, $imgurl ) && !is_archive()) {//投稿にサムネイルは無いが画像がある場合の処理
echo '<meta property="og:image" content="'.$imgurl[2].'">';echo "\n";
echo '<meta name="twitter:image" content="'.$imgurl[2].'">';echo "\n";
} else {//投稿にサムネイルも画像も無い場合の処理
echo '<meta property="og:image" content="'; bloginfo('url'); echo '/logo.png">';echo "\n";
echo '<meta name="twitter:image" content="'; bloginfo('url'); echo '/logo.png">';echo "\n";
}
} else {//単一記事ページページ以外の場合（アーカイブページやホームなど）
echo '<meta property="og:image" content="'; bloginfo('url'); echo '/logo.png">';echo "\n";
echo '<meta name="twitter:image" content="'; bloginfo('url'); echo '/logo.png">';echo "\n";
}
?>
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<!-- ここまでOGP -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php do_action( 'habakiri_before_container' ); ?>
<div id="container">
	<?php
	$header_classes     = Habakiri::get_header_classses();
	$site_branding_size = Habakiri::get_site_branding_size();
	$gnav_size          = Habakiri::get_gnav_size();
	?>
	<header id="header" class="header <?php echo esc_attr( implode( ' ', $header_classes ) ); ?>">
		<?php do_action( 'habakiri_before_header_content' ); ?>
		<div class="container">
			<div class="row header__content">
				<div class="col-xs-10 <?php echo esc_attr( $site_branding_size ); ?> header__col">
					<?php get_template_part( 'modules/site-branding' ); ?>
				<!-- end .header__col --></div>
				<div class="col-xs-2 <?php echo esc_attr( $gnav_size ); ?> header__col global-nav-wrapper clearfix">
					<?php get_template_part( 'modules/gnav' ); ?>
					<div id="responsive-btn"></div>
				<!-- end .header__col --></div>
			<!-- end .row --></div>
		<!-- end .container --></div>
		<?php do_action( 'habakiri_after_header_content' ); ?>
	<!-- end #header --></header>
	<div id="contents">
		<?php do_action( 'habakiri_before_contents_content' ); ?>
