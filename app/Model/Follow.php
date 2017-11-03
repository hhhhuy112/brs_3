<?php
App::uses('AppModel', 'Model');
/**
 * Follow Model
 *
 * @property User $User
 * @property Follower $Follower
 */
class Follow extends AppModel {

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'follower_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
    );

    public function getFollowed($follower_id, $following_id) {
        return $this->find('first', 
            array(
                'conditions' => array(
                    'follower_id' => $follower_id,
                    'following_id'=> $following_id
                )
            )
        );
    }

    public function getAllFollowActions($userId) {
        return array_merge($this->getAllFollowings($userId), $this->getAllFolloweds($userId));
    }

    // (i'm folower)
    public function getAllFollowings($userId) {
        $follows = array();
        $followings = $this->find('all', array('conditions' => array('follower_id' => $userId)));
        foreach ($followings as $following) {
            $followingUser = $this->User->findById($following['Follow']['following_id']);
            $following['Follow']['action']     = 'following';
            $following['Follow']['userName']   = $followingUser['User']['username'];
            $following['Follow']['userId']     = $followingUser['User']['id'];
            $follows[] = $following['Follow'];
        }
        return $follows;
    }

    // (i'm folowed)
    public function getAllFolloweds($userId) {
        $follows = array();
        $followeds = $this->find('all', array('conditions' => array('following_id' => $userId)));
        foreach ($followeds as $followed) {
            $followingUser = $this->User->findById($followed['Follow']['follower_id']);
            $followed['Follow']['action']     = 'followed';
            $followed['Follow']['userName']   = $followedUser['User']['username'];
            $followed['Follow']['userId']     = $followedUser['User']['id'];
            $follows[] = $followed['Follow'];
        }
        return $follows;
    }
}
