<div id="form">

    <?php
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    if(isset($_GET['done'])):
        if ($_GET['done'] == 'add') {
            $msg = '已添加新資料';
        }
        else if ($_GET['done'] == 'edit') {
            $msg = '已修改資料';
        }
        else if ($_GET['done'] == 'deleteAttachment') {
            $msg = '已刪除附件';
        }
        ?>
        <p id="msg" class="bg-success"><?php echo $msg?></p>
    <?php endif?>

    <form id="form" class="form-horizontal" enctype="multipart/form-data" method="post" action="?<?php echo $action?>">
        <input type="hidden" name="id" value="<?php echo $id?>">

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">名子:</label>
            <div class="col-sm-10">
                <input id="name" type="text" name="name" class="form-control" value="<?php showDataFromDB($name)?>" >
            </div>
        </div>

        <div class="form-group">
            <label for="content" class="col-sm-2 control-label">內容:</label>
            <div class="col-sm-10">
                <input id="content" type="text" name="content" class="form-control" value="<?php showDataFromDB($content)?>">
            </div>
        </div>

        <div class="form-group">
            <label for="attachment" class="col-sm-2 control-label">附件:</label>
            <div class="col-sm-10">
                <?php if($fileRow):?>
                <div>
                    <?php showDataFromDB($fileName)?>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target=".popup-model">刪除附件</button>
                </div>
                <?php else:?>
                <input id="attachment" type="file" name="attachment" value="<?php showDataFromDB($attachment)?>">
                <?php endif?>
            </div>
        </div>
        <a class="btn btn-default btn-sm" href="./?page=<?php echo $page?>" role="button">返回</a>
        <input class="btn btn-primary btn-sm" type="submit" value="<?php echo $submit?>">

    </form>
</div>

<div id="popup" class="modal fade popup-model" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <p>确認要删除該附件?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary btn-sm sure">确定</button>
            </div>
        </div>
    </div>
</div>
