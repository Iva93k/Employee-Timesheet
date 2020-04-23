<body class="login-body">
    <div class="container">
        <?= $this->Form->create(null, ['class' => 'form-signin'])?>
        <h2 class="form-signin-heading"><?= __('Forgot password?') ?></h2>
        <h6 class="password"><?= __('Enter your e-mail address below to reset your password.') ?></h6>
        <div class="login-wrap">
            <div class="user-login-info">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>
                <?= $this->Form->email('email', [
                    'class'         => 'form-control',
                    'placeholder'   => 'Email',
                    'autofocus'     => true,
                    'required'      => true
                ]); ?>
            </div>
            <?=$this->Form->button(__('Submit'), ['type' => 'submit', "class" => "btn btn-lg btn-login btn-block"]); ?>
            <span class="pull-right">
                    <a data-toggle="modal" href="/admin/administrators/login">Cancel</a>
            </span>
        </div>
      <?=$this->Form->end() ?>
    </div>
</body>