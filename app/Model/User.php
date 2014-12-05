<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');

/**
 * User Model
 *
 * @property Activity $Activity
 * @property Follow $Follow
 * @property Request $Request
 * @property Book $Book
 */
class User extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'email' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A email is required'
            )
        ),
        'confirm_password' => array(
            'required' => array(
                'rule' => array('notEmpty'), 
                'message' => 'Please confirm your password'
            ),
            'compare' => array(
                'rule' => array('identicalPassword'),
                'message' => 'The passwords you entered do not match.'
            )
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Activity' => array(
            'className' => 'Activity',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Follow' => array(
            'className' => 'Follow',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Request' => array(
            'className' => 'Request',
            'foreignKey' => 'user_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * hasAndBelongsToMany associations
     *
     * @var array
     */
    public $hasAndBelongsToMany = array(
        'Book' => array(
            'className' => 'Book',
            'joinTable' => 'user_book',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'book_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    // Validate confirm password
    public function identicalPassword() {
        return $this->data[$this->alias]['password'] === $this->data[$this->alias]['confirmPassword'];
    }
}
