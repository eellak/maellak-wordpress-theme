  <?php if (!is_home()){?>
   
   
     </div><!-- home container -->
    
    </div><!-- home main -->
    <?php }?>
  <div class="footer">
      <div class="container">
        <div class="row-fluid logos relative">
         <div id="theI"></div>
          <div class="cols clearfix">
            <div class="sponsor col span4 espa">
                <a href="#"><img style="margin-top: 17px; visibility: visible;" src="<?php bloginfo('template_directory'); ?>/images/logo-espa.png" alt="" height="51" width="347"></a>
            </div>
            <div class="sponsor col span2 grnet bordered">
                <a href="https://www.grnet.gr/"><img style="margin-top: 20.5px; visibility: visible;" src="<?php bloginfo('template_directory'); ?>/images/logo-grnet.png" alt="" height="43" width="89"></a>
            </div>
            <div class="sponsor col span2 ministryofeducation bordered">
                <a href="http://www.minedu.gov.gr/"><img style="margin-top: 29.5px; visibility: visible;" src="<?php bloginfo('template_directory'); ?>/images/logo-ministryofeducation.png" alt="" height="31" width="171"></a>
            </div>
            <div class="colophon col span4 gray bordered">
                <p>Η <strong><u>Διαδικτυακή Πύλη των Μονάδων Αριστείας</u></strong> είναι υπο-έργο της πράξης <strong><u>"Ηλεκτρονικές Υπηρεσίες για την Ανάπτυξη και Διάδοση του Ανοιχτού Λογισμικού"</u></strong> που υλοποιείται από το Εθνικό Δίκτυο Έρευνας και Τεχνολογίας. Η πράξη εντάσσεται στο Επιχειρησιακό Πρόγραμμα <strong><u>"Ψηφιακή Σύγκλιση" του ΕΣΠΑ</u></strong> (με τη συγχρηματοδότηση της Ελλάδας και της Ευρωπαϊκής Ένωσης - Ευρωπαϊκό Ταμείο Περιφερειακής Ανάπτυξης).</p>
            </div>
          </div>
        </div>
        <div class="row-fluid bottomline">
		  <?php 			
			$menu = wp_nav_menu( array( 'container_id' => '', 'container_class'=>'span12','theme_location' => 'footer-menu','menu_class'=>'inline','fallback_cb'=> 'fallbackfmenu' , 'echo' => false) ); 
			
			$extra_links = '<li><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" src="http://i.creativecommons.org/l/by-sa/3.0/80x15.png" /></a></li><li class="theYear"><a href="#"><strong>'.date('Y').'</strong></a></li>';
			
			$menu = str_replace('class="inline">','class="inline">'.$extra_links , $menu);
			
			echo $menu;
		  ?>
        </div>
      </div>
    </div>
    <div id="feedback">
    <a href="javascript: opencommentwindow()">
    	<!-- <img src="<?php bloginfo('template_directory'); ?>/images/test-comments.png" width="25" height="164" alt="Στείλτε τα σχόλια σας" title="Στείλτε τα σχόλια σας" >
    	 --><span class="vertical">Υποβολή Σχολίων</span>
    	 </a></div>
   <?php wp_footer()?>
<!--script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-49671538-8', 'ellak.gr');
  ga('send', 'pageview');
</script-->
    <script>
    function opencommentwindow() {
        window.open("https://docs.google.com/forms/d/1wxYYWz42mDxyj-ccp6NbNhUvSnWSi_Tv5qa_8ATUiwA/viewform",
                "Υποβολή Σχολίων", "location=0,status=0,scrollbars=1,width=720,height=1000");
    }
	</script>

  </body>
</html>
