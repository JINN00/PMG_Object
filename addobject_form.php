<h2> ADD OBJECT </h2>
<h2> 선택한 Who Object <?php echo "<br>".$_POST['target_url']."<br>"; echo $_POST['wholist_name'] ?> </h2>


<form action="/pmg/function/addobject_function.php" method="post">
<div>
  <input type="radio" id="domain" name="object_type" value="domain" checked>
  <label for="domain">Domain</label>
</div>
<div>
  <input type="radio" id="email" name="object_type" value="email">
  <label for="email">E-mail Address</label>
</div>
<br>
<input type='text' name="object_value">
<input type='hidden' name='wholist_name' value='<?php echo $_POST['wholist_name'] ?>'>
<input type='hidden' name='group_id' value='<?php echo $_POST['group_id'] ?>'>
<input type='hidden' name='target_url' value='<?php echo $_POST['target_url'] ?>'>
<input type='hidden' name='ticket' value='<?php echo $_POST['ticket'] ?>'>
<input type='hidden' name='csrftoken' value='<?php echo $_POST['csrftoken'] ?>'>
<br><br>
<button type=submit>등록하기</button>
</form>

