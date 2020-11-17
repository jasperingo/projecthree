


<?php


if (signed_in()) {
	
	$response = getCurl(API_URL."getusernotificationscount.php", app_headers());
	
	$code = httpCodeCurl($response[0]);
	
	if ($code == 200) {
		$body = json_decode($response[1], true);
		$count = $body['success']['user_notifications_count'];
		$notify = $count > 0 ? "" : "none";
	} else {
		$notify = "none";
	}
	
	curl_close($response[0]);
}


?>

<header id="main-header">
	
	<div id="main-header-div-1">
			<a href="index.php">ProJecT3</a>
	</div><div id="main-header-div-2">
		<div id="search-form-blur"></div>
		<form id="search-form" method="GET" action="search.php">
			<button id="search-hide-btn" type="button" class="search-btn">
				<?=$icons['search_cancel'];?>
			</button><input type="text" id="search-input" name="q" placeholder="<?php echo $strings['search_project3']; ?>" value="<?=isset($_GET['q'])?$_GET['q']:"";?>" /><button type="submit" class="search-btn">
				<?=$icons['search'];?>
			</button>
		</form>
	</div><nav id="main-header-div-3">
		
		<a id="search-show-btn" href="search.php" class="header-btn"><?php echo $icons['search']; ?></a>
		
		<?php if (signed_in()) : ?>
		<a href="project-create.php" class="header-btn"><?=$icons['project_create'];?></a>
		<?php endif; ?>
		
		<div id="header-user">
			<span class="header-btn"><?php echo $icons['user']; ?></span>
			<nav>
				<?php if (signed_in()) : ?>
				<a href="user.php?id=<?=user_id();?>">
					<?=$icons['user'];?>
					<span><?=$strings['profile'];?></span></a>
				</a>
				<a href="user-notifications.php">
					<?=$icons['notification'];?>
					<span><?=$strings['notifications'];?></span>
					<span id="notify" style="display:<?=$notify;?>;"></span>
				</a>
				<a href="user-settings-profile.php">
					<?=$icons['settings'];?>
					<span><?=$strings['settings']; ?></span>
				</a>
				<a href="logout.php">
					<?=$icons['log_out'];?>
					<span><?=$strings['log_out']; ?></span>
				</a>
				<?php else : ?>
				<a href="login.php"><?=$strings['log_in'];?></a>
				<a href="register.php"><?=$strings['register'];?></a>
				<?php endif; ?>
			</nav>
		</div>
		
	</nav>
	
</header>

<div id="header-pad"></div>



