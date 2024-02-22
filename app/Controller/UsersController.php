<?php
App::uses("AppController","Controller");

class UsersController extends AppController {
    var $helpers = array( 'Html' );

    public $components = array(
        'Flash',
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'users', 'action' => 'home'),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
            'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email') // Adjust as per your field names
                )
            ),
            'authError' => 'You are not authorized to access that location.'
        )
    );

    public function index() {
        return $this->redirect( array('action'=> 'home') );
    }

    public function register() {
        if($this->request->is('post')) {
            try {
                $this->User->create();
                if($this->User->save($this->request->data)) {
                    $this->Flash->success(__('Registered Succesfully!'));
                    $this->redirect(array('action'=> 'thankyou'));
                } else {
                    $this->Flash->error(__('Registration Failed!'));
                } 
            } catch (PDOException $error) {
                if($error->getCode() == 23000) {
                    $this->Flash->error(__('Email already exist!'));
                } else {
                    $this->Flash->error($error->getMessage());
                }
            }
        }
    }
    // UsersController.php
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $userId = $this->Auth->user('id');
                $this->User->id = $userId;
                $this->User->saveField('last_login', date('Y-m-d H:i:s'));

                return $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
        $this->render('login');
    }

    public function logout() {
        $this->Auth->logout();
        $this->redirect(array('action'=> 'login'));
    }

    public function thankyou() {
        $this->render('thankyou');
    }

    public function home() {
        $name = $this->Auth->user('name');
        $this->set('name', $name);

        $this->render('home');
    }


    public function profile() {
        $name = $this->Auth->user('name');
        $this->set('name', $name);
        $userId = $this->Auth->user('id');
        $this->loadModel('User');
        $user = $this->User->findById($userId);
        $this->set('user', $user);
    }

    public function edit_profile() {
        $name = $this->Auth->user('name');
        $this->set('name', $name);
    
        $userId = $this->Auth->user('id');
        if ($this->request->is('post') || $this->request->is('put')) {
            // Load the existing user record
            $user = $this->User->findById($userId);
            if (!$user) {
                throw new NotFoundException(__('Invalid user'));
            }
    
            // Update the user data
            $this->User->id = $userId;
            if ($this->User->save($this->request->data)) {
                $this->Flash->success(__('Profile updated successfully!'));
                return $this->redirect(array('action' => 'profile'));
            } else {
                $this->Flash->error(__('Failed to update profile!'));
            }
        } else {
            // Fetch user data and pass it to the view
            $user = $this->User->findById($userId);
            $this->set('user', $user);
    
            $this->request->data = $user;
        }
    }

    public function update_profile_pic() {
        
    }
}    