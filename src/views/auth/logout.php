<div class="container">
  <div id="logout-section">
    <form method="POST" action="">  
      <p><?= $__('logout_confirm_note') ?></p>
      <div>
        <a href="users/<?= ((object) $user)->id ?>"><?= $__('No') ?></a>
        <button type="submit"><?= $__('Yes') ?></button>
      </div>
    </form>
  </div>
</div>
