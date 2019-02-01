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
    <script src="lib/resource/leTextAjaxForm.js"></script>
    <link rel="stylesheet" href="lib/resource/leTextAjaxForm.css" />
</head>
<body>
<h1>Leroy</h1>

<!-- dynamic code... will be within the function -->
<?php
function leTextAjaxForm($value_name, $value)
{
    $textAjaxForm_id = uniqid();
    $output = "<div id=\"leTextAjaxForm_{$textAjaxForm_id}\" class=\"leTextAjaxForm\">
                <div id=\"leTextAjaxFormReadMode_{$textAjaxForm_id}\" class=\"mode_open_read\">                
                    <span>{$value_name}</span>
                    <div id=\"read_mode_value_{$textAjaxForm_id}\" class=\"read_mode_value\">{$value}</div>
                    <img src=\"lib/resource/delete.jpg\" id=\"leTextAjaxFormDelete_{$textAjaxForm_id}\"
                         onclick=\"leTextAjaxForm.callbackDelete();\" />
                    <img src=\"lib/resource/edit.jpg\" id=\"leTextAjaxFormEdit_{$textAjaxForm_id}\" />
                </div>
                <div id=\"leTextAjaxFormEditMode_{$textAjaxForm_id}\" class=\"mode_close\">                
                    <input type=\"text\" id=\"text_id_{$textAjaxForm_id}\"
                           name=\"text_id_{$textAjaxForm_id}\" value=\"{$value}\" />
                    <img src=\"lib/resource/cancel.png\" id=\"leTextAjaxFormCancelBtn_{$textAjaxForm_id}\"
                       onclick=\"leTextAjaxForm.callbackCancel();\" />
                    <img src=\"lib/resource/save.png\" id=\"leTextAjaxFormSaveBtn_{$textAjaxForm_id}\"
                       onclick=\"leTextAjaxForm.callbackSave();\" />
                </div>                    
            </div>
            <script>
                leTextAjaxForm.divReadModeValue = $('#read_mode_value_{$textAjaxForm_id}');
                leTextAjaxForm.divReadMode = $('#leTextAjaxFormReadMode_{$textAjaxForm_id}');
                leTextAjaxForm.divEditMode = $('#leTextAjaxFormEditMode_{$textAjaxForm_id}');
                $('#read_mode_value_{$textAjaxForm_id}').on('click', function () {
                    leTextAjaxForm.edit();
                });
                $('#leTextAjaxFormEdit_{$textAjaxForm_id}').on('click', function () {
                    leTextAjaxForm.edit();
                });
            </script>
            ";
    return $output;
}
echo leTextAjaxForm('Text Field Test:', 'This is the text to change');
?>

<!-- code that the programmer will put on the page -->
<script>
    // code that will always need to be created
    leTextAjaxForm.callbackDelete = function callbackDelete() {
        alert('I am deleting this');
    }
    leTextAjaxForm.callbackSave = function callbackSave() {
        alert('I am saving this');
    }
</script>
<br /><br /><br /><br /><br /><br /><br /><br />
<?php phpinfo(); ?>
</body>
</html>
