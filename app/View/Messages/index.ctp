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
    <h3>Messages</h3>
    <?php 
        // debug($contacts)
    ?>
    <ul>
        <?php foreach ($contacts as $contact): ?>
            <li>
                <?php if (isset($contact['Receiver']['name'])): ?>
                    <?php 
                        $senderId = $contact['Sender']['id'];
                        $receiverId = $contact['Receiver']['id'];
                        // $conversationId = $contact['Sender']['id'] . '_' $contact['Receiver']['id'];
                    ?>
                    <?php 
                        echo $this->Html->link(
                            'Conversation of ' . $contact['Sender']['name'] . ' and ' . $contact['Receiver']['name'], 
                            array(
                                'controller' => 'messages',
                                'action' => 'conversation',
                                $senderId,
                                $receiverId
                        )); 
                    ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>