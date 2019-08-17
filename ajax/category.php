<?php
ob_start();
$path = "../";
include_once("{$path}config/conf.php");

$category_id = post('id');
$json1 = "";

if ($category_id) {
    $category = prepare("`linkname`,`name`,`id`", "`category`", "`parent_id`=? AND `status`=?", [$category_id,"1"],"`ordering`","ASC")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($category as $c):
        $json1 .= "<li><ul class='megamenu-3'><li><a class='mega-title bb' href='javascript:void(0);'>{$c['name']}</a></li>";
        $altcategory = prepare("`linkname`,`name`","`category`","`parent_id`=? AND `status`=?",[$c['id'],"1"],"`ordering`","ASC")->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($altcategory)):
            foreach ($altcategory as $altc):
                $json1.="<li><a href='kateqoriya/{$altc['linkname']}/'>{$altc['name']}</a></li>";
            endforeach;
        endif;

        $json1.="</ul></li>";
    endforeach;
}
echo json_encode($json1);