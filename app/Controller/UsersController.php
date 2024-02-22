<?php
App::uses("AppController","Controller");

class UsersController extends AppController {
    var $helpers = array( 'Html' );
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
    public function login() {
        $this->render('login');
    }

    public function logout() {
        
    }

    public function thankyou() {
        $this->render('thankyou');
    }
}