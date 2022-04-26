<?php
	if ( $_POST['object_type'] == "domain" ) {
		$domain = $_POST['object_type'];
	}

	if ( $_POST['object_type'] == "email" ) {
		$email = $_POST['object_type'];
	}

	$object_value = $_POST['object_value'];
	$group_id = $_POST['group_id'];
	$target_url = $_POST['target_url'];
	$ticket = $_POST['ticket'];
	$csrftoken = $_POST['csrftoken'];
	$wholist_name = $_POST['wholist_name'];

	if(empty($object_value)) {
		echo "<script>alert('값을 입력하세요.'); location.href='http://192.168.58.247/pmg/'</script>";
	}


	$header = array('Content-Type: application/x-www-form-urlencoded',
			$csrftoken);

	if (isset($domain)) {
		$body = array(
			'domain' => $object_value
		);
		$url = $target_url.'/api2/json/config/ruledb/who/'.$group_id.'/domain';
	}

	if (isset($email)) {
		$body = array(
			'email' => $object_value
		);
		$url = $target_url.'/api2/json/config/ruledb/who/'.$group_id.'/email';
	}	

	$post_string = http_build_query($body);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_COOKIE, $ticket);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	$result = json_decode($result);
	if(isset($result->errors)){
		echo "<script>alert('오류 발생: 입력 값을 확인하세요.'); history.go(-1);</script>";
	}
	else {
		echo "<script>alert('$wholist_name: $object_value 추가'); location.href='http://192.168.58.247/pmg/'</script>";
	}
	
	curl_close($ch);

?>
