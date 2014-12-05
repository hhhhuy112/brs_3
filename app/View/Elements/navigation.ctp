<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (!$loggedIn): ?>
                    <li><?php echo $this->Html->link(__('Login'), array('controller' => 'users', 'action' => 'login'));?></li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                            <?=AuthComponent::user('username')?>
                        </a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li class="divider"></li>
                            <li>
                                <?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout'));?>
                            </li>
                        </ul>
                    </li>
                <?php endif;?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>