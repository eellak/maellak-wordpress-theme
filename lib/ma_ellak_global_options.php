<?php
/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', 'custom_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array(
    'contextual_help' => array(
      'content'       => array( 
        array(
          'id'        => 'general_help',
          'title'     => 'General',
          'content'   => '<p>Help content goes here!</p>'
        )
      ),
      'sidebar'       => '<p>Sidebar content goes here!</p>',
    ),
    'sections'        => array(
      array(
        'id'          => 'general',
        'title'       => 'Γενικά στοιχεία'
      ),
    array(
    	'id'          => 'events',
    	'title'       => 'Εκδηλώσεις'
    ),
	array(
    	'id'          => 'video',
    	'title'       => 'Βίντεο'
    ),
	array(
    	'id'          => 'document',
    	'title'       => 'Αρχεία'
    ),
     array(
        'id'          => 'social',
        'title'       => 'Social'
      ),
      array(
    	'id'          => 'addpages',
    	'title'       => 'Προσθήκη δεδομένων'
    		),
	 array(
    	'id'          => 'varius',
    	'title'       => 'Διάφορα'
    		),
	 array(
    	'id'          => 'gnorisma',
    	'title'       => 'Γνώρισμα'
    		),
	array(
    	'id'          => 'software',
    	'title'       => 'Λογισμικό'
    		),
	array(
    	'id'          => 'job',
    	'title'       => 'Προσφορά'
    		) ,  
	array(
    	'id'          => 'profile',
    	'title'       => 'Επ. Προφίλ'
    		)  ,  			
    ),
    'settings'        => array(
           array(
        'id'          => 'ma_ellak_site_description',
        'label'       => 'Περιγραφή του δικτυακού τόπου',
        'desc'        => '<p>Περιγραφή του δικτυακού τόπου',
        'std'         => '',
        'type'        => 'textarea',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_site_takepart',
      		'label'       => 'Σελίδα Συμμετέχω',
      		'desc'        => '',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'general',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_press_kit',
      		'label'       => 'Press Kit',
      		'desc'        => '',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'general',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
        'id'          => 'ma_ellak_site_image',
        'label'       => 'Φωτογραφία δικτυακού τόπου',
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_site_logo',
      		'label'       => 'Φωτογραφία δικτυακού τόπου  σε μεγάλη ανάλυση για το PressKit',
      		'desc'        => '',
      		'std'         => '',
      		'type'        => 'upload',
      		'section'     => 'general',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_site_file_description',
      		'label'       => 'PDF με την περιγραφή του έργου για το δικτυακό τόπο',
      		'desc'        => '',
      		'std'         => '',
      		'type'        => 'upload',
      		'section'     => 'general',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
           array(
        'id'          => 'ma_ellak_site_keywords',
        'label'       => 'Keywords δικτυακού τόπου',
        'desc'        => '',
        'std'         => '',
        'type'        => 'textarea-simple',
        'section'     => 'general',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_moodle',
      		'label'       => 'Υπηρεσία εκπαίδευσης',
      		'desc'        => '',
      		'std'         => '',
      		'type'        => 'text',
      		'section'     => 'general',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_redmine',
      		'label'       => 'Συνεργατικό εργαλείο',
      		'desc'        => '',
      		'std'         => '',
      		'type'        => 'text',
      		'section'     => 'general',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_view_rss',
      		'label'       => 'RSS Feeds',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα που έχετε προσθέσει τη λίστα με τα RSS feeds.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'general',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_list_event_option_id',
      		'label'       => 'Λίστα εκδηλώσεων',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα για την λίστα εκδηλώσεων όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_view_event_option_id',
      		'label'       => 'Δήλωση συμμετοχής στην εκδήλωση',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα για την σελίδα μίας σελίδας συμμετοχής στην εκδήλωση όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ), 
      array(
      		'id'          => 'ma_ellak_view_participation_option_id',
      		'label'       => 'Αξιολόγηση εκδήλωσης',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα με την φόρμα αξιολόγησης εκδήλωσης όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_view_event_program_option_id',
      		'label'       => 'Πρόγραμμα εκδήλωσης',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα με το πρόγραμμα της εκδήλωσης όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_view_event_streaming',
      		'label'       => 'Streaming page εκδήλωσης',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα για το streaming της εκδήλωσης όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_update_event',
      		'label'       => 'Ανανέωση μεταδεδομένων εκδήλωσης',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα για την Ανανέωση μεταδεδομένων της εκδήλωσης όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_event_participants_xls',
      		'label'       => 'Εξαγωγή συμμετεχόντων εκδήλωσης (xls)',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα για την Εξαγωγή των συμμετεχόντων μίας εκδήλωσης.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_event_evaluations_xls',
      		'label'       => 'Εξαγωγή αξιολογήσεων εκδήλωσης (xls)',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα για την Εξαγωγή των αξιολογήσεων μίας εκδήλωσης.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'events',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
            array(
        'id'          => 'ma_ellak_facebook_share',
        'label'       => 'Facebook page',
        'desc'        => 'Η σελίδα του facebook των Μονάδων Αριστείας',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'ma_ellak_twitter_user',
        'label'       => 'Twitter user',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
        'id'          => 'ma_ellak_google_page',
        'label'       => 'Google+ page',
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'social',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_list_video_option_id',
      		'label'       => 'Λίστα βίντεο',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα με τη λίστα των βίντεο που έχουν καταχωρηθεί στην πλατφόρμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'video',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_list_streaming_option_id',
      		'label'       => 'Λίστα προγραμματισμέων μεταδόσεων',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα με τη λίστα των προγραμματισμένων μεταδόσεων που έχουν καταχωρηθεί στην πλατφόρμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'video',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_list_video_option_id',
      		'label'       => 'Λίστα βίντεο',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα με τη λίστα των βίντεο που έχουν καταχωρηθεί στην πλατφόρμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'video',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_update_video',
      		'label'       => 'Ανανέωση μεταδεδομένων του video',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα για την Ανανέωση μεταδεδομένων του video όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'video',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_add_event_option_id',
      		'label'       => 'Προσθήκη εκδηλώσεων',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα για την προσθήκη εκδηλώσεων όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'addpages',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_add_video_option_id',
      		'label'       => 'Προσθήκη Video',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα για την προσθήκη video όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'addpages',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  array(
      		'id'          => 'ma_ellak_list_document_option_id',
      		'label'       => 'Λίστα αρχείων',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα με τη λίστα των αρχείων που έχουν καταχωρηθεί στην πλατφόρμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'document',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_update_document',
      		'label'       => 'Ανανέωση μεταδεδομένων αρχείου',
      		'desc'        => 'Από εδώ μπορείτε να να επιλέξετε τη σελίδα για την Ανανέωση μεταδεδομένων του αρχείου όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'document',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  array(
      		'id'          => 'ma_ellak_rss_document_option_id',
      		'label'       => 'RSS feed for documents',
      		'desc'        => 'Από εδώ εκτυπώνεται το RSS feed των αρχείων που έχουν καταχωρηθεί στην πλατφόρμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'document',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  array(
      		'id'          => 'ma_ellak_atom_document_option_id',
      		'label'       => 'ATOM feed for documents',
      		'desc'        => 'Από εδώ εκτυπώνεται το ATOM feed των αρχείων που έχουν καταχωρηθεί στην πλατφόρμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'document',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  array(
      		'id'          => 'ma_ellak_add_document_option_id',
      		'label'       => 'Προσθήκη αρχείου',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα για την προσθήκη αρχείου όπως έχει δηλωθεί στο Μενού που το έχετε προσθέσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'document',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  array(
      		'id'          => 'ma_ellak_get_personal_content',
      		'label'       => 'Περιεχόμενο Χρήστη',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα βλέπει το περιεχόμενο το οποίο έχει καταχωρήσει.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'varius',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	   array(
      		'id'          => 'ma_ellak_edit_unit',
      		'label'       => 'Επεξεργασία Μονάδας Αριστείας',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα επεξεργασίας των Μονάδων Αριστείας.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'varius',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	  array(
      		'id'          => 'ma_ellak_anonymous_user',
      		'label'       => 'Ανώνυμος Χρήστης',
      		'desc'        => 'Καταχωρίστε το EMAIL του λογαριασμού του Ανώνυμου Χρήστη!',
      		'std'         => '',
      		'type'        => 'text',
      		'section'     => 'varius',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	  	array(
      		'id'          => 'ma_ellak_manuals_page',
      		'label'       => 'Εγχειρίδα Χρήσης',
      		'desc'        => 'Επιλέξτε τη σελίδα των Εγχειριδίων Χρήσης',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'varius',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	   array(
      		'id'          => 'ma_ellak_json_sourceforge_fetch',
      		'label'       => 'JSON Sourceforge fetch',
      		'desc'        => 'Σελίδα ανάγνωσης των JSON data απο το Sourceforge.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'varius',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	    array(
      		'id'          => 'ma_ellak_all_news',
      		'label'       => 'Όλα τα νέα',
      		'desc'        => 'Σελίδα προβολής όλης της Δραστηριότητας.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'varius',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	   array(
      		'id'          => 'ma_ellak_submit_characteristic',
      		'label'       => 'Προσθήκη Γνωρίσματος',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα καταχωρεί Λειτουργικό Χαρακτηριστικό/Γνώρισμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'gnorisma',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	   array(
      		'id'          => 'ma_ellak_edit_characteristic',
      		'label'       => 'Επεξεργασία Γνωρίσματος',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα επεξεργάζεται Λειτουργικό Χαρακτηριστικό/Γνώρισμα.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'gnorisma',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	   array(
      		'id'          => 'ma_ellak_list_characteristic',
      		'label'       => 'Λίστα Γνωρισμάτων',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία θα εμφανίζονται όλα τα Γνωρίσματα/Λειτουργικά Χαρακτηριστικά.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'gnorisma',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	   array(
      		'id'          => 'ma_ellak_list_characteristic_unapproved',
      		'label'       => 'Λίστα Γνωρισμάτων Μη Δημοσιευμένων',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία θα εμφανίζονται όλα τα Γνωρίσματα/Λειτουργικά Χαρακτηριστικά που αναμένουν Επεξεργασία.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'gnorisma',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	  array(
      		'id'          => 'ma_ellak_list_characteristic_export',
      		'label'       => 'Εξαγωγή Γνωρισμάτων σε xls',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία θα εξάγονται όλα τα Γνωρίσματα/Λειτουργικά Χαρακτηριστικά ανα Λογισμικό.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'gnorisma',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
      array(
      		'id'          => 'ma_ellak_list_characteristic_rss',
      		'label'       => 'Εξαγωγή Γνωρισμάτων σε RSS',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία θα εξάγονται όλα τα Γνωρίσματα/Λειτουργικά Χαρακτηριστικά ανα Λογισμικό.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'gnorisma',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	  
	  
	   array(
      		'id'          => 'ma_ellak_anonymous_characteristic',
      		'label'       => 'Ανώνυμη Καταχώριση',
      		'desc'        => 'Επιτρέπεται η ανώνυμη καταχώριση ;',
      		'std'         => '',
      		'section'     => 'gnorisma',
      		'type'    => 'checkbox',
			 'class'   => '',
			 'choices' => array(
				array(
				 'label'	=> 'Ναι',
				 'value'	=> 'yes'
				)
			  )
      ),
	  
	    array(
      		'id'          => 'ma_ellak_submit_software',
      		'label'       => 'Προσθήκη Λογισμικού',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα καταχωρεί Λογισμικά.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'software',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	   array(
      		'id'          => 'ma_ellak_edit_software',
      		'label'       => 'Επεξεργασία Λογισμικού',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα επεξεργάζεται Λογισμικά',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'software',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	   array(
      		'id'          => 'ma_ellak_list_software',
      		'label'       => 'Λίστα Λογισμικών',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία θα προβάλλονται τα Λογισμικά',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'software',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
     
	  
	  
	  	    array(
      		'id'          => 'ma_ellak_submit_job',
      		'label'       => 'Προσθήκη Προσφοράς',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα καταχωρεί Προσφορές.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'job',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	   array(
      		'id'          => 'ma_ellak_edit_job',
      		'label'       => 'Επεξεργασία Προσφοράς',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα επεξεργάζεται Προσφορές',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'job',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	   array(
      		'id'          => 'ma_ellak_list_jobs',
      		'label'       => 'Λίστα Προσφορών',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία θα προβάλλονται τα Προσφορές',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'job',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	   array(
      		'id'          => 'ma_ellak_anonymous_job',
      		'label'       => 'Ανώνυμη Καταχώριση',
      		'desc'        => 'Επιτρέπεται η ανώνυμη καταχώριση ;',
      		'std'         => '',
      		'section'     => 'job',
      		'type'    => 'checkbox',
			 'class'   => '',
			 'choices' => array(
				array(
				 'label'	=> 'Ναι',
				 'value'	=> 'yes'
				)
			  )
      ),
	  
	  array(
      		'id'          => 'ma_ellak_submit_profile',
      		'label'       => 'Προσθήκη Προφίλ',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα καταχωρεί το Προφίλ του.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'profile',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  
	  array(
      		'id'          => 'ma_ellak_edit_profile',
      		'label'       => 'Επεξεργασία Προφίλ',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία ο χρήστης θα επεξεργάζεται το Προφίλ του.',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'profile',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	   array(
      		'id'          => 'ma_ellak_list_profiles',
      		'label'       => 'Λίστα Προφίλ',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα στην οποία θα προβάλλονται τα Προφίλ των Επαγγελματιών',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'profile',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
	  array(
      		'id'          => 'ma_ellak_hire',
      		'label'       => 'Πρόσληψη',
      		'desc'        => 'Από εδώ μπορείτε να επιλέξετε τη σελίδα που χρησιμοποιείται για την πρόσληψη κάποιου επαγγελματία',
      		'std'         => '',
      		'type'        => 'page-select',
      		'section'     => 'profile',
      		'rows'        => '',
      		'post_type'   => '',
      		'taxonomy'    => '',
      		'min_max_step'=> '',
      		'class'       => ''
      ),
    )
  );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( 'option_tree_settings', $custom_settings ); 
  }
  
}

?>