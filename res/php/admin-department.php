

<div class="department-box">
	<div><?=$dept['name'];?></div>
	<div><?=$dept['acronym'];?></div>
	<form method="POST" action="">
		<input name="index" class="hide" type="number" value="<?=$i;?>" />
		<button class="department-remove-btn" type="submit" name="remove"><?=$strings['remove'];?></button>
	</form>
</div>




