<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-between">
            <div class="col-auto">
                <h1>Welcome, <?php echo $name ?></h1>
            </div>
            <div class="col-auto">
                <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'logout')) ?>" class="btn btn-danger">Logout</a>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Profile</h2>
                        <p class="card-text">View and edit your profile information.</p>
                        <a href="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'profile')) ?>" class="btn btn-primary">Go to Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Messages</h2>
                        <p class="card-text">View your messages and start new conversations.</p>
                        <a href="<?php echo $this->Html->url(array('controller' => 'messages', 'action' => 'index')) ?>" class="btn btn-primary">Go to Messages</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
