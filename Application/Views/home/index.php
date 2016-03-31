<?php /** $this \MyMVC\Library\MVC\View
*/?>
<div>
    This is homeController index.php
    <br/>
    <?php
    self::esc($model->getName());
    echo '<br/>';
    echo $model->getFamily();
    echo '<br/>';
    echo $model->getAge();
    echo '<br/>';
    ?>
</div>