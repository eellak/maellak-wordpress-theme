<?php
/**
* Αρχείο συναρτήσεων για την Υπηρεσία διαχείρισης εκδηλώσεων.
*
* @licence GPL
* @author Dimitra P dimitrap54@gmail.com
* 
* Project URL http://ma.ellak.gr
*/

// Εγγραφή της εκδήλωσης (Events) [1/2]
add_action( 'init', 'ma_ellak_register_events_posttype', 0 );

// Εγγραφή του Σύνθετου Τύπου εκδήλωσης (events) [2/2]
function ma_ellak_register_events_posttype() {
	$labels = array(
		'name' 					=> _x( 'Εκδηλώσεις', 'γενικό όνομα', 'ma-ellak' ),
		'singular_name' 		=> _x( 'Εκδήλωση', 'γενικό όνομα', 'ma-ellak' ),
		'add_new' 				=> _x( 'Προσθήκη Νέας', 'Εκδήλωσης', 'ma-ellak' ),
		'add_new_item'			=> __( 'Προσθήκη Νέας Εκδήλωσης', 'ma-ellak' ),
		'edit_item' 			=> __( 'Επεξεργασία Εκδήλωσης', 'ma-ellak' ),
		'new_item' 				=> __( 'Νέα Εκδήλωση', 'ma-ellak' ),
		'all_items' 			=> __( 'Όλες οι Εκδηλώσεις', 'ma-ellak' ),
		'view_item' 			=> __( 'Προβολή Εκδηλώσεων', 'ma-ellak' ),
		'search_items' 			=> __( 'Αναζήτηση Εκδηλώσεων', 'ma-ellak' ),
		'not_found' 			=> __( 'Δεν εντοπίστηκε', 'ma-ellak' ),
		'not_found_in_trash' 	=> __( 'Δεν εντοπίστηκε στον Κάδο', 'ma-ellak' ),
		'parent_item_colon' 	=> '',
	);

	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'can_export'			=> true,
		'show_in_nav_menus'		=> false,
		'query_var' 			=> true,
		'has_archive' 			=> true,
		'rewrite' 				=> array( 'slug' => 'events', 'with_front' => true, 'feeds' => true ) ,
		'capability_type' 		=> 'post',
		'hierarchical' 			=> false,
		'menu_position' 		=> null,
		'supports' 				=> array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
		'taxonomies' 			=> array('post_tag')
				
	);

	register_post_type( 'events' , $args  );
}


// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Εκδηλώσεις [1/2]
add_filter( 'cmb_meta_boxes', 'ma_ellak_events_metaboxe' );

