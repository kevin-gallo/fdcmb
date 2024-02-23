<?php 
App::uses("AppController","Controller");

class MessagesController extends AppController {

    public function index() {
        $user = $this->Auth->user('name');
        $this->set('name', $user);

        $message = $this->Message->find('all');
        $this->set('message', $message);
    }

    public function new_message() { 
        $user = $this->Auth->user('name');
        $this->set('name', $user);

        if($this->request->is('post')) {
            if($this->Message->save($this->request->data)) {
                $this->Flash->success(__('Message sent successfully!'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Flash->error(__('Failed to send message!'));
            }
        }

        $this->render('new_message');
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
}