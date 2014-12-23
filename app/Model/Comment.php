<?php
App::uses('AppModel', 'Model');
App::uses('Book', 'Model');
/**
 * Comment Model
 *
 * @property Reviewer $Reviewer
 * @property Review $Review
 */
class Comment extends AppModel {
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'comments' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Comment can not be empty',
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Review' => array(
            'className' => 'Review',
            'foreignKey' => 'review_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function getAllCommentWithBooks($userId = null) {
        $userId = (isset($userId)) ? ($userId) : ($this->Auth->user('id'));
        $comments = $this->findAllByUserId($userId);
        $bookIds = array();
        $userComments = array();
        foreach ($comments as $comment) {
            $bookIds = $comment['Review']['book_id'];
        }
        $book = new Book();
        if (sizeof($bookIds) > 1) {
            $books = $book->find('list', array(
                'fields'     => array('Book.id', 'Book.name'),
                'conditions' => array('Book.id IN' => $bookIds)
            ));
        } else {
            $books = $book->find('list', array(
                'fields'     => array('Book.id', 'Book.name'),
                'conditions' => array('Book.id' => $bookIds)
            ));
        }
        foreach ($comments as $comment) {
            $comment['Comment']['Book']['id'] = $comment['Review']['book_id'];
            $comment['Comment']['Book']['name'] = $books[$comment['Review']['book_id']];
            $userComments[] = $comment['Comment'];
        }
        return $userComments;
    }
}
