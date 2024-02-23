<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>

<h1 style="font-size: 50px;">New Message</h1>

<div>
    <?php echo $this->Html->link('Home', array( 'controller'=> 'users','action'=> 'home')); ?>
    <?php echo $this->Html->link('Message List', 'index') ?>
</div>

<div style="margin-top: 22px;">
    <?php 
        echo $this->Form->input('receiver', array(
            'id' => 'receiver-input',
            'placeholder' => 'Search for recipient...',
            'class' => 'select2-input'
        ));
        echo $this->Form->input('message', array('label' => 'Message', 'type' => 'textarea')); 
        echo $this->Form->button('Send', array('class'=> 'button-1'));
    ?>
</div>


<script>
    $(document).ready(function() {

    })
</script>