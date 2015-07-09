<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<!-- profile="http://gmpg.org/xfn/11"/ -->
<head >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title><?php echo bloginfo('name'); ?></title>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
	<link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<?php  
		if(!is_edit_page())
			ma_ellak_social_print_header();
		
		/*
		if(get_option_tree('ma_ellak_twitter_user')!='')
		twit_count($fburl);
		fb_count($fburl);
		$fburl = curPageURL();
		googleplus_count($fburl);
	*/	wp_head(); 
	?>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-144-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-114-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-72-precomposed.png" />
    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-57-precomposed.png" />
	<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/custom.css" media="screen" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic&amp;subset=latin,greek-ext,greek' rel='stylesheet' type='text/css'>
	
	<script type="text/JavaScript">
	<!--
	function timedRefresh(timeoutPeriod) {
	    setTimeout("location.reload(true);",timeoutPeriod);
	}
	//   -->
	</script>
	<?php 
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
	
	if (is_home() && (is_plugin_active('wp-opt-in/wp-opt-in.php'))){
	?>
	<script type="text/javascript">
		jQuery(document).ready( function() {
			jQuery( '#wpoi_remove').click( function() {
				 var isChecked = jQuery('#wpoi_remove').attr('checked');
				 if(isChecked=='checked') jQuery('button#sumbitnewsletter').text('Απεγγραφή από το Newsletter');
				 else jQuery('button#sumbitnewsletter').text('Εγγραφή στο Newsletter');
			});
		});
	</script>
	<?php }?>

</head>
<body <?php body_class(); ?> <?php echo ma_body_id(); ?>>

     <div class="yamm navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="nav-collapse collapse">
          <ul class="nav">
            <li class="dropdown">
              
             <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΘΕΜΑΤΙΚΕΣ ΠΕΡΙΟΧΕΣ','ma-ellak');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <?php ma_ellak_list_all_thema_as_groups('<li>', '</li>', false); ?>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΜΟΝΑΔΕΣ ΑΡΙΣΤΕΙΑΣ','ma-ellak');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
				<?php ma_ellak_list_all_units('<li>', '</li>', false); ?>
              </ul>
            </li>
