<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="container mt-5">
    <div class="header-1">
        <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
        <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
    </div>

    <h1 class="mt-4" style="font-size: 50px;">Message List</h1>

    <div class="mb-3">
        <?php echo $this->Html->link('Home', array('controller'=> 'users','action'=> 'home'), array('class' => 'btn btn-primary mr-2')); ?>
        <?php echo $this->Html->link('New Message', 'new_message', array('class' => 'btn btn-primary')); ?>
    </div>

    <div>
        <h3>Inbox</h3>
        <ul class="list-group">
            <?php
            if(count($contacts) > 0) {
                foreach ($contacts as $contact): 
                    $receiver = "";
                    $sender = "";
                    foreach($users as $user){
                        if($contact['messages']['receiver_id'] === $user['User']['id']) {
                            $receiver = $user['User']['name'];
                        }

                        if($contact['messages']['sender_id'] === $user['User']['id']) {
                            $sender = $user['User']['name'];
                        }
                    }
                ?>
                    <li class="list-group-item">
                            <?php 
                                echo $this->Html->link(
                                    'Conversation of ' . $sender . ' and ' . $receiver, 
                                    array(
                                        'controller' => 'messages',
                                        'action' => 'conversation',
                                        $contact['messages']['receiver_id']
                                    ),
                                    array('class' => 'btn btn-primary'),
                                ); 
                            ?>
                    </li>
                <?php endforeach; 
            } else {
                echo '<p>No available contacts.</p>';
            } ?>
        </ul>
    </div>
</div>
