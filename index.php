<?php
$t = [
        'Visits For up to 180 Days' => [
            '1.001' => ['tcv_id' => 68, 'text' => 'Screening, Day 71 of Core Trial'],
            '1.002' => ['tcv_id' => 69, 'text' => 'Visit 1'],
            '1.003' => ['tcv_id' => 70, 'text' => 'Durability Confirmation'],
        ],
    'Visits for Treatment Session Assessment (Category 1 or 2)' => [
        '2.001' => ['tcv_id' => 71, 'text' => 'Screening, B'],
        '2.002' => ['tcv_id' => 72, 'text' => 'Tx Session 1 (Visit 1)'],
        '2.003' => ['tcv_id' => 73, 'text' => 'Tx Session 2 (Visit 2)'],
        '2.004' => ['tcv_id' => 74, 'text' => 'Tx Session 2 (Visit 3)'],
        '2.005' => ['tcv_id' => 75, 'text' => 'Tx Session 2 (Visit 4)'],
    ],
    'Visits for Observation Assessment (Category 1 or 2)' => [
        '3.001' => ['tcv_id' => 76, 'text' => 'Day 360'],
        '3.002' => ['tcv_id' => 77, 'text' => 'Day 540'],
        '3.003' => ['tcv_id' => 78, 'text' => 'Day 720'],
        '3.004' => ['tcv_id' => 79, 'text' => 'Day 1080'],
        '3.005' => ['tcv_id' => 80, 'text' => 'Day 1440'],
        '3.006' => ['tcv_id' => 81, 'text' => 'EOS'],
        '3.007' => ['tcv_id' => 82, 'text' => 'Durability Confirmation'],
    ],
];
$t2 = [
    '1.001' => ['tcv_id' => 68, 'text' => 'Screening, Day 71 of Core Trial'],
    '1.002' => ['tcv_id' => 69, 'text' => 'Visit 1'],
    '1.003' => ['tcv_id' => 70, 'text' => 'Durability Confirmation'],
];
?>
<html>
<head>
    <title>Sandbox</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="src/LeMVCS/ViewObjects/JS/LeFormElement.js"></script>
    <script>
        $(function() {
            const data = <?php echo json_encode($t); ?>;
            const data2 = <?php echo json_encode($t2); ?>;

            function formatOptions(input) {
                let output = {};
                const is_cohort = isCohort(input);
                if (3 <= is_cohort) {
                    $.each(input, function (group_name, optGroupOptions) {
                        output[group_name] = {};
                        $.each(optGroupOptions, function (i, record) {
                            output[group_name][record.text] = record.tcv_id;
                        });
                    });
                } else {
                    $.each(input, function (i, record) {
                        output[record.text] = record.tcv_id;
                    });
                }
                return output;
            }

            function isCohort(object) {
                if (typeof object !== "object" || object === null) {
                    return 0;
                }
                let values = Object.values(object);
                return (values.length && Math.max(...values.map(value => isCohort(value)))) + 1;
            }

            const select = LeFormElement.select('test1', '', formatOptions(data), null, null, 'test1', true);
            const select2 = LeFormElement.select('test2', '', formatOptions(data2), null, null, 'test2', false);
            $('#test').append(select);
            $('#test').append(select2);
        });
    </script>

</head>
<body>
    <h1>Hello this word!</h1>
    <div id="test"></div>
</body>
</html>
