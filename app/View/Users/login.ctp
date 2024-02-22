<h1>Login</h1>

<?php
    echo $this->Form->create('User');
    echo $this->Form->input('email');
    echo $this->Form->input('password');
?>
<p>Don't have an account yet? <?php echo $this->Html->link('Register', 'register'); ?>.</p>
<?php
    echo $this->Form->end('Login');
?>
