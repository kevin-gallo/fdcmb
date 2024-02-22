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
    echo $this->Form->create('User', array('type' => 'file'));

    // if(!empty($user['User']['profile_picture'])) {
    //     echo $this->Html->image($user['User']['profile_picture'], array('id'=> 'preview-image', 'style' => 'width:100px;height:100px;'));
    // } else {
    //     echo $this->Html->image('/img/default_profile_pic.jpg', array('id'=> 'preview-image'));
    // }
    // echo $this->Form->input('User.profile_picture', array('type' => 'file', 'label' => 'Profile Picture', 'id' => 'profile-picture'));
    
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

        // Preview uploaded image
        // $('#profile-picture').change(function() {
        //     var input = this;
        //     var url = window.URL || window.webkitURL;
        //     var file = input.files[0];
        //     var img = new Image();
        //     var imgURL = url.createObjectURL(file);
        //     img.src = imgURL;
        //     img.onload = function() {
        //         // Display preview of the image
        //         $('#preview-image').attr('src', imgURL);
        //     };
        // });
    });
</script>

<div>
    <!-- Image preview -->
    <img id="preview-image" src="#" alt="Preview Image" style="width: 100px; height: 100px; margin-top: 10px; display: none;">
</div>
