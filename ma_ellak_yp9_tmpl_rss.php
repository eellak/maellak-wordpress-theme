<?php
/**
 * Template Name: Documents Feeds
 * RSS2 Feed Template for displaying RSS2 Document Revisions feed.
 */

global $post, $wpdr;
if ( !$wpdr )
	$wpdr = &Document_Revisions::$instance;

$args=ma_ellak_documents_all_query(-1);
$documents=get_documents( $args, false);

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

	foreach ( $documents as $document ){
		$doc_id=$document->ID;
		$title=get_the_title($doc_id);
	
		$date_u=get_the_time('Y-m-d H:i:s', $doc_id);
		$pubDate=mysql2date( 'D, d M Y H:i:s +0000', $date_u, false );
	
		$unit_id = get_post_meta($post_id, '_ma_ellak_belongs_to_unit', true);
		$unit_title=get_the_title($unit_id);
		$latest_version = $wpdr->get_latest_revision( $doc_id );
		$description=html_entity_decode( $latest_version->post_excerpt );
		$thematic=ma_ellak_return_thema_rss($doc_id,'thema');
	?>	
		<item>
			<title><?php echo $title; ?></title>
			<link><?php echo doc_permalink($doc_id); ?></link>
			<pubDate><?php echo $pubDate; ?></pubDate>
			<dc:creator><?php echo $unit_title; ?></dc:creator>

			<category><![CDATA[<?php echo $thematic; ?>]]></category>
			<guid isPermaLink="false"><?php the_guid(); ?></guid>
			<description><![CDATA[<?php echo $description; ?>]]></description>
			<?php do_action( 'rss2_item' ); ?>
		</item>
	<?php
	}
	?>
</channel>
</rss>