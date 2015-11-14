<?php

$this->title = 'Home';

?>

<div class="site-login">
    <?php if ($this->context->isGuest()) : ?>
        Not logged
    <?php else: ?>
        <?= $this->context->getUser()->email ?>
    <?php endif; ?>
</div>