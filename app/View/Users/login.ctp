<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <?php echo $this->Html->css('https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'); ?>
    <?php echo $this->Html->css('components/button'); ?>
    <style>
        body {
            background-color: #f5f8fa;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h1 {
            font-size: 30px;
            margin-bottom: 30px;
            text-align: center;
        }
        .login-container p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h1>Login</h1>
            <?php
                echo $this->Form->create('User');
                echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => 'Email'));
                echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password'));
            ?>
            <div class="text-center">
                <p>Don't have an account yet? <?php echo $this->Html->link('Register', 'register'); ?>.</p>
                <?php
                    echo $this->Form->button('Login', array('class' => 'btn btn-primary btn-block'));
                ?>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</body>
</html>
