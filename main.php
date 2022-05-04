<?php
function getTickets($url, $body){
	$header = array('Content-Type: application/x-www-form-urlencoded',
			);
	$post_string = http_build_query($body);
	
	foreach($url as $key){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $key['url'].'/api2/json/access/ticket');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		$arr = json_decode($result);
		$ticket = $arr->data->ticket;
		$csrftoken = $arr->data->CSRFPreventionToken;
		
		$ticket_name = "ticket/ticket_".$key['description'];
		$ticket_file = fopen($ticket_name, "w");
		fwrite($ticket_file, $ticket);
		fclose($ticket_file);

        $csrftoken_name = "ticket/csrftoken_".$key['description'];
        $csrftoken_file = fopen($csrftoken_name, "w");
        fwrite($csrftoken_file, $csrftoken);
        fclose($csrftoken_file);

        curl_close($ch);
	}

}

function getWholist($url, $body){
	foreach($url as $key){
        $ticketname = "ticket/ticket_".$key['description'];
        $ticket_content = trim(file_get_contents($ticketname, "r"));		
		$ticket = 'PMGAuthCookie='.$ticket_content;

		$csrftoken_name = "ticket/csrftoken_".$key['description'];
		$csrftoken_content = trim(file_get_contents($csrftoken_name, "r"));
		$csrftoken = 'CSRFPreventionToken: '.$csrftoken_content;

		$addgroup_url = "/pmg/addgroup_form.php";
                echo '<div style="float: left; padding: 10px;">';
		echo "<form action='".$addgroup_url."' method='post'>";
		echo '<h3>'.$key['url'].'</h3>'."<button type='submit'> 그룹 생성 </button>";
		echo "<input type='hidden' value='".$key['url']."' name='target_url'>";
		echo "<input type='hidden' value='".$ticket."' name='ticket'>";
		echo "<input type='hidden' value='".$csrftoken."' name='csrftoken'>";
		echo "</form>";

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $key['url'].'/api2/json/config/ruledb/who');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_COOKIE, $ticket);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($ch);
		$arr = json_decode($result);
		foreach($arr->data as $wholist){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $key['url'].'/api2/json/config/ruledb/who/'.$wholist->id.'/objects');
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_COOKIE, $ticket);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_VERBOSE, true);

			$result = curl_exec($ch);
			curl_close($ch);
			
         	$addobject_url = "/pmg/addobject_form.php";
            echo "<form action='".$addobject_url."' method='post'>";
            echo '<table border=2>';
			echo '<tr>';
            echo '<td colspan="2" style="font-weight: bold;" >&nbsp'.$wholist->name.'&nbsp</td>';
            echo "<td><button type='submit'> Object 생성 </button></td>";
			echo "<input type='hidden' value='".$key['url']."' name='target_url'>";
            echo "<input type='hidden' value='".$wholist->name."' name='wholist_name'>";
            echo "<input type='hidden' value='".$wholist->id."' name='group_id'>";
			echo "<input type='hidden' value='".$ticket."' name='ticket'>";
			echo "<input type='hidden' value='".$csrftoken."' name='csrftoken'>";
            echo "</form>";
			echo '</tr>';
			
			$arr = json_decode($result);
			$remove_url = "/pmg/remove_object_db.php";
			echo '<tr>';
			foreach($arr->data as $object){
				switch($object->otype_text){
					case "Domain":
						echo '<td>&nbsp'.$object->otype_text.'&nbsp</td>';
						echo '<td>&nbsp'.$object->domain.'&nbsp</td>';
						break;
					case "Mail address":
						echo '<td>&nbsp'.$object->otype_text.'&nbsp</td>';
						echo '<td>&nbsp'.$object->email.'&nbsp</td>';
						break;
				}
				$target_url = $key['url'];
				echo "<td><button type='button' style='color: white; background-color: #555555;' onclick='remove_object(this);' id=$object->id,$wholist->id,$target_url>Object 삭제</button></td>";
				echo '</tr>';
			}
			echo '<br>';
			echo '</table>';

		}
		echo '</div>';		
	}
}
?>
