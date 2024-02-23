<?php
App::uses("AppModel","Model");

class Message extends AppModel {
    public $messageModel = "messages";

    public $belongsTo = array(
        "sender"=> array(
            "className"=> "User",
            "foreignKey" => "sender_id"
        ),
        "receiver"=> array(
            "className"=> 'User',
            'foreignKey'=> 'receiver_id'
        )
    );

    public $validate = array(
        'receiver'=> array(
            'rule'=> 'notBlank',
            'message'=> 'Please add a recipient'
        ),
        'message' => array(
            'rule' => 'notBlank',
            'message' => 'Message content is required'
        ),
    );
}