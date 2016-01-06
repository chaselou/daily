<?php foreach($dailys as $daily): ?>
    <div id="daily<?php showDataFromDB($daily['id'])?>" class="article">
        <span class="date"><?php showDataFromDB($daily['date'])?></span>
        <span class="weather"><?php showDataFromDB($daily['weather'])?></span>
        <div class="comment"><?php showDataFromDB($daily['comment'])?></div>
        <div class="action">
            <form method="post" action="">
                <input type="hidden" value="<?php showDataFromDB($daily['id'])?>" name="id">
                <button name="editDaily" class="btn btn-primary btn-sm" type="submit">修改日記</button>
            </form>
        </div>
    </div>
<?php endforeach ?>