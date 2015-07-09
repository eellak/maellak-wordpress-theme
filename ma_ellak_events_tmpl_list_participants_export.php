<?php
/*
Template Name: Event - Export Participants (xls)
*/
	
	require_once (TEMPLATEPATH . '/scripts/PHPExcel.php');
	global $wpdb;
	global $ma_prefix;
	$table = 'ma_events_participants';
	$event_id = 0;
	$proceed = false;
	if(isset($_GET['eid']) and $_GET['eid'] !=''){
		$event_post = get_post(intval($_GET['eid']));
		if(!empty($event_post) and 'events' == $event_post->post_type) {
			$event_id =intval($_GET['eid']);
			$proceed = true;
		}
	} 
	if($proceed ){
	
		$query = "SELECT * FROM ".$table." where events_id=".$event_id;
		$result = $wpdb->get_results( $query ,ARRAY_A);
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setCreator("ΜΑ ΕΛΛΑΚ")
									 ->setLastModifiedBy("ΜΑ ΕΛΛΑΚ")
									 ->setTitle("Αρχείο Εξαγωγής Συμμετεχόντων Εκδήλωσης")
									 ->setSubject("Αρχείο Εξαγωγής Συμμετεχόντων Εκδήλωσης")
									 ->setDescription("Αρχείο Εξαγωγής Συμμετεχόντων Εκδήλωσης -ΜΑ ΕΛΛΑΚ")
									 ->setKeywords("συμμετέχοντες, μονάδες αριστείας, ελλακ")
									 ->setCategory("Αρχείο Συμμετεχόντων Εκδήλωσης");

		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'ID')
						->setCellValue('B1', 'Όνομα')
						->setCellValue('C1', 'Επίθετο')
						->setCellValue('D1', 'Email')
						->setCellValue('E1', 'Θέση')
						->setCellValue('F1', 'Φορέας')
						->setCellValue('G1', 'Τηλέφωνο')
						->setCellValue('H1', 'Βιογραφικό');
			
			
			$row = 2;
			
			foreach ($result as $rowr){ 
				$j=0;
				if($rowr['ma_bio']!='')
				$rowr['ma_bio']=get_site_url()."/wp-content/files/bios/".$rowr['ma_bio'];
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$row, $rowr['id'] )
						->setCellValue('B'.$row, $rowr['name'])
						->setCellValue('C'.$row,$rowr['surname'] )
						->setCellValue('D'.$row, $rowr['email'])
						->setCellValue('E'.$row, $rowr['ma_position'])
						->setCellValue('F'.$row, $rowr['ma_institute'])
						->setCellValue('G'.$row, $rowr['ma_phone'])
						
						->setCellValue('H'.$row, $rowr['ma_bio'] );
				$row++;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Συμμετέχοντες');
			$objPHPExcel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_participants_'.$event_id.'.xls"');
			header('Cache-Control: max-age=0');

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');
			$objPHPExcel->disconnectWorksheets();
			unset($objPHPExcel);

			exit;
		
		
	} else {
		_e('Δεν έχετε δικαίωμα πρόσβασης σε αυτή τη σελίδα.', 'ma_ellak');
	}
 ?>