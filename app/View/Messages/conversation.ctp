<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>

<h1 style="font-size: 50px;">Conversation</h1>

<div>
    <?php echo $this->Html->link('Home', array('controller'=> 'users','action'=> 'home')); ?>
    &nbsp;<?php echo $this->Html->link("Message List", "index") ?>
    &nbsp;<?php echo $this->Html->link("New Message", "new_message") ?>
</div>

<div style="margin-top: 22px;">
<div style="margin-bottom: 12px;">
                <?php 

                    echo $this->Form->create("Message", array(
                        'url' => array(
                            'controller'=> 'messages',
                            'action'=> 'send_message', 
                            $receiverId, // Receiver ID
                            $senderId // Sender ID
                        )));
                    echo $this->Form->input('Message.message', array('label' => false,'placeholder' => 'Enter your message here...'));
                    echo $this->Form->button('New Message', array( 'class'=> 'button-1'));
                    echo $this->Form->end();
                ?>
            </div>
    <div>
        <?php 
        
        // debug($conversation);
        // debug($userId);
        ?>
        <?php foreach ($conversation as $msg): ?>
            <div style="margin-bottom: 20px;display:flex;flex-direction: row;align-items: center;justify-content: flex-end;">
                <div>
                    <h3><?php echo $msg['Sender']['name']; ?></h3>
                    <p><?php echo $msg['Message']['message']; ?></p>
                    <p><?php echo $msg['Message']['sent_at']; ?></p>
                </div>
                <div style="float: left; margin-right: 10px;">
                    <?php 
                        $picture = $msg['Sender']['profile_picture'];
                        if(isset($picture)) {
                            echo $this->Html->image($picture);
                        } else {
                            echo $this->Html->image('/img/default_profile_pic.jpg', array('alt'=> 'Default Image '));
                        }
                    ?>
                </div>
                <div style="clear: both;"></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>