<?php
App::uses('AppModel', 'Model');
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
}
