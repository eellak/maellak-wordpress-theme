<?php
/**
* Κεντρικό Αρχείο social_functions.php. 
* Περιέχει όλες τις βασικές συναρτήσεις για social και καλεί μέσα απο τον φάκελο scripts timthumb.
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*--------------------------------------------------------------------------------------------*
*/

/* 
* Here get the meta image or if not set the first image in the post
* The default image of the site is set when the post has no image. 
* If post has image then the timthumb sets the dimensions of the image to display
* if the custom type is video then the video thumbnail is set as the meta image
*/
function social_get_first_image_url( $width = null, $height=null, $videoalso = false,  $thumbit = false ) {
	
	global $post;
	$img = get_option_tree('ma_ellak_site_image'); //Path to default image
	
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	$first_img = $matches [1] [0];
	
	//search for an image in the post 
	//then search for an attachement
	if(!(empty($first_img))){ 
		if(!$onlyfield)
			$img = $first_img;
	} else if (has_post_thumbnail( $post->ID ) ){ // Check old Featured Image
		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' ); 
		$img = $image[0];
	}
	
	//if it a video
	//check if it is a video 
	$VideoType = get_post( $post->ID);
	if('video'==$VideoType->post_type) {
		$img = social_get_video_thumbnail($post->ID);
	}
	if($thumbit && !empty($img) && strlen($img)>5){
		if(empty($height))
			return get_bloginfo('template_directory').'/scripts/timthumb.php?src='.$img.'&amp;w='.$width.'&amp;q=100&amp;zc=1';
		else 
			return get_bloginfo('template_directory').'/scripts/timthumb.php?src='.$img.'&amp;w='.$width.'&amp;h='.$height.'&amp;q=100&amp;zc=1';
	} else {
		return $img;
	}
}
/**
 * Set the share title
 */
function social_get_title(){
	global $post;
	$title ='';
	//get options site name 
	$title =get_bloginfo('name');
	//post type 
	$title .="-". return_posttype_label($post->post_type);
	//add the page name 
	$title .=" - " . strip_tags(get_the_title());
	return $title;
	
}
/*
* Get a description of the page
*/
function social_get_description() {
	global $post;
	$description =  strip_tags(get_option_tree('ma_ellak_site_description'));
	
	$desc = my_excerpt( $post->post_content, $post->post_excerpt );
	$desc = strip_tags($desc);
	$desc = str_replace("\"", "'", $desc);
	
	if($desc && !empty($desc)){
		$description = strip_tags($desc);
	}
	return $description;
}

