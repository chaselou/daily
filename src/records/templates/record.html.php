<?php if(isset($_GET['done'])):
    if ($_GET['done'] == 'complete') {
        $msg = '已完成新任務';
    }
?>
<p id="msg" class="bg-success"><?php echo $msg?></p>
<?php endif?>

<table class="table table-hover">
    <thead>
        <tr>
            <th>名子</th>
            <th>內容</th>
            <th>附件</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($records as $record):?>
        <tr>
            <td><?php showDataFromDB($record['name'])?></td>
            <td><?php showDataFromDB($record['content'])?></td>
            <td>
                <?php if(!is_null($record['fileid'])):?>
                    <a href="?action=view&amp;recordid=<?php showDataFromDB($record['id'])?>"><?php showDataFromDB($record['filename'])?></a>
                <?php endif?>
            </td>
            <td>
                <form id="form<?php showDataFromDB($record['id'])?>" method="post" action="">
                    <input type="hidden" value="<?php showDataFromDB($record['id'])?>" name="id">
                    <button type="submit" class="btn btn-primary btn-sm" name="editRecord">修改紀錄</button>
                    <button type="button" class="btn btn-danger btn-sm popup-delete" data-toggle="modal" data-target=".popup-model">刪除紀錄</button>
                </form>
            </td>
        </tr>
        <?php endforeach?>
    </tbody>
</table>

<div id="popup" class="modal fade popup-model" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary btn-sm sure">确定</button>
            </div>
        </div>
    </div>
</div>