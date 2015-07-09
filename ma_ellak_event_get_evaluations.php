<?php
//http://www.jeasyui.com/tutorial/datagrid/datagrid24.php searchable
//http://www.jeasyui.com/tutorial/datagrid/datagrid8.php sortable
require_once( "../../../wp-config.php" );
global $wpdb;
$event_id = $_GET['event_id'];

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$name = isset($_POST['name']) ? mysql_real_escape_string($_POST['name']) : '';
$email = isset($_POST['email']) ? mysql_real_escape_string($_POST['email']) : '';
$sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
$order = isset($_POST['order']) ? strval($_POST['order']) : 'asc';

$offset = ($page-1)*$rows;

if(!empty($name) && !empty($email))
	$where = " and surname like '$name%' and email like '$email%'";
if(empty($name) && !empty($email))
	$where = " and email like '$email%'";
if(!empty($name) && empty($email))
	$where = " and surname like '$name%' ";
$query = "SELECT * FROM ma_events_evaluation where events_id=$event_id $where order by $sort $order";

$result = $wpdb->get_results( $query ,ARRAY_A);

for($i=0;$i<count($result);$i++){
	if(!empty($result[$i]['ma_impressions'])){
	switch ($result[$i]['ma_impressions']){
			case 0:
				$result[$i]['ma_impressions']=__('-- --', 'ma-ellak');
				break;
			case 1:
				$result[$i]['ma_impressions']=__('Κακή', 'ma-ellak');
				break;
			case 2:
				$result[$i]['ma_impressions']=__('Μέτρια', 'ma-ellak');
				break;
			case 3:
				$result[$i]['ma_impressions']=__('Καλή', 'ma-ellak');
				break;
			case 4:
				$result[$i]['ma_impressions']=__('Πολύ Καλή', 'ma-ellak');
				break;
			case 5:
				$result[$i]['ma_impressions']=__('Άριστη', 'ma-ellak');
				break;
		}
	}
	if(!empty($result[$i]['ma_speakers'])){
		switch ($result[$i]['ma_speakers']){
			case "0":
				$result[$i]['ma_speakers']=__('-- --', 'ma-ellak');
				break;
			case 1:
				$result[$i]['ma_speakers']=__('Κακό', 'ma-ellak');
				break;
			case 2:
				$result[$i]['ma_speakers']=__('Μέτριο', 'ma-ellak');
				break;
			case 3:
				$result[$i]['ma_speakers']=__('Καλό', 'ma-ellak');
				break;
			case 4:
				$result[$i]['ma_speakers']=__('Πολύ Καλό', 'ma-ellak');
				break;
			case 5:
				$result[$i]['ma_speakers']=__('Άριστο', 'ma-ellak');
				break;
			default:
				$result[$i]['ma_speakers']=__('-- --', 'ma-ellak');
				
		}
	}
	if(!empty($result[$i]['ma_material'])){
		switch ($result[$i]['ma_material']){
			case "0":
				$result[$i]['ma_material']=__('-- --', 'ma-ellak');
				break;
			case 1:
				$result[$i]['ma_material']=__('Κακό', 'ma-ellak');
				break;
			case 2:
				$result[$i]['ma_material']=__('Μέτριο', 'ma-ellak');
				break;
			case 3:
				$result[$i]['ma_material']=__('Καλό', 'ma-ellak');
				break;
			case 4:
				$result[$i]['ma_material']=__('Πολύ Καλό', 'ma-ellak');
				break;
			case 5:
				$result[$i]['ma_material']=__('Άριστο', 'ma-ellak');
				break;
			default:
				$result[$i]['ma_material']=__('-- --', 'ma-ellak');
	
		}
	}
	
	if(!empty($result[$i]['ma_organizers'])){
		switch ($result[$i]['ma_organizers']){
			case 0:
				$result[$i]['ma_organizers']=__('-- --', 'ma-ellak');
				break;
			case 1:
				$result[$i]['ma_organizers']=__('Κακή', 'ma-ellak');
				break;
			case 2:
				$result[$i]['ma_organizers']=__('Μέτρια', 'ma-ellak');
				break;
			case 3:
				$result[$i]['ma_organizers']=__('Καλή', 'ma-ellak');
				break;
			case 4:
				$result[$i]['ma_organizers']=__('Πολύ Καλή', 'ma-ellak');
				break;
			case 5:
				$result[$i]['ma_organizers']=__('Άριστη', 'ma-ellak');
				break;
		}
	}
	
	if(!empty($result[$i]['ma_age'])){
		switch ($result[$i]['ma_age']){
			case "0":
				$result[$i]['ma_age']=__('-- --', 'ma-ellak');
				break;
			case 1:
				$result[$i]['ma_age']=__('20-30', 'ma-ellak');
				break;
			case 2:
				$result[$i]['ma_age']=__('30-40', 'ma-ellak');
				break;
			case 3:
				$result[$i]['ma_age']=__('40-50', 'ma-ellak');
				break;
		}
	}
	if(!empty($result[$i]['ma_sex'])){
		switch ($result[$i]['ma_sex']){
			case "0":
				$result[$i]['ma_sex']=__('-- --', 'ma-ellak');
				break;
			case 1:
				$result[$i]['ma_sex']=__('Άνδρας', 'ma-ellak');
				break;
			case 2:
				$result[$i]['ma_sex']=__('Γυναίκα', 'ma-ellak');
				break;
			
		}
	}
		
	//$result[$i]['ma_impressions']="<a href=".get_site_url()."/wp-content/files/bios/".$result[$i]['ma_bio']." target='_blank'>(bio)</a>";
}
echo json_encode($result);

?>