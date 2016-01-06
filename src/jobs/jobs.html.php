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

            $('#jobs').find('.finish .popup-delete').bind('click', function() {

                var submitId = $(this).siblings('[type=hidden]').val();

                $('#popup .modal-body p').text('确認要删除該任務?' + submitId);
                $('#popup .modal-footer .sure').bind('click',function() {
                    confirmSubmit('deleteJob', submitId);
                });
            });

            $('#jobs').find('.finish .popup-complete').bind('click', function() {

                var submitId = $(this).siblings('[type=hidden]').val();

                $('#popup .modal-body p').text('确認完成該任務?' + submitId);
                $('#popup .modal-footer .sure').bind('click',function() {
                    confirmSubmit('complete', submitId);
                });
            });

        });

    </script>

    <title>工作</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/recordCheckModal.php'?>
<div id="wrapper">
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/banner.html'?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/menu.html'?>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/jobs/jobContent.html.php'?>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/footer.html'?>
</div>

</body>
</html>

