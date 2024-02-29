<?php
App::uses("AppController","Controller");

class MessagesController extends AppController {

   public $components = array('Flash');

   public function index() {
       $user = $this->Auth->user('name');
       $this->set('name', $user);

       $this->loadModel('User');
  
       // Get the current user's ID
       $userId = $this->Auth->user('id');
  
       // Retrieve the list of contacts (users with whom the current user has conversations)
    //    $contacts = $this->Message->find('all', array(
    //        'fields' => array('DISTINCT receiver_id', 'Sender.id', 'Sender.name', 'Receiver.id', 'Receiver.name'),
    //        'conditions' => array(
    //            'OR' => array(
    //                array('sender_id' => $userId),
    //                array('receiver_id' => $userId)
    //            )
    //        ),
    //        'contain' => array(
    //            'Sender', // Include the Sender data
    //            'Receiver' // Include the Receiver data
    //        )
    //    ));

        $contacts = $this->Message->query("SELECT * FROM messages WHERE sender_id = '$userId' OR receiver_id = '$userId' GROUP BY sender_id");
        $ids = [];
        foreach($contacts as $contact) {
            $ids[] = $contact['messages']['sender_id'];
            $ids[] = $contact['messages']['receiver_id'];
        }

        // $users = $this->User->query("SELECT * FROM users WHERE id IN ");

        $users = $this->User->find('all', array(
            'conditions' => array(
                'id'=> $ids
            )
        ));

        $this->set('users', $users);
        $this->set('userId', $userId); // Pass the userId to the view
        $this->set('contacts', $contacts);
   }

   public function new_message() {
       $user = $this->Auth->user('name');
       $this->set('name', $user);

       $this->loadModel('User');

       $receiverId = null;

       if($this->request->is('post')) {
           $senderId = $this->Auth->user('id');
           $receiverId = isset($this->request->data['Message']['receiver_id']) ? $this->request->data['Message']['receiver_id'] : null;

           $this->set('receiverId', $receiverId);

           if (empty($receiverId)) {
               $this->Flash->error(__('Receiver ID is required.'));
               return $this->redirect(array('action' => 'index'));
           }
           // Populate sender_id, receiver_id, sender_name, receiver_name, sender_picture, receiver_picture, and sent_at
           $receiver = $this->User->findById($receiverId);

           if (!$receiver) {
               $this->Flash->error(__('Receiver not found.'));
               return $this->redirect(array('action' => 'index'));
           }

           // Populate sender_id, receiver_id, sender_name, receiver_name, sender_picture, receiver_picture, and sent_at
           $this->request->data['Message']['sender_id'] = $senderId;
           $this->request->data['Message']['receiver_id'] = $receiverId;
           $this->request->data['Message']['sender_name'] = $this->Auth->user('name');
           $this->request->data['Message']['receiver_name'] = isset($receiver['User']['name']) ? $receiver['User']['name'] : null;
           $this->request->data['Message']['sender_picture'] = $this->Auth->user('profile_picture');
           $this->request->data['Message']['receiver_picture'] = isset($receiver['User']['profile_picture']) ? $receiver['User']['profile_picture'] : null;
           $this->request->data['Message']['message'] = isset($this->request->data['Message']['message']) ? $this->request->data['Message']['message'] : null;
           $this->request->data['Message']['sent_at'] = date('Y-m-d H:i:s');
           $this->request->data['Message']['received_at'] = null;

           if($this->Message->save($this->request->data)) {
               $this->Flash->success(__('Message sent successfully!'));
               return $this->redirect(array('action' => 'index'));
           } else {
               $this->Flash->error(__('Failed to send message!'));
           }
       }

       $this->set('receiverId', $receiverId);
   }

   public function conversation($receiverId) {
       $user = $this->Auth->user('name');
       $this->set('name', $user);
    
       $senderId = $this->Auth->user('id');
  
       // Get the current user's ID
    //    $userId = $this->Auth->user('id');
    //    $this->set('user_id', $userId);

       // Retrieve the messages exchanged between the current user and the selected receiver
    //    $this->paginate = array(
    //         'conditions' => array(
    //             'OR' => array(
    //                 array(
    //                     'AND' => array(
    //                         'sender_id' => $senderId,
    //                         'receiver_id' => $receiverId
    //                     )
    //                 ),
    //                 array(
    //                     'AND' => array(
    //                         'sender_id' => $receiverId,
    //                         'receiver_id' => $senderId
    //                     )
    //                 )
    //             ) 
    //         ),
    //         'order' => 'Message.sent_at DESC',
    //         'contain' => array(
    //             'Sender' => array('fields' => array('id', 'name', 'profile_picture')),
    //             'Receiver' => array('fields' => array('id', 'name', 'profile_picture'))
    //         ),
    //         'limit' => 10 // Number of messages per page
    //     );

        $conversation = $this->Message->query("SELECT * FROM messages WHERE (sender_id = '$senderId' 
                                            AND receiver_id = '$receiverId') 
                                            OR (sender_id = '$receiverId' 
                                            AND receiver_id = '$senderId') 
                                            ORDER BY sent_at DESC"); 

        $conversation = $this->paginate('Message');

    //    debug($conversation);
       $this->set('conversation', $conversation);
       $this->set('senderId', $senderId);
       $this->set('receiverId', $receiverId);

       if ($this->request->is('post')) {
       // Call the send_message method
           $this->send_message($receiverId);
       }  
   }