// Δηλώνουμε την εμφάνιση του metabox για τον τύπο αντικειμένου Εκδηλώσεις [2/2]
function ma_ellak_events_metaboxe( array $meta_boxes ) {
	
	global $ma_prefix ;
	$prefix = $ma_prefix;  

	$meta_boxes[] = array(
		'id'         => 'events_metabox',
		'title'      => __('Πληροφορίες Εκδηλώσεων', 'ma-ellak'),
		'pages'      => array( 'events'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
			array(
						'name'    => __('Τύπος εκδήλωσης', 'ma-ellak'),
						'desc'    => __('επιλέξτε τον τύπο της εκδήλωσης', 'ma-ellak'),
						'id'      => $prefix . 'events_type',
						'type'    => 'select',
						'options' => array(
								array( 'name' => 'Εκδήλωση', 'value' => 'event', ),
                                array( 'name' => 'Σεμινάριο', 'value' => 'seminar', ),
                                array( 'name' => 'Κύκλος Εκπαίδευσης', 'value' => 'seminar1', ),
                                array( 'name' => 'Σχολείο Ανάπτυξης Κώδικα', 'value' => 'school', ),
                                array( 'name' => 'Ημερίδα', 'value' => 'meeting', ),
                                array( 'name' => 'Θερινό σχολείο', 'value' => 'summerschool', ),
						),
				),
				array(
						'name'    => __('Δήλωση συμμετοχής', 'ma-ellak'),
						'desc'    => __('Αναφέρετε αν η εκδήλωση θα έχει δήλωση συμμετοχής', 'ma-ellak'),
						'id'      => $prefix . 'events_participate',
						'type'    => 'select',
						'options' => array(
								array( 'name' => 'Όχι', 'value' => 'no', ),
								array( 'name' => 'Ναι', 'value' => 'yes', )
						),
				),
				array(
						'name' => __('Αξιολόγηση εκδήλωσης;', 'ma-ellak'),
						'desc' => __('Συμπληρώστε αν η εκδήλωση θα έχει αξιολόγηση μετά το πέρας της', 'ma-ellak'),
						'id'   => $prefix . 'event_evaluation',
						'type' => 'checkbox',
				),
				array(
						'name' => __('Xώρος', 'ma-ellak'),
						'desc' => __('Ο Xώρος που θα διεξαχθεί η εκδήλωση', 'ma-ellak'),
						'id'   => $prefix . 'event_place',
						'type' => 'text',
				),
				array(
						'name' => __('Διεύθυνση', 'ma-ellak'),
						'desc' => __('Η διεύθυνση που θα διεξαχθεί η εκδήλωση', 'ma-ellak'),
						'id'   => $prefix . 'event_address',
						'type' => 'text',
				),
			array(
					'name' => __('Έναρξη εκδήλωσης', 'ma-ellak'),
					'desc' => __('η ημερομηνία εναρξης εκδήλωσης', 'ma-ellak'),
					'id'   => $prefix . 'event_startdate_timestamp',
					'type' => 'text_date',
			),
				array(
						'name' => __('Ώρα έναρξης εκδήλωσης', 'ma-ellak'),
						'desc' => __('η ώρα εναρξης εκδήλωσης', 'ma-ellak'),
						'id'   => $prefix . 'event_startdate_time',
						'type' => 'text_time',
				),
			array(
					'name' => __('Λήξη εκδήλωσης', 'ma-ellak'),
					'desc' => __('η ημερομηνία λήξης εκδήλωσης', 'ma-ellak'),
					'id'   => $prefix . 'event_enddate_timestamp',
					'type' => 'text_date',
			),
				
				array(
						'name' => __('Ώρα Λήξης εκδήλωσης', 'ma-ellak'),
						'desc' => __('η ημερομηνία λήξης εκδήλωσης', 'ma-ellak'),
						'id'   => $prefix . 'event_enddate_time',
						'type' => 'text_time',
				),
			array(
					'name' => __('Φωτογραφία Εκδήλωσης', 'ma-ellak'),
					'desc' => __('Ανεβάστε φωτογραφία για την εκδήλωση', 'ma-ellak'),
					'id'   => $prefix . 'event_image',
					'type' => 'file',
			),
			array(
					'name' => __('Έχει live;', 'ma-ellak'),
					'desc' => __('Συμπληρώστε αν η εκδήλωση θα έχει live', 'ma-ellak'),
					'id'   => $prefix . 'event_live',
					'type' => 'checkbox',
			),
				
		),
	);
	$meta_boxes[] = array(
			'id'         => 'events_metabox_program',
		'title'      => __('Πρόγραμμα Εκδήλωση', 'ma-ellak'),
		'pages'      => array( 'events'), // Post type
		'context'    => 'normal',
		'priority'   => 'high',
		'show_names' => true, // Show field names on the left
		'fields'     => array(
				
				array(
						'name'    => __('Πρόγραμμα Εκδήλωσης', 'ma-ellak'),
						'desc'    => __('Προσθέσετε το πρόγραμμα Εκδήλωσης', 'ma-ellak'),
						'id'      => $prefix . 'event_title_program_desc',
						'type'    => 'wysiwyg',
						'options' => array(	'textarea_rows' => 5, ),
				),
				array(
						'name' => __('Πρόγραμμα Εκδήλωσης (pdf)', 'ma-ellak'),
						'desc' => __('Ανεβάστε το πρόγραμμα για την εκδήλωση σε μορφή pdf', 'ma-ellak'),
						'id'   => $prefix . 'event_program_pdf',
						'type' => 'file',
				),
			)
	);
	
	return $meta_boxes;
}

add_action( 'init', 'ma_ellak_events_meta_boxes', 9999 );

function ma_ellak_events_meta_boxes() {

	if ( ! class_exists( 'cmb_Meta_Box' ) )
		require_once (TEMPLATEPATH . '/scripts/metabox/init.php');

}

add_action( 'add_meta_boxes', 'ma_ellak_events_show_members_box' );

/**
 *  Adds a box to the main column of events to show members
 */
function ma_ellak_events_show_members_box() {
    $screens = array( 'events');
    foreach ($screens as $screen) {
        add_meta_box(
            'ma_ellak_events_show_all_members', //HTML 'id' attribute of the edit screen section
            __( 'Ποιοι έχουν δηλώσει συμμετοχή', 'ma-ellak' ), //Title of the edit screen section, visible to user
            'ma_ellak_events_show_members', //Function that prints out the HTML for the edit screen section. The function name as a string, or, within a class, an array to call one of the class's methods. The callback can accept up to two arguments, see Callback args. 
            $screen, //The type of Write screen on which to show the edit screen section
        	'normal',//The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). 
        	'high' //The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
        );
    }
}
	/**
	* THe data to display 
	* http://codex.wordpress.org/Function_Reference/add_meta_box
	*  @param  array	$post the actual post
	*  @return shows the members than subscribed
 	*/
 function ma_ellak_events_show_members( $post ) {
 	//http://www.binnash.com/2012/08/13/using-wordpress-wp_list_table-in-the-frontend/
	// The actual fields for data entry
	// Use get_post_meta to retrieve an existing value from the database and use the value for the form
	//wp_nonce_field( 'matata_noncename', 'matata_noncename' );
	global $wpdb; //This is used only if making any database queries
    	//get the event id 
    	$postid = $post->ID;
    	
    	$result = $wpdb->get_var( "SELECT COUNT(*) FROM ma_events_participants where events_id=".$postid );
    	
		if($result>0){
			$test = new TT_List_Table_Event_Participants();
			$test->prepare_items();
			$test->display();
		}
}

add_action( 'add_meta_boxes', 'ma_ellak_events_show_evaluation_box' );

/**
 *  Adds a box to the main column of events to show members
 */
