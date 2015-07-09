<?php
/*
Template Name: newsletter monadon
*/ ?>
<?php get_header(); ?>

<STYLE type="text/css">
/* ------------------------------------- 
		GLOBAL 
------------------------------------- */

#eth
{

	float:left;
}

#eth2
{

	float:left;
}

.title1 {

	background-color:#FAED4B;
  font-size:16px;
  font-weight:bold;
  margin-left:44px;
 margin-top:136px;
  padding:13px;
}

.title2 {

background-color:#FAED4B;
  font-size:16px;
  font-weight:bold;
  margin-left:121px;
  margin-top:74px;
  padding:13px;
}

* { 
	margin:0;
	padding:0;
}
/** * { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; } */

img { 
	max-width: 100%; 
}
.collapse {
	margin:0;
	padding:0;
}
body {
	-webkit-font-smoothing:antialiased; 
	-webkit-text-size-adjust:none; 
	width: 100%!important; 
	height: 100%;
}


/* ------------------------------------- 
		ELEMENTS 
------------------------------------- */
a { color: #57294C; text-decoration: none;}

.btn {
	color:#57294C;
  cursor:pointer;
  display:inline-block;
  font-size:13px;
  font-weight:bold;]

}
.btn a {

text-decoration: none!important;
}
p.callout {
	padding:15px;
	background-color:#ECF8FF;
	margin-bottom: 15px;
}
.callout a {
	font-weight:bold;
	color: #2BA6CB;
}

