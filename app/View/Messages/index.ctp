<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>

<h1 style="font-size: 50px;">Message List</h1>

<div>
    <?php echo $this->Html->link('Home', array('controller'=> 'users','action'=> 'home')); ?>
&nbsp;<?php echo $this->Html->link("New Message", "new_message") ?>
</div>

<div style="margin-top: 22px;">
    <div>
        <!-- Display the message here -->
        <?php foreach ($message as $msg): ?>
            <div style="margin-bottom: 20px;">
                <div style="float: left; margin-right: 10px;">
                    <?php echo $this->Html->image('profile_pics/' . $msg['receiver']['profile_picture']); ?>
                </div>
                <div>
                    <p><?php echo $msg['Message']['receiver_name']; ?></p>
                    <p><?php echo $msg['Message']['message']; ?></p>
                    <p>Sent at: <?php echo $msg['Message']['sent_at']; ?></p>
                </div>
                <div style="clear: both;"></div>
                <div>
                    <p><?php echo $msg['Message']['sender_name']; ?></p>
                    <p><?php echo $msg['Message']['message']; ?></p>
                    <p>Sent at: <?php echo $msg['Message']['sent_at']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>