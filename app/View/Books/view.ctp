<?php echo $this->Html->script('book-view', array('inline' => false)); ?>
<div class="book view">
    <div class="row">
        <div class="col-md-8 book-header">
            <h3><?php echo $book['name']; ?></h3>
        </div>
        <div class="col-md-4 book-action">
            <div class="btn-group" role="group">
                <button type="button" class="mark-action btn btn-default <?php if ($bookUserDetails['BookUser']['is_reading']) echo __('btn-success') ?>" id="reading">Reading</button>
                <button type="button" class="mark-action btn btn-default <?php if ($bookUserDetails['BookUser']['is_read']) echo __('btn-success') ?>" id="read">Read</button>
                <button type="button" class="mark-action btn btn-default <?php if ($bookUserDetails['BookUser']['is_favorite']) echo __('btn-success') ?>" id="favorite">Favorite</button>
            </div>
        </div>
    </div>
    <div id='userId' class="hidden"><?php echo AuthComponent::user('id')?></div>
    <div id='userName' class="hidden"><?php echo AuthComponent::user('username')?></div>
    <div id='bookId' class="hidden"><?php echo $book['id']?></div>
</div>
    
<div class="related">
    <table class="table table-bordered table-hover">
        <tr>
            <td class="col-md-2"><?php echo __('Name') ?></td>
            <td class="col-md-8"><?php echo $book['name'] ?></td>
        </tr>
        <tr>
            <td class="col-md-2"><?php echo __('Title') ?></td>
            <td class="col-md-8"><?php echo $book['title'] ?></td>
        </tr>
        <tr>
            <td class="col-md-2"><?php echo __('Summary') ?></td>
            <td class="col-md-8"><?php echo $book['summary'] ?></td>
        </tr>
        <tr>
            <td class="col-md-2"><?php echo __('Author') ?></td>
            <td class="col-md-8"><?php echo $book['author'] ?></td>
        </tr>
        <tr>
            <td class="col-md-2"><?php echo __('Pages') ?></td>
            <td class="col-md-8"><?php echo $book['page_numbers'] ?></td>
        </tr>
        <tr>
            <td class="col-md-2"><?php echo __('Published') ?></td>
            <td class="col-md-8"><?php echo $book['published_at'] ?></td>
        </tr>
        <tr>
            <td class="col-md-2"><?php echo __('Category') ?></td>
            <td class="col-md-8">
                <?php echo $book['Category']['name']; ?>
            </td>
        </tr>
        <tr>
            <td class="col-md-2"><?php echo __('Rate'); ?></td>
            <td class="col-md-8 rating">
                <div class="rating">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-5">
                                <?php for($i = 10; $i > 0; $i--): ?>
                                    <span <?php if ($i === intval($bookUserDetails['BookUser']['rate'])) echo __('class="checked"'); ?>>
                                        <input type="radio" name="rating" id="str<?php echo $i ?>" value="<?php echo $i ?>">
                                        <label for="str<?php echo $i ?>"></label>
                                    </span>
                                <?php endfor; ?>
                            </div>
                            <div class="col-md-1 rate-average"><span class="badge"><?php echo round($rate, 2); ?></span></div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<div class="book comment">
    <div class="btn-review <?php if (isset($reviewers[AuthComponent::user('id')])) echo __('hidden')?>">
        <button class="btn btn-default" type="button" id="add-review"><?php echo __('Add a review'); ?></button>
    </div>
    <div class="old-review" id="old-review">
        <?php foreach ($reviews as $review): ?>
            <div class="panel panel-info new-review">
                <div class="panel-heading">
                    <?php echo $this->Html->link($reviewers[$review['user_id']], array('controller' => 'users', 'action' => 'index', $review['user_id']));?>
                </div>
                <div class="panel-body">
                    <p class="active"><?php echo $review['review']; ?></p>
                </div>
                <ul class="list-group list-comment" id="old-comment-<?php echo $review['id']?>">
                    <?php $comments = $comments[$review['id']]; ?>
                    <?php foreach ($comments as $comment): ?>
                        <li class="list-group-item">
                            <p class="user-comment"><?php echo $comment['comment']; ?></p>
                            <p class="user-name-comment"><?php echo $this->Html->link($comment['username'], array('controller' => 'users', 'action' => 'index', $comment['user_id']), array('class' => 'btn btn-default btn-success')); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div align="right">
                <button class="btn btn-default add-comment" type="button" id="review-<?php echo $review['id'] ?>">
                    <span class="glyphicon glyphicon-plus green"></span>
                    <?php echo __('Add a Comment'); ?>
                </button>
            </div>
            <div id='new-comment-<?php echo $review['id'] ?>' class="new-comment hidden">
                <textarea class="book comment" rows="5" cols="150" id="comment-area-<?php echo $review['id'] ?>"></textarea>
                <button class="btn btn-default btn-info btn-submit-comment" type="button" id="review-<?php echo $review['id'] ?>">
                    <span class="glyphicon glyphicon-plus green"></span>
                    <?php echo __('Add comment'); ?>
                </button>
            </div>
        <?php endforeach; ?>
        <div class="old-review hidden" id="old-review-js">
            <div align='right'>
                <button class='btn btn-default add-comment' type='button' id='add-comment'><?php echo __('Add a Comment'); ?></button>
            </div>"
        </div>
    </div>
    <br>
    <div id='new-review' class="new-review hidden">
        <textarea class="book review" rows="5" cols="150" id="review-area"></textarea>
        <button class="btn btn-default btn-info btn-submit-review" type="button" id="submit-review"><?php echo __('Add review'); ?></button>
    </div>
</div>