   public function send_message( $receiverId) {
       if($this->request->is('post')) {

         $senderId = $this->Auth->user('id');

           $this->set('senderId', $senderId);
           $this->set('receiverId', $receiverId);
           $this->request->data['Message']['sender_id'] = $senderId;
           $this->request->data['Message']['receiver_id'] = $receiverId;
           $this->request->data['Message']['sent_at'] = date('Y-m-d H:i:s');
           $this->request->data['Message']['sender_name'] = $this->Auth->user('name');
           $this->request->data['Message']['receiver_name'] = $receiverId;

           if($this->Message->save($this->request->data)) {
               $this->Flash->success(__('Message sent successfully!'));
           } else {
               $this->Flash->error(__('Failed to send message!'));
           }
       }

       $this->set('senderId', $senderId);
  
       return $this->redirect(array('action'=> 'conversation', $receiverId));
   }

   public function get_users() {
       $this->autoRender = false;
       $this->loadModel('User');
  
       if ($this->request->is('get')) {
           $conditions = array();
           $keyword = $this->request->query('q');
           $conditions['User.name LIKE'] = '%' . $keyword . '%';
  
           // Retrieve list of users with id and name
           $users = $this->User->find('list', array(
               'conditions' => $conditions,
               'fields' => array('User.id', 'User.name')
           ));
  
           // Retrieve profile pictures for all users
           $allUsers = $this->User->find('all', array(
               'fields' => array('User.id', 'User.name', 'User.profile_picture')
           ));
  
           // Match profile pictures to users
           foreach ($allUsers as $user) {
               $userId = $user['User']['id'];
               if (isset($users[$userId])) {
                   $userName = $users[$userId];
                   $users[$userId] = array(
                       'id' => $userId,
                       'name' => $userName,
                       'profile_picture' => $user['User']['profile_picture']
                   );
               }
           }
  
           // Format response
           $response = array('users' => array_values($users));
           echo json_encode($response);
       }
   }

    public function deleteConversation($senderId, $receiverId) {
        $this->autoRender = false; // Disable rendering of view

        // Check if the request is AJAX
        if ($this->request->is('ajax')) {
            // Attempt to delete the entire conversation
            if ($this->Message->deleteAll(array(
                'OR' => array(
                    array(
                        'sender_id' => $senderId,
                        'receiver_id' => $receiverId
                    ),
                    array(
                        'sender_id' => $receiverId,
                        'receiver_id' => $senderId
                    )
                )
            ))) {
                $this->Flash->success('Conversation deleted successfully.');
                // Respond with success message
                return json_encode(array('success' => true));
            } else {
                // Respond with error message
                return json_encode(array('success' => false, 'message' => 'Failed to delete conversation.'));
            }
        }
    }

    public function search_message($senderId, $receiverId, $keyword) {
        $this->autoRender = false; // Disable rendering of view
    
        // Check if the request is AJAX
        if ($this->request->is('ajax')) {
            // Fetch all messages within the conversation with associated sender and receiver data
            $messages = $this->Message->find('all', array(
                'conditions' => array(
                    'OR' => array(
                        array(
                            'sender_id' => $senderId,
                            'receiver_id' => $receiverId
                        ),
                        array(
                            'sender_id' => $receiverId,
                            'receiver_id' => $senderId
                        )
                    ),
                    // Add condition to search keyword in message content
                    'Message.message LIKE' => "%$keyword%"
                ),
                'contain' => array(
                    'Sender' => array('fields' => array('id', 'name', 'profile_picture')),
                    'Receiver' => array('fields' => array('id', 'name', 'profile_picture'))
                )
            ));
    
            // Respond with matched messages in JSON format
            $this->response->type('json');
            echo json_encode($messages);
            return;
        }
    }
}