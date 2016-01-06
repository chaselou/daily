<div id="form">

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if(isset($_GET['done'])):
        if ($_GET['done'] == 'add') {
            $msg = '已添加新日記';
        }
        else if ($_GET['done'] == 'edit') {
            $msg = '已修改日記';
        }

    ?>
    <p id="msg" class="bg-success"><?php echo $msg?></p>
    <?php endif?>

    <form id="form" class="form-horizontal" method="post" action="?<?php echo $action?>">
        <input type="hidden" name="id" value="<?php echo $id?>">

        <div class="form-group">
            <label for="date" class="col-sm-2 control-label">日期:</label>
            <div class="col-sm-10">
                <input id="date" type="text" name="date" class="form-control" value="<?php showDataFromDB($date)?>" >
            </div>
        </div>

        <div class="form-group">
            <label for="weather" class="col-sm-2 control-label">天氣:</label>
            <div class="col-sm-10">
                <input id="weather" type="text" name="weather" class="form-control" value="<?php showDataFromDB($weather)?>">
            </div>
        </div>

        <div class="form-group">
            <label for="comment" class="col-sm-2 control-label">內容:</label>
            <div class="col-sm-10">
                <textarea id="comment" name="comment" class="form-control" rows="10" cols="60"><?php showDataFromDB($comment)?></textarea>
            </div>
        </div>
        <a class="btn btn-default btn-sm" href="./?page=<?php echo $page?>" role="button">返回</a>
        <input class="btn btn-primary btn-sm" type="submit" value="<?php echo $submit?>">

    </form>
</div>