function my_excerpt($text, $excerpt){
	
    if ($excerpt) return $excerpt;

    $text = strip_shortcodes( $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
    $text = strip_tags($text);
    $excerpt_length = apply_filters('excerpt_length', 55);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split("/[\n
	 ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
    } else {
            $text = implode(' ', $words);
    }

    return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
/* 
* Here get the Video Thumbnail
*/
function social_get_video_thumbnail($post_id) {
	//Εδώ πρέπει να μπει video link όπως χρησιμοποιείται στο customn type video ;)
	$url = get_post_meta($post_id, '_ma_video_url', true);
	
	$video_url = parse_url($url);
	$imgurl = '';
	if($video_url['host'] == 'www.youtube.com' || $video_url['host'] == 'youtube.com'){
		parse_str( parse_url( $url, PHP_URL_QUERY ), $video_vars );
		$imgurl = "http://img.youtube.com/vi/".$video_vars['v']."/0.jpg";
	} else if($video_url['host'] == 'www.vimeo.com' || $video_url['host'] == 'vimeo.com'){
		$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".substr($video_url['path'], 1).".php"));
		$imgurl = $hash[0]["thumbnail_large"];
	} else if($video_url['host'] == 'www.dailymotion.com' || $video_url['host'] == 'dailymotion.com'){
		$id = strtok(basename($url), '_');
		$thumb = json_decode(file_get_contents("https://api.dailymotion.com/video/".$id ."?fields=thumbnail_url"), true);
		$imgurl = $thumb["thumbnail_url"];
	}
	
	return $imgurl;
}

function social_return_video_url($width = null, $height=null, $post_id){
		$imgUrl = social_get_video_thumbnail($post_id);
		return get_bloginfo('template_directory').'/scripts/timthumb.php?src='.$imgUrl.'&amp;w='.$width.'&amp;h='.$height.'&amp;q=100&amp;zc=1';
		
}

function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}
//http://www.daddydesign.com/wordpress/how-to-create-a-custom-facebook-share-button-with-a-custom-counter/
function social_output(){?>
			 <?php
					global $fbcount,$tcount,$gpluscount;
					$title=urlencode(social_get_title());
					$fburl = curPageURL();//'http://'.$_SERVER['HTTP_HOST'].''.$_SERVER['REQUEST_URI'];
					$url=urlencode($fburl);
					$summary=urlencode(social_get_description());
					$image=urlencode(social_get_first_image_url(200, 200,true,true ));
					$twituser = get_option_tree('ma_ellak_twitter_user');
					$fbcount=$tcount=$gpluscount=0;
			?>
			
      
        
        <?php if(get_post_type($post->ID) == 'video'){?>
        <div class="social socialbar clearfix">
              <ul class="unstyled inline pull-left">
              	<li><a  onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');" target="_parent" href="javascript: void(0)" class="petrol plain" ><i class="icon-facebook-sign"></i><span id='faces'><?php	echo $fbcount; ?></span></a></li>
             	<?php if($twituser!=''){?>
             	<li ><a  onClick="window.open('https://twitter.com/intent/tweet?original_referer=<?php echo $url;?>&amp;related=<?php echo $twituser;?>&amp;text=<?php echo $title;?>&amp;tw_p=tweetbutton&amp;url=<?php echo $url; ?>&amp;via=<?php echo $twituser;?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');" href="javascript: void(0)"  class="petrol plain" target="_blank"><i class="icon-twitter"></i> <span id='tweets'><?php echo $tcount;?></span><?php ?></a></li>
                <?php }?>
                	<li><a   onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo $url; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false" class="petrol plain" target="_blank"><i class="icon-google-plus-sign"></i><span id="googles"> <?php	echo $gpluscount; ?></span></a></li>
                    <li><a  onclick="" class="petrol plain" target="_blank" id="embedLink" ><i  class="fontello icon-export"></i></a></li>
              
              </ul>
              </div>
         <?php }else { ?>
           <div class="row-fluid back-gray social">
          <div class="span6">
            
          </div>
          
          <div class="span6 text-right">
          	<div class="social socialbar clearfix">
            	<ul class="unstyled bordered inline">
            		<li><a  onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $title;?>&amp;p[summary]=<?php echo $summary;?>&amp;p[url]=<?php echo $url; ?>&amp;p[images][0]=<?php echo $image;?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');" target="_parent" href="javascript: void(0)" class="petrol plain" ><i class="icon-facebook-sign"></i><span id="faces"><?php	echo $fbcount; ?></span></a></li>
             		<?php if($twituser!=''){?>
             			<li><a  onClick="window.open('https://twitter.com/intent/tweet?original_referer=<?php echo $url;?>&amp;related=<?php echo $twituser;?>&amp;text=<?php echo $title ;?>&amp;tw_p=tweetbutton&amp;url=<?php echo $url; ?>&amp;via=<?php echo $twituser;?>', 'sharer', 'toolbar=0,status=0,width=550,height=400');"  href="javascript: void(0)"  class="petrol plain" target="_blank"><i class="icon-twitter"></i><span id="tweets"> <?php echo $tcount;?></span></a></li>
                	<?php }?>
                	<li><a   onclick="popUp=window.open('https://plus.google.com/share?url=<?php echo $url; ?>', 'popupwindow', 'scrollbars=yes,width=800,height=400');popUp.focus();return false" class="petrol plain" target="_blank"><i class="icon-google-plus-sign"></i> <span id="googles"><?php	echo $gpluscount; ?></span></a></li>
           	</ul>
            </div>
          </div>
        </div>
        <?php } ?>
	      <script src="http://connect.facebook.net/en_US/all.js"></script>
        
<?php }
/*
function fb_count($url) {
		global $fbcount;
		$ctx = stream_context_create(array('http' => array('timeout' => 10)));
		$facebook = file_get_contents('http://api.facebook.com/restserver.php?method=links.getStats&urls='.$url,0,$ctx);
		$fbbegin = '<share_count>'; $fbend = '</share_count>';
		$fbpage = $facebook;
		$fbparts = explode($fbbegin,$fbpage);
		$fbpage = $fbparts[1];
		$fbparts = explode($fbend,$fbpage);
		$fbcount = $fbparts[0];
		if($fbcount == '') { $fbcount = '0'; }
}
		
function twit_count($url) {	
		global $tcount;
		$ctx = stream_context_create(array('http' => array('timeout' => 10)));
		$twit = file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url='.$url,0,$ctx);
		
		if ($twit) 
		{
  			$response = json_decode($twit);                   
  			$tcount  = $response->count;
		}else
			$tcount =0;
}		
//http://www.tomanthony.co.uk/blog/google_plus_one_button_seo_count_api/
//Count googleplus 
function googleplus_count($url){
	global $gpluscount;
 if(function_exists('curl_version')){
	 $ch = curl_init();  
	 curl_setopt($ch, CURLOPT_URL, "https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ");
	 curl_setopt($ch, CURLOPT_POST, 1);
	 curl_setopt($ch, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	 
	 $curl_results = curl_exec ($ch);
	 curl_close ($ch);
	 
	 $parsed_results = json_decode($curl_results, true);
	 
	 $gpluscount= $parsed_results[0]['result']['metadata']['globalCounts']['count'];
 }else $gpluscount=0;
}
*/
function ma_ellak_social_print_header(){
	if(is_singular()) {
	
		global $post;
	
		// Ðáßñíïõìå ôçí åéêüíá áðï ôï Üñèñï
		$fbimage = social_get_first_image_url(200, 200 );
		$title = strip_tags(social_get_title());
		$desc = social_get_description();
		$site_keywords  = strip_tags(get_option_tree('ma_ellak_site_keywords'));
	
		$posttags = get_the_tags($post->ID);
		$tagz = '';
		if ($posttags) {
			foreach($posttags as $tag) {
				$tagz .= $tag->name.', ';
			}
		}
		?>
		<meta property="og:title" content="<?php echo $title; ?>"/>
		<meta property="og:description" content="<?php echo $desc; ?>"/>
		<meta property="og:url" content="<?php echo urlencode(curPageURL()); ?>"/>
		<meta property="og:image" content="<?php echo $fbimage; ?>"/>
		<meta property="og:type" content="article"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
		
		<meta name="description" content="<?php echo $desc; ?>"/>
		<meta name="keywords" content="<?php echo $tagz; ?><?php echo $site_keywords;?>" /> 
		
	<?php } else { 
		
		
	// Áëëéþò êáôé generic
		$title = strip_tags(social_get_title());
		$fbimage =get_option_tree('ma_ellak_site_image'); //Path to default image
		$fbimage = get_bloginfo('template_directory').'/scripts/timthumb.php?src='.$fbimage.'&amp;w=100LO&amp;q=100&amp;zc=1';
		$site_description =  strip_tags(get_option_tree('ma_ellak_site_description'));
		$site_keywords  = strip_tags(get_option_tree('ma_ellak_site_keywords'));
	?>
		<meta property="og:title" content="<?php echo $title; ?>"/>
		<meta property="og:description" content="<?php echo $site_description; ?>"/>
		<meta property="og:url" content="<?php urlencode(bloginfo( 'url' )); ?>"/>
		<meta property="og:image" content="<?php echo $fbimage; ?>"/>
		<meta property="og:type" content="website"/>
		<meta property="og:site_name" content="<?php bloginfo('name'); ?>"/>
		
		<meta name="description" content="<?php bloginfo('name'); echo " - "; bloginfo('description'); ?>"/>
		<meta name="keywords" content="<?php echo $site_keywords;?>" />
		
<?php } 
}

function ma_ellak_social_print_data ($post_id, $rewrite_permalink, $type){
	$meta=get_post_meta($post_id);
	$stars=$meta['ratings_average'][0];
	if (!isset($stars))
		$stars=0;
	$views=ma_ellak_show_statistics($post_id, $rewrite_permalink);
	if (!isset($views))
		$views=0;

	$numOfComments = get_comments_number( $post_id );
	if ($type=='list'){
		?>
		<div class="under">
			<p class="views-and-likes">
				<i class="icon-eye-open"></i> <?php echo $views; ?> 
				<i class="icon-star"></i> <?php echo $stars;?>
				<?php if($numOfComments>0){?>
				<i class="icon-comments"><?php echo $numOfComments ?></i>
				<?php }?>
			</p>
		</div>
		<?php
	}
	else if($type=='document'){
	?>
	<div class="under">
		<p class="views-and-likes">
				<i class="icon-eye-open"></i> <?php echo $views; ?>
			</p>
			<div style="clear:both"></div>
		<div id="post_ratings_container">
			<div class="post_ratings_block">
				<?php the_ratings('div', $post_id, true, '');?>
			</div>
			</div>
		</div>
	<?php
	}
	else if ($type=='listview'){
		?>
			<div class="under">
				<p class="views-and-likes">
					<i class="icon-eye-open"></i> <?php echo $views; ?> 
					<?php if($numOfComments>0){?>
						<i class="icon-comments"><?php echo $numOfComments;?> </i>
					<?php }?>
					
			</p>
			</div>
			<?php
		}
		
	else if ($type=='purple'){
	?>
		<div class="back-gray viewingstats">
			<ul class="unstyled inline">
				<li><span class="magenta"><i class="icon-eye-open"></i> <?php echo $views; ?></span></li>
				<?php if($numOfComments>0){?>
				<li><span class="magenta"><i class="icon-comments"></i> <?php echo $numOfComments; ?></span></li>
				<?php }?>
				
			</ul>
			<?php if(function_exists('like_counter_p')) { like_counter_p(''); }?>
			<?php if(function_exists('dislike_counter_p')) { dislike_counter_p(''); }?>
			<div class="border"></div>
			<div class="ratings">
			<?php the_ratings('div', $post_id, true, 'video');?>
			</div>	
		</div>
	<?php
	}
}
	
function ma_ellak_show_statistics($post_id, $rewrite_permalink){
	global $wpdb;

	$url=get_permalink($post_id);
	$new_url=explode($rewrite_permalink, $url);
	$search=$rewrite_permalink.$new_url[1];
	$search="%".$search;

	$query="SELECT count(*) FROM ma_wassup WHERE urlrequested LIKE '%s'";
	$views=$wpdb->get_var($wpdb->prepare($query, $search));
	return $views;
}
?>