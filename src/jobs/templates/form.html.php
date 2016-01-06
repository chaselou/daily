<div id="form">

    <?php if(isset($_GET['done'])):
        if ($_GET['done'] == 'add') {
            $msg = '已添加新任務';
        }
        else if ($_GET['done'] == 'edit') {
            $msg = '已修改任務';
        }
    ?>
    <p id="msg" class="bg-success"><?php echo $msg?></p>
    <?php endif?>

    <form class="form-horizontal" method="post" action="?<?php echo $action?>">

        <div class="form-group">
            <label for="start_date" class="col-sm-2 control-label">開始日期:</label>
            <div class="col-sm-10">
                <input id="start_date" type="text" name="start_date" class="form-control" value="<?php showDataFromDB($startDate)?>">
            </div>
        </div>

        <div class="form-group">
            <label for="types" class="col-sm-2 control-label">類型:</label>
            <div class="col-sm-10">
                <select id="types" name="types" class="form-control">
                    <?php foreach($jobTypes as $jobType): ?>
                        <option value="<?php echo $jobType?>" <?php if ($jobType == $jobTypesDB) echo 'selected'?>><?php echo $jobType?></option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="detail" class="col-sm-2 control-label">描述:</label>
            <div class="col-sm-10">
                <textarea id="detail" name="detail" class="form-control" rows="10" cols="60"><?php showDataFromDB($detail)?></textarea>
            </div>
        </div>
        <input type="hidden" name="id" value="<?php echo $id?>">
        <a class="btn btn-default btn-sm" href="." role="button">返回</a>
        <input class="btn btn-primary btn-sm" type="submit" value="<?php echo $submit?>">
    </form>
</div>
