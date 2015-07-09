<?php
/**
* Functions for Service 9 -  Document Management System
*
* @licence GPL
* @author Zoi Politopoulou - politopz@gmail.com
* 
* Project URL http://ma.ellak.gr
*/

/**
* Δημιουργεί τις παραμέτρους για να τρέξει το query που παρουσιάζει τη λίστα των αρχείων που έχουν φορτωθεί εφόσον είναι στην κατάσταση "Final" και "Δημόσια"
* Είσοδος:
* $limit ο αριθμός των αρχείων που θα εμφανίζονται ανά σελίδα
*/
function ma_ellak_documents_all_query($limit){
	$obj=get_term_by('name', 'Final', 'workflow_state');
	$final_id=$obj->term_id;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array (
		'post_type' => 'document',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
		'orderby' => 'post_date',
		'order' =>  'DESC',
		'tax_query' => array(
			'relation' => 'and',
			array(
				'taxonomy' => 'workflow_state',
				'field' => 'taxonomy_id',
				'terms' => $final_id
			)
		)
	);
	return $args;
}

/**
* Δημιουργία των παραμέτρων για το query που επιστρέφει τα πιο δημοφιλή έγγραφα (αφορά έγγραφα που είναι Final και Δημόσια)
* Είσοδος:
* $limit Ο αριθμός των αρχείων που θα παρουσιάζονται ανά σελίδα
*/
function ma_ellak_documents_popular_query($limit){
	$obj=get_term_by('name', 'Final', 'workflow_state');
	$final_id=$obj->term_id;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array (
		'post_type' => 'document',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
		'meta_key' => 'ratings_average',
        'orderby' => 'meta_value',
        'order' => 'DESC',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => 'ratings_average',
				'compare' => '='
			)
		),
		'tax_query' => array(
			'relation' => 'and',
			array(
				'taxonomy' => 'workflow_state',
				'field' => 'taxonomy_id',
				'terms' => $final_id
			)
		)
	);
	return $args;
}

/**
* Δημιουργία των παραμέτρων για το query που επιστρέφει τα έγγραφα που ανήκουν σε μια κατηγορία(αφορά έγγραφα που είναι Final και Δημόσια)
* Είσοδος:
* $limit Ο αριθμός των αρχείων που θα παρουσιάζονται ανά σελίδα
*/
function ma_ellak_documents_list_thema_query($thema, $limit){
	$obj=get_term_by('name', 'Final', 'workflow_state');
	$final_id=$obj->term_id;

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array(
        'post_type' => 'document',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
		'orderby' => 'post_date',
		'order' =>  'ASC',
		'tax_query' => array(
			'relation' => 'and',
			array(
				'taxonomy' => 'workflow_state',
				'field' => 'taxonomy_id',
				'terms' => $final_id
			),
			array(
				'taxonomy' => 'thema',
				'field' => 'taxonomy_id',
				'terms' => $thema
			)
		)
    );
	return $args;
}

/**
* Δημιουργεί τις παραμέτρους για να τρέξει το query που παρουσιάζει τη λίστα των αρχείων που έχουν φορτωθεί από τη μονάδα αριστείας που ανήκει ο χρήστης
* Είσοδος:
* $limit ο αριθμός των αρχείων που θα εμφανίζονται ανά σελίδα
*/
function ma_ellak_documents_unit_query($unitid, $limit){
	/*$obj=get_term_by('name', 'Final', 'workflow_state');
	$final_id=$obj->term_id;*/

	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	$args = array (
		'post_type' => 'document',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
		'orderby' => 'post_date',
		'order' =>  'DESC',
		'author' => $unitid,
		/*'meta_key' => '_ma_ellak_belongs_to_unit',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_ma_ellak_belongs_to_unit',
				'compare' => '='
			)
		)*/
		/*'tax_query' => array(
			'relation' => 'and',
			array(
				'taxonomy' => 'workflow_state',
				'field' => 'taxonomy_id',
				'terms' => $final_id
			)
		)*/
	);
	return $args;
}

