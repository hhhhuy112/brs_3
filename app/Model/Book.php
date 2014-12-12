<?php
App::uses('AppModel', 'Model');
/**
 * Book Model
 *
 * @property Category $Category
 * @property Request $Request
 * @property Review $Review
 * @property Category $Category
 * @property User $User
 */
class Book extends AppModel {

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Book\' name can not be empty',
            ),
        ),
        'title' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Title name can not be empty',
            ),
        ),
        'category_id' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Category can not be empty',
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Review' => array(
            'className' => 'Review',
            'foreignKey' => 'book_id',
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
        'User' => array(
            'className' => 'User',
            'joinTable' => 'book_users',
            'foreignKey' => 'book_id',
            'associationForeignKey' => 'user_id',
            'unique' => 'keepExisting',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
        )
    );

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    public function addReview($requestData, $userId) {
        $this->Review->create();
        $data = array(
            'review' => $requestData['review'],
            'book_id'=> $requestData['bookId'],
            'user_id'=> $userId
        );
        $this->Review->save($data, array('validate' => 'false'));
        $this->Review->clear();
    }

    public function addComment($requestData, $userId) {
        $this->Review->Comment->create();
        $data = array(
            'comments'      => $requestData['comment'],
            'review_id'     => $requestData['reviewId'],
            'reviewer_id'   => $userId
        );
        $this->Review->Comment->save($data, array('validate' => 'false'));
        $this->Review->Comment->clear();
    }

    public function getBookRate($bookId) {
        $bookUsers = $this->BookUser->find('all', array('conditions' => array('book_id' => $bookId)));
        $totalRate = 0;
        $count = 0;
        foreach ($bookUsers as $bookUser) {
            if ($bookUser['BookUser']['rate']) {
                $totalRate += $bookUser['BookUser']['rate'];
                $count++;
            }
        }
        return ($count == 0) ? (0.0) : ($totalRate / $count);
    }

    public function modifyReview($requestData) {
        $reviewId = $requestData['reviewId'];
        if ($requestData['type'] === 'edit') {
            $this->Review->id = $reviewId;
            $this->Review->save(array('review' => $requestData['updatedReview']));
        } else {
            $this->Review->delete($reviewId, true);
        }
        $this->Review->clear();
    }

    public function modifyComment($requestData) {
        if ($requestData['type'] === 'edit') {
            $this->Review->Comment->id = $requestData['commentId'];
            $this->Review->Comment->save(array('comment' => trim($requestData['conmment'])));
        } else {
            $this->Review->Comment->delete($requestData['commentId'], true);
        }
        $this->Review->Comment->clear();
    }

    public function getFavoriteBookByUserId($userId) {
        $favoriteBooks = $this->BookUser->find('all',
            array(
                'conditions' => array(
                    'BookUser.user_id'     => $userId,
                    'BookUser.is_favorite' => true
                )
            )
        );
        $favoriteBookIds = array();
        foreach ($favoriteBooks as $favoriteBook) {
            $favoriteBookIds[] = $favoriteBook['BookUser']['book_id'];
        }
        
        $books = $this->find('all', array('conditions' => array('Book.id IN' => $favoriteBookIds)));
        $favoriteBooks = array();
        foreach ($books as $book) {
            $favoriteBooks[] = $book['Book'];
        }
        return $favoriteBooks;
    }
}
