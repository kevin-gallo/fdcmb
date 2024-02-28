<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>
<div class="mb-3">
    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'home')) ?>" class="btn btn-primary">Home</a>
    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'profile')) ?>" class="btn btn-info">Profile</a>
</div>
<h1 style="font-size: 50px;">User Profile</h1>
<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic autem repellat velit distinctio delectus quisquam voluptas repudiandae eveniet, in ullam consequuntur vero, veritatis ducimus sequi dolore molestiae aut, assumenda harum.</p>

<?php
    echo $this->Form->create('User', array('id' => 'UserChangePasswordForm'));
    echo $this->Form->input('current_password', array('type' => 'password'));
    echo $this->Form->input('new_password', array('type' => 'password', 'id' => 'UserNewPassword'));
    echo $this->Form->input('confirm_password', array('type' => 'password', 'id' => 'UserConfirmPassword'));
    echo $this->Form->button('Change Password', array('class'=> 'button-1'));
    echo $this->Form->end();
?>

<script>
    $(document).ready(function() {
        $('#UserChangePasswordForm').submit(function(e) {
            let newpassword = $('#UserNewPassword').val();
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