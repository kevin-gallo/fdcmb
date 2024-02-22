<h1>Register</h1>

<?php
    echo $this->Session->flash();
    echo $this->Form->create('User');
    echo $this->Form->input('name');
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->input('confirm password', array('type' => 'password'));
    ?>
    <p>Already have an account? <?php echo $this->Html->link('Login', 'login'); ?>.</p>
    <?php
    echo $this->Form->end('Register');
?> 