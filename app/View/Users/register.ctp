<?php echo $this->Html->css('components/button'); ?>

<h1 style="font-size: 50px;">Register</h1>
    <p class="error-message" style="display:none;">Password does not match!</p>
<?php
    echo $this->Session->flash();
    echo $this->Form->create('User');
    echo $this->Form->input('name');
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->input('confirm password', array('type' => 'password'));
    ?>
    <p>Already have an account? <?php echo $this->Html->link('Login', 'login'); ?>.</p>
    <?php
    echo $this->Form->button('Register', array('class'=> 'submit button-1', 'id' => 'register_btn'));
    echo $this->Form->end();
?>

<script>
    $(document).ready(function() {
        $('#UserRegisterForm').submit(function(e) {
            var password = $('#UserPassword').val();
            var confirmPassword = $('#UserConfirmPassword').val();
            
            if (password !== confirmPassword) {
                $('.error-message').show();
                e.preventDefault();
            } else {
                $('.error-message').hide();
            }
        });
    });
</script>