<div class="users form">
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo __('Sign up'); ?></h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $this->Form->create('User', array('role' => 'form')); ?>
                <div class="form-group">
                    <?php echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => __('User Name'))); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('email', array('class' => 'form-control', 'placeholder' => __('Email'))); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => __('Password'))); ?>
                </div>              
                <div class="form-group">
                    <?php echo $this->Form->input('confirm_password', array('class' => 'form-control', 'placeholder' => __('Confirm Password'), 'type' => 'password')); ?>
                </div>
                <div class="form-group">
                    <?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-default')); ?>
                </div>
            <?php echo $this->Form->end(); ?>
        </div><!-- end col md 12 -->
    </div><!-- end row -->
</div>
