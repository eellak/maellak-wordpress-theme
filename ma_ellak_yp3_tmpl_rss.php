<?php
/**
 * Template Name: Characteristic Feeds
 * RSS2 Feed Template for displaying RSS2 Document Revisions feed.
 */


global $ma_prefix;
	$software_post;
	$software_id = 0;
	if(isset($_GET['sid']) and $_GET['sid'] !='' and  $_GET['sid'] !=-1){
		$software_post = get_post(intval($_GET['sid']));
		if(!empty($software_post) and 'software' == $software_post->post_type){ 
			$software_id =intval($_GET['sid']);
		}
	}
	
	$args = array(
		'posts_per_page' =>-1,
		'post_type' => 'characteristic',
		'post_status' => 'publish', 

	);
	
	$args['meta_query'] = array();
	
	// Viewing for certain Software only
	if($software_id != 0){
		$args['meta_query'] = array(
			array(
				'key' => $ma_prefix.'for_software',
				'value' => $software_id,
			)
		);
	}
	
	$my_query = new WP_Query($args);

@header( 'Content-Type: ' . feed_content_type( 'rss-http' ) . '; charset=' . get_option( 'blog_charset' ), true );

echo '<?xml version="1.0" encoding="'.get_option( 'blog_charset' ).'"?'.'>'; ?>

<rss version="2.0"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"
	<?php do_action( 'rss2_ns '); ?>>
<channel>
	<title><?php bloginfo_rss( 'name' ); wp_title_rss(); ?></title>
	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />
	<link><?php bloginfo_rss( 'url' ) ?></link>
	<description><?php bloginfo_rss( 'description' ) ?></description>
	<lastBuildDate><?php echo mysql2date( 'D, d M Y H:i:s +0000', get_lastpostmodified( 'GMT' ), false ); ?></lastBuildDate>
	<language><?php echo get_option( 'rss_language' ); ?></language>
	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>
	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>
	<?php do_action( 'rss2_head' );

	while ($my_query->have_posts()) : $my_query->the_post();
		$cid= get_the_ID();
		$post = get_post($cid);
	
		$date_u=get_the_time('Y-m-d H:i:s', $cid);
		$pubDate=mysql2date( 'D, d M Y H:i:s +0000', $date_u, false );
		$unit_id = get_post_meta($cid, '_ma_ellak_belongs_to_unit', true);
		$unit_title=get_the_title($cid);
		$description = $post->post_content;
		$thematic=ma_ellak_return_thema_rss($doc_id,'thema');
	?>	
		<item>
			<title><?php echo get_the_title(); ?></title>
			<link><?php echo get_permalink($cid); ?></link>
			<pubDate><?php echo $pubDate; ?></pubDate>
			<dc:creator><?php echo $unit_title; ?></dc:creator>
			<category><![CDATA[<?php echo $thematic; ?>]]></category>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<description><![CDATA[<?php echo $description; ?>]]></description>
			<?php do_action( 'rss2_item' ); ?>
		</item>
	<?php
			endwhile;
	?>
</channel>
</rss>