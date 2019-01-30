<?php
/**
 * Created by PhpStorm.
 * User: rob
 * Date: 9/25/2018
 * Time: 11:42 PM
 */
require_once dirname(__FILE__, 2) . '/src/bootstrap.php';

//use Leroy\LeCache\LeCacheFactory;
//$leCache = new LeCacheFactory('memcached');
//use Leroy\LeSecurity\LeSecureForm;
//$leSecure = new LeSecureForm();
//echo 'token: ' . $leSecure->getToken() . '<br />';

?>
<html>
<head>
    <script src="lib/jquery-3.3.1.min.js"></script>
    <script src="lib/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="lib/resource/leTextAjaxForm.css" />
</head>
<body>
<h1>Leroy</h1>
<div id="leTextAjaxForm" class="leTextAjaxForm">
    <label for="text_id">Text Id</label>
    <input type="text" id="text_id" name="text_id" value="<?php echo $_GET['text_id']; ?>" />
    <div id="leTextAjaxFormCommand">
        <img src="lib/resource/edit.jpg" id="leTextAjaxFormCommandEdit" />
        <img src="lib/resource/delete.jpg" id="leTextAjaxFormCommandDelete" />
    </div>
    <script>
        $(function() {
            // code that will always need to be created
            var callback = function() {
                alert("deleting");
            }
            $('#leTextAjaxFormCommandDelete').on('click', callback());

            // code that will be moved to a leTextAjaxForm.js file
        });
    </script>
</div>
<?php phpinfo(); ?>
</body>
</html>
