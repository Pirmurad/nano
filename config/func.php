<?PHP

/***********************************

 * Developer : Məmmədov Sadiq Ilham

 * Website   : http://mrsadiq.info

 * Phone     : (+994) 77 434 07 11

 ***********************************/



// ********** [ IMAGES UPLOAD FUNCTION ] ********** //

function imgUpload($tmp, $imgname,$transparent='0',$scale = 100, $funWidth = '', $funHeight = '')

{



    list($width, $height, $type) = @getimagesize($tmp);



    if ($type != "") {

//        $r = $width / $height;

//        if ($funWidth/$funHeight > $r) {

//            $newWidth = $funHeight*$r;

//            $newHeight = $funHeight;

//        } else {

//            $newHeight = $funWidth/$r;

//            $newWidth = $funWidth;

//        }



        if ($funWidth != "" && $funHeight != "") {

            $newWidth = $funWidth;

            $newHeight = $funHeight;

        } elseif ($width > 4000) {

            $newWidth = $width * 0.5;

            $newHeight = $height * 0.5;

            $scale = 70;

        } else {

            $newWidth = $width;

            $newHeight = $height;

        }



        // Create Free Images

        $freeImages = @imagecreatetruecolor($newWidth, $newHeight);



        // Change Images Type

        if ($type == 1) {

            $images = @imagecreatefromgif($tmp);

        } elseif ($type == 2) {

            $images = imagecreatefromjpeg($tmp);

        } elseif ($type == 3) {

            imagealphablending( $freeImages, false );

            imagesavealpha( $freeImages, true );

            $images = @imagecreatefrompng($tmp);

        }

        if ($transparent=='1'){

            imagecopyresampled( $freeImages, $images, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            imagepng($freeImages, $imgname, 9);

            @imagedestroy($images);

        }else{

            // Images Add Color

            $color = @imagecolorallocate($freeImages, 255, 255, 255);

            @imagefill($freeImages, 0, 0, $color);



            // Create New Images

            @imagecopyresampled(

                $freeImages, $images, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height

            );



            // Create New Images PNG

            @imagejpeg($freeImages, $imgname, $scale);



            // Remove Images

            @imagedestroy($images);

        }



        return true;

    }

}



// ********** [ DATA INSERT FUNCTION ] ********** //

function insert($table, $insertData, $sql)

{



    global $db;



    /*

        $table      ->  Table Name

        $insertData ->  They will be added

        $execute        ->  Insert Data

    */



    $insert = $db->prepare("INSERT INTO $table SET $insertData");

    $insert->execute($sql);



    return $insert ? $db->lastInsertId() : false;

}



// ********** [ DATA UPDATE FUNCTION ] ********** //

function update($table, $updateData, $where, $execute)

{



    global $db;



    $update = $db->prepare("UPDATE $table SET $updateData WHERE $where");

    $update->execute($execute);



    if ($update) {

        return true;

    }

}



// ********** [ DATA DELETE FUNCTION ] ********** //

function delete($table, $where, $execute, $orderby = 'id', $desc = 'DESC', $limit = '')

{



    global $db;



    /*

        $table      ->  Table Name

        $where      ->  What value

        $execute        ->  Delete Data

    */



    $delete = $db->prepare("DELETE FROM $table WHERE $where ORDER BY $orderby $desc $limit");

    $delete->execute($execute);



    if ($delete) {

        return true;

    }

}



// ********** [ PREPARE FUNCTION ] ********** //

function prepare($selectData, $table, $where, $execute, $orderby = 'id', $desc = 'DESC', $limit = ''

) {



    global $db;



    /*

        $table      ->  Table Name

        $where      ->  What value

        $execute    ->  Delete Data

        $order      ->  Placement

    */



    $query = $db->prepare(

        "SELECT $selectData FROM $table WHERE $where ORDER BY $orderby $desc $limit"

    );

    $query->execute($execute);



    return $query;

}



// ********** [ QUERY FUNCTION ] ********** //

function select($selectData, $table, $orderby = 'id', $desc = 'DESC', $limit = '')

{



    global $db;



    /*

        $table      ->  Table Name

        $order      ->  Placement

    */



    $query = $db->query("SELECT $selectData FROM $table ORDER BY $orderby $desc $limit");

    return $query;

}



function fetchAll($query){

    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    return $result;

}



function fetch($query){

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;

}



// ********** [ SHORT TEXT FUNCTION ] ********** //

function shortText($val, $long = 50, $type = "...")

{



    if (strlen($val) > $long) {

        return mb_substr($val, 0, $long, "UTF-8") . $type;

    } else {

        return $val;

    }

}



// ********** [ USER IP ADDRESS FUNCTION ] ********** //

function getIP()

{

    if (getenv("HTTP_CLIENT_IP")) {

        $ip = getenv("HTTP_CLIENT_IP");

    } elseif (getenv("HTTP_X_FORWARDED_FOR")) {

        $ip = getenv("HTTP_X_FORWARDED_FOR");

        if (strstr($ip, ',')) {

            $tmp = explode(',', $ip);

            $ip = trim($tmp[0]);

        }

    } else {

        $ip = getenv("REMOTE_ADDR");

    }



    return $ip;

}



// ********** [ SQL INJECTION FILTER FUNCTION ] ********** //

function sqlInjectionFilet($val)

{



    $find = ["select", "union", "order", "\"", "'", "version", "#", "$"];

    $change = ["", "", "", "", "", "", "", ""];



    return str_replace($find, $change, $val);

}



// ********** [ URL FILTER FUNCTION ] ********** //

function filterUrl($val)

{



    return trim(addslashes(strip_tags(filter_var(rtrim($val, "/"), FILTER_SANITIZE_URL))));

}



// ********** [ GET METHOD RETURN FUNCTION ] ********** //

function get($val)

{



    if (isset($_GET[$val])) {



        if (is_array($_GET[$val])) {



            return array_map(

                function ($item) {

                    return sqlInjectionFilet(filterUrl($item));

                }, $_GET[$val]

            );

        } else {



            return sqlInjectionFilet(filterUrl($_GET[$val]));

        }

    }

}



// ********** [ POST METHOD RETURN FUNCTION ] ********** //

function post($val, $htmlTags = '')

{



    if (isset($_POST[$val])) {



        if ($htmlTags != "") {



            return @htmlspecialchars(trim(addslashes($_POST[$val])));

        } else {



            return @htmlspecialchars(trim(addslashes(strip_tags($_POST[$val]))));

        }

    }

}



// ********** [ CREATE SEO LINK FUNCTION ] ********** //

function dolinkname($linkname, $unwanted_array)

{

    $linkname = strtolower(strtr($linkname, $unwanted_array));

    $linkname = preg_replace('~[^-a-zA-Z0-9_]+~u', '-', $linkname);

    $linkname = trim($linkname);



    return $linkname;

}



function dologin($linkname, $unwanted_array)

{

    $linkname = strtolower(strtr($linkname, $unwanted_array));

    $linkname = preg_replace('~[^-a-zA-Z0-9_]+~u', '_', $linkname);

    $linkname = trim($linkname);



    return $linkname;

}



// ********** [ DO SAFE EXTRACT TO POST DATA FUNCTION ] ********** //

function postextract($variable, $htmlTags = "")

{

    if (isset($variable)) {

        if ($htmlTags != "") {

            return @htmlspecialchars(trim(addslashes($variable)));

        } else {

            return @htmlspecialchars(trim(addslashes(strip_tags($variable))));

        }

    }

}



// ********** [ SESSION CREATE FUNCTION ] ********** //

function session_create($val)

{



    foreach ($val as $key => $i) {

        $_SESSION[$key] = $i;

    }

}



// ********** [ SESSION RETURN FUNCTION ] ********** //

function session($val)

{



    if (@$_SESSION[$val]) {

        return $_SESSION[$val];

    } else {

        return false;

    }

}



// ********** [ MULTILEVEL MENU RECURSIVE FUNCTION ] ********** //

function multilevelMenu($table,$parentId,$blank, $count, $c, $catid)

{

    if ($table == "menyu"){$selectData = "`id`,`name`,`parent_id`,`type`";}else{$selectData="`id`,`name`,`parent_id`";}
    $parentcategoryfetch = prepare(

        $selectData, "$table", "`parent_id`=? AND `status`=?", [$parentId,"1"], "`name`", "ASC"

    );



    if ($c < $count) {

        $blank .= "╚═ ";

    }

    $c = $count;

    $count++;



    while($parentcategory = fetch($parentcategoryfetch)) {

        if ($catid == $parentcategory['id']) {

            $selected = 'selected';

        } else {

            $selected = '';

        }

        if (get('id')!=$parentcategory['id'] AND intval($parentcategory['id']) > 0) {

            echo '<option value="' . $parentcategory['id'] . '" ' . $selected . '>';

            echo $blank . $parentcategory['name'];

            if ($table=="menyu"){
                echo " - [".$parentcategory['type']." menyu]";
            }

            echo '</option>';

            multilevelMenu($table, $parentcategory['id'], $blank, $count, $c, $catid);

        }

    }

}



// ********** [ FIND TABLE ROW COUNT FUNCTION ] ********** //

function fetchColumn($countData = "COUNT(id)",$table,$where="`id`>?",$execute=["0"])
{

    global $db;



    $fetch = $db->prepare("SELECT $countData FROM $table WHERE $where");

    $fetch->execute($execute);

    $fetchColumn = $fetch->fetchColumn();



    if ($fetchColumn) {

        return $fetchColumn;

    } elseif (empty($fetchColumn)) {

        return 0;

    }

}





// ********** [ IMAGE UPLOAD FROM POST FUNCTION ] ********** //

function imageupload($file_tmp, $uploadpath,$imagepath,$size,$deleteimagecolumn, $table, $getId, $folder, $errorredirect,$transparent)

{

    // Əgər şəkil yüklənibsə İF-in içinə girəcək olmasa ELSE-nin

    if (!empty($file_tmp)) {

        $rand_name_1 = rand(1000000, 9999999);

        $rand_name_2 = rand(1000000, 9999999);

        $rand = "$rand_name_2$rand_name_1";



        $allowedTypes = [IMAGETYPE_PNG, IMAGETYPE_SWF, IMAGETYPE_JPEG, IMAGETYPE_GIF];

        $detectedType = exif_imagetype($file_tmp);



        if (in_array($detectedType, $allowedTypes)) {

            $errors = "";

        } else {

            $errors = "Yanlış formatda fayl yüklənib!";

        }



        $file_name = $rand .'_'. basename($_FILES["fileToUpload"]["name"]);

    } else {

        $file_name = '';

    }



    if (empty($errors) == true) {

        @$deleteimage = prepare($deleteimagecolumn, $table, "`id`=?", [$getId])->fetch(PDO::FETCH_ASSOC);



        if (empty($file_name)) {

            // Əgər boşdursa bazadakı şəkilin adını götürür

            $file_name = $deleteimage[$deleteimagecolumn];

            return $file_name;

        } else {

            // Əgər şəkil gəlibsə köhnə şəkilləri silirik

            if (@$deleteimage[$deleteimagecolumn] != null) {

                @unlink("{$uploadpath}uploads/{$folder}/{$deleteimage[$deleteimagecolumn]}");

                @unlink("{$uploadpath}uploads/{$folder}/large/{$deleteimage[$deleteimagecolumn]}");

                @unlink("{$uploadpath}uploads/{$folder}/medium/{$deleteimage[$deleteimagecolumn]}");

                @unlink("{$uploadpath}uploads/{$folder}/little/{$deleteimage[$deleteimagecolumn]}");

            }



            if ($detectedType!=1){

                // Yeni şəkil upload olunur

                imgUpload($file_tmp, "{$uploadpath}uploads/{$folder}/" . $file_name,$transparent);



                $image = new SimpleImage("{$uploadpath}uploads/{$folder}/" . $file_name);

                $resize = [];
                $i = 1;
                foreach ($size as $s) {

                    $resize[$i] = $s;

                    $i++;

                }



                if (! empty($resize['1'])) {

                    $image->thumbnail($resize['1'], $resize['2']);

//                    $image->overlay($imagepath . 'dist/img/watermark.png', 'bottom right');

                    $image->save("{$uploadpath}uploads/{$folder}/large/" . $file_name);

                }

                if (! empty($resize['3'])) {

                    $image->thumbnail($resize['3'], $resize['4']);

//                    $image->overlay($imagepath . 'dist/img/watermark.png', 'bottom right');

                    $image->save("{$uploadpath}uploads/{$folder}/medium/" . $file_name);

                }

                if (! empty($resize['5'])) {

                    $image->thumbnail($resize['5'], $resize['6']);

                    // $image->overlay($imagepath . 'dist/img/watermark.png', 'bottom right');

                    $image->save("{$uploadpath}uploads/{$folder}/little/" . $file_name);

                }

            }else{

                move_uploaded_file($file_tmp, "{$uploadpath}uploads/{$folder}/large/" . $file_name);

            }



            return $file_name;

        }

    } else {

        $_SESSION['errors'] = $errors;



        redirect($errorredirect);

    }



    return $file_name;

}



// ********** [ REDIRECT FUNCTION ] ********** //

function redirect($address, $time = '0')

{

    echo '<META HTTP-EQUIV=REFRESH CONTENT="' . $time . '; ' . $address . '">';

    exit();

}



function addInput(

    $col = 'col-md-4', $title, $name, $value, $valuestatus = '0', $type = 'text',

    $maxlength = '100', $required = '1'

) {

    if ($valuestatus == '0') {

        $placeholder = 'placeholder="' . $value . '"';

    } else {

        $placeholder = 'value="' . $value . '"';

    }

    if ($required == '1') {

        $required = 'required';

    } else {

        $required = '';

    }

    if (! empty($maxlength)) {

        $maxlength = 'maxlength="' . $maxlength . '"';

    } else {

        $maxlength = '';

    }

    $return = '

        <div class="' . $col . '">

            <label for="' . $name . '"><span>' . $title . '</span></label><br>

            <input type="' . $type . '" id="' . $name . '" name="' . $name . '" ' . $required . ' '

              . $maxlength . '  class="form-control" ' . $placeholder . '/>

        </div>

    ';



    return $return;

}



function pagination($perpage = "10",$page, $viewpagecount = "2", $table,$where="`id`>?",$execute=["0"],$link)

{

    $total_records = fetchColumn("COUNT(id)", $table,$where,$execute);

    $total_pages = @ceil($total_records / $perpage);

    if (empty($total_pages)) {$total_pages = 1;}

    if ($page > $total_pages) {redirect($link . "/list/");}

    if ($total_pages>1){

        $nav = '<div class="col-md-4"><ul class="pagination">';

        if ($page > 1) {

            $nav .= '<li><a href="'.$link.'/list/'.($page-1).'/" aria-label="Previous"><span aria-hidden="true">&larrtl;</span></a></li>';

        }

        for ($i=$page-$viewpagecount; $i<=$page+1+$viewpagecount; $i++) {

            if ($i>0 && $i<=$total_pages){

                if ($page==$i){ $active = 'class="active"';}else{ $active = "";}

                $nav .= '<li '.$active.'><a href="'.$link.'/list/'.$i.'/">'.$i.'<span class="sr-only"></span></a></li>';

            }

        }

        if ($page<$total_pages) {

            $nav .= '<li><a href="'.$link.'/list/'.($page+1).'/" aria-label="Next"><span aria-hidden="true">&rightarrowtail;</span></a></li>';

        }

        $nav .= " </ul></div>";

    }else{

        $nav = '<div class="col-md-4"><ul class="pagination" style="margin: 18px;"></ul></div>';

    }



    return $nav;

}



function imagemindimensionupload($image,$minwidth,$minheight)

{

    $img=@getimagesize($image);

    $width= $img[0];

    $height =$img[1];

    if ($width<$minwidth || $height<$minheight){

        $errors['dimension'] = 'Şəkilin eni və ya uzunluğu balacadır.Şəkil minimum '.$minwidth.'x'.$minheight.' ölçülərində olmalıdır! Zəhmət olmasa yenidən yoxlayın :)';

        return $errors;

    }else{

        return true;

    }

}



function multilevelCat($table,$parentId,$catId,$count)

{

    $parentcategory = prepare(

        "`id`,`name`,`parent_id`,`icon`,`linkname`", "$table", "`parent_id`=? AND `status`=?", [$parentId,"1"], "`ordering`", "ASC"

    );

    $menu="";
    $count++;
    while ($parentcategoryfetch = fetch($parentcategory)) {

        if ($table=='`category`'){$link = 'kateqoriya/'.$parentcategoryfetch['linkname'].'/';}else{$link = $parentcategoryfetch['linkname'].'/';}

        if ($catId==$parentcategoryfetch['linkname']){$active=' class="active"';}else{$active="";}

        $menu.= '<li '.$active.'><a href="#" data-id="'.$parentcategoryfetch['id'].'">';

        if ($parentId==0) {

                $menu.= '<div class="fa-px text-center"><i class="'.$parentcategoryfetch['icon'].'"></i></div>';

        }

        if ($count>1){$right='<i class="fas fa-angle-right pull-right"></i>';}else{$right='';}

        $menu.= '<span>'.ucfirst($parentcategoryfetch['name']).$right.'</span>';

        $menu.= '</a>';

        multilevelCat($table, $parentcategoryfetch['id'], $catId,$count);

        $menu.='</li>';
    }

    return $menu;

}

function multilevelOrtaMenu($table,$type,$parentId,$catId,$count)

{

    $parentcategory = prepare(

        "`id`,`name`,`parent_id`,`linkname`", "$table", "`type`=? AND `parent_id`=? AND `status`=?", [$type,$parentId,"1"], "`ordering`", "ASC"

    );

    $menu="";
    $count++;
    while ($parentcategoryfetch = fetch($parentcategory)) {

        if ($catId==$parentcategoryfetch['linkname']){$active=' class="active"';}else{$active="";}

        $menu.= '<li '.$active.'><a href="'.$parentcategoryfetch['linkname'].'/">';

        if ($count>1){$right='<i class="fas fa-caret-down"></i>';}else{$right='';}

        $menu.= '<span>'.ucfirst($parentcategoryfetch['name']).$right.'</span>';

        $menu.= '</a>';

        $menu.='</li>';
    }

    return $menu;

}

function multilevelBottomCat($table,$type,$catId)

{

    $parentcategory = prepare(

        "`id`,`name`,`linkname`", "$table", "`type`=? AND `status`=?", [$type,"1"], "`ordering`", "ASC"

    );

    $menu="";

    while ($parentcategoryfetch = fetch($parentcategory)) {

        if ($catId==$parentcategoryfetch['linkname']){$active=' class="active"';}else{$active="";}

        $menu.= '<li '.$active.'><i class="far fa-dot-circle fa-fw fa-spin"></i> <a href="'.$parentcategoryfetch['linkname'].'/'.'">'.$parentcategoryfetch['name'];

        $menu.= '</a>';

        $menu.='</li>';

    }

    return $menu;

}



function checklevel($getlink,$user)

{

    if ($user['user']=='ok'){

        $konum = strpos($getlink, "news");

        if ($konum==false){

            redirect("index.php");

        }

    }

}

?>