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
	$where = " and name like '$name%' and email like '$email%'";
if(empty($name) && !empty($email))
	$where = " and email like '$email%'";
if(!empty($name) && empty($email))
	$where = " and name like '$name%' ";
$query = "SELECT * FROM ma_events_participants where events_id=$event_id $where order by $sort $order";
$result = $wpdb->get_results( $query ,ARRAY_A);

for($i=0;$i<count($result);$i++)
	if(!empty($result[$i]['ma_bio']))
	$result[$i]['ma_bio']="<a href=".get_site_url()."/wp-content/files/bios/".rawurlencode($result[$i]['ma_bio'])." target='_blank'>Bio</a>";
	

echo json_encode($result);

?>