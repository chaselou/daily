<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/huaqiao/vendor/bootstrap3.3.5.min.css">
    <link rel="stylesheet" href="/huaqiao/vendor/jquery-ui-datepicke.min.css">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/dailys/templates/stylesheet.html'?>

    <script src="/huaqiao/vendor/jquery1.11.3.min.js"></script>
    <script src="/huaqiao/vendor/jquery-ui-datepicker.min.js"></script>
    <script src="/huaqiao/vendor/bootstrap3.3.5.min.js"></script>
    <script>
        $(function() {
            $( "#date" ).datepicker({
                dateFormat: "yy-mm-dd"
            });

            $('#form').submit(function(e) {
                var error = false;
                $(this).find("[type=text], textarea").each(function() {
                    $(this).parent().parent().removeClass('has-error');
                    if($(this).val().length == 0) {
                        $(this).parent().parent().addClass('has-error');
                        error = true;
                    }
                });
                if (error) {
                    e.preventDefault();
                }
            });



        });
    </script>
    <title><?php echo $title?></title>
</head>
<body>
<div id="wrapper">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/banner.html'?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/menu.html'?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/dailys/templates/form.html.php'?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/footer.html'?>
</div>
</body>
</html>