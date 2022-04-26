<?php
	$object_id = $_GET['object_id'];
	$group_id = $_GET['group_id'];
	$target_url = $_GET['target_url'];

	$arr = json_decode(file_get_contents('../url_list.json'), true);

	foreach($arr as $key) {
		if ($target_url === $key['url']) {
			$ticketname = "../ticket/ticket_".$key['description'];
			$ticket_content = trim(file_get_contents($ticketname, "r"));		
			$ticket = 'PMGAuthCookie='.$ticket_content;
		
			$csrftoken_name = "../ticket/csrftoken_".$key['description'];
			$csrftoken_content = trim(file_get_contents($csrftoken_name, "r"));
			$csrftoken = 'CSRFPreventionToken: '.$csrftoken_content;	
		}
	}

    $header = array('Content-Type: application/x-www-form-urlencoded',
    		$csrftoken);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $target_url.'/api2/json/config/ruledb/who/'.$group_id.'/objects/'.$object_id);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_COOKIE, $ticket);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
	header('Location: http://192.168.58.247/pmg/');
	die();
    curl_close($ch);

?>
