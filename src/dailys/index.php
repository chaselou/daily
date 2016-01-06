<?php

function showDataFromDB($data) {
    $data = htmlspecialchars($data,ENT_QUOTES, 'UTF-8');
    $data = str_replace('  ','&nbsp;&nbsp;',$data);
    echo $data;
}

$fromPage = 'dailys';
if (isset($_GET['addDaily'])) {
    $title = '新加日記';
    $action = 'addFrom';
    $weather = '';
    $comment = '';
    $submit = '新加';
    $date = date('Y-m-d');
    $id = '';

    include 'form.php';
    exit();
}

if (isset($_GET['addFrom'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'INSERT INTO Daily SET Date=:date, Weather=:weather, Comment=:comment';
        $s = $pdo->prepare($sql);
        $s->bindValue(':date', $_POST['date']);
        $s->bindValue(':weather', $_POST['weather']);
        $s->bindValue(':comment', $_POST['comment']);
        $s->execute();
    }
    catch (PDOException $e){
        $output = 'ERROR inserting daily ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: ?addDaily&done=add');
    exit();
}

if (isset($_REQUEST['editDaily'])) {

    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'SELECT Date, Weather, Comment FROM Daily WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_REQUEST['id']);
        $s->execute();
        $row = $s->fetch();
    }
    catch (PDOException $e) {
        $output = 'ERROR fetching daily ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    $title = '修改日記';
    $action = 'editFrom';
    $date = $row['Date'];
    $weather = $row['Weather'];
    $comment = $row['Comment'];
    $submit = '修改';
    $id = $_REQUEST['id'];
    include 'form.php';
    exit();
}

if (isset($_GET['editFrom'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'UPDATE Daily SET Date=:date, Weather=:weather, Comment=:comment WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':date', $_POST['date']);
        $s->bindValue(':weather', $_POST['weather']);
        $s->bindValue(':comment', $_POST['comment']);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = 'ERROR editing daily ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: .?editDaily&id='.$_POST['id'].'&done=edit');
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/lib/paginate.php';

try {

    $pageSize = 5;

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sql = "SELECT COUNT(*) FROM Daily";
    $result = $pdo->query($sql);
    $rowCount = $result->fetchColumn();

    $pageTotal = ceil(intval($rowCount) / $pageSize);
    $offset = ($page - 1) * $pageSize;

    $pagination = outputPagination($page, $pageTotal, 8, 'cid=10');

    $sql = "SELECT id, Date, Weather, Comment FROM Daily ORDER BY Date DESC LIMIT $offset, $pageSize";
    $result = $pdo->query($sql);

    while ($row = $result->fetch()) {
        $dailys[] = array('id' => $row['id'], 'date' => $row['Date'], 'weather' => $row['Weather'], 'comment' => $row['Comment']);
    }

    include 'dailys.html.php';
}
catch (PDOException $e) {
    $output = 'Error fetching daily: ' . $e->getMessage();
    include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
    exit();
}


