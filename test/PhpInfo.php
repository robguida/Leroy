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
    <title>Leroy</title>
</head>
<body>
<h1>Leroy</h1>
<?php phpinfo(); ?>
</body>
</html>
