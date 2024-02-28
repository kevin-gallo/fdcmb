<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <?php echo $this->Html->css('components/button'); ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f8fa;
            text-align: center;
        }
        .thank-you-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 50px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }
        h1 {
            font-size: 36px;
            color: #1da1f2;
            margin-bottom: 30px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #1da1f2;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <h1>Thank you for registering</h1>
        <?php echo $this->Html->link('Back to Homepage', 'home', array('class' => 'button')); ?>
    </div>
</body>
</html>
