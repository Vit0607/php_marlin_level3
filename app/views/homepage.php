<?php $this->layout('layout', ['title' => 'User Profile']) ?>

<h1>Home page</h1>

<?php foreach ($usersInView as $user): ?>
<?php echo $user['username'] . '<br>'; ?>
<?php endforeach; ?>
