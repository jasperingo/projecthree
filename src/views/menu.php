<div class="container">
  
  <ul class="menu">

    <li>
      <a href="departments/">
        <?= $icons['department'] ?>
        <div><?= $__('Departments') ?></div></a>
      </a>
    </li>

    
    <?php if ($user !== null) : ?>
    
    <li>
      <a href="users/<?= $user->id ?>">
        <?= $icons['user'] ?>
        <div><?= $__('profile') ?></div></a>
      </a>
    </li>

    <li>
      <a href="users/<?= $user->id ?>/update">
        <?= $icons['settings'] ?>
        <div><?= $__('Edit_profile') ?></div></a>
      </a>
    </li>

    <li>
      <a href="project/create">
        <?= $icons['project_create'] ?>
        <div><?= $__('create_project') ?></div></a>
      </a>
    </li>

    <li>
      <a href="auth/logout">
        <?= $icons['log_out'] ?>
        <div><?= $__('log_out') ?></div>
      </a>
    </li>

    <?php else : ?>
  
    <li>
      <a href="auth/login">
        <?= $icons['user'] ?>
        <div><?= $__('log_in') ?></div></a>
      </a>
    </li>

    <li>
      <a href="users/create">
        <?= $icons['user'] ?>
        <div><?= $__('register') ?></div></a>
      </a>
    </li>

    <?php endif ?>
    
  </ul>

</div>
