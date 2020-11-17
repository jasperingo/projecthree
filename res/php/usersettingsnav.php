



<?php

$s = [
	'edit_profile',
	'change_photo',
	'change_email',
	'change_password'
];

$u = [
	"user-settings-profile.php",
	"user-settings-photo.php",
	"user-settings-email.php",
	"user-settings-password.php",
];

?>


<nav id="user-settings-nav">
	<?php for ($i=0;$i<4;$i++) : ?>
	<a href="<?=$u[$i];?>" class="user-settings-btn <?=$nav_active==$i?"active":"";?>"><?=$strings[$s[$i]];?></a>
	<?php endfor; ?>
</nav>




