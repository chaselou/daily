<?php

function outputPagination($page, $pageTotal, $showPage=8, $where=null)
{
    if($pageTotal <= 1) {
        return '';
    }
    if (is_null($page) or $page < 1 or !is_numeric($page)) {
        $page = 1;
    }
    if ($page > $pageTotal) {
        $page = $pageTotal;
    }

    $url = $_SERVER['PHP_SELF'];
    $where = $where == null ? null : '&'.$where;
    $first = ($page == 1) ? '' : "<li><a href='$url?page=1{$where}' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>";
    $end = ($page == $pageTotal) ? '' : "<li><a href='$url?page={$pageTotal}{$where}' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>";

    if($showPage >= $pageTotal ) {
        $startPage = 1;
        $endPage = $pageTotal;
    }
    else {
        $frontPageOffset = floor(($showPage - 1)/2);
        $lastPageOffset = floor($showPage / 2);

        if ($frontPageOffset >= $page) {
            $startPage = 1;
            $endPage = $showPage;
        } else if($page > $pageTotal - $lastPageOffset) {
            $startPage = $pageTotal - $showPage + 1;
            $endPage = $pageTotal;
        } else {
            $startPage = $page - $frontPageOffset;
            $endPage = $page + $lastPageOffset;
        }
    }

    $middle = '';
    for ($i = $startPage; $i <= $endPage; $i++) {
        $isActive = ($page == $i) ? 'active' : '';
        $middle .= "<li class='$isActive'><a href='$url?page=$i{$where}'>$i</a></li>";
    }

    return '<ul class="pagination">' . $first . $middle . $end . '</ul>';
}