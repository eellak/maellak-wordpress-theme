(function($){
	$(document).ready( function(){
		
		Radiosource = $('#datafetcher input[type=radio]:checked').val();
		$('#help_message').html('<small>Δηλώστε την διεύθυνση του project στο sourceforge. Βρείτε το όνομα του απο το sourceforge και χρησιμοποιήστε ένα σύνδεσμο της μορφής http://sourceforge.net/projects/ΟΝΟΜΑ. Το όνομα μπορείτε να το βρείτε από το σύνδεσμο που χρησιμοποιεί το ίδιο το sourceforge. Για παράδειγμα το project με όνομα "Apache OpenOffice", έχει ως σύνδεσμο στο φυλλομετρητή τον ακόλουθο http://sourceforge.net/projects/openofficeorg.mirror/?source=frontpage&position=1 εσείς πρέπει να προσθέσετε το σύνδεσμο http://sourceforge.net/projects/openofficeorg.mirror</small>');
		$("#datafetcher input[type=radio]").change(function () {
			Radiosource = $('#datafetcher input[type=radio]:checked').val();
			if(Radiosource=='sourceforge')
				$('#help_message').html('<small>Δηλώστε την διεύθυνση του project στο sourceforge. Βρείτε το όνομα του απο το sourceforge και χρησιμοποιήστε ένα σύνδεσμο της μορφής http://sourceforge.net/projects/ΟΝΟΜΑ. Το όνομα μπορείτε να το βρείτε από το σύνδεσμο που χρησιμοποιεί το ίδιο το sourceforge. Για παράδειγμα το project με όνομα "Apache OpenOffice", έχει ως σύνδεσμο στο φυλλομετρητή τον ακόλουθο http://sourceforge.net/projects/openofficeorg.mirror/?source=frontpage&position=1 εσείς πρέπει να προσθέσετε το σύνδεσμο http://sourceforge.net/projects/openofficeorg.mirror</small>');
			if(Radiosource=='github')		
				$('#help_message').html('<small>Δηλώστε την διεύθυνση του project στο github. Βρείτε το όνομα του απο το github.com και χρησιμοποιήστε ένα σύνδεσμο της μορφής https://github.com/OWNER/PROJECTNAME. Για παράδειγμα ακολουθείστε το σύνδεσμο της ΕΕΛΛΑΚ στο github https://github.com/eellak. Εκεί θα βρείτε τα project της DMS, orgchart κτλ. Για να φτιάξετε τον απαραίτητο σύνδεσμο ο owner είναι η ΕΕΛΛΑK owner=eellak και το όνομα του project πχ orgchart. Αρα ο σύνδεσμος που χρησιμοποιείται είναι https://github.com/eellak/orgchart.</small>');
			$('#fetch_message').html("");
		});
		$('#datafetcherviewer').click(function( event){
			 event.preventDefault();
			$('#datafetcher').slideToggle();
		});
		
		$('#fetch_remote_data').click(function (event) {
			event.preventDefault();
			$('#fetch_message').html('');
			var remote_url = $('#remote_url').val();
			var source = $('#datafetcher input[type=radio]:checked').val();
			if(source == 'sourceforge'){ // Getting for sourceforge
				if (checkUrlSourceforge(remote_url)) {
					temp_url = remote_url.replace("http://sourceforge.net/projects/", "");
					temp_url = temp_url.replace("https://sourceforge.net/projects/", "");
					temp_url = temp_url.split("/");
					if(temp_url[0].length>0){
						$('#fetch_message').html('<strong>Λήψη δεδομένων ('+temp_url[0]+')...</strong>');
						getSourceforgeData(temp_url[0]);
					} else {
						$('#fetch_message').html('<span class="error"><strong>Σφάλμα! Ο σύνδεσμος πρέπει να είναι της μορφής http://sourceforge.net/projects/****** !</strong></span>');
					}
				}
			} else { // Getting for Github
				if (checkUrlGitHub(remote_url)) {
					temp_url = remote_url.replace("https://github.com/", "");
					temp_url = temp_url.replace("http://github.com/", "");
					temp_url = temp_url.split("/");
					if(temp_url[0].length > 0 && temp_url[1].length > 0 ){
						project = temp_url[0]+'/'+temp_url[1];
						$('#fetch_message').html('<strong>Λήψη δεδομένων ('+project+')...</strong>');
						
						
						getGitHubRepo(project);
					} else {
						$('#fetch_message').html('<span class="error"><strong>Σφάλμα! Ο σύνδεσμος πρέπει να είναι της μορφής https://github.com/#####/****** !</strong></span>');
					}
				}
			}
		});

		function checkUrlSourceforge(url) {
			if (url.indexOf("http://sourceforge.net/projects") > -1) {
				return true;
			} else {
				$('#fetch_message').html('<span class="error"><strong>Σφάλμα! Ο σύνδεσμος πρέπει να είναι της μορφής http://sourceforge.net/projects/#####/ !</strong></span>');
				return false;
			}
		}
		
		function checkUrlGitHub(url) {
			if (url.indexOf("https://github.com/") > -1) {
				return true;
			} else {
				$('#fetch_message').html('<span class="error"><strong>Σφάλμα! Ο σύνδεσμος πρέπει να είναι της μορφής https://github.com/#####/****** !</span>');
				return false;
			}
		}
		
		function software_clear_form(){
			$("input[name=ctitle]").val('');
			$("textarea[name=cdescription]").val('');
			$("input[name=_ma_software_website_url]").val('');
			$("input[name=_ma_software_repository_url]").val('');
			$("textarea[name=_ma_software_contact]").val('');
			$("#licenceslist").html("");
			$("textarea[name=_ma_software_specifications]").val();
		}
		/**
		 * Get SourceForge Data
		 * By using the sourceforge api
		 */
		function getSourceforgeData(project){
			software_clear_form();
		$.when(	
		$.ajax(
        { type: "GET",
        	url: ma_ellak_fetch_settings.fetcher_url +'?prj='+project,
			dataType: "json", 
			success: function(results,  textStatus, jqXHR)
			{ 
				if(results===null){
					newproblem=1;
				}else{
					$("input[id=_ma_software_repository_source]").val('sourceforge');
					if(results.hasOwnProperty("Project")){
						if(results.Project.hasOwnProperty("name")){
							var ProjectName = results.Project.name;
							$("input[name=ctitle]").val(ProjectName);
						}
						if(results.Project.hasOwnProperty("description")){
							var ProjectDescription = results.Project.description;
							$("textarea[name=cdescription]").val(ProjectDescription);
						}
						if(results.Project.hasOwnProperty("homepage")){
							var ProjectUrl = results.Project.homepage;
							$("input[name=_ma_software_website_url]").val(ProjectUrl);
							console.log(ProjectUrl);
						}
						if(results.Project.hasOwnProperty("SVNRepository")){
							if(results.Project.SVNRepository.hasOwnProperty("browse")){
								var ProjectRepo = results.Project.SVNRepository.browse;
								$("input[name=_ma_software_repository_url]").val(ProjectRepo);
							}
					}
					
					//stoixeia epikoinwnias
					if(results.Project.hasOwnProperty("maintainers")){
						 var ProjectTech='';
						 ProjectTech = '<strong><u>Maintainers</u></strong><br/>';
						 ProjectTech =ProjectTech+'<strong>Name:</strong> '+results.Project.maintainers[0].name+'<br/>';
						 ProjectTech =ProjectTech+'<strong>Homepage:</strong> <a href="'+results.Project.maintainers[0].homepage+'" target="blank"/>'+results.Project.maintainers[0].homepage+'</a><br/>';
						 if(results.Project.developers){
							 ProjectTech =ProjectTech+'<strong><u>Developers</u></strong><br/>';
							 ProjectTech =ProjectTech+'<strong>Name:</strong> '+results.Project.developers[0].name+'<br/>';
							 ProjectTech =ProjectTech+'<strong>Homepage:</strong> <a href="'+results.Project.developers[0].homepage+'" target="blank"/>'+results.Project.developers[0].homepage+'</a><br/>';
						 }
						 
						 //trackers
						 if(results.Project.hasOwnProperty("trackers")){
							 ProjectTech =ProjectTech+ "<br/><strong><u>trackers: </u></strong><br/>";
							
							for(i=0;i<results.Project.trackers.length;i++){
								ProjectTech = ProjectTech +'<strong>'+results.Project.trackers[i].name+'</strong><br/>';
								ProjectTech =ProjectTech+'Homepage: <a href="'+results.Project.trackers[i].location+'" target="blank"/>'+results.Project.trackers[i].location+'</a><br/>';
							   
							}
							ProjectTech = ProjectTech +"<br/>";
						 }
						 
						 $("textarea[name=_ma_software_contact]").val(ProjectTech);
					}//results.Project.hasOwnProperty("maintainers")
					
					//licences
					var Licences ='';
					if(results.Project.hasOwnProperty("licenses")){
						Licences="<li class='search-choice'>";
						for(i=0;i<results.Project.licenses.length;i++){
							Licences = Licences + '<span>'+results.Project.licenses[i].name +'</span><br/>';
						}
						Licences=Licences+"</li>";
						//console.log(Licences);
						//skata = $("select[name='licence-select[]']").attr("id");
						$("#licenceslist").html("<strong>Παρακαλώ συσχετίστε αν υπάρχουν τις ακόλουθες άδειες</strong>"+Licences);
						
					}//results.Project.hasOwnProperty("licenses")
					//texnika xarakthristika
					var Technical ='';
					if(results.Project.hasOwnProperty("os")){
						Technical = "<strong>os: </strong>";
						
						for(i=0;i<results.Project.os.length;i++){
							Technical = Technical +results.Project.os[i];
							if(i<results.Project.os.length-1) 
								Technical = Technical+ ",";
						}
						Technical = Technical +"<br/>";
					}//results.Project.hasOwnProperty("os")
					
					if(results.Project.hasOwnProperty("topics")){
						Technical = Technical + "<strong>topics: </strong>";
						for(i=0;i<results.Project.topics.length;i++){
							Technical = Technical +results.Project.topics[i];
							if(i<results.Project.topics.length-1) 
								Technical = Technical+ ",";
	
						}
						Technical = Technical +"<br/>";
					}
					
					if(results.Project.hasOwnProperty("audiences")){
						Technical = Technical + "<strong>audiences: </strong>";
						for(i=0;i<results.Project.audiences.length;i++){
							Technical = Technical +results.Project.audiences[i];
							if(i<results.Project.audiences.length-1) 
								Technical = Technical+ ",";
						}
						Technical = Technical +"<br/>";
					}
					
					if(results.Project.hasOwnProperty("environments")){
						Technical = Technical + "<strong>environments: </strong>";
						for(i=0;i<results.Project.environments.length;i++){
							Technical = Technical +results.Project.environments[i];
							if(i<results.Project.environments.length-1) 
								Technical = Technical+ ",";
						}
						Technical = Technical +"<br/>";
					}
					
					if(results.Project.hasOwnProperty("databases")){
						Technical = Technical + "<strong>databases: </strong>";
						for(i=0;i<results.Project.databases.length;i++){
							Technical = Technical +results.Project.databases[i];
							if(i<results.Project.databases.length-1) 
								Technical = Technical+ ",";
						}
						Technical = Technical +"<br/>";
					}
							
					$("textarea[name=_ma_software_specifications]").val(Technical);     		
				
				
					}else{
						alert('Σφάλμα! Ο σύνδεσμος που μας δώσατε δεν έχει αποτελέσματα');
					}
			
				}
			}, 
			error: function(XMLHttpRequest, textStatus, errorThrown)
			{ 
				$('#fetch_message').html('<span class="error"><strong>Δεν βρέθηκαν αποτελέσματα με τα στοιχεία που προσθέσατε. Βεβαιωθείτε ότι τα στοιχεία που δηλώσατε είναι σωστά και προσπαθήστε ξανά. </strong></span>');
				console.log(textStatus); console.log(errorThrown); 
			} 
		}) ).then(function() {
			$('#fetch_message').html('<span class="petrol"><strong>Η λήψη δεδομένων ολοκληρώθηκε! Ελέγξτε και αν χρειάζεται διορθώστε τα παρακάτω στοιχεία.Χρειάζεται να συμπληρώσετε και τις άδειες χρήσης όπως παρουσιάζονται στο sourceforge. <strong></span>');
			if(newproblem==1)
				$('#fetch_message').html('<span class="error"><strong>Δεν βρέθηκαν αποτελέσματα με τα στοιχεία που προσθέσατε. Βεβαιωθείτε ότι τα στοιχεία που δηλώσατε είναι σωστά και προσπαθήστε ξανά. </strong></span>');
			newproblem=0;
			});
	};
	
	function getGitHubRepo(project){
		software_clear_form();
		$.when(	
			$.ajax(
			   { type: "GET",
				url:'https://api.github.com/repos/'+project,
				dataType: "json", 
				success: function(results)
				{
					$("input[id=_ma_software_repository_source]").val('github');

					if(results.hasOwnProperty("id")){
							
						if(results.hasOwnProperty("name")){
							var ProjectName = results.name;
							$("input[name=ctitle]").val(ProjectName);
						}
						if(results.hasOwnProperty("description")){
							var ProjectDescription = results.description;
							$("textarea[name=cdescription]").val(ProjectDescription);
						}
					   if(results.hasOwnProperty("html_url")){
							 var ProjectUrl = results.html_url;
							 $("input[name=_ma_software_website_url]").val(ProjectUrl);
					   }
					   if(results.hasOwnProperty("svn_url")){
							var ProjectRepo = results.svn_url;
							$("input[name=_ma_software_repository_url]").val(ProjectRepo);
					   }
					}
				}, 
				error: function(XMLHttpRequest, textStatus, errorThrown)
					{ 
						if(textStatus=='error')
							$('#fetch_message').html('<span class="error"><strong>Δεν βρέθηκαν αποτελέσματα με τα στοιχεία που προσθέσατε. Βεβαιωθείτε ότι τα στοιχεία που δηλώσατε είναι σωστά και προσπαθήστε ξανά. </strong></span>');
						console.log(textStatus); console.log(errorThrown); 
					} 
			    }) ).then(function() {
					$('#fetch_message').html('<span class="petrol"><strong>Η λήψη δεδομένων ολοκληρώθηκε! Ελέγξτε και αν χρειάζεται διορθώστε τα παρακάτω στοιχεία.<strong></span>');
		});
	}
	
});			

})(jQuery);