function ma_ellak_events_show_evaluation_box() {
	$screens = array( 'events');
	foreach ($screens as $screen) {
		add_meta_box(
				'ma_ellak_events_show_all_evaluations', //HTML 'id' attribute of the edit screen section
				__( 'Ποιοι έχουν αξιολογήσει την εκδήλωση', 'ma-ellak' ), //Title of the edit screen section, visible to user
				'ma_ellak_events_show_evaluation', //Function that prints out the HTML for the edit screen section. The function name as a string, or, within a class, an array to call one of the class's methods. The callback can accept up to two arguments, see Callback args.
				$screen, //The type of Write screen on which to show the edit screen section
				'normal',//The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side').
				'high' //The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
		);
	}
}
/**
 * THe data to display
 * http://codex.wordpress.org/Function_Reference/add_meta_box
 *  @param  array	$post the actual post
 *  @return shows the members than subscribed
 */
function ma_ellak_events_show_evaluation( $post ) {
	//http://www.binnash.com/2012/08/13/using-wordpress-wp_list_table-in-the-frontend/
	// The actual fields for data entry
	// Use get_post_meta to retrieve an existing value from the database and use the value for the form
	//wp_nonce_field( 'matata_noncename', 'matata_noncename' );
	global $wpdb; //This is used only if making any database queries
	//get the event id
	$postid = $post->ID;
	 
	$result = $wpdb->get_var( "SELECT COUNT(*) FROM ma_events_evaluation where events_id=".$postid );
	 
	if($result>0){
		$test = new TT_List_Table_Event_Evaluation();
		$test->prepare_items();
		$test->display();
	}
}



	/** Από εδώ φτιάχνω τον πίνακα του διαχειριστικού των Εκδηλώσεων*/
	add_filter ("manage_edit-events_columns", "ma_ellak_events_edit_columns");
	add_action ("manage_posts_custom_column", "ma_ellak_events_custom_columns");
	
	/** Ονοματίζω τις στήλες του διαχειριστικού πίνακα
	* @param  array	$columns the column names
	* @return array the final column values
	**/

 function ma_ellak_events_edit_columns($columns) {
 
	$columns = array(
	    "cb" => "<input type=\"checkbox\" />",
	    "col_ev_id" => __('ID', 'ma-ellak'),
		"title" => __('Εκδήλωση', 'ma-ellak'),
	    "col_ev_type" => __('Τύπος', 'ma-ellak'),
	    "col_ev_date" => __('Ημερομηνίες Εκδήλωσης', 'ma-ellak'),
	    "col_ev_times" => __('Ώρες έναρξης - λήξης', 'ma-ellak'),
	    "col_ev_desc" => __('Περιγραφή Εκδήλωσης', 'ma-ellak'),
	
	);
	return $columns;
	}
	/** 
	* Γεμίζω με data τις στήλες του διαχειριστικού πίνακα
	* @param  	array	$column	the column names
	* @return string the column value
	**/
	function ma_ellak_events_custom_columns($column)
	{
	
		global $post;
		$custom = get_post_custom();
		switch ($column)
		{
			case "col_ev_id":
				echo $post->ID;
				break;
			case "col_ev_type":
				echo $custom['_ma_events_type'][0];
				break;
			case "col_ev_date":
			    $startd = $custom['_ma_event_startdate_timestamp'][0];
			    $endd = $custom['_ma_event_enddate_timestamp'][0];
			    $startdate = date("F j, Y", $startd);
			    $enddate = date("F j, Y", $endd);
			    echo $startd . '<br /><em>' . $endd . '</em>';
			break;
			case "col_ev_times":
			    $startt = $custom['_ma_event_startdate_time'][0];
			    //$starttime = date("h:i A", $startt);
			    $endt = $custom['_ma_event_enddate_time'][0];
			  //  $endtime = date("h:i A", $endt);
			    
			    echo $startt ." ". $endt;
			break;
				
			case "col_ev_desc";
			    the_excerpt();
			break;
		 
		}
	}
 //http://wp.tutsplus.com/tutorials/plugins/a-guide-to-wordpress-custom-post-types-taxonomies-admin-columns-filters-and-archives/
 
	/**Register Columns as Sortable
	Register a function to be called when WordPress identifies sortable columns in CPT.**/
	add_filter( 'manage_edit-events_sortable_columns', 'ma_ellak_events_sort' );
	/**
	 * Set the types you want to sort the events table
	 * This function identifies two columns to make them sortable and then returns the array.
	 * @param  	array	$column	the column names
	 * @return  array the final column values
	 **/
	function ma_ellak_events_sort( $columns ) {
		$columns['col_ev_type'] = '_ma_events_type';
		$columns['col_ev_date'] = '_ma_event_startdate_timestamp';
		
		return $columns;
	}
	
	add_filter( 'request', 'ma_ellak_events_sort_column_orderby' );
	/**
	 * Order by Custom Field
	 * The above function is associated with the request filter and adds elements to the query array, 
	 * based on the variables in the query URL. Actually WordPress doesn’t know how to order by the fields 
	 * ‘Event Type’ or ‘Event Start Date’, so we need to teach WordPress how to do that through this function.
	 * @param array $vars
	 * @return array with the sortable data
	 */
	function ma_ellak_events_sort_column_orderby ( $vars ) {
		if ( !is_admin() )
			return $vars;
		if ( isset( $vars['orderby'] ) && 'col_ev_type' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array( 'meta_key' => '_ma_events_type', 'orderby' => 'meta_value' ) );
		}
		else if ( isset( $vars['orderby'] ) && 'col_ev_date' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array( 'meta_key' => '_ma_event_startdate_timestamp', 'orderby' => 'meta_value' ) );
		}
		return $vars;
	}
	
	//http://wordpress.stackexchange.com/questions/19838/create-more-meta-boxes-as-needed/19852#19852
	add_action( 'add_meta_boxes', 'ma_ellak_events_dynamic_videos' );
	/* Do something with the data entered */
	add_action( 'save_post', 'ma_ellak_events_dynamic_videos_save_postdata' );
	/* Adds a box to the main column on the Post and Page edit screens */
	function ma_ellak_events_dynamic_videos() {
		add_meta_box(
				'dynamic_sectionid',
				__( 'Ζωντανή σύνδεση', 'ma-ellak' ),
				'ma_ellak_events_dynamic_videos_inner_custom_box',
				'events',
				'normal',//The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side'). 
        		'high' //The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
				
				);
	}
	/* Prints the box content */
	function ma_ellak_events_dynamic_videos_inner_custom_box() {
		global $post;
		// Use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
		$meta = get_post_meta(get_the_ID());
		if(isset($meta['_ma_event_live'][0]) && $meta['_ma_event_live'][0]!=''){
		?>
	    <div id="meta_inner">
	    </div>
	   	<span class="add button button-primary button-small"><?php _e('Προσθήκη Ζωντανής Σύνδεσης','ma-ellak'); ?></span>
	    
	 <?php 
	 
	 //get the saved meta as an array
	 //echo $post->ID;
	 $events = get_post_meta($post->ID,'eventslive',true);
	 $c = 0;
	 //if($events)
	 if($events)
	 if ( count( $events ) >= 0 ) {
	 	foreach( $events as $event ) {
	 		
	 		if ( isset( $event['_ma_ellak_event_url'] ) ) {
	 			printf( '<p><strong>Url</strong> <input type="text" name="eventslive[%1$s][_ma_ellak_event_url]" value="%2$s" id="_ma_ellak_event_url%1$s" /> -- <strong>Τίτλος</strong> <input type="text" name="eventslive[%1$s][_ma_ellak_event_url_title]" id="_ma_ellak_event_url_title%1$s"  value="%3$s" /><input type="text" name="eventslive[%1$s][_ma_ellak_event_views]" id="_ma_ellak_event_views%1$s"  value="%4$s" readonly width="10" size="3"/><span class="remove">%5$s</span></p>', $c, $event['_ma_ellak_event_url'],$event['_ma_ellak_event_url_title'],$event['_ma_ellak_event_views'], "<span class='button button-warning button-small'>".__( ' - Αφαίρεση','ma-ellak' )."</span>" );
	 			$c = $c +1;
	 		}
	 	}
	 }
	
	 $template_dir =  get_bloginfo('template_directory');
	 wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
	 wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
	
	 ?>
	 <span id="here"></span>
	 
	 <script>
	     var $ =jQuery.noConflict();
	     $(document).ready(function() {
	         var count = <?php echo $c; ?>;
	         $(".add").click(function() {
	             count = count + 1;
	             $('#here').append('<p> <strong>Url </strong><input type="text" name="eventslive['+count+'][_ma_ellak_event_url]" id="_ma_ellak_event_url'+count+'"  class="required url" value="" />  -- <strong>Τίτλος</strong> <input type="text" name="eventslive['+count+'][_ma_ellak_event_url_title]" id="_ma_ellak_event_url_title'+count+'" value="" />  <input type="hidden" name="eventslive['+count+'][_ma_ellak_event_views]" id="_ma_ellak_event_views'+count+'"  class="" value="0" /><span class="remove button button-danger button-small"> - Αφαίρεση</span>' );
	             return false;
	         });
	         $(".remove").live('click', function() {
	             $(this).parent().remove();
	         });
			 
			 $('#ma_ellak_events_show_all_members').find('#_wpnonce').remove();

	       });
	     </script>
	 <?php
		}else
			_e('Επιλέξτε πρώτα αν θα έχει ζωντανή μετάδοση','ma-ellak');
	 }
	 
	 /* When the post is saved, saves our custom data */
	 function ma_ellak_events_dynamic_videos_save_postdata( $post_id ) {
	 	// verify if this is an auto save routine.
	 	// If it is our form has not been submitted, so we dont want to do anything
	 	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
	 		return;
	 
	 	// verify this came from the our screen and with proper authorization,
	 	// because save_post can be triggered at other times
	 	if ( !isset( $_POST['dynamicMeta_noncename'] ) )
	 		return;
	 
	 	if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
	 		return;
	 
	 	// OK, we're authenticated: we need to find and save the data
	 
	 	$events = $_POST['eventslive'];
	 	
	 	update_post_meta($post_id,'eventslive',$events);
	 	 	 
	 }
	 //Delete members when an event is deleted
	 add_action('admin_init', 'ma_ellak_events_codex_init');
	 function ma_ellak_events_codex_init() {
	 	if (current_user_can('delete_posts')) add_action('delete_post', 'ma_ellak_events_codex_sync_members', 10);
	 }
	 
	 function ma_ellak_events_codex_sync_members($pid) {
	 	global $wpdb;
	 	if ($wpdb->get_var($wpdb->prepare('SELECT events_id FROM ma_events_participants WHERE events_id = %d', $pid))) {
	 		return $wpdb->query($wpdb->prepare('DELETE FROM ma_events_participants WHERE events_id = %d', $pid));
	 	}
	 	return true;
	 }
	 
	 add_action('admin_enqueue_scripts', 'ma_ellak_events_scripts_backend');
	 /**
	  * Προσθέτει javascripts και css styles  για τη διαχείριση των λαθών 
	  * στο backend της διαχείρισης των εκδηλώσεων
	  */
	 function ma_ellak_events_scripts_backend(){
	 
		$template_dir =  get_bloginfo('template_directory');
	 	global $typenow;
		if($typenow == 'events'){
	 		wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
			wp_enqueue_script( 'ma_ellak_events_validate_event_back',  $template_dir . '/js/validate_events_tmpl_add_events_back.js',  array('jquery'), '1.0', true );
		}
	}
	// Προσθέτει javascripts και css styles [1/2]
	function ma_ellak_events_scripts() {
		global $post;
		
		$template_dir =  get_bloginfo('template_directory');
		if ( get_post_type()=='events' || is_page_template('ma_ellak_events_list.php')) {
			wp_enqueue_style( 'ma_ellak_bootstrap_css', $template_dir . '/css/bootstrap.min.css' );
				
		}
	if(is_page_template('ma_ellak_tmpl_live_streaming.php')){
		wp_enqueue_script( 'ma_ellak_events_streaming',  $template_dir . '/js/ma_ellak_events_streaming.js',  array('jquery'), '1.0', true );
		wp_localize_script( 'ma_ellak_events_streaming', 'ajax_request_streaming_settings', array(
		'ajax_url' => admin_url( 'admin-ajax.php' ),
		'req_nonce' => wp_create_nonce("ajax_request_streaming_nonce"),
   ) );
  }
		if(is_page_template('ma_ellak_events_tmpl_program.php')){
			wp_enqueue_style( 'ma_ellak_bootstrap_css', $template_dir . '/css/bootstrap.min.css' );
		}		
		else if ( is_page_template('ma_ellak_events_tmpl_form_participation.php')) {
			wp_enqueue_style( 'ma_ellak_bootstrap_css', $template_dir . '/css/bootstrap.min.css' );
			wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'ma_ellak_tagselect_js',  $template_dir . '/scripts/tagselect/tagselect.js',  array('jquery'), '1.0', true );
			
			wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
			wp_enqueue_script( 'ma_ellak_events_validate_form',  $template_dir . '/js/validate_events_tmpl_form_participation.js',  array('jquery'), '1.0', true );
				
		}
		else if ( is_page_template('ma_ellak_events_tmpl_form_evaluation.php')) {
			wp_enqueue_style( 'ma_ellak_bootstrap_css', $template_dir . '/css/bootstrap.min.css' );
			wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'ma_ellak_tagselect_js',  $template_dir . '/scripts/tagselect/tagselect.js',  array('jquery'), '1.0', true );
				
			wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
			wp_enqueue_script( 'ma_ellak_events_validate_form',  $template_dir . '/js/validate_events_tmpl_form_evaluation.js',  array('jquery'), '1.0', true );
		
		}
	
		else if ( is_page_template('ma_ellak_events_tmpl_add_event.php') ||  is_page_template('ma_ellak_events_tmpl_update_event.php')) {
			
			wp_enqueue_style( 'ma_ellak_chosen_css', $template_dir . '/scripts/tagselect/chosen/chosen.css' );
			wp_enqueue_style( 'ma_ellak_tagselect_css',  $template_dir . '/scripts/tagselect/tagselect.css');
			wp_enqueue_style( 'ma_ellak_bootstrap_css', $template_dir . '/css/bootstrap.min.css' );
		
			wp_enqueue_script( 'ma_ellak_chosen_js', $template_dir . '/scripts/tagselect/chosen/chosen.jquery.min.js', array('jquery'), '1.0', true );
			wp_enqueue_script( 'ma_ellak_tagselect_js',  $template_dir . '/scripts/tagselect/tagselect.js',  array('jquery'), '1.0', true );
		
			wp_enqueue_script( 'ma_ellak_validate',  $template_dir . '/js/jquery.validate.min.js',  array('jquery'), '1.0', true );
			wp_enqueue_script( 'ma_ellak_events_validate_event',  $template_dir . '/js/validate_events_tmpl_add_event.js',  array('jquery'), '1.0', true );
			
			// From init.php
			 $cmb_script_array = array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'media-upload', 'thickbox' );
			 $cmb_style_array = array( 'thickbox' );
			wp_enqueue_script( 'cmb-timepicker', CMB_META_BOX_URL . 'js/jquery.timePicker.min.js', true );
			wp_enqueue_script( 'cmb-scripts', CMB_META_BOX_URL . 'js/cmb.js', $cmb_script_array, '1.0', true );
			wp_enqueue_style( 'cmb-styles', CMB_META_BOX_URL . 'style.css', $cmb_style_array );
			wp_enqueue_style('easyui',$template_dir . '/js/easyui/themes/bootstrap/easyui.css');
			wp_enqueue_style('easyui-icon',$template_dir . '/js/easyui/themes/icon.css');
			wp_enqueue_style('easyui-icon-demo',$template_dir . '/js/easyui/demo.css');
			wp_enqueue_script('easyui',$template_dir . '/js/easyui/jquery.easyui.min.js');
			
		
			
		}
	}
	// Προσθέτει javascripts και css styles [2/2]
	add_action( 'wp_enqueue_scripts', 'ma_ellak_events_scripts', 11111);
	
	
	// Αποθηκεύει τα έξτρα πεδία (post meta) απο τη φόρμα front-end υποβολής
	function ma_ellak_events_save_details( $post_id ){
	
		$prefix = '_ma_'; // Underscore για να μη φαίνονται στη default λίστα. Το ίδιο που χρησιμοποιούμε και στη δήλωση των εσωτερικών metaboxes.
	
		if ( isset( $_POST['_ma_event_place'] ) )
			update_post_meta( $post_id, '_ma_event_place',  $_POST['_ma_event_place'] );
		else
			delete_post_meta( $post_id,'_ma_event_place' );
		
		if ( isset( $_POST['_ma_event_address'] ) )
			update_post_meta( $post_id, '_ma_event_address',  $_POST['_ma_event_address'] );
		else
			delete_post_meta( $post_id,'_ma_event_address' );
		
		if ( isset( $_POST['_ma_events_participate'] ) )
			update_post_meta( $post_id, '_ma_events_participate',  $_POST['_ma_events_participate'] );
		else
			delete_post_meta( $post_id,'_ma_events_participate' );
		
		if ( isset( $_POST['_ma_event_live'] ) )
			update_post_meta( $post_id, '_ma_event_live',  $_POST['_ma_event_live'] );
		else
			delete_post_meta( $post_id,'_ma_event_live' );
		
		if ( isset( $_POST['_ma_event_evaluation'] ) )
			update_post_meta( $post_id, '_ma_event_evaluation',  $_POST['_ma_event_evaluation'] );
		else
			delete_post_meta( $post_id,'_ma_event_evaluation' );
		
		if ( isset( $_POST['_ma_events_type'] ) )
			update_post_meta( $post_id, '_ma_events_type',  $_POST['_ma_events_type'] );
		else
			delete_post_meta( $post_id,'_ma_events_type' );
		
		if ( isset( $_POST['_ma_event_title_program_desc'] ) )
			update_post_meta( $post_id, '_ma_event_title_program_desc',  $_POST['_ma_event_title_program_desc'] );
		else
			delete_post_meta( $post_id,'_ma_event_title_program_desc' );
		
		if(isset($_POST['eventz'])){
			update_post_meta( $post_id, 'eventslive',  $_POST['eventz'] );
		}
		if(isset($_POST['_ma_event_startdate_timestamp'])){
			$new = strtotime( $_POST['_ma_event_startdate_timestamp']);
			$new = $_POST['_ma_event_startdate_timestamp'];
			update_post_meta($post_id,'_ma_event_startdate_timestamp',$new);
		}
		if(isset($_POST['_ma_event_startdate_time'])){
			$new = strtotime($_POST['_ma_event_startdate_time']);
			$new = $_POST['_ma_event_startdate_time'];
			update_post_meta($post_id,'_ma_event_startdate_time',$new);
		}
		if(isset($_POST['_ma_event_enddate_timestamp'])){
			$new = strtotime( $_POST['_ma_event_enddate_timestamp']);
			$new = $_POST['_ma_event_enddate_timestamp'];
			update_post_meta($post_id,'_ma_event_enddate_timestamp',$new);
		}
		if(isset($_POST['_ma_event_enddate_time'])){
			$new =  strtotime($_POST['_ma_event_enddate_time']);
			$new =  $_POST['_ma_event_enddate_time'];
			update_post_meta($post_id,'_ma_event_enddate_time',$new);
		}	
		
		$unit_id =  ma_ellak_get_unit_id();
		if( $unit_id != 0)
			update_post_meta( $post_id, '_ma_ellak_belongs_to_unit',$unit_id );
		
	}
	
	/** return the name of the month of an event timestamp
	 * 
	 * ?
	 * 
	 * 
	 */
	function ma_ellak_events_return_month($monthstring){
		switch ($monthstring){
		case '01':
				$mname = __('ΙΑΝ','ma-ellak');
			break;
		case '02':
			$mname = __('ΦΕΒ','ma-ellak');
			break;
		case '03':
			$mname = __('ΜΑΡ','ma-ellak');
			break;
		case '04':
			$mname = __('ΑΠΡ','ma-ellak');
			break;
		case '05':
			$mname = __('ΜΑΙ','ma-ellak');
			break;
		case '06':
			$mname = __('ΙΟΥΝ','ma-ellak');
			break;
		case '07':
			$mname = __('ΙΟΥΛ','ma-ellak');
			break;
		case '08':
			$mname = __('ΑΥΓ','ma-ellak');
			break;
		case '09':
			$mname = __('ΣΕΠ','ma-ellak');
			break;
		case '10':
			$mname = __('ΟΚΤ','ma-ellak');
			break;
		case '11':
			$mname = __('ΝΟΕ','ma-ellak');
			break;
		case '12':
			$mname = __('ΔΕΚ','ma-ellak');
			break;
			
			}
		return $mname;
	}
	
