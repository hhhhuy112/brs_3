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
    const IS_ADMIN = '2';
    
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
                'rule' => array('email', 'notEmpty'),
                'message' => 'A email is required'
            )
        ),
        'confirmPassword' => array(
            'required' => array(
                'rule' => array('notEmpty'), 
                'message' => 'Please confirm your password'
            ),
            'compare' => array(
                'rule' => array('validatePasswords'),
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
            'foreignKey' => 'follower_id',
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
        ),
        'Review' => array(
            'className' => 'Review',
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
            'joinTable' => 'book_users',
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

    public $uses = array('Follow', 'Review', 'Activity');

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }

    // Validate confirm password
    public function validatePasswords() {
        return $this->data[$this->alias]['password'] === $this->data[$this->alias]['confirmPassword'];
    }

    public function getAllUserActivities($userId = null) {
        $userId = (isset($userId)) ? ($userId) : ($this->user('id'));
        $userAllActivities  = array();
        $userFollowActions  = $this->Follow->getAllFollowActions($userId);
        $userActivities     = $this->Activity->getAllActivities($userId);
        $userComments       = $this->Review->Comment->getAllCommentWithBooks($userId);
        $userReviews        = $this->Review->getReviewByUserId($userId);
        $userAllActivities  = array_merge($userFollowActions, $userActivities, $userComments, $userReviews);
        usort($userAllActivities, function($a1, $a2) {
            $v1 = strtotime($a1['created']);
            $v2 = strtotime($a2['created']);
            return $v2 - $v1;
        });
        return $userAllActivities;
    }
}