/**
* Φίλτρο το οποίο χρησιμοποιείται για την υποστήριξη της αναζήτησης. Ελέγχει εάν υπάρχει ένα συγκεκριμένο keyword 
* στον τίτλο ή στην περιγραφή του αρχείου
* Είσοδος:
* $where το where statement όπως έχει διαμορφωθεί έως εκείνη της στιγμή
* $wp_query το query που θα χρησιμοποιηθεί για την επιστροφή των αποτελεσμάτων της αναζήτησης
*/
function documents_keyword_search( $where, &$wp_query ){
    global $wpdb;

	$where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\'';
	$where .= ' OR ' . $wpdb->posts . '.post_excerpt LIKE \'%' . esc_sql( like_escape( $_GET['keyword'] ) ) . '%\')';

	return $where;
}

/**
* Υλοποιεί την αναζήτηση και παρουσιάζει τα αποτελέσματα δεδομένης μιας λέξης κλειδί που παρέχει ο χρήστης
* Είσοδος:
* $keyword λέξη-κλειδί που εισάγει ο χρήστης στη φόρμα αναζήτησης
* $limit αριθμός αρχείων που θα περιέχονται σε κάθε σελίδα
*/
function ma_ellak_documents_search_results($keyword, $limit){
	$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
	global $wpdb;
	$obj=get_term_by('name', 'Final', 'workflow_state');
	$final_id=$obj->term_id;

	$args = array(
		'post_type' => 'document',
		'post_status' => 'publish',
		'paged' => $paged,
		'posts_per_page' => $limit,
		'ignore_sticky_posts'=> 1,
		'orderby' => 'post_date',
		'order' =>  'DESC',
		'tax_query' => array(
			'relation' => 'and',
			array(
				'taxonomy' => 'workflow_state',
				'field' => 'taxonomy_id',
				'terms' => $final_id
			)
		)
	);

	if ($keyword!='')
		add_filter( 'posts_where', 'documents_keyword_search', 10, 2 );
	$wp_query=new WP_Query($args);
	if ($wp_query->found_posts>0){
		$message="Αποτελέσματα αναζήτησης για τον όρο: ". $keyword ."<br><br>";
		_e($message, 'ma-ellak');
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			$doc_id=get_the_ID();
			show($doc_id);
		endwhile;
		if ($wp_query->found_posts>$limit)
			pagination(false, false, $wp_query);
	}
	else
		_e('Δεν βρέθηκαν αποτελέσματα για τη συγκεκριμένη αναζήτηση.', 'ma_ellak');

	echo social_output();
}

/**
* Ενδιάμεση συνάρτηση η οποία καλεί άλλες συναρτήσεις για τη δημιουργία της σελίδας των αρχείων
* Είσοδος:
* $args Οι παράμετροι των queries όπως επιστρέφονται από τις παραπάνω συναρτήσεις
* $message Ενημερωτικό μήνυμα που βλέπει ο χρήστης όταν εκτελεί κάποια ενέργεια
*/
function documents_create_page($args, $message, $term_id, $limit){
	global $wpdb;
	$wp_query=null;
	$wp_query=new WP_Query($args);

	$return_attachments=false;
	$all_documents=get_documents( $args, $return_attachments);

	if ($term_id!=''){	//prints the content for by_category page
		if ($wp_query->found_posts>0){
			$obj=get_term_by('id', $term_id, 'thema');
			$term_name=$obj->name;
			$message="<b>Αποτελέσματα αναζήτησης για την κατηγορία: ". $term_name ."</b><br><br>";
			_e($message, 'ma-ellak');
			ma_ellak_documents_print_list($all_documents);
			if ($wp_query->found_posts>$limit)
				pagination(false, false, $wp_query);
		}
		if ($wp_query->found_posts==0 || $term_id=='')
			_e($message, 'ma_ellak');
	}
	else{	//prints the page for list and popular documents
		if ($wp_query->found_posts>0){
			ma_ellak_documents_print_list($all_documents);
			if ($wp_query->found_posts>$limit)
				pagination(false, false, $wp_query);
		}
		else
			_e($message, 'ma-ellak');
	}
	echo social_output();
}

/**
* Συνάρτηση που καλείται από τα tmpl αρχεία για την παρουσίαση των αρχείων που ανήκουν σε μια μονάδα αριστείας
* Είσοδος:
* $limit ο αριθμός των αρχείων που θα παρουσιάζεται ανά σελίδα
*/
function ma_ellak_documents_by_unit($unitid, $limit){
	$args=ma_ellak_documents_unit_query($unitid, $limit);
	$message='Δεν έχουν καταχωρηθεί ακόμη αρχεία για τη συγκεκριμένη μονάδα αριστείας.';
	documents_create_page($args, $message, '', $limit);
}

