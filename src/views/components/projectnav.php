


<?php

$s = [
	'home',
	'reviews',
	'documents',
	'messages',
	'edit'
];

$u = [
	"project.php",
	"project-reviews.php",
	"project-documents.php",
	"project-messages.php",
	"project-edit.php"
];


if (user_id() == $participants["supervisor_id"]) {
	$len = 5;
	$n_class = "";
} elseif (user_id() == $participants["student_id"]) {
	$len = 4;
	$n_class = "four";
} else {
	$len = 2;
	$n_class = "two";
}



?>


<nav id="entity-nav" class="<?=$n_class;?>">
	<?php for ($i=0;$i<$len;$i++) : ?><a href="<?=$u[$i];?>?id=<?=$_GET['id'];?>" class="<?=$nav_active==$i?"active":"";?>">
		<?=$strings[$s[$i]];?>
	</a><?php endfor; ?>
</nav>




