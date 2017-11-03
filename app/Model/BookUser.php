<?php
App::uses('AppModel', 'Model');
/**
 * UserBook Model
 *
 * @property Book $Book
 * @property User $User
 */
class BookUser extends AppModel {

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Book' => array(
            'className' => 'Book',
            'foreignKey' => 'book_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function findByBookIdAndUserId($bookId, $userId) {
        return $this->find('first',
            array(
                'conditions' => array(
                    'user_id' => $userId,
                    'book_id' => $bookId
                )
            )
        );
    }

    public function addRating($requestData, $userId) {
        $bookUsers = $this->findByBookIdAndUserId($requestData['bookId'], $userId);
        if (!$bookUsers) {
            $this->create();
            $data = array(
                'book_id'       => $requestData['bookId'],
                'user_id'       => $userId,
                'rate'          => $requestData['rating']
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        } else {
            $this->id = $bookUsers['BookUser']['id'];
            $data = array(
                'rate'  => $requestData['rating']
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        }
    }

    public function markReading($bookId, $userId) {
        $bookUsers = $this->findByBookIdAndUserId($bookId, $userId);
        if (!$bookUsers) {
            $this->create();
            $data = array(
                'book_id'       => $bookId,
                'user_id'       => $userId,
                'is_reading'    => true,
                'is_read'       => false
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        } else {
            $this->id = $bookUsers['BookUser']['id'];
            $data = array(
                'is_reading'    => true,
                'is_read'       => false
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        }
    }

    public function markRead($bookId, $userId) {
        $bookUsers = $this->findByBookIdAndUserId($bookId, $userId);
        if (!$bookUsers) {
            $this->create();
            $data = array(
                'book_id'       => $bookId,
                'user_id'       => $userId,
                'is_reading'    => false,
                'is_read'       => true
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        } else {
            $this->id = $bookUsers['BookUser']['id'];
            $data = array(
                'is_reading'    => false,
                'is_read'       => true
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        }
    }

    public function markFavorite($bookId, $userId) {
        $bookUsers = $this->findByBookIdAndUserId($bookId, $userId);
        if (!$bookUsers) {
            $this->create();
            $data = array(
                'book_id'       => $bookId,
                'user_id'       => $userId,
                'is_favorite'   => true
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        } else {
            $this->id = $bookUsers['BookUser']['id'];
            $data = array(
                'is_favorite'   => true
            );
            $this->save($data, array('validate' => 'false'));
            $this->clear();
        }
    }
}