/**
* Συνάρτηση που καλείται από τα tmpl αρχεία για την παρουσίαση των πιο δημοφιλών αρχείων
* Είσοδος:
* $limit ο αριθμός των αρχείων που θα παρουσιάζεται ανά σελίδα
*/
function ma_ellak_documents_popular_page($limit){
	$args=ma_ellak_documents_popular_query($limit);
	$message='Τα αρχεία που έχουν καταχωρηθεί στην πλατφόρμα δεν έχουν βαθμολογηθεί ακόμη.';
	documents_create_page($args, $message, '', $limit);
}

/**
* Συνάρτηση που καλείται από τα tmpl αρχεία για την παρουσίαση της λίστας των αρχείων
* Είσοδος:
* $limit ο αριθμός των αρχείων που θα παρουσιάζεται ανά σελίδα
*/
function ma_ellak_documents_library($limit){
	$args=ma_ellak_documents_all_query($limit);
	$message='Δεν έχουν καταχωρηθεί αρχεία ακόμη.';
	documents_create_page($args, $message, '', $limit);
}

/**
* Συνάρτηση που καλείται από τα tmpl αρχεία για την παρουσίαση των αρχείων εντός μιας θεματικής ενότητας
* Είσοδος:
* $thema η θεματική ενότητα εντός της οποίας γίνεται η αναζήτηση
* $limit ο αριθμός των αρχείων που θα παρουσιάζεται ανά σελίδα
*/
function ma_ellak_documents_by_category($thema, $limit){
	$args=ma_ellak_documents_list_thema_query($thema, $limit);
	$message='Δεν έχουν καταχωρηθεί ακόμη αρχεία σε αυτή τη θεματική κατηγορία.';
	documents_create_page($args, $message, $thema, $limit);
}

/**
* Δημιουργεί τη λίστα των αρχείων και καλεί τη συνάρτηση για την παρουσίαση κάθε αρχείου
* Είσοδος:
* $documents η λίστα με τα αρχεία που επιστρέφεται με βάση τις παραμέτρους που δίνονται σε κάθε query
*/
function ma_ellak_documents_print_list($documents){
	foreach ( $documents as $document ){
		$doc_id=$document->ID;
		show($doc_id);
	}
}

/**
* Παρουσίαση των στοιχείων που συνοδεύουν κάθε αρχείο
* Είσοδος:
* $doc_id το αναγνωριστικό του αρχείου το οποίο πρόκειται να παρουσιαστεί
*/
function show($doc_id, $add=''){
	$title=get_the_title($doc_id);
	$date_u=get_the_time('Y-m-d', $doc_id);
	$date_upload=date(MA_DATE_FORMAT, strtotime($date_u));

	global $wpdr;
	$latest_version = $wpdr->get_latest_revision( $doc_id );
	if ( $latest_version = $wpdr->get_latest_revision( $doc_id ) ) {
	?>
		<p>
			<div class="row-fluid event">
				<div class="cols">
					<div class="span4 col">
						<div class="boxed-in text-center the-date">
							<p class="magenta">
								<?php
									$extension=$wpdr->get_extension( get_attached_file( $latest_version->post_content ) );
									 echo print_icon($extension);?></h4>
									<p class="magenta">
										<?php echo __('Τελευταία έκδοση','ma-ellak') .":". date(MA_DATE_FORMAT, strtotime($latest_version->post_date));?>
									</p>
							</p>
						</div>
					</div><!-- span4 col -->
					<div class="span8 text col">
						<?php
							global $post, $typenow, $extension;
							$tmp_post_id=$post->ID;
							$post->ID=$doc_id;
					
							$tmp_typenow='page';
							$typenow='document';
						?>
						<h3><a target="_blank" href="<?php the_permalink(); ?>" rel="bookmark" title="<?php echo $title;?>" class="btn btn-large btn-link"><?php echo $title;?></a></h3>
						
						<?php
							if (is_page_template('ma_ellak_yp9_tmpl_list_documents_by_unit.php')){
								$add_link=get_permalink(get_option_tree('ma_ellak_add_document_option_id'));
								echo "<i>[<a href=\"". $add_link ."?doc_id=". $doc_id ."\">ΠΡΟΣΘΗΚΗ ΝΕΑΣ ΕΚΔΟΣΗΣ</a>]</i></a>";
							}
							$post->ID=$tmp_post_id;
							$typenow='page';
						?>
						<p class="meta purple">
							<?php echo $date_upload;?>
							<?php echo ma_ellak_print_unit_title($doc_id);?>
							<?php echo ma_ellak_print_thema($doc_id,'thema');?>
						</p>
						<div class="under">
							<?php ma_ellak_social_print_data ($doc_id, 'documents', 'document');?>
						</div>
						<?php echo html_entity_decode( $latest_version->post_excerpt );?>
					</div><!-- span8 text col -->
				</div><!-- cols -->
			</div>
		</p>
		<?php } //end if latest version
}