<li><a href="http://ma.ellak.gr/overview/"><?php _e('ΔΡΑΣΕΙΣ','ma-ellak');?></a></li>

            <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_site_takepart'));?>"><?php _e('ΠΩΣ ΣΥΜΜΕΤΕΧΩ','ma-ellak');?></a></li>
          	
         <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΒΙΒΛΙΟΘΗΚΗ','ma-ellak');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              	<?php if(get_option_tree('ma_ellak_list_video_option_id')!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_video_option_id')); ?>"><?php _e('Video','ma-ellak');?></a></li>
                <?php }?>
				<?php if(get_option_tree('ma_ellak_list_document_option_id')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_document_option_id')); ?>"><?php _e('Αρχεία','ma-ellak');?></a></li>
				<?php }?>
				<?php if(get_option_tree('ma_ellak_list_software')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_software')); ?>"><?php _e('Λογισμικά','ma-ellak');?></a></li>
				<?php }?>
				<?php if(get_option_tree('ma_ellak_list_characteristic')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_characteristic')); ?>"><?php _e('Γνωρίσματα','ma-ellak');?></a></li>
				<?php }?>
				<?php if(get_option_tree('ma_ellak_list_profiles')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_profiles')); ?>"><?php _e('Προφιλ','ma-ellak');?></a></li>
				<?php }?>
				<?php if(get_option_tree('ma_ellak_list_profiles')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_jobs')); ?>"><?php _e('Εργασιες','ma-ellak');?></a></li>
				<?php }?>
				</ul>
            </li>
              <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΑΝΑΖΗΤΗΣΗ','ma-ellak');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              	<?php if(get_option_tree('ma_ellak_list_video_option_id')!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_video_option_id')); ?>"><?php _e('Αναζήτηση Video','ma-ellak');?></a></li>
                <?php }?>
				<?php if(get_option_tree('ma_ellak_list_document_option_id')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_document_option_id')); ?>"><?php _e('Αναζήτηση Αρχείων','ma-ellak');?></a></li>
				<?php }?>
				<?php if(get_option_tree('ma_ellak_list_software')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_software')); ?>"><?php _e('Αναζήτηση Λογισμικού','ma-ellak');?></a></li>
				<?php }?>
				<?php if(get_option_tree('ma_ellak_list_profiles')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_profiles'))."/?action=search"; ?>"><?php _e('Αναζήτηση Προφιλ','ma-ellak');?></a></li>
				<?php }?>
				<?php if(get_option_tree('ma_ellak_list_profiles')!=''){?>
				<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_jobs')); ?>"><?php _e('Αναζήτηση Εργασιας','ma-ellak');?></a></li>
				<?php }?>
				</ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΝΕΑ','ma-ellak');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              	<?php if(get_option_tree('ma_ellak_list_event_option_id')!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_event_option_id')); ?>"><?php _e('ΕΚΔΗΛΩΣΕΙΣ','ma-ellak');?></a></li>
                <?php }?>
                <?php if(get_option_tree('ma_ellak_list_streaming_option_id')!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_list_streaming_option_id')); ?>"><?php _e('ΖΩΝΤΑΝΕΣ ΜΕΤΑΔΟΣΕΙΣ','ma-ellak');?></a></li>
                <?php }?>
                 <?php if(get_option_tree('ma_ellak_press_kit')!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_press_kit')); ?>"><?php _e('Press Kit','ma-ellak');?></a></li>
                <?php }?>
                <li><a href="http://ma.ellak.gr/%CE%B5%CE%BD%CE%B7%CE%BC%CE%B5%CF%81%CF%89%CF%84%CE%B9%CE%BA%CE%AC-%CE%B4%CE%B5%CE%BB%CF%84%CE%AF%CE%B1-%CE%BC%CE%BF%CE%BD%CE%AC%CE%B4%CF%89%CE%BD-%CE%B1%CF%81%CE%B9%CF%83%CF%84%CE%B5%CE%AF%CE%B1/"><?php _e('Ενημερωικά Δελτία','ma-ellak');?></a></li>
                
                </ul>
            </li>
          <?php if (is_user_logged_in()){  
			if(ma_ellak_get_unit_id()!=0 or current_user_can('activate_plugins')){ ?>
          	<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΕΝΕΡΓΕΙΕΣ','ma-ellak');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
               <?php if(get_option_tree('ma_ellak_add_event_option_id')!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_add_event_option_id')); ?>"><?php _e('ΠΡΟΣΘΗΚΗ ΕΚΔΗΛΩΣΗΣ','ma-ellak');?></a></li>
                <?php }?>
                <?php if(get_option_tree('ma_ellak_add_video_option_id')!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_add_video_option_id')); ?>"><?php _e('ΠΡΟΣΘΗΚΗ VIDEO','ma-ellak');?></a></li>
                <?php }?>
                
                <?php 
                $writeDocs = get_option_tree('ma_ellak_add_document_option_id');
                if( !empty($writeDocs) or $writeDocs!=''){?>
                <li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_add_document_option_id')); ?>"><?php _e('ΠΡΟΣΘΗΚΗ ΑΡΧΕΙΩΝ','ma-ellak');?></a></li>
                <?php }?>
				 <?php 
                $add_software = get_option_tree('ma_ellak_submit_software');
                if( !empty($add_software) or $add_software != '' ){?>
                <li><a href="<?php echo get_permalink($add_software); ?>"><?php _e('ΠΡΟΣΘΗΚΗ ΛΟΓΙΣΜΙΚΟΥ','ma-ellak');?></a></li>
                <?php }?>
				 <?php 
                $add_job = get_option_tree('ma_ellak_submit_job');
                if( !empty($add_job) or $add_job != '' ){?>
                <li><a href="<?php echo get_permalink($add_job); ?>"><?php _e('ΠΡΟΣΘΗΚΗ Εργασίας','ma-ellak');?></a></li>
                <?php }?>
				
				<?php 
					$user_has_profile = user_has_profile();
					$add_profile = get_option_tree('ma_ellak_submit_profile');
					if(!$user_has_profile and ( !empty($add_profile) or $add_profile != '' )) { ?>
					 <li><a href="<?php echo get_permalink($add_profile); ?>"><?php _e('ΠΡΟΣΘΗΚΗ ΠΡΟΦΙΛ ΕΠΑΓΓΛΕΜΑΤΙΑ/ΕΘΕΛΟΝΤΗ','ma-ellak');?></a></li>	
	<?php		}?>
				<?php
					$redmine = get_option_tree('ma_ellak_redmine');
					$moodle = get_option_tree('ma_ellak_moodle');
				?>
				<?php if(isset($moodle) && strlen($moodle)>5){?>
					<li><a href="<?php echo $moodle; ?>"><?php _e('ΚΑΤΑΧΩΡΙΣΗ ΕΚΠΑΙΔΕΥΤΙΚΟΥ ΥΛΙΚΟΥ','ma-ellak');?></a></li>
				<?php }
					if(isset($redmine) && strlen($redmine)>5){?>
					<li><a href="<?php echo $redmine; ?>"><?php _e('ΚΑΤΑΧΩΡΙΣΗ ΕΡΓΟΥ','ma-ellak');?></a></li>
				<?php }?>
                </ul>
            </li>
            <?php }
				if(current_user_can('activate_plugins')){  /* Εδω να προβάλλονται οι ανώνυμες καταχωρίσεις. ?>
				 <li><a href="<?php echo get_permalink($list_profile); ?>"><?php _e('ΑΝΑΖΗΤΗΣΗ ΕΠΑΓΓΕΛΜΑΤΙΑ/ΕΘΕΛΟΝΤΗ','ma-ellak');?></a></li>	
			<?php */ }
			}?>
			<!--<li><a href="<?php echo get_permalink(get_option_tree('ma_ellak_manuals_page')); ?>"><?php _e('ΕΓΧΕΙΡΙΔΙΑ','ma-ellak');?></a></li>-->
			<li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('ΕΡΓΑΛΕΙΑ','ma-ellak');?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
              	
                <li><a target="_blank" href="http://ma.ellak.gr/edu"><?php _e('ΤΗΛΕΚΠΑΙΔΕΥΣΗ','ma-ellak');?></a></li>
               
				
				<li><a target="_blak" href="http://ma.ellak.gr/forge"><?php _e('ΑΝΑΠΤΥΞΗ ΕΡΓΩΝ','ma-ellak');?></a></li>
			
				
				<li><a href="http://ma.ellak.gr/manuals/"><?php _e('ΟΔΗΓΙΕΣ ΧΡΗΣΗΣ','ma-ellak');?></a></li>
			
				
				</ul>
            </li>	
           </ul>
          <ul class="nav pull-right">
          <?php 
          	$facebook_link = get_option_tree('ma_ellak_facebook_share');
          	$twitter_link = get_option_tree('ma_ellak_twitter_user');
          	$gplus_link = get_option_tree('ma_ellak_google_page');
          	$rss_link = get_option_tree('ma_ellak_view_rss');
          	if(isset($facebook_link) && $facebook_link!='') echo "<li class='icn'><a href='".$facebook_link."' target='_blank'><i class='icon-facebook-sign'></i></a></li>";
          		if(isset($twitter_link) &&  $twitter_link!='') echo "<li class='icn'><a href='".$twitter_link."' target='_blank'><i class='icon-twitter-sign'></i></a></li>";
          		if(isset($gplus_link) && $gplus_link!='') echo "<li class='icn'><a href='".$gplus_link."' target='_blank'><i class='icon-github-sign'></i></a></li>";
          		if(isset($rss_link) && $rss_link!='') echo "<li class='icn'><a href='".get_permalink($rss_link)."'><i class='icon-rss'></i></a></li>";
          	?>
            
			<?php if (! is_user_logged_in()){ ?>
				<li><a href="<?php echo wp_login_url(); ?>" title=<?php _e('ΣΥΝΔΕΣΗ','ma-ellak');?> class="dropdown-toggle"><?php _e('ΣΥΝΔΕΣΗ','ma-ellak');?></a></li>
				<li><a href="https://ma.ellak.gr/register.php" title="<?php _e('Εγγραφή','ma-ellak');?>" id="signup_button" class="dropdown-toggle"><?php _e('Εγγραφή','ma-ellak');?></a></li>
			<?php } else{  
				$cur_user = wp_get_current_user();
			?>
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $cur_user->display_name ;?> <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="<?php echo bp_loggedin_user_domain(); ?>" class="dropdown-toggle"><?php _e('ΤΟ ΠΡΟΦΙΛ ΜΟΥ','ma-ellak');?></a></li>
					<?php
						$mycontent = get_permalink(get_option_tree('ma_ellak_get_personal_content'));
						if(!empty($mycontent) and $mycontent != '') { ?>
							<li><a href="<?php echo $mycontent; ?>" class="dropdown-toggle"><?php _e('ΟΙ ΚΑΤΑΧΩΡIΣΕΙΣ MOY','ma-ellak');?></a></li>
			<?php	} ?>
			<?php
						if($user_has_profile) { 
							$cur_user = wp_get_current_user();
							$args = array(
								'post_per_page' => 1,
								'post_type' => 'profile',
								'post_status' => 'publish', 
								'author' =>  $cur_user->ID
							); 
							$profiles = get_posts($args);
				?>
						<li><a href="<?php echo get_permalink($profiles[0]->ID); ?>" class="dropdown-toggle"><?php _e('ΕΠΑΓΓΕΛΜΑΤΙΚΟ ΠΡΟΦΙΛ','ma-ellak');?></a></li>
			<?php	} ?>
					<li><a href="<?php echo wp_logout_url( home_url() ); ?>" class="dropdown-toggle"><?php _e('ΑΠΟΣΥΝΔΕΣΗ','ma-ellak');?></a></li>
					<?php if(isset($moodle) && strlen($moodle)>5){?>
						<li><a href="<?php echo $moodle; ?>" class="dropdown-toggle"><?php _e('ΥΠΗΡΕΣΙΑ ΕΚΠΑΙΔΕΥΣΗΣ','ma-ellak');?></a></li>
					<?php }
						if(isset($redmine) && strlen($redmine)>5){?>
						<li><a href="<?php echo $redmine; ?>" class="dropdown-toggle"><?php _e('ΣΥΝΕΡΓΑΤΙΚΟ ΕΡΓΑΛΕΙΟ','ma-ellak');?></a></li>
				 	<?php }?>
				 </ul>
				</li>
				
				
			<?php }  ?>
           </ul>
           </div><!-- nav-collapse collapse -->
      </div><!-- navbar-inner -->
    </div><!-- yamm navbar navbar-inverse navbar-fixed-top -->
	
    <?php if (!is_home()){ ?>
  	
    <div id="main" class="main">
      <div class="container"><br /><br />
      <?php 

      if ((get_post_type($post->ID) != 'unit') and (bp_current_component() === false)){?>
        <div class="row-fluid">
          <div class="span4 offset4">
            <p  id="logo">
            	<a href="<?php echo get_site_url(); ?>">
            		<img class="logo hidden-tablet hidden-phone" src="<?php bloginfo('template_directory'); ?>/images/logo_normal.png" width="283" height="180" alt="<?php echo bloginfo('name');?>" title="<?php echo bloginfo('name');?>"/>
            		<img class="logo logo-ipad hidden-desktop" src="<?php bloginfo('template_directory'); ?>/images/logo_ipad.png" width="202" height="128" alt="<?php echo bloginfo('name');?>" title="<?php echo bloginfo('name').' for ipad';?>"/>
            		
            	</a></p>
          </div><!-- span4 -->
        </div><!-- row-fluid -->
        <?php } ?>
		<?php global $post; 
		if(is_category()==1){
			?>
			<div class="row-fluid">
				<div class="span12"><h2 class="text-center"><?php single_cat_title();?></h2></div>
			</div>
			
		<?php }else if(is_tag()==1){
			?>
			<div class="row-fluid">
				<div class="span12"><h2 class="text-center"><?php single_tag_title();?></h2></div>
			</div>
			
		<?php }else 
		if( (get_post_type($post->ID) != 'unit') and (get_post_type($post->ID) != 'software') and bp_current_component() === false){ ?>
	        <div class="row-fluid">
	          <div class="span12"><h2 class="text-center"><?php echo the_title_attribute();?></h2></div>
	        </div>
		 <?php }?>
        <?php }?>