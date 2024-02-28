<?php echo $this->Html->css('components/index') ?>
<?php echo $this->Html->css('components/button') ?>

<div class="container">
    <div class="header-1 mt-5">
        <p style="text-transform:capitalize;">Welcome, <?php echo h($name) ?> </p>
        <p><?php echo $this->Html->link('Logout', array('controller' =>'users','action'=> 'logout'), array('class'=> 'btn btn-danger')); ?></p>
    </div>

    <h1 class="mt-5">Conversation</h1>

    <div class="mt-3">
        <?php echo $this->Html->link('Home', array('controller'=> 'users','action'=> 'home'), array('class'=> 'btn btn-primary')); ?>
        <?php echo $this->Html->link("Message List", "index", array('class'=> 'btn btn-primary')); ?>
        <?php echo $this->Html->link("New Message", "new_message", array('class'=> 'btn btn-primary')); ?>
    </div>

    <div class="mt-4">
        <form id="searchForm">
            <div class="input-group">
                <input type="text" class="form-control" name="searchQuery" id="searchQuery" placeholder="Search message..." required>
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="mt-4">
        <?php 
            echo $this->Form->create("Message", array(
                'url' => array(
                    'controller'=> 'messages',
                    'action'=> 'send_message', 
                    $receiverId, // Receiver ID
                    $senderId // Sender ID
                ),
                'class' => 'mt-3'
            ));
            echo $this->Form->input('Message.message', array(
                'label' => false,
                'class' => 'form-control',
                'placeholder' => 'Enter your message here...',
                'required' => true,
            ));
            echo $this->Form->button('Reply', array( 'class'=> 'btn btn-primary mt-3'));
            echo $this->Form->end();
        ?>
    </div>

    <div class="mt-4">
        <?php 
            if(count($conversation) > 0) { ?>
                <button class="delete-conversation">Delete Conversation</button>
            <?php }
        ?>
    </div>

    <div class="conversation mt-4">
        <?php foreach ($conversation as $msg): ?>
            <div class="message-wrapper mb-4">
                <?php if($senderId === $msg['Message']['sender_id']) { ?>
                    <div class="text-right">
                        <h3 class="text-right"><?php echo $msg['Message']['sender_name']; ?></h3>
                        <?php if(strlen($msg['Message']['message']) > 10) { ?>
                            <div class="short-message"><?php echo substr($msg['Message']['message'],0, 50) . '...'; ?></div>
                            <div class="full-message" style="display: none;"><?php echo $msg['Message']['message']; ?></div>
                            <a href="#" class="show-more">Show More</a>
                        <?php } else { ?>
                            <div class="short-message"><?php echo $msg['Message']['message']; ?></div>
                        <?php } ?>
                        <div class="message-info mt-2">
                            <p><?php echo $msg['Message']['sent_at']; ?></p>
                        </div>
                        <div class="profile-picture">
                            <?php 
                                $picture = $msg['Sender']['profile_picture'];
                                if(isset($picture)) {
                                    echo $this->Html->image($picture);
                                } else {
                                    echo $this->Html->image('/img/default_profile_pic.jpg', array('alt'=> 'Default Image '));
                                }
                            ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="text-left">
                        <h3><?php echo $msg['Message']['sender_name']; ?></h3>
                        <?php if(strlen($msg['Message']['message']) > 10) { ?>
                            <div class="short-message"><?php echo substr($msg['Message']['message'],0, 50) . '...'; ?></div>
                            <div class="full-message" style="display: none;"><?php echo $msg['Message']['message']; ?></div>
                            <a href="#" class="show-more">Show More</a>
                        <?php } else { ?>
                            <div class="short-message"><?php echo $msg['Message']['message']; ?></div>
                        <?php } ?>
                        <div class="message-info mt-2">
                            <p><?php echo $msg['Message']['sent_at']; ?></p>
                        </div>
                        <div class="profile-picture">
                            <?php 
                                $picture = $msg['Sender']['profile_picture'];
                                if(isset($picture)) {
                                    echo $this->Html->image($picture);
                                } else {
                                    echo $this->Html->image('/img/default_profile_pic.jpg', array('alt'=> 'Default Image '));
                                }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="text-center mt-4">
        <?php 
            echo $this->Paginator->prev('Show Less', array('class' => 'btn btn-primary')) . ' ';
            echo $this->Paginator->next('Show More', array('class' => 'btn btn-primary')); 
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

    $(document).ready(function() {
        $('.show-more').click(function () {  
            $(this).closest('.message-wrapper').find('.short-message').hide();
            $(this).closest('.message-wrapper').find('.full-message').show();
        })

        $('.show-less').click(function () {  
            $(this).closest('.message-wrapper').find('.full-message').hide();
            $(this).closest('.message-wrapper').find('.short-message').show();
        })
    })
</script>