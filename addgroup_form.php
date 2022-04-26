<h2> ADD GROUP </h2>
<h4>대상 PMG 서버: <?php echo $_POST['target_url'] ?></h4>


<form action="/pmg/function/addgroup_function.php" method="post">
<table>
	<tr>
		<th style='text-align: left'>Group Name </th>
		<td><input type='text' name="name"></td>
	</tr>
        <tr>
                <th style='text-align: left'>Description </th>
                <td><input type='text' name="description"></td>
        </tr>
</table>
<input type='hidden' name='target_url' value='<?php echo $_POST['target_url'] ?>'>
<input type='hidden' name='ticket' value='<?php echo $_POST['ticket'] ?>'>
<input type='hidden' name='csrftoken' value='<?php echo $_POST['csrftoken'] ?>'>
<br>
<button type=submit>등록하기</button>
</form>

