<?php 
App::uses("AppModel","Model");
App::uses("Security","Utility");

class User extends AppModel {
    public $useTable = "users";

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
        ),
        'confirm_password'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'Confirm Password is required!'
            ),
        ),
        'birthdate'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'Birthdate is required!'
            )
        ),
        'gender'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'Birthdate is required!'
            )
        ),
        'hobby'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'Birthdate is required!'
            )
        ),
        'current_password'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'New Password is required!'
            ),
        ),
        'new_password'=> array(
            'required'=> array(
                'rule'=> array('notBlank'),
                'message'=> 'New Password is required!'
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
}
?>