<?php
ob_start();
$path = "../";
include_once("{$path}config/conf.php");


function display_children($parent, $level,$count) {
    $category = prepare(
        "`id`,`name`,`parent_id`,`linkname`", "`category`", "`parent_id`=? AND `status`=?", [$parent,"1"], "`ordering`", "ASC"
    )->fetchAll(PDO::FETCH_ASSOC);
    $menu = "";echo "<pre>";
     var_dump($category);
    $menu .= '<ul class="';
    ($count==0) ? $menu .= 'megamenu-2 box-shadow' : $menu .= 'megamenu-3';
    $menu .= '">';
    if (!empty($category)){
        foreach($category as $row) {
            if (count($row )> 0) {
                $menu.='<li><a href="'.$row['linkname'].'">' . $row['name'] . "</a>";
                echo display_children($row['id'], $level + 1,$count++);
                $menu .= "</li>";
            } elseif (count($row)==0) {
                $menu .= "<li><a href='" . $row['linkname'] . "'>" . $row['name'] . "</a></li>";
            } else;
        }
    }

    $menu .= "</ul>";
    return $menu;
}
echo display_children(0, 1,0);

//echo json_encode(['html'=>$form,'tag'=>post('matchvalue')]);?>



