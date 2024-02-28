<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col">
                <div class="header-1">
                    <p class="text-capitalize">Welcome, <?php echo h($name) ?></p>
                    <p><a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')) ?>" class="btn btn-secondary">Logout</a></p>
                </div>
                <h1 class="mt-4">User Profile</h1>
                <div class="mb-3">
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'home')) ?>" class="btn btn-primary">Home</a>
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'edit_profile')) ?>" class="btn btn-info">Edit Profile</a>
                    <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'change_password')) ?>" class="btn btn-warning">Change Password</a>
                </div>
                <div class="row">
                    <div class="col-md-3">
                    <?php
                        if (!empty($user['User']['profile_picture'])) {
                            $image = $user['User']['profile_picture'];
                            echo $this->Html->image($image, array('style'=> 'width:100px;height:100px;'));
                        } else {
                            echo $this->Html->image('/img/default_profile_pic.jpg', array('alt' => 'Default Profile Picture'));
                        }
                    ?>
                    </div>
                    <div class="col-md-9">
                        <div class="row mb-3">
                            <div class="col">
                                <h3 class="text-capitalize"><?php echo $user['User']['name'] ?></h3>
                                <?php 
                                    $birthdate = new DateTime($user['User']['birthdate']);
                                    $today = new DateTime();
                                    $ageInterval = $today->diff($birthdate);
                                    $age = $ageInterval->y;
                                ?>
                                <p><?php echo $age ?> years old</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <p>Email: <?php echo $user['User']['email'] ?></p>
                                <p>Gender: <?php echo $user['User']['gender'] ?></p>
                                <p>Birthdate: <?php echo date('F d, Y', strtotime($user['User']['birthdate'])) ?></p>
                                <p>Joined: <?php echo date('F d, Y g A', strtotime($user['User']['joined'])) ?></p>
                                <p>Last Login: <?php echo isset($user['User']['last_login']) ? date('F d, Y g A', strtotime($user['User']['last_login'])) : '' ?></p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <p>Hobby:</p>
                                <p><?php echo $user['User']['hobby'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
