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

    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
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
}
