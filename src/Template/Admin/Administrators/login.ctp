<body class="login-body">
    <div class="container">
        <?= $this->Form->create(null, ['class' => 'form-signin'])?>
        <h2 class="form-signin-heading"><?= __('sign in now')?></h2>
        
        <div class="login-wrap">
            <div class="user-login-info">
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Flash->render() ?>
                    </div>
                </div>
                <?= $this->Form->email('email', [
                    'class'         => 'form-control top',
                    'placeholder'   => 'Email',
                    'required'      => true
                ]); ?>
                <?= $this->Form->password('password', [
                    'class'         => 'form-control top',
                    'placeholder'   => 'Password',
                    'required'      => true
                ]);?>
            </div>
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> <?= __('Remember me') ?>
                <span class="pull-right">
                    <a data-toggle="modal" href="/admin/administrators/forgotPassword"><?= __('Forgot Password?') ?></a>
                </span>
            </label>
            <?=$this->Form->button(__('Sign in'), ['type' => 'submit', "class" => "btn btn-lg btn-login btn-block"]); ?>
        </div>

      <?=$this->Form->end() ?>
    </div>
</body>