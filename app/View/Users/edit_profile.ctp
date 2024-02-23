<?php


 echo $this->Html->css('components/button') ?>
<?php echo $this->Html->css('components/index') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>

<h1 style="font-size: 50px;">Edit Profile</h1>

<div>
    <?php echo $this->Html->link('Home', 'home') ?>
    <?php echo $this->Html->link('Profile', 'profile') ?>
</div>

<div style="margin-top: 22px;">
    <?php
    echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'edit_profile'), 'type' => 'file')); 

    if(!empty($user['User']['profile_picture'])) {
        echo $this->Html->image($user['User']['profile_picture'], array('id'=> 'preview-image', 'style' => 'width:100px;height:100px;'));
    } else {
        echo $this->Html->image('/img/default_profile_pic.jpg', array('id'=> 'preview-image'));
    }
    echo $this->Form->input('User.profile_picture', array(
        'type' => 'file',
        'name' => 'data[User][profile_picture]',
        'class' => 'form-control-file',
        'accept' => '.jpg,.jpeg,.gif,.png',
        'label' => 'Profile Picture',
        'id' => 'profile-picture'
    ));
     
    ?>
    <p><?php echo $this->Form->input('User.name', array('label' => 'Name')); ?></p>
    <p><?php echo $this->Form->input('User.email', array('label' => 'Email'));?></p>
    <p> <?php echo $this->Form->input('User.birthdate', array('label' => 'Birthdate', 'type' => 'text', 'class' => 'datepicker'));?></p>
    <p><?php echo $this->Form->input('User.gender', array(
        'type' => 'radio',
        'label' => 'Gender',
        'options' => array('male' => 'Male', 'female' => 'Female')
    )); ?></p>
    <p><?php echo $this->Form->input('User.hobby', array('label' => 'Hobby', 'type' => 'textarea')); ?></p>
    <p> <?php echo $this->Form->button('Update Profile', array('class'=> 'button-1'));?></p>
   
</div>

<script>
    $(document).ready(function() {
        // Datepicker for the birthdate field
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd' // Adjust the date format as needed
        });

        $(document).ready(() => {
            $('#profile-picture').change(function () {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $('#preview-image').attr('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    });
</script>

<div>
    <img id="preview-image" src="#" alt="Preview Image" style="width: 100px; height: 100px; margin-top: 10px; display: none;">
</div>
