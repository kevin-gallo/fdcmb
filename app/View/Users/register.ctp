<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <?php echo $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'); ?>
    <?php echo $this->Html->css('components/button'); ?>
</head>
<body>
    <div class="container">
        <div class="register-container">
            <h1>Register</h1>
            <p class="error-message" style="display: none;">Password does not match!</p>
            <?php
                echo $this->Session->flash();
                echo $this->Form->create('User', array('id' => 'UserRegisterForm'));
                echo $this->Form->input('name', array('class' => 'form-control', 'placeholder' => 'Name'));
                echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Email'));
                echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password'));
                echo $this->Form->input('confirm_password', array('type' => 'password', 'class' => 'form-control', 'placeholder' => 'Confirm Password'));
            ?>
            <p>Already have an account? <?php echo $this->Html->link('Login', 'login'); ?>.</p>
            <div class="text-center">
                <?php
                    echo $this->Form->button('Register', array('class' => 'btn btn-primary btn-block', 'id' => 'register_btn'));
                ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#UserRegisterForm').submit(function(e) {
            let password = $('#UserPassword').val();
            let confirmPassword = $('#UserConfirmPassword').val();
            
            if (password !== confirmPassword) {
                $('.error-message').show();
                e.preventDefault();
            } else {
                $('.error-message').hide();
            }
        });
    });
    </script>
</body>
</html>