table.social {
/* 	padding:15px; */
	background-color: #FFFFFF;
	
}
.social .soc-btn {
	padding: 3px 7px;
	font-size:12px;
	margin-bottom:10px;
	text-decoration:none;
	color: #FFF;font-weight:bold;
	display:block;
	text-align:center;
}
a.fb { background-color: #3B5998!important; }
a.tw { background-color: #1daced!important; }
a.gp { background-color: #DB4A39!important; }
a.ms { background-color: #000!important; }

.sidebar .soc-btn { 
	display:block;
	width:100%;
}

/* ------------------------------------- 
		HEADER 
------------------------------------- */
table.head-wrap { width: 100%;}

.header.container table td.logo { padding: 15px; }
.header.container table td.label { padding: 15px; padding-left:0px;}


/* ------------------------------------- 
		BODY 
------------------------------------- */
table.body-wrap { width: 100%;}


/* ------------------------------------- 
		FOOTER 
------------------------------------- */
table.footer-wrap { width: 100%;	clear:both!important;
}
.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
.footer-wrap .container td.content p {
	font-size:10px;
	font-weight: bold;
	
}


/* ------------------------------------- 
		TYPOGRAPHY 
------------------------------------- */
/**h1,h2,h3,h4,h5,h6 {
font-family: "HelveticaNeue-Light", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
}*/
h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

h1 { font-size:32px;
  font-weight:bold;
  text-align:center;}

h2 { font-weight:200; font-size: 37px;}
h3 { background-color:#FAED4B;
  font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size:15px;
  font-weight:bold;
  margin-top:10px;
  padding:11px;
  text-align:center;
}

h3 a {

	text-decoration: none;
	font-size: 12px;
}

h4 { font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size:12px;
  font-weight:normal!important; 

  margin-top:8px;}




h5 { font-weight:900; font-size: 17px;}
h6 { font-weight:900; font-size: 14px; text-transform: inherit; color:#444;}

.collapse { margin:10px!important;}

p, ul { 
	/**margin-bottom: 10px; 
	font-weight: normal; 
	font-size:14px; 
	line-height:1.6;*/
}
p.lead { background-color:#FAED4B;
  font-size:17px;
  font-weight:bold;
  text-align:center;}


p.last { margin-bottom:0px;}

ul li {
	margin-left:5px;
	list-style-position: inside;
}

/* ------------------------------------- 
		SIDEBAR 
------------------------------------- */
ul.sidebar {
	background:#ebebeb;
	display:block;
	list-style-type: none;
}
ul.sidebar li { display: block; margin:0;}
ul.sidebar li a {
	text-decoration:none;
	color: #666;
	padding:10px 16px;
/* 	font-weight:bold; */
	margin-right:10px;
/* 	text-align:center; */
	cursor:pointer;
	border-bottom: 1px solid #777777;
	border-top: 1px solid #FFFFFF;
	display:block;
	margin:0;
}
ul.sidebar li a.last { border-bottom-width:0px;}
ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



/* --------------------------------------------------- 
		RESPONSIVENESS
		Nuke it from orbit. It's the only way to be sure. 
------------------------------------------------------ */

/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
.container {
	display:block!important;
	max-width:800px!important;
	
	clear:both!important;
	margin-left:auto;
  margin-right:auto;
}

/* This should also be a block element, so that it will fill 100% of the .container */
.content {
	padding:9px;
	width:800px!important;
	margin:0 auto;
	display:block;
	background-color: whitesmoke;
}

/* Let's make sure tables in the content area are 100% wide */
.content table { width: 100%; }


.content1 {
	padding:9px;
	width:350px;
	display:block;
	float: left;
}

/* Let's make sure tables in the content area are 100% wide */
.content1 table { width: 100%; }


.content2 {
	padding:9px;
	width:350px;
	display:block;
	float: left;
}

/* Let's make sure tables in the content area are 100% wide */
.content2 table { width: 100%; }

#leftcol 
{

float: left;
width:350px;
border-right: 1px solid #57294C;
padding-right:40px;
}

#rightcol 
{
float:left;
  padding-left:31px;
  padding-top:8px;
  width:350px;
}



/* Odds and ends */
.column {
	width: 300px;
	float:left;
}
.column tr td { padding: 15px; }
.column-wrap { 
	padding:0!important; 
	margin:0 auto; 
	max-width:600px!important;
}
.column table { width:100%;}
.social .column {
	width: 280px;
	min-width: 279px;
	float:left;
}

/* Be sure to place a .clear element after each set of columns, just to be safe */
.clear { display: block; clear: both; }


/* ------------------------------------------- 
		PHONE
		For clients that support media queries.
		Nothing fancy. 
-------------------------------------------- */
@media only screen and (max-width: 600px) {
	
	a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

	div[class="column"] { width: auto!important; float:none!important;}
	
	table.social div[class="column"] {
		width:auto!important;
	}

}






/*------------------------ */
.col1{
  background:url(http://ma.ellak.gr/wp-content/themes/ma_ellak/images/stock-stats.png) 50% 50% / cover no-repeat;
 width:23%;
  padding:13px;
  float: left;
  margin-right:32px;
}
.col2{
  
width:34%;

   float: left;

}
.col3{
  width:34%;
   float: left;
   margin-right:7px;
}
.count {
  background:#FAED4B;
  border-bottom-left-radius:2em;
  border-bottom-right-radius:2em;
  border-top-left-radius:2em;
  border-top-right-radius:2em;
  color:#57294C;
  display:inline-block;
  font-size:16px !important;
  font-weight:300 !important;
  height:1.5em;
  padding:0.75em;
  text-align:center;
  width:1.5em;
  margin-bottom:12px;

}


.col1 li a {
color:#FFFFFF;
  font-size:19px;
  font-weight:900;
  padding-left:0.5em;
  text-decoration:none;
  text-transform:inherit
}

ul.unstyled, ol.unstyled {
  list-style:none;
  margin-left:0;
}

.col2 li
{

	 border-bottom-color:#F2F2F2;
  border-bottom-style:solid;
  border-bottom-width:1px;
  line-height:50px;
  padding:10px 0;
  position:relative;
}

.col2 li a 

{


	color:#57294C;
  
  line-height:1.25;
  vertical-align:middle;
  text-decoration:none;
}

.accordion-graphic
{


}

.accordion-graphic img
{
float:left !important;
  margin-right:15px;
  margin-bottom:15px;

}
.col3 li
{

	 border-bottom-color:#F2F2F2;
  border-bottom-style:solid;
  border-bottom-width:1px;
  line-height:50px;
  padding:10px 0;
  position:relative;
}

.col3 li a 

{


	color:#57294C;
  
  line-height:1.25;
  vertical-align:middle;
  text-decoration:none;
}
.accordion-logo
{


}


.accordion-logo img 
{
float:left !important;
  margin-right:15px;
  margin-bottom:17px;



}

small {

	background-color: #FAED4B;
}
</STYLE>

<div class="row-fluid">
 
<body bgcolor="#FFFFFF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#FFFFFF">
	<tr>
		<td></td>
		<td class="header container" align="">
			
			<!-- /content -->
			<div class="content">
				<table bgcolor="#FFFFFF" >
					<tr>
						<td><img width="800px" src="https://newsletter.ellak.gr/monades_aristeias/images/maellak_header.png" /></td>
						<td align="right"><!--<img align="center" src="http://newsletter.ellak.gr/monades_aristeias/images/eellak.png" />--><h6 class="collapse"></h6></td>
					</tr>
				</table>
			</div><!-- /content -->
			
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->

<!-- BODY -->
<table class="body-wrap" bgcolor="">
	<tr>
		<td></td>
		<td class="container" align="" bgcolor="#FFFFFF">
			
			<!-- content -->
			<div class="content">
				<table>
					<tr>
						<td>
							
							<h1>Οι Μονάδες Αριστείας ΕΛ/ΛΑΚ</h1>
							
							
							<center>
							<p>Οι <b>Μονάδες Αριστείας</b>, είναι ομάδες σε <b>Πανεπιστημιακά Ιδρύματα</b> και <b>Ερευνητικά Κέντρα</b> που υλοποιούν το έργο του Εθνικού Δικτύου Έρευνας & Τεχνολογίας «<b>Ηλεκτρονικές Υπηρεσίες για την Ανάπτυξη και Διάδοση του Ανοιχτού Λογισμικού</b>» </p>
							</center>
							<hr />
						 
							
<!--
						     <p><img height="250px" src="http://newsletter.ellak.gr/monades_aristeias/images/fbheader.png" /></p>
							<p><img height="250px" src="http://newsletter.ellak.gr/monades_aristeias/images/fbheader.png" /></p>

							-->
						</td>
					</tr>
				</table>
			</div><!-- /content -->
			<div id="leftcol">
			<!-- content -->
			<div class="content1">
				<h3>Εκδηλώσεις Μονάδων Αριστείας
				<br /> <a href="http://ma.ellak.gr/list-events/eventslist/?pagetype=old">Όλες</a> | <a href="http://ma.ellak.gr/videopage/videolist/">Βίντεο</a> </h3>
				<table bgcolor="">
					<tr>
						<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/UAegean_LOGO_EN-%CE%BC%CF%80%CE%BB%CE%B5_no_background-2.png" /></td>
						<td>
							<small>Πανεπιστημιο Αιγαιου</small><h4>Ηλεκτρονικες Υπηρεσιες – Ανοιχτο Λογισμικο στις Μεταφορες και τη Ναυτιλια (Μαιος 2014) <a href="http://ma.ellak.gr/events/%CE%B7%CE%BB%CE%B5%CE%BA%CF%84%CF%81%CE%BF%CE%BD%CE%B9%CE%BA%CE%AD%CF%82-%CF%85%CF%80%CE%B7%CF%81%CE%B5%CF%83%CE%AF%CE%B5%CF%82-%CE%B1%CE%BD%CE%BF%CE%B9%CF%87%CF%84%CF%8C-%CE%BB%CE%BF%CE%B3%CE%B9/" class="btn">περισσότερα &raquo;</a></h4>
							
							
						</td>
					</tr>
				</table>
			
			</div><!-- /content -->
			
			<!-- content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/UOM_logo_new_GR300.jpg" /></td>
					<td>
						<small>Πανεπιστημιο Μακεδονιας</small><h4>Θερινό Σχολείο Κώδικα ΕΛ/ΛΑΚ σε επιχειρηματικές εφαρμογές/υπηρεσίες για μικρομεσαίες επιχειρήσεις <a href="http://ma.ellak.gr/events/%CE%B8%CE%B5%CF%81%CE%B9%CE%BD%CE%BF-%CF%83%CF%87%CE%BF%CE%BB%CE%B5%CE%B9%CE%BF-%CE%BA%CF%89%CE%B4%CE%B9%CE%BA%CE%B1-%CE%B5%CE%BB%CE%BB%CE%B1%CE%BA-%CF%83%CE%B5-%CE%B5%CF%80%CE%B9%CF%87%CE%B5%CE%B9/" class="btn">περισσότερα &raquo;</a></h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/logo-ioa.png" /></td>
					<td>
						<small>Πανεπιστημιο Ιωαννινων & Επιστημονικο και Τεχνολογικο Παρκο Ηπειρου</small><h4>Πρώτος κύκλος εκπαιδευτικών σεμιναρίων της Μονάδας Αριστείας ΕΛ/ΛΑΚ Ιωαννίνων <a href="http://ma.ellak.gr/events/%CF%80%CF%81%CF%8C%CF%83%CE%BA%CE%BB%CE%B7%CF%83%CE%B7-%CF%83%CF%85%CE%BC%CE%BC%CE%B5%CF%84%CE%BF%CF%87%CE%AE%CF%82-%CF%83%CF%84%CE%BF%CE%BD-%CF%80%CF%81%CF%8E%CF%84%CE%BF-%CE%BA%CF%8D%CE%BA%CE%BB/" class="btn">περισσότερα &raquo;</a>
</h4>
					
					</td>
				</tr>
			</table></div><!-- /content -->

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/PANEPISTIMIO-PATRON-logo-4xromo.jpg" /></td>
					<td>
						<small>Πανεπιστημιο Πατρων</small><h4>1ο Σεμινάριο ΕΛ/ΛΑΚ της Μονάδας Αριστείας του Πανεπιστημίου Πατρών <a href="http://ma.ellak.gr/events/%CF%80%CF%81%CF%8C%CF%83%CE%BA%CE%BB%CE%B7%CF%83%CE%B7-%CF%83%CF%85%CE%BC%CE%BC%CE%B5%CF%84%CE%BF%CF%87%CE%AE%CF%82-%CF%83%CE%B5-%CF%83%CE%B5%CE%BC%CE%B9%CE%BD%CE%AC%CF%81%CE%B9%CE%BF-%CE%B5%CE%BB/" class="btn">περισσότερα &raquo;</a>
</h4>
						<small>Πανεπιστημιο Πατρων</small><h4>2ο Σεμινάριο ΕΛ/ΛΑΚ της Μονάδας Αριστείας του Πανεπιστημίου Πατρών <a href="http://ma.ellak.gr/events/%CF%80%CF%81%CF%8C%CF%83%CE%BA%CE%BB%CE%B7%CF%83%CE%B7-%CF%83%CF%85%CE%BC%CE%BC%CE%B5%CF%84%CE%BF%CF%87%CE%AE%CF%82-%CF%83%CF%84%CE%BF-2%CE%BF-%CF%83%CE%B5%CE%BC%CE%B9%CE%BD%CE%AC%CF%81%CE%B9%CE%BF/" class="btn">περισσότερα &raquo;</a>
</h4>
					</td>


				</tr>
			</table></div><!-- /content -->

			

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/Logo_teiath.gif" /></td>
					<td>
						<small>ΤΕΙ Αθηνας</small><h4>Αποθετήρια & Ανοικτοί Εκπαιδευτικοί Πόροι (ΑΕΠ) <a href="http://ma.ellak.gr/events/%CE%B1%CF%80%CE%BF%CE%B8%CE%B5%CF%84%CE%AE%CF%81%CE%B9%CE%B1-%CE%B1%CE%BD%CE%BF%CE%B9%CE%BA%CF%84%CE%BF%CE%AF-%CE%B5%CE%BA%CF%80%CE%B1%CE%B9%CE%B4%CE%B5%CF%85%CF%84%CE%B9%CE%BA%CE%BF%CE%AF-%CF%80/" class="btn">περισσότερα &raquo;</a>
</h4>
	    				<small>ΤΕΙ Αθηνας</small><h4>Θερινό Σχολείο Ανάπτυξης Κώδικα, με θέμα: Ανάπτυξη εφαρμογής για κινητές συσκευές του Σ.Δ.Μ. Open eClass <a href="http://ma.ellak.gr/events/%CE%B8%CE%B5%CF%81%CE%B9%CE%BD%CF%8C-%CF%83%CF%87%CE%BF%CE%BB%CE%B5%CE%AF%CE%BF-%CE%B1%CE%BD%CE%AC%CF%80%CF%84%CF%85%CE%BE%CE%B7%CF%82-%CE%BA%CF%8E%CE%B4%CE%B9%CE%BA%CE%B1-%CE%BC%CE%B5-%CE%B8%CE%AD-2/" class="btn">περισσότερα &raquo;</a></h4>

	    			

						
					</td>
				</tr>
			</table></div><!-- /content -->

			

		<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/hua.gif" /></td>
					<td>
						<small>Χαροκοπειο Πανεπιστημιο, Τμημα Πληροφορικης και Τηλεματικης</small><h4>Τουρισμός – Προώθηση και προβολή τουριστικών υποδομών <a href="http://ma.ellak.gr/events/%CF%84%CE%BF%CF%85%CF%81%CE%B9%CF%83%CE%BC%CF%8C%CF%82-%CF%80%CF%81%CE%BF%CF%8E%CE%B8%CE%B7%CF%83%CE%B7-%CE%BA%CE%B1%CE%B9-%CF%80%CF%81%CE%BF%CE%B2%CE%BF%CE%BB%CE%AE-%CF%84%CE%BF%CF%85%CF%81%CE%B9/" class="btn">περισσότερα &raquo;</a>

</h4>

						<small>Χαροκοπειο Πανεπιστημιο, Τμημα Πληροφορικης και Τηλεματικης</small><h4>Πολιτισμός – Διαχείριση Συλλογών <a href="http://ma.ellak.gr/events/%CF%80%CE%BF%CE%BB%CE%B9%CF%84%CE%B9%CF%83%CE%BC%CF%8C%CF%82-%CF%83%CF%85%CF%83%CF%84%CE%AE%CE%BC%CE%B1%CF%84%CE%B1-%CE%B4%CE%B9%CE%B1%CF%87%CE%B5%CE%AF%CF%81%CE%B9%CF%83%CE%B7%CF%82-%CF%83%CF%85/" class="btn">περισσότερα &raquo;</a>

</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/logo5.png" /></td>
					<td>
						<small>Αριστοτελειο Πανεπιστημιο Θεσσαλονικης</small><h4>Πρώτος εκπαιδευτικός κύκλος Σεμιναρίων ΕΛ/ΛΑΚ της Μονάδας Αριστείας του Α.Π.Θ. <a href="http://ma.ellak.gr/events/%CF%80%CF%81%CE%BF%CF%83%CE%BA%CE%BB%CE%B7%CF%83%CE%B7-%CF%83%CF%85%CE%BC%CE%BC%CE%B5%CF%84%CE%BF%CF%87%CE%B7%CF%83-%CF%83%CF%84%CE%BF-%CF%80%CF%81%CF%89%CF%84%CE%BF-%CF%83%CE%B5%CE%BC%CE%B9%CE%BD/" class="btn">περισσότερα &raquo;</a>

</h4>
							<small>Αριστοτελειο Πανεπιστημιο Θεσσαλονικης</small><h4>Δεύτερος εκπαιδευτικός κύκλος Σεμιναρίων ΕΛ/ΛΑΚ της Μονάδας Αριστείας του Α.Π.Θ. <a href="http://ma.ellak.gr/events/%CF%80%CF%81%CE%BF%CF%83%CE%BA%CE%BB%CE%B7%CF%83%CE%B7-%CF%83%CF%85%CE%BC%CE%BC%CE%B5%CF%84%CE%BF%CF%87%CE%B7%CF%83-%CF%83%CF%84%CE%BF-%CE%B4%CE%B5%CF%85%CF%84%CE%B5%CF%81%CE%BF-%CF%83%CE%B5%CE%BC/" class="btn">περισσότερα &raquo;</a>


</h4>
							<small>Αριστοτελειο Πανεπιστημιο Θεσσαλονικης</small><h4>Θερινό Σχολείο Ανάπτυξης Κώδικα από τη Μονάδα Αριστείας ΕΛ/ΛΑΚ του A.Π.Θ <a href="http://ma.ellak.gr/events/%CE%B8%CE%B5%CF%81%CE%B9%CE%BD%CF%8C-%CF%83%CF%87%CE%BF%CE%BB%CE%B5%CE%AF%CE%BF-%CE%B1%CE%BD%CE%AC%CF%80%CF%84%CF%85%CE%BE%CE%B7%CF%82-%CE%BA%CF%8E%CE%B4%CE%B9%CE%BA%CE%B1-%CE%B1%CF%80%CF%8C-%CF%84/" class="btn">περισσότερα &raquo;</a>


</h4>
								<small>Αριστοτελειο Πανεπιστημιο Θεσσαλονικης</small><h4>1η ημερίδα ΕΛ/ΛΑΚ της Μονάδας Αριστείας του Α.Π.Θ. <a href="http://ma.ellak.gr/events/1%CE%B7-%CE%B7%CE%BC%CE%B5%CF%81%CE%B9%CE%B4%CE%B1-%CE%BC%CE%BF%CE%BD%CE%B1%CE%B4%CE%B1%CF%83-%CE%B1%CF%81%CE%B9%CF%83%CF%84%CE%B5%CE%B9%CE%B1%CF%83-%CE%B1-%CF%80-%CE%B8-%CE%B5%CE%BB%CE%B5%CF%85/" class="btn">περισσότερα &raquo;</a>


</h4>


						
					</td>
				</tr>
			</table></div><!-- /content -->

			
			

			

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/10/imis_logo_new_vertical.png" /></td>
					<td>
						<small>Ινστιτουτο Πληροφοριακων Συστηματων / Ερευνητικο Κεντρο "Αθηνα"</small><h4>Συστήματα Γεωγραφικών Πληροφοριών – 1ος Κύκλος Εκπαίδευσης <a href="http://ma.ellak.gr/events/%CF%83%CF%85%CF%83%CF%84%CE%AE%CE%BC%CE%B1%CF%84%CE%B1-%CE%B3%CE%B5%CF%89%CE%B3%CF%81%CE%B1%CF%86%CE%B9%CE%BA%CF%8E%CE%BD-%CF%80%CE%BB%CE%B7%CF%81%CE%BF%CF%86%CE%BF%CF%81%CE%B9%CF%8E%CE%BD-1/" class="btn">περισσότερα &raquo;</a>


</h4>

						<small>Ινστιτουτο Πληροφοριακων Συστηματων / Ερευνητικο Κεντρο "Αθηνα"</small><h4>Αγροτική Ανάπτυξη – Περιβάλλον – 1ος Κύκλος Εκπαίδευσης <a href="http://ma.ellak.gr/events/%CE%B1%CE%B3%CF%81%CE%BF%CF%84%CE%B9%CE%BA%CE%AE-%CE%B1%CE%BD%CE%AC%CF%80%CF%84%CF%85%CE%BE%CE%B7-%CF%80%CE%B5%CF%81%CE%B9%CE%B2%CE%AC%CE%BB%CE%BB%CE%BF%CE%BD-1%CE%BF%CF%82-%CE%BA%CF%8D/" class="btn">περισσότερα &raquo;</a>


</h4>

						<small>Ινστιτουτο Πληροφοριακων Συστηματων / Ερευνητικο Κεντρο "Αθηνα"</small><h4>Συστήματα Γεωγραφικών Πληροφοριών – Σχολείο Ανάπτυξης Κώδικα <a href="http://ma.ellak.gr/events/%CF%83%CF%85%CF%83%CF%84%CE%AE%CE%BC%CE%B1%CF%84%CE%B1-%CE%B3%CE%B5%CF%89%CE%B3%CF%81%CE%B1%CF%86%CE%B9%CE%BA%CF%8E%CE%BD-%CF%80%CE%BB%CE%B7%CF%81%CE%BF%CF%86%CE%BF%CF%81%CE%B9%CF%8E%CE%BD/"  class="btn">περισσότερα &raquo;</a>

</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->

		

			

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="60px" src="http://ma.ellak.gr/wp-content/uploads/2013/09/%CE%9B%CE%BF%CE%B3%CF%8C%CF%84%CF%85%CF%80%CE%BF-%CE%A0%CE%9A.png" /></td>
					<td>
						<small>Πανεπιστημιο Κρητης</small><h4>Αξιοποίηση Δεδομένων & Κοινωνικά Δίκτυα στο Τουρισμό – Αποθετήρια & Ανοικτοί Εκπαιδευτικοί Πόροι <a href="http://ma.ellak.gr/events/%CF%83%CE%B5%CE%BC%CE%B9%CE%BD%CE%AC%CF%81%CE%B9%CE%BF-%CE%B1%CE%BE%CE%B9%CE%BF%CF%80%CE%BF%CE%AF%CE%B7%CF%83%CE%B7-%CE%B4%CE%B5%CE%B4%CE%BF%CE%BC%CE%AD%CE%BD%CF%89%CE%BD-%CE%BA%CE%BF%CE%B9%CE%BD/" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
	<div id="eth">
<div class="title1"><a href="http://ma.ellak.gr/search-profile/?action=search"> Αναζητήστε Επαγγελματία/Εθελοντή</a></div>
</div>	

<br />
<br />
<div id="eth2">
<div class="title2"><a href="http://ma.ellak.gr/search-profile/?action=search"> Λίστα Εργασιών</a></div>
</div>		
</div>


<div id="rightcol">
<h3>Αναζήτηση Λογισμικού ανά Θεματική περιοχή <br />&nbsp;</h3>

<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px"  style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/9/920f695e9a24d7fc0418c6494e4de9b4-bpfull.png" /></td>
					<td>
						<small>Πολιτισμός</small><h4>OpenSim ,Blender,Αποθετήριο Fedora,DSpace, GIMP, OMEKA, WordPress Χαροκόπειο Πανεπιστήμιο, Τμήμα Πληροφορικής και Τηλεματικής <a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25cf%2580%25ce%25bf%25ce%25bb%25ce%25b9%25cf%2584%25ce%25b9%25cf%2583%25ce%25bc%25cf%258c%25cf%2582&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/4/fce7c88d05319b8bffa614899f727dc3-bpfull.png" /></td>
					<td>
						<small>Συστήματα γεωγραφικών πληροφοριών</small><h4>GeoNetwork opensource, OpenLayers, GeoServer, MapServer, PostgreSQL, PostGIS, OSGeo Live, QGIS (Quantum GIS)<a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25cf%2583%25cf%2585%25cf%2583%25cf%2584%25ce%25ae%25ce%25bc%25ce%25b1%25cf%2584%25ce%25b1-%25ce%25b3%25ce%25b5%25cf%2589%25ce%25b3%25cf%2581%25ce%25b1%25cf%2586%25ce%25b9%25ce%25ba%25cf%258e-%25cf%2580%25ce%25bb%25ce%25b7%25cf%2581%25ce%25bf%25cf%2586%25ce%25bf%25cf%2581%25ce%25b9%25cf%258e%25ce%25bd&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn"> περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/7/ae801358abd68a194fe18d50358fad30-bpfull.png" /></td>
					<td>
						<small>Αγροτική ανάπτυξη-Περιβάλλον</small><h4>Agrosense, Crop Planning <a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25ce%25b1%25ce%25b3%25cf%2581%25ce%25bf%25cf%2584%25ce%25b9%25ce%25ba%25ce%25ae-%25ce%25b1%25ce%25bd%25ce%25ac%25cf%2580%25cf%2584%25cf%2585%25ce%25be%25ce%25b7-%25cf%2580%25ce%25b5%25cf%2581%25ce%25b9%25ce%25b2%25ce%25ac%25ce%25bb%25ce%25bb%25ce%25bf%25ce%25bd&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn"> περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/6/996bb941478a9b10a16e4a30d6c54d84-bpfull.png" /></td>
					<td>
						<small>Τουρισμός</small><h4>OpenSim, WP Socializer, ZenPhoto, Drupal, Joomla, WordPress <a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25cf%2584%25ce%25bf%25cf%2585%25cf%2581%25ce%25b9%25cf%2583%25ce%25bc%25cf%258c%25cf%2582&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/5/638abde3ce8e8b0bb6c5b2a92148ca06-bpfull.png" /></td>
					<td>
						<small>Επιχειρηματικές εφαρμογές/Υπηρεσίες για μικρομεσαίες επιχειρήσεις</small><h4>Vtiger CRM, SugarCRM, OpenCart, Zen Cart E-Commerce Shopping Cart, osCommerce, Drupal, Joomla!, Openbravo ERP, Open ERP – Software Solution for all, ProcessMaker Open Source <a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25ce%25b5%25cf%2580%25ce%25b9%25cf%2587%25ce%25b5%25ce%25b9%25cf%2581%25ce%25b7%25ce%25bc%25ce%25b1%25cf%2584%25ce%25b9%25ce%25ba%25ce%25ad%25cf%2582-%25ce%25b5%25cf%2586%25ce%25b1%25cf%2581%25ce%25bc%25ce%25bf%25ce%25b3%25ce%25ad%25cf%2582%25cf%2585%25cf%2580%25ce%25b7%25cf%2581%25ce%25b5%25cf%2583%25ce%25af%25ce%25b5%25cf%2582&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/1/116a9baf48cd158e723c85cba37345d9-bpfull.png" /></td>
					<td>
						<small>Βασικές εφαρμογές/Εργαλεία ΕΛ/ΛΑΚ</small><h4>Drupal, Joomla <a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25ce%25b2%25ce%25b1%25cf%2583%25ce%25b9%25ce%25ba%25ce%25ad%25cf%2582-%25ce%25b5%25cf%2586%25ce%25b1%25cf%2581%25ce%25bc%25ce%25bf%25ce%25b3%25ce%25ad%25cf%2582%25ce%25b5%25cf%2581%25ce%25b3%25ce%25b1%25ce%25bb%25ce%25b5%25ce%25af%25ce%25b1-%25ce%25b5%25ce%25bb%25ce%25bb%25ce%25b1%25ce%25ba&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/3/b957f9ce3f0912e94802053d74ac889f-bpfull.png" /></td>
					<td>
						<small>Δημόσια διοίκηση και τοπική αυτοδιοίκηση</small><h4>Open Spending, opengovernment, Fix my street, Open-Data-Catalog <a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25ce%25b4%25ce%25b7%25ce%25bc%25cf%258c%25cf%2583%25ce%25b9%25ce%25b1-%25ce%25b4%25ce%25b9%25ce%25bf%25ce%25af%25ce%25ba%25ce%25b7%25cf%2583%25ce%25b7-%25ce%25ba%25ce%25b1%25ce%25b9-%25cf%2584%25ce%25bf%25cf%2580%25ce%25b9%25ce%25ba%25ce%25ae-%25ce%25b1%25cf%2585%25cf%2584%25ce%25bf%25ce%25b4%25ce%25b9%25ce%25bf%25ce%25af&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/2/b507359f9a62284d6c51d8b4b5ed864a-bpfull.png" /></td>
					<td>
						<small>Εκπαιδευτικό λογισμικό</small><h4>OpenSim, Invenio, Dspace, Moodle, OpenMeetings, Drupal, Joomla, WordPress, Invenio, Openmeetings <a href="http://ma.ellak.gr/search-software/?keyword=&type=0&thema=%25ce%25b5%25ce%25ba%25cf%2580%25ce%25b1%25ce%25b9%25ce%25b4%25ce%25b5%25cf%2585%25cf%2584%25ce%25b9%25ce%25ba%25cf%258c-%25ce%25bb%25ce%25bf%25ce%25b3%25ce%25b9%25cf%2583%25ce%25bc%25ce%25b9%25ce%25ba%25cf%258c&nace=0&licence=0&frascati=0&submit=%CE%95%CF%86%CE%B1%CF%81%CE%BC%CE%BF%CE%B3%CE%B7" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->


			
</div>

<div id="rightcol">
<h3>Βιβλιοθήκη αρχείων</h3>
<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/7/ae801358abd68a194fe18d50358fad30-bpfull.png" /></td>
					<td>
						<small>Αγροτική ανάπτυξη-Περιβάλλον</small><h4>Εισαγωγή στο ΕΛΛΑΚ για εφαρμογές αγροτικής ανάπτυξης και περιβάλλοντος<a href="http://ma.ellak.gr/list-files/?action=listthema&term=8" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/1/116a9baf48cd158e723c85cba37345d9-bpfull.png" /></td>
					<td>
						<small>Βασικές εφαρμογές/Εργαλεία ΕΛ/ΛΑΚ</small><h4>Περιγραφή Έργου Συνεισφοράς, Θερινού Σχολείου με θέμα, PhoneGap, Εισαγωγή στο git, Slim Framework / Web APIs <a href="http://ma.ellak.gr/list-files/?action=listthema&term=2" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/3/b957f9ce3f0912e94802053d74ac889f-bpfull.png" /></td>
					<td>
						<small>Δημόσια διοίκηση και τοπική αυτοδιοίκηση</small><h4>Παρουσίαση Java/JEE, Παρουσίαση PHP – Θερινό Σχολείο Κώδικα Α.Π.Θ, Παρουσίαση Git – Θερινό Σχολείο Κώδικα Α.Π.Θ <a href="http://ma.ellak.gr/list-files/?action=listthema&term=4" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/2/b507359f9a62284d6c51d8b4b5ed864a-bpfull.png" /></td>
					<td>
						<small>Εκπαιδευτικό λογισμικό</small><h4>Περιγραφή Έργου Συνεισφοράς, Θερινού Σχολείου με θέμα, PhoneGap, Εισαγωγή στο git, Slim Framework / Web APIs, Αρχιτεκτονική Open eClass<a href="http://ma.ellak.gr/list-files/?action=listthema&term=3" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/5/638abde3ce8e8b0bb6c5b2a92148ca06-bpfull.png" /></td>
					<td>
						<small>Επιχειρηματικές εφαρμογές/Υπηρεσίες για μικρομεσαίες επιχειρήσεις</small><h4>Introduction to Free Software, Παρουσίαση 2ου Σεμιναρίου(2ος Εκπαιδευτικός Κύκλος) Μονάδας Αριστείας Α.Π.Θ <a href="http://ma.ellak.gr/list-files/?action=listthema&term=6" class="btn"> περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/8/6d43b84045eadd3aaca46668170d166e-bpfull.png" /></td>
					<td>
						<small>Μεταφορές-Ναυτιλία</small><h4>ΣΕΜΙΝΑΡΙΟ Σ1_Μεταφορές – Ναυτιλία: Μια συνθετική εικόνα των πηγών πληροφορίας και των εργαλείων, UAegean_OSS-CoE_Seminar1 (Μάιος – Ιούλιος 2014): Κατάλογος Συμμετεχόντων <a href="http://ma.ellak.gr/list-files/?action=listthema&term=9" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/10/ab421b66c0a5634070c4bd09272c3636-bpfull.png" /></td>
					<td>
						<small>Πληροφοριακά συστήματα υγείας </small><h4>Παρουσίαση Java/JEE, Παρουσίαση PHP – Θερινό Σχολείο Κώδικα Α.Π.Θ, Παρουσίαση Git – Θερινό Σχολείο Κώδικα Α.Π.Θ <a href="http://ma.ellak.gr/list-files/?action=listthema&term=11" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/8/6d43b84045eadd3aaca46668170d166e-bpfull.png" /></td>
					<td>
						<small>Πολιτισμός </small><h4> Δημιουργία Ψηφιακών Συλλογών με Omeka, Ψηφιακό αποθετήριο Omeka, Δημιουργία ιστοσελίδας με WordPress – Βασικές λειτουργίες <a href="http://ma.ellak.gr/list-files/?action=listthema&term=10" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/4/fce7c88d05319b8bffa614899f727dc3-bpfull.png" /></td>
					<td>
						<small>Συστήματα γεωγραφικών πληροφοριών </small><h4>Παρουσίαση της πλατφόρμας OpenStreetMap, Εισαγωγή στο QGIS, Εισαγωγή στη PostGIS, Εισαγωγή στο ΕΛΛΑΚ για Γεωγραφικά Συστήματα Πληροφοριών <a href="http://ma.ellak.gr/list-files/?action=listthema&term=5" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->

			<div class="content1"><table bgcolor="">
				<tr>
					<td class="small" width="75px" style="vertical-align: top; padding-right:10px;"><img width="40px" src="http://ma.ellak.gr/wp-content/uploads/group-avatars/6/996bb941478a9b10a16e4a30d6c54d84-bpfull.png" /></td>
					<td>
						<small>Τουρισμός </small><h4>Πολυγλωσσία στο WordPress, Εγκατάσταση και χρήση plugins στο WordPress <a href="http://ma.ellak.gr/list-files/?action=listthema&term=7" class="btn">περισσότερα &raquo;</a>


</h4>
						
					</td>
				</tr>
			</table></div><!-- /content -->
</div>
			


			<!-- content -->
			
			
			<!-- content -->
			
			
			<!-- content -->
			
			
			<!-- content -->
			<div class="content">
				<table bgcolor="">
					<tr>
						<td>
							
							<!-- social & contact -->
							<table bgcolor="" class="social" width="100%">
								<tr>
									<td>
										
										<!--- column 1 -->
										<div class="column">
											<table bgcolor="" cellpadding="" align="left">
										<tr>
											<td>				
												
												<h5 class="">Κοινωνικά Δίκτυα </h5>
												<p class=""><a href="https://www.facebook.com/ma.elllak" class="soc-btn fb">Facebook</a> <a href="https://twitter.com/ma_ellak" class="soc-btn tw">Twitter</a> </p>
						
												
											</td>
										</tr>
									</table><!-- /column 1 -->
										</div>
										
										<!--- column 2 -->
										<div class="column">
											<table bgcolor="" cellpadding="" align="left">

										<tr>
											<td>				
																			
												<h5 class="">Επικοινωνία: </h5>												
												<p><br/>
                Email: <strong><a href="info@eellak.gr">info AT eellak.gr </a></strong></p>
                
											</td>
										</tr>
									</table><!-- /column 2 -->	
										</div>
										
										<div class="clear"></div>
	
									</td>
								</tr>

							</table><!-- /social & contact -->
							
						</td>
					</tr>
				</table>
			</div><!-- /content -->
			

		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">
			
				<!-- content -->
				<div class="content">
					<table>
						<tr>
							<td align="center">
							<p style="font-family: &quot;Lucida Grande&quot;, sans-serif;font-size: 8px;font-weight: normal;color: #151515">Αν δεν επιθυμείτε να λαμβάνετε ενημερώσεις μπορείτε να τροποποιήσετε τις ρυθμίσεις του προφίλ σας <a href="http://pommo.ellak.gr/pommo/login.php">εδώ</a><br/>

               </p>
               <p style="font-family: &quot;Lucida Grande&quot;, sans-serif;font-size: 10px;font-weight: normal;color: #151515">Το υλικό του ΕΛΛΑΚ ΝΕΑ διανέμεται με την άδεια χρήσης:<br/><img src="https://newsletter.ellak.gr/images/cc_BY.png" width="88"/><br/><a style="font-family: &quot;Lucida Grande&quot;, sans-serif;font-size: 10px;font-weight: normal;color: #a72323;text-decoration: none" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons Αναφορά προέλευσης 4.0 Ελλάδα</a>.

               </p>
							<img width="800px" src="https://newsletter.ellak.gr/monades_aristeias/images/footer.png" />
								<p>
									<a href="http://ma.ellak.gr/the-project/">Το Έργο</a> |
									<a href="http://ma.ellak.gr/participate/">Πώς συμετέχω</a>
									
								</p>
							</td>
						</tr>
					</table>
				</div><!-- /content -->
				
		</td>

		<td></td>
	</tr>

</table><!-- /FOOTER -->
</div>
 <?php get_footer();
?>