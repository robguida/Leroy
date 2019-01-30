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

<!-- dynamic code... will be within the function -->
<?php
function leTextAjaxForm($value)
{
    $textAjaxForm_id = uniqid();
    $output = "<div id=\"leTextAjaxForm_{$textAjaxForm_id}\" class=\"leTextAjaxForm\">
                <label for=\"text_id_{$textAjaxForm_id}\">Text Id</label>
                <input type=\"text\" id=\"text_id_{$textAjaxForm_id}\"
                       name=\"text_id_{$textAjaxForm_id}\" value=\"{$value}\" />
                <div id=\"leTextAjaxFormCommand_{$textAjaxForm_id}\">
                    <img src=\"lib/resource/delete.jpg\" id=\"leTextAjaxFormCommandDelete_{$textAjaxForm_id}\"
                         onclick=\"callbackDelete();\" />
                    <img src=\"lib/resource/edit.jpg\" id=\"leTextAjaxFormCommandEdit_{$textAjaxForm_id}\" />
                </div>
            </div>
            <script>
                $('#leTextAjaxFormCommandEdit_{$textAjaxForm_id}').on('click', function () {
                    leTextAjaxForm.edit();
                });
            </script>
            ";
    return $output;
}
echo leTextAjaxForm('This is the text to change');
?>

<!-- code that the programmer will put on the page -->
<script>
    // code that will always need to be created
    function callbackDelete() {
        alert('I am deleting this');
    }
</script>

<!-- code that will go into a .js file -->
<script>
    var leTextAjaxForm = {
        edit: function () {
            alert('test');
        }
    }
</script>

<?php phpinfo(); ?>
</body>
</html>
