<?php
/*
 * Template Name: Documents Atom
 */
/**
 * Atom Feed Template for displaying Atom Posts feed.
 *
 * @package WordPress
 */

header('Content-Type: ' . feed_content_type('atom') . '; charset=' . get_option('blog_charset'), true);
$more = 1;

echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>
<feed
  xmlns="http://www.w3.org/2005/Atom"
  xmlns:thr="http://purl.org/syndication/thread/1.0"
  xml:lang="<?php bloginfo_rss( 'language' ); ?>"
  xml:base="<?php bloginfo_rss('url') ?>/wp-atom.php"
  <?php do_action('atom_ns'); ?>
 >
	<title type="text"><?php bloginfo_rss('name'); wp_title_rss(); ?></title>
	<subtitle type="text"><?php bloginfo_rss("description") ?></subtitle>

	<updated><?php echo mysql2date('Y-m-d\TH:i:s\Z', get_lastpostmodified('GMT'), false); ?></updated>

	<link rel="alternate" type="<?php bloginfo_rss('html_type'); ?>" href="<?php bloginfo_rss('url') ?>" />
	<id><?php bloginfo('atom_url'); ?></id>
	<link rel="self" type="application/atom+xml" href="<?php self_link(); ?>" />

	<?php do_action('atom_head'); ?>
	<?php 
	global $post, $wpdr;
	if ( !$wpdr )
		$wpdr = &Document_Revisions::$instance;

	$args=ma_ellak_documents_all_query(-1);
	$documents=get_documents( $args, false);?>

	<?php 
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
		$author=get_the_author_meta('display_name', $latest_version->post_author);
		$link=doc_permalink( $doc_id );
		$id=home_url() ."/?p=". $doc_id;
	?>
	<entry>
		<author>
			<name><?php echo $author; ?></name>
			<?php do_action('atom_author'); ?>
		</author>
		<title type="html"><![CDATA[<?php echo $title; ?>]]></title>
		<link rel="alternate" type="text/html" href="<?php echo $link; ?>" />
		<id><?php echo $id; ?></id>
		<updated><?php echo $pubDate; ?></updated>
		<published><?php echo $pubDate; ?></published>

		<?php
			for ($i=0; $i<count($thematic); $i++)
				echo "<category term=\"$thematic[$i]\"/>";
		?>
				
		<summary type="html"><![CDATA[<?php echo $description; ?>]]></summary>
		<content type="html" xml:base="<?php echo $link; ?>"><![CDATA[<?php echo $description;?>]]></content>
		<link rel="replies" type="text/html" href="" thr:count="0"/>
		<link rel="replies" type="application/atom+xml" href="" thr:count="0"/>
		<thr:total>0</thr:total>
	</entry>
	<?php }?>
</feed>
