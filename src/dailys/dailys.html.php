<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/huaqiao/vendor/bootstrap3.3.5.min.css">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/dailys/templates/stylesheet.html'?>

    <script src="/huaqiao/vendor/jquery1.11.3.min.js"></script>
    <script src="/huaqiao/vendor/bootstrap3.3.5.min.js"></script>
    <title>日記</title>
</head>
<body>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/recordCheckModal.php'?>
<div id="wrapper">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/banner.html'?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/menu.html'?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/dailys/dailyContent.html.php'?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/footer.html'?>
</div>
</body>
</html>

