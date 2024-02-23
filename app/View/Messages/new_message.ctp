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
        echo $this->Form->create('Message');
        echo $this->Form->input('receiver', array(
            'id' => 'receiver-input',
            'data-hidden-input' => 'receiver-hidden', // Link the select input to the hidden input
            'placeholder' => 'Search for recipient...',
            'class' => 'select2-input',
        ));
        echo $this->Form->input('message', array(
            'label' => 'Message', 
            'type' => 'textarea',
        )); 
        echo $this->Form->button('Send Message', array('class'=> 'button-1'));
    ?>
</div>

<script>
    $(document).ready(function() {
        let data = [];

        // Ajax request to fetch user data
        $.ajax({
            url: 'http://localhost/fdcmb/messages/get-users',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Data:', response);
                // Assuming response is an array of users with 'id' and 'name' properties
                data = response.users.map(function(user) {
                    return { 
                        id: user.id, 
                        text: user.name,
                        image: 'http://localhost/fdcmb/app/webroot/img/' + user.profile_picture
                    };
                });

                // // Initialize Select2 with preloaded data
                $('#receiver-input').select2({
                    data: data,
                    templateResult: formatUser,
                    minimumInputLength: 1
                });
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
            }
        });

        function formatUser(user) {
        if (!user.id) {
            return user.text;
        }

        var $user = $(
            '<span><img src="' + user.image + '" class="avatar" style="width:20px;height:20px;"/> ' + user.text + '</span>'
        );
        return $user;
    }
    });

</script>