<?php
use MyMVC\Library\MVC\View;
use MyMVC\Library\Utility\ViewHelpers\Alert;
/**@var \MyMVC\Application\ViewModels\LoginViewModel $model */
?>
<?php foreach ($model->getAlerts() as $alert) {
    Alert::create()->setType($alert['type'])
        ->setText($alert['text'])
        ->addClouseBtn()
        ->render();
}?>
<section class="form" id="login">
    <div class="container">
    	<div class="row">
    	    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <h1>Log in with your email account</h1>
                <form role="form" action="<?php View::url('user', 'login')?>" method="POST" id="login-form" autocomplete="off">
                    <div class="form-group">
                        <label for="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo $model->getEmail()?>" class="form-control" placeholder="somebody@example.com">
                    </div>
                    <div class="form-group">
                        <label for="pass" class="sr-only">Password</label>
                        <input type="password" name="password" id="pass" class="form-control" placeholder="Password">
                    </div>
                    <div class="checkbox">
                        <span class="character-checkbox" onclick="showPassword()"></span>
                        <span class="label">Show password</span>
                    </div>
                    <input type="hidden" name="csrfToken" value="<?php echo $model->getCsrfToken(); ?>">
                    <input type="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Log in">
                </form>
                <a href="javascript:;" class="forget" data-toggle="modal" data-target=".forget-modal">Forgot your password?</a>
                <hr>
    		</div> <!-- /.col-xs-12 -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<div class="modal fade forget-modal" tabindex="-1" role="dialog" aria-labelledby="myForgetModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">×</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title">Recovery password</h4>
			</div>
			<div class="modal-body">
				<p>Type your email account</p>
				<input type="email" name="recovery-email" id="recovery-email" class="form-control" autocomplete="off">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-custom">Recovery</button>
			</div>
		</div> <!-- /.modal-content -->
	</div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->
<script>
function showPassword() {

    var key_attr = $('#pass').attr('type');

    if(key_attr != 'text') {

        $('.checkbox').addClass('show');
        $('#pass').attr('type', 'text');

    } else {

        $('.checkbox').removeClass('show');
        $('#pass').attr('type', 'password');
    }
}
</script>