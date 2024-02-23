<?php echo $this->Html->css('components/index') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>

<h1 style="font-size: 50px;">User Profile</h1>
<div>
    <?php echo $this->Html->link('Home', 'home') ?>
    <?php echo $this->Html->link('Edit Profile', 'edit_profile') ?>
</div>

<div style="margin-top: 22px;">
    <div style="display: flex;gap:5px;">
        <div style="width:100px;height:100px;">
        <?php
            if (!empty($user['User']['profile_picture'])) {
                $image = $user['User']['profile_picture'];
                echo $this->Html->image($image, array('style'=> 'width:100px;height:100px;'));
            } else {
                echo $this->Html->image('/img/default_profile_pic.jpg', array('alt' => 'Default Profile Picture'));
            }
        ?>
        </div>
        <div>
            <div style="display: flex; gap: 5px;">
                <h3 style="text-transform: capitalize;"><?php echo $user['User']['name']  ?></h3>
                <h3> <?php 
                    $birthdate = new DateTime($user['User']['birthdate']);
                    $today = new DateTime();
                    $ageInterval = $today->diff($birthdate);
                    $age = $ageInterval->y;

                    echo $age;
                ?></h3>
            </div>
            <p>Email: <?php echo $user['User']['email']  ?></p>
            <p>Gender: <?php echo $user['User']['gender']    ?></p>
            <p>Birthdate: <?php echo date('F d, Y', strtotime($user['User']['birthdate'])) ?></p>
            <p>Joined: <?php echo date('F d, Y g A', strtotime($user['User']['joined'])) ?></p>
            <p>Last Login: <?php 
                $last_login = $user['User']['last_login'];

                if(isset($last_login)) {
                    echo date('F d, Y g A', strtotime($user['User']['last_login']));
                }?>
            </p>
        </div>
    </div>
    <div>
        <p>Hobby:</p>
        <p> <?php echo $user['User']['hobby']  ?></p>
    </div>
</div>