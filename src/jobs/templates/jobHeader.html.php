<div id="job-done">
    <ul class="nav nav-pills" role="tablist">
        <li role="presentation" <?php if(!$isComplete):?>class="active" <?php endif?>><a href=".">未完成</a></li>
        <li role="presentation" <?php if($isComplete):?>class="active" <?php endif?>><a href="?complete=1">已完成</a></li>
    </ul>
</div>
<div id="job-type" class="btn-group" role="group" aria-label="...">
    <a class="btn btn-default" href="?complete=<?php echo $isComplete?>" role="button">All</a>
    <a class="btn btn-default" href="?t=code&amp;complete=<?php echo $isComplete?>" role="button">code</a>
    <a class="btn btn-default" href="?t=short-term&amp;complete=<?php echo $isComplete?>" role="button">short-term</a>
    <a class="btn btn-default" href="?t=long-term&amp;complete=<?php echo $isComplete?>" role="button">long-term</a>
</div>

<div id="new-job">
    <?php if(!$isComplete):?>
        <a href="?addJob" class="btn btn-success btn-sm" role="button">新增工作</a>
    <?php endif?>
</div>


