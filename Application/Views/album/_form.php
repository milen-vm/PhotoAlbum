<?php
use MyMVC\Library\MVC\View;
use MyMVC\Library\Utility\ViewHelpers\Alert;
use MyMVC\Library\App;
/**@var \MyMVC\Application\ViewModels\FormAlbumViewModel $model */
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
                <h1>Create new album</h1>
                    <form role="form" action="<?php View::url('album', App::getRouter()->getAction())?>"
                        method="POST" autocomplete="off">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="<?php echo $model->getName(); ?>" id="name"
                                autofocus="autofocus" class="form-control" placeholder="some name">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" value="<?php echo $model->getDescription(); ?>"
                                class="form-control" placeholder="some description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Private album</label>
                            <p>
                                <input type="checkbox" name="isPrivate" value="1" id="chBox" class="">
                                Only you can see the album.
                            </p>

                        </div>
                        <input type="hidden" name="csrfTokenFromPost" value="<?php echo $model->getCsrfToken(); ?>">
                        <input type="submit" name="submit" class="btn btn-custom btn-lg btn-block"
                            value="<?php echo App::getRouter()->getAction() == 'create' ? 'Create' : 'Save'; ?>">
                    </form>
                    <hr>
        	    </div>
    		</div> <!-- /.col -->
    	</div> <!-- /.row -->
    </div> <!-- /.container -->
</section>