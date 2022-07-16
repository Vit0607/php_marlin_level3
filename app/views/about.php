<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<?= flash()->display(); ?>

<h1>About page</h1>
<p><?php echo $this->e($title); ?></p>
