<div class="container">
  
  <ul class="menu">
    
    <li>
      <a href="users">
        <?= $icons['user'] ?>
        <div><?= $__('profile') ?></div></a>
      </a>
    </li>

    <li>
      <a href="project/create">
        <?= $icons['project_create'] ?>
        <div><?= $__('create_project') ?></div></a>
      </a>
    </li>

    <li>
      <a href="users/notifications">
        <?= $icons['notification'] ?>
        <div><?= $__('notifications') ?></div>
        <span class="menu-badge"></span>
      </a>
    </li>

    <li>
      <a href="users/settings/profile">
        <?= $icons['settings'] ?>
        <div><?= $__('settings') ?></div>
      </a>
    </li>

    <li>
      <a href="auth/logout">
        <?= $icons['log_out'] ?>
        <div><?= $__('log_out') ?></div>
      </a>
    </li>
  
    <li>
      <ul class="sub-menu">
        <li>
          <a href="auth/login"><?= $__('log_in') ?></a>
        </li>

        <li>
          <a href="users/create"><?= $__('register') ?></a>
        </li>
      </ul>
    </li>
    
  </ul>

</div>
