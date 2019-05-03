<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 5/2/2019
 * Time: 3:18 PM
 */
?>
<html>
<head>
    <script src="/test/lib/jquery/jquery.min.js"></script>
    <script src="/test/lib/jquery-ui/jquery-ui.min.js"></script>
    <script src="/src/LeMVCS/ViewObjects/JS/LeFormElement.js"></script>
</head>
<body>
<script>
    $('body').append(
        LeFormElement.button(
            'Button',
            'Press me',
            {'data-test':'Fred', 'data-test2':'Ethyl'},
            {'width':'100px','height':'50px'},
            'button'
        )
    ).append(LeFormElement.checkbox('Checkbox', 'Judy', [], [], 'judy'))
        .append(LeFormElement.color('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.date('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.dateTime('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.dateTimeLocal('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.email('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.file('ElementName' + Math.random().toString()), 'Should not be set')
        .append(LeFormElement.hidden('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.image('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.month('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.password('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.radio('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.range('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.reset('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.search('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.submit('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.tel('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.text('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.time('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.url('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElement.week('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(
            LeFormElement.select(
                'Select',
                '133',
                {'14':'Live TV', '44':'Prerecorded TV', '99':'Beta', '133':'VHS', '88':'Cable'},
                {'data-type':'select',elvis:'Costello'},
                {width:'200px',height:'75px'}
            )
        ).append(
            LeFormElement.textArea(
                'Valley Forge',
                'George Washington was the first President of the United States. A county born out of conspiracy and revolution',
                {rows:10,cols:30},
                {'background-color':'grey'}
            )
        ).append(
            LeFormElement.select(
                'Select',
                '133',
                {'14':'Live TV', '44':'Prerecorded TV', '99':'Beta', '133':'VHS', '88':'Cable'},
                {'data-type':'select',elvis:'Costello',multiple:1},
                {width:'200px',height:'75px'}
            )
        ).append(
            LeFormElement.label(
                'This is for',
                'YOU'
            )
        )
        ;
</script>

</body>
</html>
