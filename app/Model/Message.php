<?php
App::uses("AppModel","Model");

class Message extends AppModel {
    public $useTable = "messages";
    public $belongsTo = array(
        "Sender" => array(
            "className"=> "User",
            "foreignKey" => "sender_id"
        ),
        "Receiver" => array(
            "className"=> 'User',
            'foreignKey'=> 'receiver_id'
        )
    );

    public $virtualFields = array(
        'sender_name' => 'Sender.name',
        'receiver_name' => 'Receiver.name'
    );
}