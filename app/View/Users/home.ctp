<?php echo $this->Html->css('components/index') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>
<h1 style="font-size: 50px;">Home</h1>
<div>
    <?php echo $this->Html->link('Profile', 'profile'); ?>
    <?php echo $this->Html->link('Messages', 'profile'); ?>
</div>