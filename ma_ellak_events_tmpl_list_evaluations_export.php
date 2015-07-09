<?php
/*
Template Name: Event - Export Evaluations (xls)
*/
	
	require_once (TEMPLATEPATH . '/scripts/PHPExcel.php');
	global $wpdb;
	global $ma_prefix;
	$table = 'ma_events_evaluation';
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
									 ->setTitle("Αρχείο Εξαγωγής Αξιολογήσεων Εκδήλωσης")
									 ->setSubject("Αρχείο Εξαγωγής Αξιολογήσεων Εκδήλωσης")
									 ->setDescription("Αρχείο Εξαγωγής Αξιολογήσεων Εκδήλωσης -ΜΑ ΕΛΛΑΚ")
									 ->setKeywords("αξιολογήσεων, μονάδες αριστείας, ελλακ")
									 ->setCategory("Αρχείο Αξιολογήσεων Εκδήλωσης");

		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A1', 'ID')
						->setCellValue('B1', 'Όνομα')
						->setCellValue('C1', 'Επίθετο')
						->setCellValue('D1', 'Email')
						->setCellValue('E1', 'Θέση')
						->setCellValue('F1', 'Φορέας')
						->setCellValue('G1', 'Τηλέφωνο')
						->setCellValue('H1', 'Πώς σας φάνηκε η εκδήλώση/σεμινάριο')
						->setCellValue('I1', 'Πώς σας φάνηκε το επίπεδο των ομιλητών')
						->setCellValue('K1', 'Πώς σας φάνηκε το συνοδευτικό υλικό;')
						->setCellValue('L1', 'Πώς σας φάνηκε η οργάνωση της εκδήλώσης/σεμιναρίου;')
						->setCellValue('M1', 'Θα παρακολουθούσατε αντίστοιχη εκδήλωσης/σεμινάριο;')
						->setCellValue('N1', 'Σχόλια')
						->setCellValue('O1', 'Ημερομηνία')
						->setCellValue('P1', 'Φύλο')
						->setCellValue('Q1', 'Ηλικία')
					;
			
			
			$row = 2;
			
			foreach ($result as $rowr){ 
				switch ($rowr['ma_impressions']){
					case 0:
						$rowr['ma_impressions']=__('', 'ma-ellak');
						break;
					case 1:
						$rowr['ma_impressions']=__('Κακή', 'ma-ellak');
						break;
					case 2:
						$rowr['ma_impressions']=__('Μέτρια', 'ma-ellak');
						break;
					case 3:
						$rowr['ma_impressions']=__('Καλή', 'ma-ellak');
						break;
					case 4:
						$rowr['ma_impressions']=__('Πολύ Καλή', 'ma-ellak');
						break;
					case 5:
						$rowr['ma_impressions']=__('Άριστη', 'ma-ellak');
						break;
				}//end switch
				
				switch ($rowr['ma_speakers']){
					case "0":
						$rowr['ma_speakers']=__('', 'ma-ellak');
						break;
					case 1:
						$rowr['ma_speakers']=__('Κακό', 'ma-ellak');
						break;
					case 2:
						$rowr['ma_speakers']=__('Μέτριο', 'ma-ellak');
						break;
					case 3:
						$rowr['ma_speakers']=__('Καλό', 'ma-ellak');
						break;
					case 4:
						$rowr['ma_speakers']=__('Πολύ Καλό', 'ma-ellak');
						break;
					case 5:
						$rowr['ma_speakers']=__('Άριστο', 'ma-ellak');
						break;
					default:
						$rowr['ma_speakers']=__('', 'ma-ellak');
				
				}//end switch
				
				if(!empty($rowr['ma_material'])){
					switch ($rowr['ma_material']){
						case "0":
							$rowr['ma_material']=__('', 'ma-ellak');
							break;
						case 1:
							$rowr['ma_material']=__('Κακό', 'ma-ellak');
							break;
						case 2:
							$rowr['ma_material']=__('Μέτριο', 'ma-ellak');
							break;
						case 3:
							$rowr['ma_material']=__('Καλό', 'ma-ellak');
							break;
						case 4:
							$rowr['ma_material']=__('Πολύ Καλό', 'ma-ellak');
							break;
						case 5:
							$rowr['ma_material']=__('Άριστο', 'ma-ellak');
							break;
						default:
							$rowr['ma_material']=__('', 'ma-ellak');
								
					}//end switch
				}//end if
					
				if(!empty($rowr['ma_organizers'])){
					switch ($rowr['ma_organizers']){
						case 0:
							$rowr['ma_organizers']=__('', 'ma-ellak');
							break;
						case 1:
							$rowr['ma_organizers']=__('Κακή', 'ma-ellak');
							break;
						case 2:
							$rowr['ma_organizers']=__('Μέτρια', 'ma-ellak');
							break;
						case 3:
							$rowr['ma_organizers']=__('Καλή', 'ma-ellak');
							break;
						case 4:
							$rowr['ma_organizers']=__('Πολύ Καλή', 'ma-ellak');
							break;
						case 5:
							$rowr['ma_organizers']=__('Άριστη', 'ma-ellak');
							break;
					}//end switch
				}//end if
				if(!empty($rowr['ma_nexttime'])){
					switch ($rowr['ma_nexttime']){
							
						case 0:
							$rowr['ma_nexttime']= '';
							break;
						case 1:
							$rowr['ma_nexttime']=__('Ναι', 'ma-ellak');
							break;
						case 2:
							$rowr['ma_nexttime']=__('Οχι', 'ma-ellak');
							break;
					}
				}
				
				if(isset($rowr['ma_sex'])){
					if($rowr['ma_sex']==0)  $rowr['ma_sex']="";
					if($rowr['ma_sex']==1)  $rowr['ma_sex']="Άνδρας";
					if($rowr['ma_sex']==2)  $rowr['ma_sex']="Γυναίκα";
						
				}
				if(isset($rowr['ma_age'])){
					if($rowr['ma_age']==0)  $rowr['ma_age']="";
					if($rowr['ma_age']==1)  $rowr['ma_age']="20-30";
					if($rowr['ma_age']==2)  $rowr['ma_age']="30-40";
					if($rowr['ma_age']==3)  $rowr['ma_age']="40-50";
				
				}
					
				$j=0;
				$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$row, $rowr['id'] )
						->setCellValue('B'.$row, $rowr['name'])
						->setCellValue('C'.$row,$rowr['surname'] )
						->setCellValue('D'.$row, $rowr['email'])
						->setCellValue('E'.$row, $rowr['ma_position'])
						->setCellValue('F'.$row, $rowr['ma_institute'])
						->setCellValue('G'.$row, $rowr['ma_phone'])
						->setCellValue('H'.$row, $rowr['ma_impressions'] )
						->setCellValue('I'.$row, $rowr['ma_speakers'] )
						->setCellValue('K'.$row, $rowr['ma_material'] )
						->setCellValue('L'.$row, $rowr['ma_organizers'] )
						->setCellValue('M'.$row, $rowr['ma_nexttime'])
						->setCellValue('N'.$row, $rowr['ma_comments'])
						->setCellValue('O'.$row, $rowr['ma_datetime'] )
						->setCellValue('P'.$row, $rowr['ma_sex'] )
						->setCellValue('Q'.$row, $rowr['ma_age'] );
				$row++;
			}
			
			$objPHPExcel->getActiveSheet()->setTitle('Αξιολογήσεις');
			$objPHPExcel->setActiveSheetIndex(0);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="export_evaluations_'.$event_id.'.xls"');
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