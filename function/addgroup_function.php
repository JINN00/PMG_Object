<?php

	$name = $_POST['name'];
	$description = $_POST['description'];
	$target_url = $_POST['target_url'];
	$ticket = $_POST['ticket'];
	$csrftoken = $_POST['csrftoken'];	

	$header = array('Content-Type: application/x-www-form-urlencoded',
			$csrftoken);

	$body = array(
		'name' => $name,
		'info' => $description
		);
	$post_string = http_build_query($body);
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $target_url.'/api2/json/config/ruledb/who');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_COOKIE, $ticket);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$result = curl_exec($ch);
	$result = json_decode($result);
	if (empty($result->data)) {
		echo "<script>alert('오류 발생: 입력 값을 확인하세요.'); history.go(-1);</script>";
	}
	else {
		echo "<script>alert('이름: {$name}, 내용: {$description} URL : {$target_url}'); location.href='http://192.168.58.247/pmg/'</script>";
	}

	curl_close($ch);

?>
