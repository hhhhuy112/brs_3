<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

    /**
     * Components
     *
     * @var array
     **/
    public $components = array('Paginator');
    public $uses = array('User', 'Follow', 'Book');

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                if ($this->Auth->user('type') !== User::IS_ADMIN) {
                   return $this->redirect($this->Auth->redirect());
                } else {
                    return $this->redirect(array('controller' => 'admins', 'action' => 'index'));
                }
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
        }
    }

    public function signup() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Auth->login();
                return $this->redirect(array('controller'=>'users', 'action' => 'home'));
            }
            $this->Session->setFlash(
                __('Something was wrong! Please, try again.')
            ); 
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid user'));
        }
        $followed = $this->Follow->getFollowed($this->Auth->user('id'), $id);
        if ($this->request->is('post')) {
            $this->autoRender = false;
            if (!$followed) {
                $data = array(  
                    'follower_id' => $this->Auth->user('id'),
                    'following_id'=> $id
                );
                $this->Follow->save($data);
                $this->Follow->clear();
            }  else {
                $this->Follow->delete($followed['Follow']['id']);
            }
        }
        $user = $this->User->findById($id);
        $this->set('favoriteBooks', $this->Book->getFavoriteBookByUserId($id));
        $this->set('followed', $followed);
        $this->set('activities', $this->User->getAllUserActivities());
        $this->set('user', $user['User']);
    }

}
