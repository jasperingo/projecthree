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
				<li>
					<a href="search" class="header-btn"><?= $icons['search'] ?></a>
				</li>

				<li>
					<a href="menu" class="header-btn"><?= $icons['menu'] ?></a>
				</li>

				<li>
					<a href="menu" class="header-lg-btn"><?= $__('Menu') ?></a>
				</li>

				<li>
					<a href="auth/login" class="header-lg-btn"><?= $__('log_in') ?></a>
				</li>

				<li>
					<a href="users/create" class="header-lg-btn"><?= $__('register') ?></a>
				</li>
			</ul>
			
		</nav>

	</div>
</header>
