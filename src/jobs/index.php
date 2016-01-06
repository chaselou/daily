<?php

function showDataFromDB($data) {
    $data = htmlspecialchars($data,ENT_QUOTES, 'UTF-8');
    $data = str_replace('  ','&nbsp;&nbsp;',$data);
    echo $data;
}

$fromPage = 'jobs';
if (isset($_GET['addJob'])) {
    $title = '新加任務';
    $action = 'addFrom';
    $jobTypes = array('Code', 'short-term', 'long-term');
    $jobTypesDB = '';
    $detail = '';
    $startDate = date('Y-m-d');
    $submit = '新加';
    $id = '';

    include 'form.php';
    exit();
}

if (isset($_GET['addFrom'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'INSERT INTO cl_jobs SET detail=:detail, start_date=:start_date, types=:types';
        $s = $pdo->prepare($sql);
        $s->bindValue(':detail', $_POST['detail']);
        $s->bindValue(':start_date', $_POST['start_date']);
        $s->bindValue(':types', $_POST['types']);
        $s->execute();
    }
    catch (PDOException $e){
        $output = 'ERROR inserting job ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: .?addJob&done=add');
    exit();
}


if (isset($_REQUEST['editJob'])) {

    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'SELECT detail, start_date, completed_date, is_complete, types FROM cl_jobs WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_REQUEST['id']);
        $s->execute();
        $row = $s->fetch();
    }
    catch (PDOException $e) {
        $output = 'ERROR fetching job ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    $title = '修改任務';
    $action = 'editFrom';
    $jobTypes = array('Code', 'short-term', 'long-term');
    $startDate = $row['start_date'];
    $jobTypesDB = $row['types'];
    $detail = $row['detail'];
    $submit = '修改';
    $id = $_REQUEST['id'];
    include 'form.php';
    exit();
}

if (isset($_GET['editFrom'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'UPDATE cl_jobs SET detail=:detail, start_date=:start_date, types=:types WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':detail', $_POST['detail']);
        $s->bindValue(':start_date', $_POST['start_date']);
        $s->bindValue(':types', $_POST['types']);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = 'ERROR editing job ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: .?editJob&id='.$_POST['id'].'&done=edit');
    exit();
}


if (isset($_POST['complete'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'UPDATE cl_jobs SET is_complete = 1 WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = 'ERROR editing job ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: .?done=complete');
    exit();
}

if (isset($_POST['deleteJob'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'DELETE FROM cl_jobs WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = 'ERROR deleting job ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: ?done=delete');
    exit();
}



include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/lib/paginate.php';

$isComplete = 0;
$pageWhere = 'complete=0';
$where = '';
$placeholder = array();
if (isset($_REQUEST['complete']) and $_REQUEST['complete'] == 1) {
    $isComplete = 1;
    $pageWhere = 'complete=1';
}
if (isset($_REQUEST['t'])) {
    $pageWhere .= '&amp;t=' . $_REQUEST['t'];
    $where = ' And types=:types';
    $placeholder[':types'] = $_REQUEST['t'];
}
$placeholder[':is_complete'] = $isComplete;
try {

    $pageSize = 5;

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sql = "SELECT COUNT(*) FROM cl_jobs WHERE is_complete=:is_complete" . $where;
    $s = $pdo->prepare($sql);
    $s->execute($placeholder);

    $rowCount = $s->fetch();

    $pageTotal = ceil(intval($rowCount) / $pageSize);
    $offset = ($page - 1) * $pageSize;

    $pagination = outputPagination($page, $pageTotal, 8, $pageWhere);
    $select = 'SELECT id, detail, start_date, completed_date, types';
    $from = ' From cl_jobs';
    $where = ' WHERE true AND is_complete=:is_complete' . $where;
    $order = ' ORDER BY start_date DESC';
    $limit = " LIMIT $offset, $pageSize";


    $sql = $select . $from . $where . $order . $limit;
    $s = $pdo->prepare($sql);
    $s->execute($placeholder);

    while ($row = $s->fetch()) {
        $jobs[] = array('id' => $row['id'], 'detail' => $row['detail'], 'start_date' => $row['start_date'], 'completed_date' => $row['completed_date'], 'types' => $row['types']);
    }
    include 'jobs.html.php';
}
catch (PDOException $e) {
    $output = 'Error fetching jobs: ' . $e->getMessage();
    include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
    exit();
}