function ma_ellak_events_list($my_query,$whichType='video'){
		global $paged;
		global  $wpdb,$postID;
		//$custom_loop = $wpdb->get_results($my_query, ARRAY_A);
		if( $my_query->have_posts() ) {
			$count=0;
			//foreach ( $custom_loop as $post )
			//{
			//setup_postdata( $post );
			//print_r($post);
			while ($my_query->have_posts()) { 
			$my_query->the_post();
			$cid= get_the_ID();
			$meta = get_post_meta( $cid );
			$postID = $cid;
			$start = $meta['_ma_event_startdate_timestamp'][0]?strtotime($meta['_ma_event_startdate_timestamp'][0]):'';
			$starttime = $meta['_ma_event_startdate_time'][0]?$meta['_ma_event_startdate_time'][0]:'';
			$startd = date(MA_DATE_FORMAT,$start);
  			$endd = $meta['_ma_event_enddate_timestamp'][0]?date(MA_DATE_FORMAT,strtotime($meta['_ma_event_enddate_timestamp'][0])):'';
  			$endtime = $meta['_ma_event_enddate_time'][0]?$meta['_ma_event_enddate_time'][0]:'';
  			
  			$SdateD = date('d',$start);
  			$SdateM = date('m',$start);
			$event_type = $meta['_ma_events_type'][0];
			$Sdate = explode('/',$startd);
			$title = get_the_title();
			
			?>
	 <?php if ($whichType=='streaming'){?>
	 
	 <?php if ($count==0){?>
		<div class="row-fluid videolist streaming">
          <div class="cols padded clearfix">
          <?php
			}
	?>
            <div class="span4 square col">
              <div class="over"><p><a href="<?php echo get_permalink($cid); ?>"><strong><?php _e('ΕΠΟΜΕΝΗ ΜΕΤΑΔΟΣΗ','ma-ellak');?></strong></a></p></div>
              <div class="preview">
                <strong class="live-now back-petrol white"><?php _e('LIVE ΣΤΙΣ ','ma-ellak'); echo " ".$startd;?></strong>
                <div class="overlay absolute-center">
                  <i class="icon-play"></i>
                </div>
              </div>
              <div class="meta">
           		<h3><a href="<?php the_permalink($cid) ?>" rel="bookmark" 
	       			title="<?php  echo $title;?>"><?php echo $title; ?></a>
	       			<a href="?ical&eid=<?php echo$cid; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/btn_ical.png" alt="ical" width="24" height="15"/></a></h3>
	       		</a>
	       		<?php echo  ma_ellak_single_edit_permalink();?>
	       		
	       		</h3>
	            <ul class="unstyled purple">
                  <li>
                   <?php 
                  
                   		get_event_type_label($event_type);
	      			?>
	       			<?php echo ma_ellak_print_unit_title($cid);?>  
		       		<?php echo ma_ellak_print_thema($cid,'thema');?>
	       			<?php echo $startd ." ". $starttime; if($endd) echo" - ". $endd ." ". $endtime;?></p>
                  </li>
                </ul>
              </div>
            
              <div class="under">
          		    <?php ma_ellak_social_print_data ($cid, 'events', 'listview');?>
	          </div>
            </div>
            <?php 
        $count++;
		if ($count==3 || $count==$my_query->post_count){
			echo"</div><!-- cols -->";
     		echo"</div><!-- row-fluid -->";
			$count=0;
			}
			?>
      
      
	 <?php }else{ ?>
	   
	   <div class="row-fluid event">
	     <div class="cols">
	     
	      <div class="span4 col">
	       <div class="boxed-in text-center the-date">
	        <h3 class="white"><?php echo  $SdateD;?></h3>
			<h4 class="magenta"><?php echo  ma_ellak_events_return_month($SdateM);?></h4>
	     </div>
	     </div><!-- span4 col -->
	     <div class="span8 text col">
	       <h3><a href="<?php  echo get_permalink($cid); ?>" rel="bookmark" 
	       title="<?php  echo $title;?>" class="btn btn-large btn-link"><?php  echo $title; ?></a> 
	       	<a href="?ical&eid=<?php echo$cid; ?>" target="_blank"><img src="<?php bloginfo('template_directory'); ?>/images/btn_ical.png" alt="ical" width="24" height="15"/></a>
	       	<?php echo  ma_ellak_single_edit_permalink();?>
	    
	       	</h3>
	       <p  class="meta purple">
	       <?php 
	       get_event_type_label($event_type);
	      ?>
	       <?php echo ma_ellak_print_unit_title($cid);?>  
		   <?php echo ma_ellak_print_thema($cid,'thema');?>
	       <?php echo $startd ." ". $starttime; if($endd) echo"-". $endd ." ". $endtime;?></p>
		   <?php  the_excerpt_max_charlength(240);?>
	       <?php ma_ellak_social_print_data ($cid, 'events', 'listview');?>
	       	       			 
	       
	    </div><!-- span8 text col -->
	     </div><!-- cols -->
	     	
	   </div><!-- row-fluid event -->
	   
		<?php }?>
	 <?php } //endwhile;
	
	 if( $my_query->max_num_pages>1){
	 	pagination(false, false, $my_query);
	 }
	}else
		_e('Δεν υπάρχουν διαθέσιμα δεδομένα προς το παρόν.','ma-ellak');
	}
	
	function ma_ellak_print_streaming ($event_id){
	$events = get_post_meta($event_id,'eventslive',true);
	//print_r($events);
	 $c = 0;
	 if($events)
	 	if ( count( $events ) >= 1 ) {
		 	foreach( $events as $event ) {
	 			if ( isset( $event['_ma_ellak_event_url'] ) ) {
				 	if($c==0){
				 	echo"<div id='single-home-container'>";
				 	echo"<h4 class='magenta'>".$event['_ma_ellak_event_url_title']."</h4>";
				 	 
						// FOTIS for Proof of concept: USE ONLY THE XXXXXXXXXXXXXXX from the youtube.com/watch?v=XXXXXXXXXXXXX
						//echo '<iframe width="420" height="315" src="//www.youtube.com/embed/'.$event['_ma_ellak_event_url'].'?rel=0" frameborder="0" allowfullscreen></iframe>';
						echo '<iframe scrolling="no"  name="video_frame" src="'.$event['_ma_ellak_event_url'].'/#left" width="640" height="360" frameborder="0" style="height: 360px; border: 0px none; width: 640px; margin-top: 0; margin-left: -24px; "></iframe>';
						echo'<p class="views-and-likes"><i class="icon-eye-open"></i> '. $event['_ma_ellak_event_views'] .'</p>';
						
					echo '</div>';
					
					$events_keys = array_keys($events);
					if ( count( $events ) >= 0 ) {
						for($i=0;$i<count($events_keys);$i++)
							//foreach( $events as $event ) {
							if ($events[$events_keys[$i]]['_ma_ellak_event_url_title']== $event['_ma_ellak_event_url_title']){
							$events[$events_keys[$i]]['_ma_ellak_event_views']=$events[$events_keys[$i]]['_ma_ellak_event_views']+1;
						}
					}
					update_post_meta($event_id,'eventslive',$events);
				 	}
					$c = $c +1;
					echo"<a class='trick' rel=".$event['_ma_ellak_event_url']." href='#12' eventid=".$event_id." eventtitle='".$event['_ma_ellak_event_url_title']."'>";
					echo $event['_ma_ellak_event_url_title'];
					echo"</a>  ";
			 		}
			 	}
	 }
	
	}


