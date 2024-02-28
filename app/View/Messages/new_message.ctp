<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="container">
    <div class="header-1 mt-5">
        <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
        <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> 'btn btn-danger')); ?></p>
    </div>

    <h1 class="mt-5">New Message</h1>

    <div class="mt-3">
        <?php echo $this->Html->link('Home', array('controller'=> 'users','action'=> 'home'), array('class'=> 'btn btn-primary')); ?>
        <?php echo $this->Html->link('Message List', 'index', array('class'=> 'btn btn-primary')); ?>
    </div>

    <div class="mt-4">
        <?php 
            echo $this->Form->create('Message', array('class' => 'mt-3'));
            echo $this->Form->input('receiver_id', array(
                'type' => 'hidden', 
                'id' => 'receiver-hidden',
                'value' => ''
            ));
            echo $this->Form->input('receiver', array(
                'id' => 'receiver-input',
                'data-hidden-input' => 'receiver-hidden', // Link the select input to the hidden input
                'placeholder' => 'Search for recipient...',
                'class' => 'form-control select2-input',
            ));
            echo $this->Form->input('message', array(
                'label' => 'Message', 
                'type' => 'textarea',
                'required' => true,
                'class' => 'form-control'
            )); 
            echo $this->Form->button('Send Message', array('class'=> 'btn btn-primary mt-3'));
            echo $this->Form->end();
        ?>
    </div>
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

                // Initialize Select2 with preloaded data
                $('#receiver-input').select2({
                    data: data,
                    templateResult: formatUser,
                    minimumInputLength: 1
                });

                // Update receiver ID field when a user is selected
                $('#receiver-input').on('select2:select', function (e) {
                    var data = e.params.data;
                    $('#receiver-hidden').val(data.id); // Set the selected user's ID as the receiver ID
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
