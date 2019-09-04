<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 9/4/2019
 * Time: 9:51 AM
 */
?>
<html>
<head>
    <script src="/src/LeMVCS/ViewObjects/JS/LeBinary.js"></script>
</head>
<body>
    <script>
        var tests = [6, 9, 26, 44, 87, 379, 7843, 78437, 589361, 7985693, 999999999999999999];
        tests.forEach(function(test) {
            var binaries = [];
            binaries = LeBinary.getBinaries(test);
            console.log('binaries');
            console.log(binaries);

            document.write('Binaries for number: ' + test + '<br />');
            document.write(binaries.join(', ') + '<hr />');
        });
    </script>
</body>
</html>
