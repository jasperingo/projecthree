<header id="main-header">
	
	<h1>
		<a href="/"><?= $__('ProJecT3') ?></a>
	</h1>
	
	<div id="main-header-div-2">
		
		<div id="search-form-blur"></div>
		<form id="search-form" method="GET" action="search">
			<button id="search-hide-btn" type="button" class="search-btn">
				<?= $icons['search_cancel'] ?>
			</button>

			<input 
				name="q" 
				type="text" 
				id="search-input" 
				placeholder="<?= $__('search_project3') ?>" 
				value="<?= isset($_GET['q']) ? $_GET['q']: "" ?>" 
			/>

			<button type="submit" class="search-btn">
				<?= $icons['search'] ?>
			</button>
		</form>

	</div>

	<nav id="main-header-div-3">
		
		<a id="search-show-btn" href="search" class="header-btn"><?= $icons['search'] ?></a>
		
		<a href="project/create" class="header-btn"><?= $icons['project_create'] ?></a>
		
		
		<div id="header-user">
			<span class="header-btn"><?= $icons['user'] ?></span>
			<nav>
				
				<a href="user">
					<?= $icons['user'] ?>
					<span><?= $__('profile') ?></span></a>
				</a>
				<a href="users/notifications">
					<?= $icons['notification'] ?>
					<span><?= $__('notifications') ?></span>
					<span id="notify" style="display:<?//=$notify;?>;"></span>
				</a>
				<a href="users/settings/profile">
					<?= $icons['settings'] ?>
					<span><?= $__('settings') ?></span>
				</a>
				<a href="auth/logout">
					<?= $icons['log_out'] ?>
					<span><?= $__('log_out') ?></span>
				</a>
			
				<a href="auth/login"><?= $__('log_in') ?></a>
				<a href="users/create"><?= $__('register') ?></a>
				
			</nav>
		</div>
		
	</nav>
	
</header>

<div id="header-pad"></div>