/**
* Δημιουργεί την μπάρα από όπου γίνεται η πλοήγηση του χρήστη στις σελίδες παρουσίασης των αρχείων
*/
function ma_ellak_document_upper_bar(){
?>
	<div class="row-fluid">&nbsp;</div>
	<div class="row-fluid">
		<div class="span8">
			<ul class="unstyled inline filters">
				<?php $link_page=get_permalink(get_option_tree('ma_ellak_list_document_option_id'));?>
				<?php if (isset($_GET['action']) && $_GET['action']!=''){?>
				<li><a href="<?php echo $link_page; ?>?action=list">				
					<?php _e('ΠΙΣΩ ΣΤΗ ΛΙΣΤΑ', 'ma-ellak');?></a>
				</li>
				<li>|</li>
				<?php }?>
				<li><a href="<?php echo $link_page; ?>?action=list"
				class="<?php if (isset($_GET['action']) && $_GET['action']=='list') echo'active-menu';?>">
				<?php _e('ΠΡΟΣΦΑΤΑ', 'ma-ellak');?></a>
				</li>
				<li>|</li>
				<li><a href="<?php echo $link_page; ?>?action=popular"
				class="<?php if (isset($_GET['action']) && $_GET['action']=='popular') echo'active-menu';?>">
				<?php _e('ΔΗΜΟΦΙΛΗ', 'ma-ellak'); ?></a></li>
				<li>|</li>
				<li>
					<div class="dropdown">
						<a href="<?php echo $link_page; ?>?action=search_by_thema" 
						class="dropdown-toggle <?php if (isset($_GET['action']) && $_GET['action']=='listthema') echo'active-menu';?>" data-toggle="dropdown"><?php _e('ΚΑΤΗΓΟΡΙΕΣ', 'ma-ellak');?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<?php
								$terms = get_terms('thema',array( 'hide_empty' => false ));
								foreach ( $terms as $term ){
									if (isset($_GET['term']) && $_GET['term']==$term->term_id) 
										echo "<li><a href=\"". $link_page ."?action=listthema&term=". $term->term_id ."\" class=\"active-menu\">" . $term->name . "</a></li>";
									else
										echo "<li><a href=\"". $link_page ."?action=listthema&term=". $term->term_id ."\">" . $term->name . "</a></li>";
							
								}
							?>
						</ul>
					</div>
				</li>
				<?php 
				if (is_user_logged_in()){
					$add_link=get_permalink(get_option_tree('ma_ellak_add_document_option_id'));
				?>
					<li>|</li>
					<li><a href="<?php echo $add_link; ?>"><?php _e('ΠΡΟΣΘΗΚΗ ΝΕΟΥ ΑΡΧΕΙΟΥ', 'ma-ellak'); ?></a></li>
				<?php
				}
				?>
			</ul>
		</div>
		<?php ma_ellak_document_print_search_form();?>
	</div>
<?php
}

// Εκτυπώνει το κουτί της αναζήτησης της μπάρας σε κάθε σελίδα που είναι απαραίτητο
function ma_ellak_document_print_search_form(){
?>
	<div class="span4 pull-right videolist-search">
		<script type="text/javascript">
			function submitOnEnter(inputElement, event) {  
				if (event.keyCode == 13) { // No need to do browser specific checks. It is always 13.  
					inputElement.form.submit();  
				}
			}
		</script>
		<form class="form-search form-inverse" action="">
			<input type="text" name="keyword" onkeypress="submitOnEnter(this, event);" class="input-block-level search-query" placeholder="<?php _e('ΑΝΑΖΗΤΗΣΗ', 'ma-ellak');?>">
		</form>
	</div>
<?php
}

