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
        $query = $this->request->query('q');
        $users = $this->User->finc('list', array(
            'conditions'=> array("User.name LIKE" => '%' . $query . '%')
        ));

        echo json_encode($users);
    }
}