<?php
use MyMVC\Library\MVC\View;
use MyMVC\Library\Utility\ViewHelpers\Alert;
/**@var \MyMVC\Application\ViewModels\RegisterViewModel $model */
?>
<?php foreach ($model->getAlerts() as $alert) {
    Alert::create()->setType($alert['type'])
        ->setText($alert['text'])
        ->addClouseBtn()
        ->render();
}?>
<section class="form">
    <div class="container">
    	<div class="row">
    	    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
        	    <div class="form-wrap">
                <h1>Create new account</h1>
                    <form role="form" action="<?php View::url('user', 'register')?>" method="POST" autocomplete="off">
                        <div class="form-group">
                            <label for="email" class="">Email</label>
                            <input type="email" name="email" value="<?php echo $model->getEmail(); ?>" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="full-name" class="">Full name</label>
                            <input type="text" id="full-name" name="name" value="<?php echo $model->getName(); ?>" class="form-control" placeholder="Max 50 characters">
                        </div>
                        <div class="form-group">
                            <label for="pass" class="">Password</label>
                            <input type="password" name="password" id="pass" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="pass-conf" class="">Confirm Password</label>
                            <input type="password" name="confPassword" id="pass-conf" class="form-control" placeholder="Repeat password">
                        </div>
                        <input type="hidden" name="csrfToken" value="<?php echo $model->getCsrfToken(); ?>">
                        <input type="submit" name="submit" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                    <hr>
        	    </div>
    		</div> <!-- /.col -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>