<?php
/**
* Αρχείο Προβολής Buddypress / Group
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*/

// Dummy Fix to Redirect the Global Activity
if (strpos($_SERVER['REQUEST_URI'],'/activity/') !== false and strpos($_SERVER['REQUEST_URI'],'/members/') === false) 
	header('Location: '.get_bloginfo('url'));
		
get_header();

if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php the_content(); ?>
		
<?php endwhile; else: ?>
    <p>Sorry, no pages matched your criteria.</p>
<?php
  endif; 
  get_footer();
?>