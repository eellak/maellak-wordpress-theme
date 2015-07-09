<?php
/*
Template Name: Characteristic - Export (xls)
*/
	
	require_once (TEMPLATEPATH . '/scripts/PHPExcel.php');
	global $ma_prefix;
	$software_post;
	$software_id = 0;
	$proceed = false;
	if(isset($_GET['sid']) and $_GET['sid'] !=''){
		$software_post = get_post(intval($_GET['sid']));
		if(!empty($software_post) and 'software' == $software_post->post_type) {
			$software_id =intval($_GET['sid']);
			if(ma_ellak_user_is_post_admin($software_post)){
				$proceed = true;
			}
		}
	} 
	if($proceed ){
	
		$args = array(
			'post_per_page' => -1,
			'post_type' => 'characteristic',
			'post_status' => 'publish', 
			'paged' => $paged,
		);
		
		$args['meta_query'] = array(
			array(
				'key' => $ma_prefix.'for_software',
				'value' => $software_id,
			)
		);

		$posts = get_posts($args);
		if(count($posts) == 0){
			get_header();
			_e('Δεν υπάρχουν Γνωρίσματα ή Χαρακτηριστικά προς Εξαγωγή.', 'ma_ellak');
			get_footer();
		} else {
		
			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setCreator("ΜΑ ΕΛΛΑΚ")
										 ->setLastModifiedBy("ΜΑ ΕΛΛΑΚ")
										 ->setTitle("Αρχείο Εξαγωγής Γνωρισμάτων")
										 ->setSubject("Αρχείο Εξαγωγής Γνωρισμάτων")
										 ->setDescription("Αρχείο Εξαγωγής Γνωρισμάτων -ΜΑ ΕΛΛΑΚ")
										 ->setKeywords("γνωρίσματα, μονάδες αριστείας, ελλακ")
										 ->setCategory("Αρχείο Γνωρισμάτων");

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'ID')
						->setCellValue('B1', 'Τίτλος')
						->setCellValue('C1', 'Είδος')
						->setCellValue('D1', 'Ημερομηνία Υποβολής')
						->setCellValue('E1', 'Προβολές')
						->setCellValue('F1', 'Ψηφοφορία')
						//->setCellValue('G1', 'Ψηφοι Θετικοί')
						//->setCellValue('H1', 'Ψηφοι Αρνητικοί')
						->setCellValue('G1', 'Περιεχόμενο')
						->setCellValue('H1', 'Σχόλια')
						->setCellValue('I1', 'Σύνδεσμος');
			
			$row = 2;
			
			foreach($posts as $post){ setup_postdata($post);
				
				$meta=get_post_meta($post->ID);
				
				$type = get_post_meta( $post->ID, $ma_prefix.'characteristic_type', true);
				if($type == 'gnorisma') $type = __('Λειτουργικό Γνώρισμα', 'ma-ellak'); 
				else  $type = __('Χαρακτηριστικό', 'ma-ellak');
				
				$stars=$meta['ratings_average'][0];
				if (!isset($stars))
					$stars=0;
			
				$views=ma_ellak_show_statistics($post->ID, 'characteristic');
				if (!isset($views))
					$views=0;
				
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$row, $post->ID )
						->setCellValue('B'.$row, get_the_title())
						->setCellValue('C'.$row, $type  )
						->setCellValue('D'.$row, get_the_date())
						->setCellValue('E'.$row, $views)
						->setCellValue('F'.$row, $stars)
						//->setCellValue('G'.$row, )
						//->setCellValue('H'.$row, )
						->setCellValue('G'.$row, get_the_content())
						->setCellValue('H'.$row,  get_comments_number( $post->ID ) )
						->setCellValue('I'.$row, get_permalink($post->ID));
				$row++;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Γνωρίσματα');
			$objPHPExcel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_characteristics_'.$software_id.'.xls"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			$objPHPExcel->disconnectWorksheets();
			unset($objPHPExcel);

			exit;
		
		}
	} else {
		_e('Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα.', 'ma_ellak');
	}
 ?>