/**
* Επιστρέφει τον κώδικα για την παρουσίαση μιας εικόνας βάσει της επέκτασης κάθε αρχείου
* Είσοδος:
* $extensio το είδος του αρχείου που αφορά η εικόνα
*/
function print_icon($extension){
	$img="";
	switch ($extension){
		case ".gif":
			$img="gif";
			break;
		case ".html":
			$img="html";
			break;
		case ".jpg":
			$img="jpg";
			break;
		case ".pdf":
			$img="pdf";
			break;
		case ".png":
			$img="png";
			break;
		case ".txt":
			$img="txt";
			break;
		case ".doc":
		case ".docx":
			$img="word";
			break;
		case ".zip":
		case ".rar":
			$img="zip";
			break;
	}
	$src="<img src=\"". get_template_directory_uri() ."/images/". $img.".png\" alt=\"". $img ."\" width=\"40\" height=\"40\"/>";
	return $src;
}

/***********************Adding document from the front-end************/
// Αποθηκεύει τα έξτρα πεδία (post meta) απο τη φόρμα front-end υποβολής
function ma_ellak_document_save_details( $post_id ){
	$prefix = '_ma_'; // Underscore για να μη φαίνονται στη default λίστα. Το ίδιο που χρησιμοποιούμε και στη δήλωση των εσωτερικών metaboxes.
	
	if (isset($_POST['_ma_document_know']))
		update_post_meta( $post_id, $prefix.'document_know',  $_POST['_ma_document_know'] );
	else
		delete_post_meta( $post_id, $prefix.'document_know' );
}

/****Validation rules***/
function ma_ellak_yp9_scripts(){
	$template_dir =  get_bloginfo('template_directory');
	global $typenow;
	if($typenow == 'document' || is_page_template('ma_ellak_yp9_tmpl_add_document.php') || is_page_template('ma_ellak_yp9_tmpl_update_document.php')){
		wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_validate_fields_submit',  $template_dir . '/js/validate_yp9_tmpl_add_document_val_submit.js',  array('jquery'), '1.0', true );	
		wp_enqueue_style( 'ma_ellak_chosen_css', $template_dir . '/scripts/tagselect/chosen/chosen.css' );
		wp_enqueue_style( 'ma_ellak_tagselect_css',  $template_dir . '/scripts/tagselect/tagselect.css');
		wp_enqueue_style( 'ma_ellak_bootstrap_css', $template_dir . '/css/bootstrap.min.css' );
		
		wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
		wp_enqueue_script( 'ma_ellak_tagselect_js',  $template_dir . '/scripts/tagselect/tagselect.js',  array('jquery'), '1.0', true );
		
	}
}
add_action('admin_enqueue_scripts', 'ma_ellak_yp9_scripts');
add_action('wp_enqueue_scripts', 'ma_ellak_yp9_scripts', 11);

/**hook for the permalink in case the extension is not included**/
function formulate_permalink() {
    global $post, $typenow, $wpdr;
	
	if ($post->post_type=='document' || $typenow=='document'){
		$permalink=get_permalink($post->ID);
		$latest_version = $wpdr->get_latest_revision( $post->ID);
		$extension=$wpdr->get_extension( get_attached_file( $latest_version->post_content ) );
		$perm=explode($extension, $permalink);
		if (count($perm)==1)
			$permalink.=$extension;
		return $permalink;
	}
	else{
		$permalink=get_permalink();
		return $permalink;
	}
}
add_filter('the_permalink', 'formulate_permalink');

// Fix for not looped Doc items
function doc_permalink($post_id) {
	global $wpdr;
    $post = get_post($post_id);
	
	if ($post->post_type=='document'){
		$permalink=get_permalink($post->ID);
		$latest_version = $wpdr->get_latest_revision( $post->ID);
		$extension=$wpdr->get_extension( get_attached_file( $latest_version->post_content ) );
		$perm=explode($extension, $permalink);
		if (count($perm)==1)
			$permalink.=$extension;
		return $permalink;
	}
	else{
		$permalink=get_permalink($post_id);
		return $permalink;
	}
}

?>