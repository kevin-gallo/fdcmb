<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="header-1">
    <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
    <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> '')); ?></p>
</div>

<h1 style="font-size: 50px;">Conversation</h1>

<div>
    <?php echo $this->Html->link('Home', array('controller'=> 'users','action'=> 'home')); ?>
    &nbsp;<?php echo $this->Html->link("Message List", "index") ?>
    &nbsp;<?php echo $this->Html->link("New Message", "new_message") ?>
</div>

<div style="margin-top: 22px;">
<div style="margin-bottom: 12px;">
    <form id="searchForm">
        <input type="text" name="searchQuery" id="searchQuery" placeholder="Search message...">
        <button type="submit" class="button-1">Search</button>
    </form>
    <?php 
        echo $this->Form->create("Message", array(
            'url' => array(
                'controller'=> 'messages',
                'action'=> 'send_message', 
                $receiverId, // Receiver ID
                $senderId // Sender ID
            )));
        echo $this->Form->input('Message.message', array('label' => false,'placeholder' => 'Enter your message here...'));
        echo $this->Form->button('New Message', array( 'class'=> 'button-1'));
        echo $this->Form->end();
    ?>
</div>
<div>
    <?php 
        if(count($conversation) > 0) { ?>
            <button class="delete-conversation">Delete Conversation</button>
        <?php }
    ?>
</div>
    <div class="conversation">
        <?php foreach ($conversation as $msg): ?>
            <div style="margin-bottom: 20px;display:flex;flex-direction: row;align-items: center;justify-content: flex-end;">
                <div>
                    <h3><?php echo $msg['Sender']['name']; ?></h3>
                    <p><?php echo $msg['Message']['message']; ?></p>
                    <p><?php echo $msg['Message']['sent_at']; ?></p>
                </div>
                <div style="float: left; margin-right: 10px;">
                    <?php 
                        $picture = $msg['Sender']['profile_picture'];
                        if(isset($picture)) {
                            echo $this->Html->image($picture);
                        } else {
                            echo $this->Html->image('/img/default_profile_pic.jpg', array('alt'=> 'Default Image '));
                        }
                    ?>
                </div>
                <div style="clear: both;"></div>
            </div>
        <?php endforeach; ?>
        <?php 
          if(count($conversation) > 10) { ?>
            <div style="text-align: center;">
                <!-- Pagination -->
                <?php echo $this->Paginator->prev('Show Less'); ?>
                <?php echo $this->Paginator->next('Show More'); ?>
            </div>
          <?php }
        ?>
    </div>
    
</div>

<script>
    $(document).ready(function() {
        // Handle delete conversation button click
        $('.delete-conversation').click(function() {
            var confirmed = confirm('Are you sure you want to delete this conversation?');
            if (confirmed) {
                // Send AJAX request to delete conversation
                $.ajax({
                    url: 'http://localhost/fdcmb/messages/deleteConversation/<?php echo $senderId; ?>/<?php echo $receiverId; ?>',
                    type: 'POST',
                    success: function(response) {
                        // Fade out the conversation container
                        $('.conversation').fadeOut('slow', function() {
                            $(this).remove();
                        });
                        location.reload()
                    },
                    error: function() {
                        alert('Failed to delete conversation. Please try again.');
                    }
                });
            }0
        });
    });

    $(document).ready(function() {
        $('#searchForm').submit(function(event) {
            event.preventDefault(); // Prevent default form submission

            var keyword = $('#searchQuery').val(); // Get the search keyword

            // Perform AJAX request to search for messages
            $.ajax({
                url: 'http://localhost/fdcmb/messages/search_message/<?php echo $senderId ?>/<?php echo $receiverId ?>/' + keyword,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Clear existing messages
                    $('.conversation').empty();
                    let noResults = '<h2>No Message Found</h2>';
                    // Display matched messages
                    if(data.length === 0) {
                        $('.conversation').append(noResults)
                    } else {
                        $.each(data, function(index, message) {
                        let senderName = message['Sender']['name'];
                        let receiverName = message['Receiver']['name'];
                        let senderPicture = message['Sender']['profile_picture'];
                        let receiverPicture = message['Receiver']['profile_picture'];
                        let sentAt = message['Message']['sent_at'];
                        let messageContent = message['Message']['message'];

                        let messageHTML = `
                            <div style="display:flex;flex-direction: row;align-items: center;justify-content: flex-end;gap:10px;">
                                <div>
                                    <img src="/fdcmb/app/webroot/img/default_profile_pic.jpg"/>
                                </div>
                                <div>
                                    <h3>${senderName} - ${receiverName}</h3>
                                    <p>${messageContent}</p>
                                    <p>${sentAt}</p>
                                </div>
                            </div>
                        `;

                        $('.conversation').append(messageHTML);
                    });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error); // Log any errors
                }
            });
        });
    });
</script>