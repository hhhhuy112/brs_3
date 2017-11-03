<?php
App::uses('AppModel', 'Model');
/**
 * Activity Model
 *
 * @property User $User
 */
class Activity extends AppModel {
    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function addActivity($data, $userId) {
        if ($data['action'] === 'follow' || $data['action'] === 'unfollow') {
            $data = array(
                'action'    => $data['action'],
                'target_id' => $data['followedId'],
                'user_id'   => $userId
            );
        } else {
            $data = array(
                'action'    => $data['action'],
                'target_id' => $data['bookId'],
                'user_id'   => $userId
            );
        }
        $this->save($data);
        $this->clear();
    }

    public function getAllActivities($userId) {
        $activities = $this->findAllByUserId($userId);
        $result = array();
        $bookIds = array();
        foreach ($activities as $activity) {
            $bookIds[] = $activity['target_id'];
        }
        // Get list of books
        $books = $this->Book->find('list', array(
            'conditions' => array('Book.id IN' => $bookIds),
            'fields'     => array('Book.id', 'Book.name')
        ));

        foreach ($activities as $activity) {
            $bookId = $activity['target_id'];
            $activity['Activity']['bookName'] = $books[$bookId];
            $result[] = $activity['Activity'];
        }
        return $result;
    }
}
