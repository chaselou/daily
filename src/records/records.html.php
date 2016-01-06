<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/huaqiao/vendor/bootstrap3.3.5.min.css">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/jobs/templates/stylesheet.html'?>

    <script src="/huaqiao/vendor/jquery1.11.3.min.js"></script>
    <script src="/huaqiao/vendor/bootstrap3.3.5.min.js"></script>
    <script>
        function confirmSubmit(type, id){

            var form = document.getElementById('form' + id);
            var submitType = document.createElement("input");
            submitType.setAttribute("type", "hidden");
            submitType.setAttribute("name", type);
            form.appendChild(submitType);

            form.submit();
        }

        $(function() {
            $('.popup-delete').bind('click', function () {

            var submitId = $(this).siblings('[type=hidden]').val();

            $('#popup .modal-body p').text('确認要删除該紀錄?' + submitId);
            $('#popup .modal-footer .sure').bind('click',function() {
                confirmSubmit('deleteRecord', submitId);
            });
            });

        });
    </script>

    <title>記綠</title>
</head>
<body>

<div id="wrapper">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/banner.html'?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/menu.html'?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/records/recordContent.html.php'?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/footer.html'?>
</div>
</body>
</html>

