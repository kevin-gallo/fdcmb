<?php 
App::uses("AppModel","Model");
App::uses("Security","Utility");

class User extends AppModel {
    public $users = "users";

    public $validate = array(
        'name' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Name is required!'
            ),
            'length' => array(
                'rule' => array('between', 5, 20),
                'message' => 'Name should be between 5 and 20 characters!'
            )
        ),
        'email'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'Email is required!'
            )
        ),
        'password' => array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'Password is required!'
            ),
            // 'match'=> array(
            //     'rule'=> array('password', 'confirm password'),
            //     'message'=> 'Password does not match'
            // )
        ),
        'confirm password'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'Confirm Password is required!'
            ),
        )
    );

    public function beforeSave($options = array()) {
        if(!empty($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = Security::hash($this->data[$this->alias]['password'], 'sha1', true);
        }

        if(!$this->id) {
            $this->data[$this->alias]['joined'] = date('Y-m-d H:i:s');
            $this->data[$this->alias]['last_login_time'] = date('Y-m-d H:i:s');
        }

        return true;
    }

    // public function compareFields($field1, $field2) {
    //     if (isset($this->data[$this->alias][$field1]) && isset($this->data[$this->alias][$field2])) {
    //         return $this->data[$this->alias][$field1] === $this->data[$this->alias][$field2];
    //     }
    //     return false;
    // }
    
    // public function updateLastLogin($userId) {
    //     $user = $this->findById($userId);
    //     $user[$this->alias]['last_login'] = date('Y-m-d H:i:s');
    //     return $this->save($user);
    // }
}
?>