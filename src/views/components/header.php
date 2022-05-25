<header id="main-header">
	<div class="container">
		
		<h1>
			<a href="/"><?= $__('ProJecT3') ?></a>
		</h1>
		
		<form method="GET" action="search">
			<div>
				<input 
					name="q" 
					type="text" 
					placeholder="<?= $__('search_project3') ?>" 
					value="<?= isset($_GET['q']) ? $_GET['q']: "" ?>" 
				/>

				<button type="submit" class="search-btn">
					<?= $icons['search'] ?>
				</button>
			</div>
		</form>

		<nav>
			
			<ul>
				<li class="header-btn">
					<a href="search"><?= $icons['search'] ?></a>
				</li>

				<li class="header-btn">
					<a href="menu"><?= $icons['menu'] ?></a>
				</li>

				<li class="header-lg-btn">
					<a href="menu"><?= $__('Menu') ?></a>
				</li>

				<li class="header-lg-btn">
					<a href="auth/login"><?= $__('log_in') ?></a>
				</li>

				<li class="header-lg-btn">
					<a href="users/create"><?= $__('register') ?></a>
				</li>
			</ul>
			
		</nav>

	</div>
</header>
