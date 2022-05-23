<header id="main-header">
	<div class="container">
		
		<h1>
			<a href="/"><?= $__('ProJecT3') ?></a>
		</h1>
		
		<form method="GET" action="search">
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

		<nav>
			
			<ul>
				<li>
					<a href="search" class="header-btn"><?= $icons['search'] ?></a>
				</li>
				
				<!-- <li>
					<a href="project/create" class="header-btn"><?= $icons['project_create'] ?></a>
				</li>
				 -->

				<li id="header-menu">
					<a href="menu" class="header-btn"><?= $icons['menu'] ?></a>
					<ul>
						
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
						
					</ul>
				</li>
			</ul>
			
		</nav>

	</div>
</header>
