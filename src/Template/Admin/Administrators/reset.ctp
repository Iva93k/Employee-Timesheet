<body class="login-body">
    <div class="container">
        <?= $this->Form->create($administrator, ['class' => 'form-signin'])?>
        <h2 class="form-signin-heading"><?= __('Reset Password') ?></h2>
        <h6 class="password"><?= __('Passwords must be at least 4 characters!') ?></h6>
        <div class="login-wrap">
            <div class="user-login-info">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Flash->render(); ?>
                    </div>
                </div>
                <?= $this->Form->password('password', [
                    'class'         => 'form-control top',
                    'placeholder'   => ' New password',
                    'required'      => true,
                    'autofocus' => true
                ]);?>
                <?= $this->Form->password('confirm_password', [
                    'class'         => 'form-control top',
                    'placeholder'   => 'Confirm password',
                    'required'      => true
                ]);?>
            </div>
            <?=$this->Form->button(__('Submit')); ?>
        </div>
      <?=$this->Form->end() ?>
    </div>
</body>