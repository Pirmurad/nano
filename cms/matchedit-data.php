<?php
ob_start();
$path = '../';
include "{$path}config/conf.php";

if (!empty($_POST)):
    postextract(extract($_POST));
    $param = prepare("`name`,`linkname`,`id`", "`type_param`", "`type_id`=?", [$matchvalue])->fetchAll(PDO::FETCH_ASSOC);
    $form = "";
    // burdakı sorğu hansı tabledan çəkir? paramdan cekir
    if (!empty($param)):
        $key = 0;
        foreach ($param as $par):
            $value = prepare("`name`,`linkname`", "`value`", "`param_id`=?", [$par['id']])->fetchAll(PDO::FETCH_ASSOC);

            if (empty($value)) {
                if ($key == 3 || $key == 0): $form .= '<div class="col-md-12 p10">'; endif;
                $form .= '<div class="col-md-4">
                        <label for="' . $par['linkname'] . '"><span>' . $par['name'] . '</span></label><br>
                        <input type="text" id="' . $par['linkname'] . '" name="product[' . $par['linkname'] . ']" required maxlength="100" class="form-control" placeholder="' . $par['name'] . ' *"/>
                    </div>';
                if ($key == 2): $form .= '</div>'; endif;
                $key++;
                if ($key == 3) {
                    $key = 0;
                }
            } else {
                if ($key == 3 || $key == 0): $form .= '<div class="col-md-12 p10">'; endif;
                $form .= '<div class="col-md-4">
                    <label for="' . $par['linkname'] . '"><span>' . $par['name'] . '</span></label>
                    <br>
                    <select name="product[' . $par['linkname'] . ']" id="' . $par['linkname'] . '" class="form-control">';
                foreach ($value as $val):
                    $form .= '<option value="' . $val['name'] . '">' . $val['name'] . '</option>';
                endforeach;
                $form .= '</select>

            <!-- 
               <button type="submit" id="refresh" style="position: absolute;top: 50%;right: -13px;background-color: transparent;border: none;">  <span><i class="fa fa-refresh"></i></span></button>
                <input type="text" id="yenile_id" value="' . $par['id'] . '" name="' . $par['id'] . '">
            -->
              <button 
                   type="button" 
                   class="refresh"  
                   value="' . $par['id'] . '" 
                   style="position: absolute;top: 50%;right: -13px;background-color: transparent;border: none;"> 
                   <span><i class="fa fa-refresh"></i></span>
                   </button>
                </div>';
                if ($key == 2): $form .= '</div>'; endif;
                $key++;
                if ($key == 3) {
                    $key = 0;
                }
            }
        endforeach;
    endif;
    $type = prepare("`tags`", "`type`", "`id`=?", [$matchvalue])->fetchAll(PDO::FETCH_ASSOC);
    $tagarray = "";
    if (!empty($type)):
        foreach ($type as $tag):
            $tagarray .= $tag['tags'];
        endforeach;
    endif;

    $type_param = prepare("`name`,`linkname`,`type_id`", "`type_param`", "`id`=?", [$yenile_id])->fetch(PDO::FETCH_ASSOC);
    $value= prepare("`name`,`linkname`,`id`", "`value`", "`param_id`=?", [$yenile_id])->fetchAll(PDO::FETCH_ASSOC);

    $html = '';
    foreach ($value as $v){
        $html .= '<option value="'.$v['name'].'">'.$v['name'].'</option>';
    }

endif;


echo json_encode(array("form" => $form, "tags" => $tagarray,'type'=>$type,'type_param'=>$type_param,'value'=>$html,'matchvalue'=>$matchvalue));
ob_end_flush();