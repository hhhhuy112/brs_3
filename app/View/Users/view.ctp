<div class="panel panel-info panel-home">
    <div class="panel panel-heading panel-home">
        <div class="row">
            <div class="col-md-8">
                <h5><?php echo $user['username']; ?></h5>
                <div id='followingId' class="hidden"><?php echo $user['id'];?></div>
            </div>
            <div class="btn-group pull-right" role="group">
                <button type="button" class="btn btn-default btn-home changeview btn-success">Home</button>
                <button type="button" class="btn btn-default btn-favorite changeview">Favorite</button>
                <button type="button" class="btn btn-default btn-follow 
                    <?php if (AuthComponent::user('id') === $user['id']) echo __("hidden") ?> 
                    <?php if ($followed) echo __("hidden") ?>" id="follow">Follow
                </button>
                <button type="button" class="btn btn-default btn-info btn-follow 
                    <?php if (AuthComponent::user('id') === $user['id']) echo __("hidden") ?> 
                    <?php if (!$followed) echo __("hidden") ?>" id="unfollow">Unfollow
                </button>
            </div>
        </div>
    </div>
    <div class="panel panel-body panel-view">
        <ul class="list-group">
        <?php foreach ($activities as $key => $activity): ?>
            <li class="list-group-item">
                <div class="media">
                    <div class="media-body">
                        <h4 class="media-heading">
                            <?php if (isset($activity['review'])): ?>
                                <?php echo __("Post review in "); ?>
                                <?php echo $this->Html->link($activity['book']['name'], array('controller' => 'books', 'action' => 'view', $activity['book']['id'])) ?>
                            <?php elseif (isset($activity['comment'])): ?>
                                <?php echo __("Wrote comment in");  ?>
                                <?php echo $this->Html->link($activity['book']['name'], array('controller' => 'books', 'action' => 'view', $activity['book']['id'])) ?>
                            <?php elseif (isset($activity['follower_id'])): ?>
                                <?php echo $user['username']; ?>
                                <small>
                                    <?php if ($activity['action'] === 'followed'): ?>
                                        <?php echo __(" is ") ?>
                                        <?php echo $activity['action']; ?>
                                        <?php echo __(" by ") ?>
                                    <?php else: ?>
                                        <?php echo __(" is ") ?>
                                        <?php echo $activity['action']; ?>
                                    <?php endif; ?>
                                </small>
                                <?php echo $this->Html->link($activity['userName'], array('controller' => 'users', 'action' => 'view', $activity['userId'])) ?>
                            <?php elseif (isset($activity['action']) && !($activity['action'] === 'modify-comment')): ?>
                                <?php echo __("Marked ");  ?>
                                <?php echo $this->Html->link($activity['bookName'], array('controller' => 'users', 'action' => 'view', $activity['target_id'])) ?>
                                <?php echo __(" as ");  ?>
                                <?php echo $activity['action'];  ?>
                            <?php endif; ?>
                            <small class="right"> 
                                <?php echo $activity['created']; ?>
                            </small>
                        </h4>
                        <p>
                            <?php if (isset($activity['review'])): ?>
                                <?php echo $activity['review'] ?>
                            <?php elseif (isset($activity['comment'])): ?>
                                <?php echo $activity['comment'];  ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <div class="right">
                    <button type="button" class="btn btn-default btn-like" id="like-<?php echo $key ?>">Like</button>
                    <button type="button" class="btn btn-default btn-success btn-like hidden" id="unlike-<?php echo $key ?>">Unlike</button>
                </div>
            </li>
        <?php endforeach; ?>
       </ul>
    </div>

    <div class="panel panel-body panel-favorite hidden">
        <table class="table table-bordered table-hover table-condensed">
        <?php if (isset($favoriteBooks)): ?>
            <tr>
                <th class="col-md-1"><?php echo __('#')?></th>
                <th class="col-md-3"><?php echo __('Name') ?></th>
                <th class="col-md-3"><?php echo __('Title'); ?></th>
                <th><?php echo __('Author'); ?></th>
                <th><?php echo __('Page Numbers'); ?></th>
                <th><?php echo __('Published At'); ?></th>
            </tr>
            <?php foreach ($favoriteBooks as $key => $book) : ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $this->Html->link($book['name'], array('controller' => 'books', 'action' => 'view', $book['id'])); ?></td>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td><?php echo $book['page_numbers']; ?></td>
                    <td><?php echo $book['published_at']; ?></td>
                </tr>
            <?php endforeach; ?>
       <?php endif; ?>
       </table>
    </div>
</div>
