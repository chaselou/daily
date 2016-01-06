<?php

function showDataFromDB($data) {
    $data = htmlspecialchars($data,ENT_QUOTES, 'UTF-8');
    $data = str_replace('  ','&nbsp;&nbsp;',$data);
    echo $data;
}

$fromPage = 'records';

session_start();
if ($_POST['checkRecordPw'] != 'gc' and !isset($_SESSION['checkRecordPw'])) {
    $returnTo = 'dailys';
    if(isset($_POST['fromPage'])) {
        $returnTo = $_POST['fromPage'];
    }

    header('Location: /huaqiao/src/' . $returnTo . '?recordCheck=wrong');
    exit();
}
$_SESSION['checkRecordPw'] = TRUE;


if (isset($_GET['addRecord'])) {

    $title = '新加資料';
    $action = 'addFrom';
    $name = '';
    $content = '';
    $submit = '新加';
    $id = '';

    include 'form.php';
    exit();
}

if (isset($_GET['addFrom'])) {

    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'INSERT INTO record SET name=:name, content=:content';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':content', $_POST['content']);
        $s->execute();
    }
    catch (PDOException $e){
        $output = 'ERROR inserting record ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    if(isset($_FILES['attachment']['name']) and $_FILES['attachment']['size'] > 0) {

        if($_FILES['attachment']['error'] > 0) {
            $output = 'Upload Failed. Error corde is:' . $_FILES['attachment']['error'];
            include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
            exit();
        }

        if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {

            $attachment = $_FILES['attachment']['tmp_name'];
            $filename = $_FILES['attachment']['name'];
            $filetype = $_FILES['attachment']['type'];
            $filedata = file_get_contents($attachment);

            try {
                $recordid = $pdo->lastInsertId();

                $sql = 'INSERT INTO filestore SET filename=:filename, minetype=:minetype, filedata=:filedata, recordid=:recordid';
                $s = $pdo->prepare($sql);
                $s->bindValue(':filename', $filename);
                $s->bindValue(':minetype', $filetype);
                $s->bindValue(':filedata', $filedata);
                $s->bindValue(':recordid', $recordid);
                $s->execute();
            } catch (PDOException $e) {
                $output = 'ERROR inserting filestore ' . $e->getMessage();
                include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
                exit();
            }
        }
    }
    header('Location: ?addRecord&done=add');
    exit();

}

if(isset($_POST['deleteAttachmentId'])){

    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'DELETE FROM filestore WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['deleteAttachmentId']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = 'ERROR deleting filestore ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: .?editRecord&id='.$_POST['recordid'].'&done=deleteAttachment');
    exit();
}

if (isset($_REQUEST['editRecord'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'SELECT name, content FROM record WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_REQUEST['id']);
        $s->execute();
        $row = $s->fetch();
    }
    catch (PDOException $e) {
        $output = 'ERROR fetching record ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    try {
        $sql = 'SELECT id, filename FROM filestore WHERE recordid=:recordid';
        $s = $pdo->prepare($sql);
        $s->bindValue(':recordid', $_REQUEST['id']);
        $s->execute();
        $fileRow = $s->fetch();

        if($fileRow) {
            $fileId = $fileRow['id'];
            $fileName = $fileRow['filename'];
        }

    }
    catch (PDOException $e) {
        $output = 'ERROR fetching filestore ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    $title = '修改記綠';
    $action = 'editFrom';
    $name = $row['name'];
    $content = $row['content'];
    $submit = '修改';
    $id = $_REQUEST['id'];
    include 'form.php';
    exit();
}

if (isset($_GET['editFrom'])) {

    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'UPDATE record SET name=:name, content=:content WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':name', $_POST['name']);
        $s->bindValue(':content', $_POST['content']);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = 'ERROR editing record ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    if(isset($_FILES['attachment']['name']) and $_FILES['attachment']['size'] > 0) {

        if($_FILES['attachment']['error'] > 0) {
            $output = 'Upload Failed. Error corde is:' . $_FILES['attachment']['error'];
            include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
            exit();
        }

        if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {

            $attachment = $_FILES['attachment']['tmp_name'];
            $filename = $_FILES['attachment']['name'];
            $filetype = $_FILES['attachment']['type'];
            $filedata = file_get_contents($attachment);

            try {
                $sql = 'INSERT INTO filestore SET filename=:filename, minetype=:minetype, filedata=:filedata, recordid=:recordid';
                $s = $pdo->prepare($sql);
                $s->bindValue(':filename', $filename);
                $s->bindValue(':minetype', $filetype);
                $s->bindValue(':filedata', $filedata);
                $s->bindValue(':recordid', $_POST['id']);
                $s->execute();
            } catch (PDOException $e) {
                $output = 'ERROR inserting filestore ' . $e->getMessage();
                include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
                exit();
            }
        }
    }

    header('Location: .?editRecord&id='.$_POST['id'].'&done=edit');
    exit();
}

if (isset($_POST['deleteRecord'])) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = 'DELETE FROM record WHERE id=:id';
        $s = $pdo->prepare($sql);
        $s->bindValue(':id', $_POST['id']);
        $s->execute();
    }
    catch (PDOException $e) {
        $output = 'ERROR deleting record ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    header('Location: ?done=delete');
    exit();
}

if ($_GET['action'] == 'view' and isset($_GET['recordid'])) {

    include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
    try {
        $sql = "SELECT filename, minetype, filedata FROM filestore WHERE recordid =:recordid";
        $s = $pdo->prepare($sql);
        $s->bindValue('recordid', $_GET['recordid']);
        $s->execute();

    }
    catch (PDOException $e) {
        $output = 'Error fetching file: ' . $e->getMessage();
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    $file = $s->fetch();
    if(!$file) {
        $output = 'File not exist';
        include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
        exit();
    }

    $filename = $file['filename'];
    $minetype = $file['minetype'];
    $filedata = $file['filedata'];
    $disposition = 'attachment';

    header('Content-length: ' . strlen($filedata));
    header("Content-type: application/octet-steams");
    header("Content-disposition: $disposition;filename=$filename");

    echo $filedata;
    exit();
}


include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/include/dbConnection.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/lib/paginate.php';

try {

    $pageSize = 1;

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $sql = "SELECT COUNT(*) FROM record";
    $result = $pdo->query($sql);
    $rowCount = $result->fetchColumn();

    $pageTotal = ceil(intval($rowCount) / $pageSize);
    $offset = ($page - 1) * $pageSize;

    $pagination = outputPagination($page, $pageTotal);

    $sql = "SELECT record.id AS id, name, content, filestore.id AS fileid, filename FROM record LEFT JOIN filestore ON recordid = record.id LIMIT $offset, $pageSize";
    $result = $pdo->query($sql);

    while ($row = $result->fetch()) {
        $records[] = array('id' => $row['id'], 'name' => $row['name'], 'content' => $row['content'], 'fileid' => $row['fileid'], 'filename' => $row['filename']);
    }

    include 'records.html.php';
}
catch (PDOException $e) {
    $output = 'Error fetching daily: ' . $e->getMessage();
    include $_SERVER['DOCUMENT_ROOT'] . '/huaqiao/src/templates/output.html.php';
    exit();
}
