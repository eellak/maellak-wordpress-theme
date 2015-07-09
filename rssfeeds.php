<?php
/*

 Template Name: RssFeeds

*/

get_header();

?>
 <div class="row-fluid">
  	<div class="span8">
  	<?php _e('Το ακρωνύμιο RSS, από τον αγγλικό όρο Really Simple Syndication (Πολύ Απλή Διανομή), αναφέρεται σε μία προτυποποιημένη μέθοδο ανταλλαγής ψηφιακού πληροφοριακού περιεχομένου διαμέσου του Διαδικτύου, στηριγμένη στην πρότυπη, καθιερωμένη και ευρέως υποστηριζόμενη γλώσσα σήμανσης XML. Ένας χρήστης του Διαδικτύου μπορεί έτσι να ενημερώνεται αυτομάτως για γεγονότα και νέα από όσες ιστοσελίδες υποστηρίζουν RSS, αρκεί να έχει εγγραφεί ο ίδιος συνδρομητής στην αντίστοιχη υπηρεσία της εκάστοτε ιστοσελίδας. Οι εν λόγω ενημερώσεις («ροές RSS», αγγλ: «RSS feeds») περιέχουν τα πλήρη δεδομένα, σύνοψη των δεδομένων, σχετικά μεταδεδομένα, ημερομηνία έκδοσης κλπ, ενώ αποστέλλονται αυτομάτως στον συνδρομητή μέσω Διαδικτύου.','ma-ellak');
  	?>
  	<h3><?php _e('KANAΛΙΑ RSS','ma-ellak')?></h3>
<ul class="nav">
<?php 
global $ma_ellak_content_types;
$post_types = get_post_types( '', 'names' );
$url = get_site_url()."/feeds/?custom_type=";
$documentTmplRss= get_option_tree('ma_ellak_rss_document_option_id');
$documentTmplAtom= get_option_tree('ma_ellak_atom_document_option_id');
//echo $documentTmplRss;
//echo $documentTmplAtom;
foreach ( $ma_ellak_content_types as $post_type ) {
	
	if($post_type=='job' || $post_type=='bp_doc') continue;
	
	?>

	<li class="icn">
    <?php 
		if ($post_type!='document'){
	?>
			<a href="<?php bloginfo('rss2_url'); ?>?post_type=<?php echo $post_type;?>" 
			title="<?php _e('Syndicate this site using RSS'); ?>">
	<?php
		}else if(isset($documentTmplRss) && $documentTmplRss>0){
				$link_page=get_permalink(get_option_tree('ma_ellak_rss_document_option_id'));
				echo "<a href=\"". $link_page ."\">";
		//	}
		}
	?>	

    <i class="icon-rss">
    	<?php if ($post_type=='events') _e('ΟΙ ΤΕΛΕΥΤΑΙΕΣ ΕΚΔΗΛΩΣΕΙΣ','ma-ellak');?>
    	<?php if ($post_type=='video') _e('ΤΑ ΤΕΛΕΥΤΑΙΑ VIDEO','ma-ellak');?>
    	<?php if ($post_type=='software') _e('ΛΟΓΙΣΜΙΚΟ','ma-ellak');?>
    	<?php if ($post_type=='post') _e('TA ΤΕΛΕΥΤΑΙΑ NEA','ma-ellak');?>
    	<?php 
			if ($post_type=='document' && isset($documentTmplRss))
				_e('TA ΤΕΛΕΥΤΑΙΑ ΕΓΓΡΑΦΑ','ma-ellak');
		?>
    </i></a></li>
<?php 

}

?>

</ul>

<h3><?php _e('ATOM','ma-ellak')?></h3>
<ul class="nav">
<?php 
$post_types = get_post_types( '', 'names' );
global $ma_ellak_content_types;
$url = get_site_url()."/feeds/atom/?custom_type=";
foreach ( $ma_ellak_content_types as $post_type ) {
	if($post_type=='job' || $post_type=='bp_doc') continue;
		?>

    <li class="icn">
	<?php 
		if ($post_type!='document'){
	?>
			<a href="<?php bloginfo('atom_url'); ?>/?post_type=<?php echo $post_type;?>" title="<?php _e('Syndicate this site using RSS'); ?>">
	<?php
		}else if(isset($documentTmplAtom) && strlen($documentTmplAtom>0)){
			//	if(isset(get_option_tree('ma_ellak_atom_document_option_id')) && get_option_tree('ma_ellak_atom_document_option_id')!=''){
			$link_page=get_permalink(get_option_tree('ma_ellak_atom_document_option_id'));
			echo "<a href=\"". $link_page ."\">";
		//	}
		}
	?>
    <i class="icon-rss">
    	<?php if ($post_type=='events') _e('ΟΙ ΤΕΛΕΥΤΑΙΕΣ ΕΚΔΗΛΩΣΕΙΣ','ma-ellak');?>
    	<?php if ($post_type=='video') _e('ΤΑ ΤΕΛΕΥΤΑΙΑ VIDEO','ma-ellak');?>
    	<?php if ($post_type=='software') _e('ΛΟΓΙΣΜΙΚΟ','ma-ellak');?>
    	<?php if ($post_type=='post') _e('TA ΤΕΛΕΥΤΑΙΑ NEA','ma-ellak');?>
		<?php 
			if ($post_type=='document' && isset($documentTmplAtom)){
					_e('TA ΤΕΛΕΥΤΑΙΑ ΕΓΓΡΑΦΑ','ma-ellak');
			}
		?>
    </i></a></li>
<?php 
}
?>
</ul>
<h3><?php _e('Εκδηλώσεις','ma-ellak');?>				  	
<a href="?ical" target="_blank">
<img src="<?php bloginfo('template_directory'); ?>/images/btn_ical.png" alt="ical" width="24" height="15"/></a></h3>


<h3><?php _e('Προγράμματα ανάγνωσης ειδήσεων','ma-ellak');?></h3>

<p>
Υπάρχουν πολλά προγράμματα από τα οποία μπορείτε να επιλέξετε αυτό που σας ταιριάζει περισσότερο. Πιο συγκεκριμένα:</p>
<ul>
<li><a href="http://www.deskshare.com/awr.aspx" target="_blank">Active Web Reader</a> – Windows</li>
<li><a href="http://www.feedreader.com/" target="_blank">FeedReader</a> – Windows</li>
<li><a rel="external" href="http://www.newsgator.com/" title="NewsGator" target="_blank">NewsGator</a> - Online - Windows | Mac | iphone | ipad</li>
<li><a rel="external" href="http://www.bloglines.com" title="Bloglines" target="_blank">Bloglines</a> - Online</li>
<li><a rel="external" href="http://feedlounge.com" title="FeedLounge" target="_blank">FeedLounge</a>Online</li>
<li><a href="http://www.feedbucket.com/" target="_blank">FeedBucket</a>&nbsp;- Online</li>
</ul>

</div><!-- span8 end -->
  	<div class="span4 sidebar">
  		<?php get_sidebar()?>
  	</div><!-- span4 end -->
 </div><!-- row-fluid -->
<?php 
get_footer();

?>