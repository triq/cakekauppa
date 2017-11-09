<h1>Login </h1>

<?= $this->Form->create(); ?>
<legend><?= __('Please enter your username and password') ?></legend>
<?= $this->Form->input('name'); ?>
<?= $this->Form->input('password'); ?>
<?= $this->Form->button('Login'); ?>
<?= $this->Form->end(); ?>

