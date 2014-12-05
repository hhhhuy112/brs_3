<div class="container">    
    <div id="loginbox" class="login mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title"><?php echo __('Sign In'); ?></div>
            </div>
            <div class="login panel-body" >
                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                    <?php echo $this->Form->create('User', array('role' => 'form')); ?>
                        <div class="form-group">
                            <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => __('User Name')));?>
                        </div>
                        <div class="form-group">
                            <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password')));?>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-12 controls">
                                <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-success')); ?>
                                <div class="login signup-link" >
                                    <?php echo __('Don\'t have an account!') ?>
                                    <?php echo $this->Html->link(__('Sign up'), array('controller' => 'users', 'action' => 'signup'));?>    
                                </div>
                            </div>
                        </div>
                    <?php echo $this->Form->end() ?>
                </div>
            </div>
        </div>  
    </div>
</div>