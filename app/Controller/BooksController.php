<?php
App::uses('AppController', 'Controller');
App::uses('Model', 'Book');
/**
 * Books Controller
 *
 * @property Book $Book
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class BooksController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'Session');

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Book->exists($id)) {
            throw new NotFoundException(__('Invalid book'));
        }
        $userId = $this->Auth->user('id');
        $book = $this->Book->findById($id);
        $reviews = $this->Book->Review->findAllByBookId($id);
        $reviewers = array();
        $comments = array();
        foreach ($reviews as $review) {
            $user = $this->Book->User->findById($review['Review']['user_id']);
            $reviewers[$review['Review']['user_id']] = $user['User']['username'];
            $userComments = $review['Comment'];
            $comment = array();
            foreach ($userComments as $userComment) {
                $user = $this->Book->User->findById($userComment['reviewer_id']);
                $comment[] = array('comment' => $userComment['comments'], 'user_id' => $user['User']['id'], 'username' => $user['User']['username']);
            }
            $comments[$review['Review']['id']] = $comment;
        }

        $this->set('book', $book['Book']);
        $this->set('comments', $comments);
        $this->set('reviewers', $reviewers);
        $this->set('reviews', $book['Review']);
        $this->set('rate', $this->Book->getBookRate($id));
        $this->set('bookUserDetails', $this->Book->BookUser->findByBookIdAndUserId($id, $userId));

        // Action in view page
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $requestData = $this->request->data;
            switch ($requestData['action']) {
                case 'addReview':
                    $this->Book->addReview($requestData, $userId);
                    break;
                case 'addComment':
                    $this->Book->addComment($requestData, $userId);
                    break;
                case 'addRating':
                    $this->Book->addRating($requestData, $userId);
                    break;
                case 'reading':
                    $this->Book->markReading($requestData['bookId'], $userId);
                    break;
                case 'read':
                    $this->Book->markRead($requestData['bookId'], $userId);
                    break;
                case 'favorite':
                    $this->Book->markFavorite($requestData['bookId'], $userId);
                    break;
                default:
                    break;
            }
        }
    }
}
