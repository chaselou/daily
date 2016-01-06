<script>
    <?php
    session_start();
    if(!isset($_SESSION['checkRecordPw'])):?>
        $(function() {
            $('#menu-records').click(function() {
                $('#recordCheckModal').modal();
                return false;
            });
            <?php if($_GET['recordCheck'] == 'wrong'):?>
            $('#modal-pw').addClass('has-error');
            $('#modal-pw label').text('密碼不正确');
            $('#recordCheckModal').modal();
            <?php endif;?>
        });
    <?php endif?>
</script>


<div class="modal fade" id="recordCheckModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="recordCheckModalLabel">請輸入紀錄密碼</h4>
            </div>
            <form id="checkRecordForm" action="../records/index.php" method="post">
                <div class="modal-body">
                    <div id="modal-pw">
                        <label class="control-label" for="checkRecordPw"></label>
                        <input type="password" name="checkRecordPw" class="form-control" id="checkRecordPw" >
                    </div>
                    <input type="hidden" name="fromPage" value="<?php echo $fromPage?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <input type="submit" class="btn btn-primary" value="确定">
                </div>
            </form>
        </div>
    </div>
</div>