<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 * @property Book $Book
 * @property Comment $Comment
 */
class Review extends AppModel {
    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'review' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Your review can not be empty',
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
        'Book' => array(
            'className' => 'Book',
            'foreignKey' => 'book_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Comment' => array(
            'className' => 'Comment',
            'foreignKey' => 'review_id',
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

}
