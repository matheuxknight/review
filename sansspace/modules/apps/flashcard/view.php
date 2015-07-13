<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

    <link href="/bower_components/flashcard/dist/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css"/>
    <link href="/bower_components/flashcard/dist/stylesheets/print.css" media="print" rel="stylesheet" type="text/css"/>

    <!--[if IE]>
    <link href="/bower_components/flashcard/dist/stylesheets/ie.css" media="screen, projection" rel="stylesheet" type="text/css"/>
    <![endif]-->
</head>
<body class="container">

<div id="FlashcardContainer">
</div>
<script>
    // todo find a way to pass variables to flashcard module instead of dumping them into global namespace
    var flashcardId = <?=$object->id?>;
</script>
<script data-main="/bower_components/flashcard/main" src="/bower_components/requirejs/require.js"></script>

</body>
</html>