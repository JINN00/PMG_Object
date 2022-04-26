<?php include_once("main.php")?>

<head>
<h1>PMG Who Object</h1>

<?php
	$url = json_decode(file_get_contents('./url_list.json'), true);
	$body = array(
		'username' => 'root@pam',
		'password' => trim(file_get_contents('./password'))
		);

	getTickets($url, $body);
	getWholist($url, $body);
?>


<script>
	function remove_object(element) {
		if(window.confirm("정말로 삭제하시겠습니까?")){
			var id = element.id
			id = id.split (',')
			location.href = '/pmg/function/remove_object_function.php?object_id='+id[0]+'&group_id='+id[1]+'&target_url='+id[2]+''
		}else{
			return false;
		}
	}
</script>
</head>