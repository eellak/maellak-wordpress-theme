<?php
/*
Template Name: overview_thematikes
*/ ?>
<?php get_header(); ?>
<div class="col1">
<?php //start by fetching the terms for the animal_cat taxonomy
$terms = get_terms( 'thema', array(
    'orderby'    => 'count',
    'hide_empty' => 0
) );
?>
<h3><b><font size="+1">Πανεπιστήμια</font></b> / Θεματική</h3>

<?php
// now run a query for each animal family
foreach( $terms as $term ) {
 
    // Define the query
    $args = array(
        'post_type' => 'unit',
        'thema' => $term->slug
    );
    $query = new WP_Query( $args );
               
    // output the term name in a heading tag                
    echo'<h2>' . ' ' . $term->name . '</h2>';
     
    
	// output the post titles in a list
    echo '<div class="listcol1">';
      
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>

        <li class="animal-listing" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
    
        <?php endwhile;
     
    echo '</div>';
     
    // use reset postdata to restore orginal query
    wp_reset_postdata();
 
} ?>
 
</div>
<div class="col1">
	<h3><b><font size="+1">Βίντεο</font></b> / Θεματική</h3>
<?php //start by fetching the terms for the animal_cat taxonomy
$terms = get_terms( 'thema', array(
    'orderby'    => 'count',
    'hide_empty' => 1
) );
?>
<?php
// now run a query for each animal family
foreach( $terms as $term ) {
 
    // Define the query
    $args = array(
        'post_type' => 'video',
        'thema' => $term->slug
    );
    $query = new WP_Query( $args );
             
    // output the term name in a heading tag                
    echo'<h2>'. '' . $term->name . '</h2>';
     
    // output the post titles in a list
    echo '<div class="listcol1">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li class="animal-listing" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
     
    echo '</div>';
     
    // use reset postdata to restore orginal query
    wp_reset_postdata();
 
} ?>
</div>

<div class="col1">
	<h3><b><font size="+1">Εκδηλώσεις</font></b> / Θεματική</h3>
<?php //start by fetching the terms for the animal_cat taxonomy
$terms = get_terms( 'thema', array(
    'orderby'    => 'count',
    'hide_empty' => 1
) );
?>
<?php
// now run a query for each animal family
foreach( $terms as $term ) {
 
    // Define the query
    $args = array(
        'post_type' => 'events',
        'thema' => $term->slug
    );
    $query = new WP_Query( $args );
             
    // output the term name in a heading tag                
    echo'<h2>'. '' . $term->name . '</h2>';
     
    // output the post titles in a list
    echo '<div class="listcol1">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li class="animal-listing" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
     
    echo '</div>';
     
    // use reset postdata to restore orginal query
    wp_reset_postdata();
 
} ?>
</div>
<div class="col1">
	<h3><b><font size="+1">Λογισμικό</font></b> / Θεματική</h3>
<?php //start by fetching the terms for the animal_cat taxonomy
$terms = get_terms( 'thema', array(
    'orderby'    => 'count',
    'hide_empty' => 1
) );
?>
<?php
// now run a query for each animal family
foreach( $terms as $term ) {
 
    // Define the query
    $args = array(
        'post_type' => 'software',
        'thema' => $term->slug
    );
    $query = new WP_Query( $args );
             
    // output the term name in a heading tag                
    echo'<h2>' . ''. $term->name . '</h2>';
     
    // output the post titles in a list
    echo '<div class="listcol1">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li class="animal-listing" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
     
    echo '</div>';
     
    // use reset postdata to restore orginal query
    wp_reset_postdata();
 
} ?>
</div>
<div class="colf1">
	<h3><b><font size="+1">Αρχεία</font></b> / Θεματική</h3>
<?php //start by fetching the terms for the animal_cat taxonomy
$terms = get_terms( 'thema', array(
    'orderby'    => 'count',
    'hide_empty' => 1
) );
?>
<?php
// now run a query for each animal family
foreach( $terms as $term ) {
 
    // Define the query
    $args = array(
        'post_type' => 'document',
        'thema' => $term->slug
    );
    $query = new WP_Query( $args );
             
    // output the term name in a heading tag                
    echo'<h2>' . $term->name . '</h2>';
     
    // output the post titles in a list
    echo '<div class="listcol1">';
     
        // Start the Loop
        while ( $query->have_posts() ) : $query->the_post(); ?>
 
        <li class="animal-listing" id="post-<?php the_ID(); ?>">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
         
        <?php endwhile;
     
    echo '</div>';
     
    // use reset postdata to restore orginal query
    wp_reset_postdata();
 
} ?>
</div>

<!--
<?php 
// args1
$args3 = array(
	'numberposts' => 10,
	'post_status'=> 'publish',
	'post_type' => array( '','events' ),
	'tax_query' => array(
	               array(
	                       'taxonomy' => 'thema',
	                       'field' => 'slug',
	                       'terms' => array('βασικές-εφαρμογέςεργαλεία-ελλακ','εκπαιδευτικό-λογισμικό','επιχειρηματικές-εφαρμογέςυπηρεσίες'),
					
							   
	               )
	       ),
		  
);

//?>
<p> Εκδηλώσεις Πανεπιστημίου Πατρών</p>
<?php $the_query = new WP_Query( $args3 );?>

<?php if( $the_query->have_posts() ): ?>
	<ul>
		
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>

 
<?php wp_reset_query();?> 
<?php 
// args1
$args2 = array(
	'numberposts' => 10,
	'post_status'=> 'publish',
	'post_type' => array( '','events' ),
	'tax_query' => array(
	               array(
	                       'taxonomy' => 'thema',
	                       'field' => 'slug',
	                       'terms' => array('εκπαιδευτικό-λογισμικό' , 'βασικές-εφαρμογέςεργαλεία-ελλακ' ,  'επιχειρηματικές-εφαρμογέςυπηρεσίες'),
					
							   
	               )
	       ),
		  
);

//?>
<p> Εκδηλώσεις ΤΕΙ Αθήνας</p>
<?php $the_query = new WP_Query( $args2 );?>

<?php if( $the_query->have_posts() ): ?>
	<ul>
		
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>

 
<?php wp_reset_query();?> 
<?php 
// args1
$args1 = array(
	'numberposts' => 10,
	'post_status'=> 'publish',
	'post_type' => array( '','events' ),
	'tax_query' => array(
	               array(
	                       'taxonomy' => 'thema',
	                       'field' => 'slug',
	                       'terms' => 'δημόσια-διοίκηση-και-τοπική-αυτοδιοί',
					
							   
	               )
	       ),
		  
);

//?>
<p> Εκδηλώσεις ΑΠΘ</p>
<?php $the_query = new WP_Query( $args1 );?>

<?php if( $the_query->have_posts() ): ?>
	<ul>
		
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>

 
<?php wp_reset_query();?> 

	<p> Εκδηλώσεις Πανεπιστημίου Αιγαίου</p>
<?php 
// args
$args = array(
	'numberposts' => 10,
	'post_status'=> 'publish',
	'post_type' => array( '','events' ),
	'tax_query' => array(
	               array(
	                       'taxonomy' => 'thema',
	                       'field' => 'slug',
	                       'terms' => 'μεταφορές-ναυτιλία',
					
							   
	               )
	       ),
		  
);?>
<?php $the_query = new WP_Query( $args);?>

<?php if( $the_query->have_posts() ): ?>
	<ul>
		
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</li>
	<?php endwhile; ?>
	</ul>
<?php endif; ?>
 

<?php wp_reset_query();?>  


 -->


 <?php get_footer();
?>