function ma_ellak_events_list_join( $join){

    global $wpdb;
	$join .= " JOIN ".$wpdb->postmeta." AS mt ON 
        (".$wpdb->posts.".ID = mt.post_id)";
		
    return $join;
}	
	
function ma_ellak_events_list_where( $where ){
    
	global $pageType;
	$compareType = '>=';
	if($pageType=='old') $compareType = '<';
	$today=date('m/d/Y');
	
	$where .= " AND (mt.meta_key = '_ma_event_enddate_timestamp' AND STR_TO_DATE(mt.meta_value, '%m/%d/%Y') $compareType STR_TO_DATE('$today', '%m/%d/%Y'))";
	
	return $where;
}

function ma_ellak_events_list_order_by( $order ) {
	
	global $pageType;
	if($pageType=='old')
		$order = " STR_TO_DATE(mt.meta_value, '%m/%d/%Y') DESC"; // Για να φαίνονται οι περασμένες πιο πρόσφατες
	else
		$order = " STR_TO_DATE(mt.meta_value, '%m/%d/%Y') ASC";
	
	return $order;
}

function ma_ellak_streaming_list_join( $join){

    global $wpdb;
	
	$join .= " INNER JOIN ".$wpdb->postmeta." ON (".$wpdb->posts.".ID = ".$wpdb->postmeta.".post_id) ";
	$join .= "INNER JOIN ".$wpdb->postmeta." AS mt1 ON (".$wpdb->posts.".ID = mt1.post_id) ";
	$join .= "INNER JOIN ".$wpdb->postmeta." AS mt2 ON (".$wpdb->posts.".ID = mt2.post_id)"; 
	
    return $join;
}	
	

function ma_ellak_streaming_list_where( $where ){

	global $pageType;
	$compareType = '>=';
	$today=date('m/d/Y');

	$where .= "AND ( ma_postmeta.meta_key = '_ma_event_enddate_timestamp' 
	AND (mt1.meta_key = '_ma_event_enddate_timestamp' AND STR_TO_DATE(mt1.meta_value, '%m/%d/%Y') $compareType STR_TO_DATE('$today', '%m/%d/%Y')) 
	AND (mt2.meta_key = '_ma_event_live' AND CAST(mt2.meta_value AS CHAR) = 'on') )";
	
	return $where;
}

function ma_ellak_streaming_list_order_by( $order ) {

	$order = " STR_TO_DATE(mt1.meta_value, '%m/%d/%Y') ASC";
	
	return $order;
}
	
?>