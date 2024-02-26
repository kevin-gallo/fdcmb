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

                return $this->redirect("home");
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
    
            // Handle file upload for profile picture
            if (!empty($this->request->data['User']['profile_picture']['name'])) {
                $file = $this->request->data['User']['profile_picture'];
                $file_ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                $file_new_name = $userId . '_' . time() . '.' . $file_ext;
                $file_destination = WWW_ROOT . 'img' . DS . 'profile_pics' . DS . $file_new_name;
    
                if (move_uploaded_file($file['tmp_name'], $file_destination)) {
                    // Save the new profile picture path to the user record
                    $this->request->data['User']['profile_picture'] = 'profile_pics/' . $file_new_name;
                } else {
                    $this->Flash->error(__('Failed to upload profile picture.'));
                }
            } else {
                $this->request->data['User']['profile_picture'] = $user['User']['profile_picture'];
            }
    
            // Update the user data
            $this->User->id = $userId;
            try {
                if ($this->User->save($this->request->data)) {
                    $this->Flash->success(__('Profile updated successfully!'));
                    return $this->redirect(array('action' => 'profile'));
                } else {
                    $this->Flash->error(__('Failed to update profile!'));
                }
            } catch (PDOException $e) {
                if ($e->getCode() == 23000) {
                    $this->Flash->error(__('Email already exists! Please use a different email.'));
                } else {
                    $this->Flash->error($e->getMessage());
                }
            }
        } else {
            // Fetch user data and pass it to the view
            $user = $this->User->findById($userId);
            $this->set('user', $user);
    
            $this->request->data = $user;
        }
    }
    public function change_password() {
        $name = $this->Auth->user('name');
        $this->set('name', $name);
    
        if ($this->request->is('post')) {
            // Load the User model
            $this->loadModel('User');
            
            // Get the user ID from the session
            $userId = $this->Auth->user('id');
            
            // Get the current password, new password, and confirm password from the form data
            $currentPassword = $this->request->data['User']['current_password'];
            $newPassword = $this->request->data['User']['new_password'];
            $confirmPassword = $this->request->data['User']['confirm_password'];
    
            // Retrieve the user's record from the database
            $user = $this->User->findById($userId);
            
            // Check if the current password matches the password in the database
            if (Security::hash($currentPassword, 'sha1', true) === $user['User']['password']) {
                // Check if the new password and confirm password match
                if ($newPassword === $confirmPassword) {
                    // Set the new password
                    $user['User']['password'] = Security::hash($newPassword, 'sha1', true);
                    
                    // Save the updated user data
                    if ($this->User->save($user, false)) { // Set validate to false to bypass validation
                        $this->Flash->success('Password changed successfully.');
                        return $this->redirect("profile");
                    } else {
                        $this->Flash->error('Failed to update password.');
                    }
                } else {
                    $this->Flash->error('New password and confirm password do not match.');
                }
            } else {
                $this->Flash->error('Current password is incorrect.');
            }
        }
    }
    
}    