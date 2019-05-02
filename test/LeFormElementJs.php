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
    <script src="/src/LeMVCS/ViewObjects/JS/LeFormElements.js"></script>
</head>
<body>
<script>
    $('body').append(
        LeFormElements.button(
            'Button',
            'Press me',
            {'data-test':'Fred', 'data-test2':'Ethyl'},
            {'width':'100px','height':'50px'},
            'button'
        )
    ).append(LeFormElements.checkbox('Checkbox', 'Judy', [], [], 'judy'))
        .append(LeFormElements.color('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.date('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.dateTime('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.dateTimeLocal('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.email('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.file('ElementName' + Math.random().toString()), 'Should not be set')
        .append(LeFormElements.hidden('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.image('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.month('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.password('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.radio('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.range('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.reset('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.search('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.submit('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.tel('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.text('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.time('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.url('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(LeFormElements.week('ElementName' + Math.random().toString(), 'Judy' + Math.random().toString()))
        .append(
            LeFormElements.select(
                'Select',
                '133',
                {'14':'Live TV', '44':'Prerecorded TV', '99':'Beta', '133':'VHS', '88':'Cable'},
                {'data-type':'select',elvis:'Costello'},
                {width:'200px',height:'75px'}
            )
        ).append(
            LeFormElements.textArea(
                'Valley Forge',
                'George Washington was the first President of the United States. A county born out of conspiracy and revolution',
                {rows:10,cols:30},
                {'background-color':'grey'}
            )
        ).append(
            LeFormElements.select(
                'Select',
                '133',
                {'14':'Live TV', '44':'Prerecorded TV', '99':'Beta', '133':'VHS', '88':'Cable'},
                {'data-type':'select',elvis:'Costello',multiple:1},
                {width:'200px',height:'75px'}
            )
        ).append(
            LeFormElements.label(
                'This is for',
                'YOU'
            )
        )
        ;
</script>

</body>
</html>
