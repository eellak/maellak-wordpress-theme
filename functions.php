<?php
/**
* Κεντρικό Αρχείο functions.php του Theme. Περιέχει όλες τις βασικές συναρτήσεις και καλεί μέσα απο τον φάκελο lib όλα τα υπόλοιπα αρχεία συναρτήσεων.
*
* @licence GPL
* @author Fotis Routsis - fotis@routsis.gr
* 
* Project URL http://ma.ellak.gr
*
*--------------------------------------------------------------------------------------------*
*
* Στο παρόν αρχείο περιέχονται βασικές συναρτήσεις μη σχετικές με συγκεκριμένη υπηρεσία ενώ στο τέλος καλεί τα σχετικά αρχεία μεσα απο τον φάκελο lib.
*
*--------------------------------------------------------------------------------------------*
* Βασικές Οδηγίες.
* 
* 01. Όλα τα ονόματα συναρτήσεων αρχίζουν με ma_ellak_ (δηλαδή ma_ellak_onoma_synartisis()) με όσο το δύνατόν πιο περιγραφικό όνομα.
*
* 03. Πρίν τη δήλωση της συνάρτησης περιέχεται τεκμηρίωση με κατ ελάχιστο: α) τι παραμέτρους αναμένει και β) τι αποτέλεσματα επιστρέφει.
*
* 03. Κατά προτίμηση οι συναρτήσεις που εκτυπώνουν κάτι να εκτελούν return και όχι echo ή print ώστε να χειρίζονται ύστερα προγραμματιστικά.
*
* 04. Τα αρχεία συναρτήσεων ανα υπηρεσία συγκεντρώνονται στον φάκελο /lib με ονόματα ma_ellak_yp1_functions.php (οπου yp1 έως yp9 αναλόγως της υπηρεσίας που εξυπηρετούν).
*
* 05. Γενικής χρήσεων συναρτήσεις (πχ γενικές ταξονομίες κλπ) θα περιέχονται στο lib/ma_ellak_global_functions.php
*
* 06. Ειδικές global μεταβλητές (πχ post ids κλπ) χρήσιμες απο όλο το σύστημα θα αποθηκεύονται στο lib/ma_ellak_global_variables.php
*
* 07. Σελίδες όπου θα ορίζονται ρυθμίσεις μέσα απο το περιβάλλον διαχείρισης (wp-admin) θα αποθηκεύονται στον φάκελο /lib με όνοματα ma_ellak_yp1_options.php (πχ control panel)
*
* 08. Σελίδες όπου θα ορίζονται ρυθμίσεις μέσα απο το περιβάλλον διαχείρισης και αφορούν συνολικά το σύστημα θα περιέχονται σε αρχεία της μορφής lib/ma_ellak_global_options_NAME.php
* 
* 09. Τα αρχεία αποθηκεύονται σε encoding UTF-8.
* 
* 10. Τυχόν AJAX συναρτήσεις που αξιοποιούν το wp-ajax θα περιλαμβάνοναι στο αρχείο lib/ma_ellak_global_ajax.php
*
* 11. Σελίδες Προτύπων (Template Files) αποθηκεύονται στο root φάκελο του θέματος με ονόματα ma_ellak_yp1_tmpl_NAME.php (οπου yp1 έως yp9 αναλόγως της υπηρεσίας που εξυπηρετούν).
* 
* 12. Όλες οι εικόνες θα αποθηκεύονται στον φάκελο /images (εκτός και αν απαιτούνται απο CSS αρχεία με relative path).
*
* 13. Όλα τα javascript θα αποθηκεύονται στον φάκελο /js.
*
* 14. Όλες οι τρίτες βιβλιοθήκες θα αποθηκεύονται στον φάκελο /scripts (πχ php scripts ή κλάσεις απο API εξωτερικών παρόχων)
*
* 15. Τυχόν τρίτα αρχεία CSS που ίσως απαιτηθούν θα αποθηκεύονται στον φάκελο /css
*
* 16. H χρήση συμβολοσειρών θα αξιοποιεί την τεχνική gettext με κατάλληλη χρήση των __() και _e() όπου απαιτείται. To text domain θα είναι το ma-ellak
*
* 17. Όλα τα Μενού (Menu) θα ορίζονται μέσα στο αρχείο lib/ma_ellak_global_menus.php
*
* 18. Τα ονόματα των Custom Fields να ξεκινάνε με underscore (πχ ημερομηνία εκδήλωσης _ma_event_datestart) για να μην φαίνονται στο διαχειριστικό αυτόματα.
*/


// Παρακάτω δηλώνουμε την καταγραφή όλων των σφαλμάτων σε log αρχείο με όνομα ma_ellak_error_log.txt στο φάκελο του Θέματος.
ini_set('display_errors',0); 
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/ma_ellak_error_log.txt');
error_reporting(E_ALL^E_NOTICE^E_STRICT);


// Defined μεταβλητές συστήματος για τους φακέλους (για ευκολία χρήσης). Αφορά URL accessible φακέλους και όχι server ralative paths.
define('ROOT', get_bloginfo('template_url'));
define('JS', ROOT . '/js');
define('IMG', ROOT . '/images');
define('MA_DATE_FORMAT', 'j.m.Y');

// Αφαιρεί τη bar του Buddypress
add_filter( 'show_admin_bar', '__return_false' );

// Προσθέτει τη δυνατότητα Featured Εικόνων σε Σελίδες και Άρθρα
add_theme_support( 'post-thumbnails', array( 'post', 'page' ) ); 

// Προσθέτει τη δυνατότητα Αποσπάσματος στις Σελίδες
add_post_type_support('page', 'excerpt');

// [Ασφάλεια] Αφαιρεί την έκδοση του Wordpress απο τα meta tags του <head> element.
remove_action('wp_head', 'wp_generator'); 

// Καλεί τα αρχεία μεσα απο τον φάκελο lib.
// Αρχεία Γενικών (global) ρυθμίσεων και συναρτήσεων
require_once( TEMPLATEPATH . '/lib/ma_ellak_global_variables.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_global_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_global_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_global_menus.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_global_ajax.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_global_options.php');

// Μονάδες Αριστείας
require_once( TEMPLATEPATH . '/lib/ma_ellak_unit_functions.php');

// Εκδηλώσεις
require_once( TEMPLATEPATH . '/lib/ma_ellak_events_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_ical.php');

// Σελίδα Επιλογών για Αντιστοίχιση Μονάδων Αριστείας & Θεματικών

// Υπηρεσία 2
require_once( TEMPLATEPATH . '/lib/ma_ellak_yp2_functions.php');
// Υπηρεσία 3
require_once( TEMPLATEPATH . '/lib/ma_ellak_yp3_functions.php');
// Υπηρεσία 4
require_once( TEMPLATEPATH . '/lib/ma_ellak_yp4_functions.php');
// Υπηρεσία 5
require_once( TEMPLATEPATH . '/lib/ma_ellak_yp5_functions.php');
// Υπηρεσία 7
require_once( TEMPLATEPATH . '/lib/ma_ellak_yp6_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_yp7_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_yp9_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_social_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_buddypress_functions.php');
require_once( TEMPLATEPATH . '/lib/ma_ellak_calendar.php');
?>