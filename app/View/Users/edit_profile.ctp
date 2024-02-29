<?php echo $this->Html->css('components/button') ?>
<?php echo $this->Html->css('components/index') ?>

<div class="container mt-5">
    <div class="header-1">
        <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?></p>
        <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
    </div>

    <h1 class="mt-4" style="font-size: 50px;">Edit Profile</h1>

    <div class="mb-3">
        <?php echo $this->Html->link('Home', 'home', array('class' => 'btn btn-primary mr-2')) ?>
        <?php echo $this->Html->link('Profile', 'profile', array('class' => 'btn btn-primary')) ?>
    </div>

    <div class="profile-section">
        <?php
            echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'edit_profile'), 'type' => 'file', 'class' => 'mt-4'));
            
            if(!empty($user['User']['profile_picture'])) {
                echo $this->Html->image($user['User']['profile_picture'], array('id'=> 'preview-image', 'class' => 'img-thumbnail mb-3', 'style' => 'width:100px;height:100px;'));
            } else {
                echo $this->Html->image('/img/default_profile_pic.jpg', array('id'=> 'preview-image', 'class' => 'img-thumbnail mb-3'));
            }
            
            echo $this->Form->input('User.profile_picture', array(
                'type' => 'file',
                'name' => 'data[User][profile_picture]',
                'class' => 'form-control-file mb-3',
                'accept' => '.jpg,.jpeg,.gif,.png',
                'label' => 'Upload Picture',
                'id' => 'profile-picture'
            ));

            echo $this->Form->input('User.name', array('label' => 'Name', 'class' => 'form-control mb-3'));
            echo $this->Form->input('User.email', array('label' => 'Email', 'class' => 'form-control mb-3'));
            echo $this->Form->input('User.birthdate', array('label' => 'Birthdate', 'type' => 'text', 'class' => 'form-control datepicker mb-3'));
            echo $this->Form->input('User.gender', array(
                'type' => 'radio',
                'label' => 'Gender',
                'options' => array('male' => 'Male', 'female' => 'Female'),
                'class' => 'mb-3'
            ));
            echo $this->Form->input('User.hobby', array('label' => 'Hobby', 'type' => 'textarea', 'class' => 'form-control mb-3'));

            echo $this->Form->button('Update Profile', array('class'=> 'btn btn-primary mb-3'));
            echo $this->Form->end();
        ?>
    </div>
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
                        $('#preview-image').show();
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    });
</script>
