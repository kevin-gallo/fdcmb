<?php 
    echo $this->Html->css("components/button");
?>

<h1 style="font-size: 50px;">Login</h1>

<?php
    echo $this->Form->create('User');
    echo $this->Form->input('email');
    echo $this->Form->input('password');
?>
<p>Don't have an account yet? <?php echo $this->Html->link('Register', 'register'); ?>.</p>
<?php
    echo $this->Form->button('Login', array('class'=> 'button-1'));
?>
