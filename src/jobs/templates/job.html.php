<?php if(isset($_GET['done'])):
    if ($_GET['done'] == 'complete') {
        $msg = '已完成新任務';
    }
    else if ($_GET['done'] == 'delete') {
        $msg = '已刪除任務';
    }
    ?>
<p id="msg" class="bg-success"><?php echo $msg?></p>
<?php endif?>

<div id="jobs">

    <?php foreach($jobs as $job): ?>
        <div class="job">
            <div class="job-top">
                <span class="types"><?php showDataFromDB($job['types'])?></span>
                <span class="startDate"><?php showDataFromDB($job['start_date'])?></span>
            </div>
            <div class="detail"><?php showDataFromDB($job['detail'])?></div>
            <div class="job-bottom">
                <?php if(!$isComplete):?>
                <div class="finish">
                    <form id="form<?php showDataFromDB($job['id'])?>" method="post" action="">
                        <input type="hidden" value="<?php showDataFromDB($job['id'])?>" name="id">
                        <button type="button" class="btn btn-danger btn-sm popup-delete" data-toggle="modal" data-target=".popup-model">刪除任務</button>
                        <button type="submit" class="btn btn-primary btn-sm" name="editJob">修改任務</button>
                        <button type="button" class="btn btn-primary btn-sm popup-complete" data-toggle="modal" data-target=".popup-model">完成任務</button>
                    </form>
                </div>
                <?php endif?>
            </div>
        </div>
    <?php endforeach ?>
</div>

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
