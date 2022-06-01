<nav id="entity-nav" class="<?=$n_class;?>">
	<?php for ($i=0;$i<$len;$i++) : ?>
		<a href="<?=$u[$i];?>?id=<?=$_GET['id'];?>" class="<?=$nav_active==$i?"active":"";?>">
			<?=$strings[$s[$i]];?>
		</a>
	<?php endfor; ?>
</nav>
