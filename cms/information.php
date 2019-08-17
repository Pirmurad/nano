<?PHP
ob_start();
$path='../';
include_once "{$path}config/conf.php";
include_once 'pages/html_start.php';?>
<div id="wrapper">

    <?PHP include 'nav.php';?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?PHP
                if(isset($_GET['action']) && !empty($_GET['action'])){
                    $getcurrentaction=$_GET['action'];
                    if(in_array($getcurrentaction,array('edit'))){


                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            postextract(extract($_POST));
                            $error = array();
                            $mail = filter_var($mail,FILTER_VALIDATE_EMAIL);

                            if (!filter_var(($facebook), FILTER_VALIDATE_URL) === false) {
                                $facebook = htmlspecialchars(trim($facebook));
                            }else{
                                $facebook="";
                            }
                            if (!filter_var(($twitter), FILTER_VALIDATE_URL) === false) {
                                $twitter = htmlspecialchars(trim($twitter));
                            }else{
                                $twitter="";
                            }
                            if (!filter_var(($instagram), FILTER_VALIDATE_URL) === false) {
                                $instagram = htmlspecialchars(trim($instagram));
                            }else{
                                $instagram="";
                            }
                            if (!filter_var(($whatsapp), FILTER_VALIDATE_URL) === false) {
                                $whatsapp = htmlspecialchars(trim($whatsapp));
                            }else{
                                $whatsapp="";
                            }

                            if(count($error) > 0) {
                                session_create(['error'=>$error]);
                                redirect('info/edit/');
                            }

                            $data =	"`mail` = ?,`about` = ?,`address` = ?,`phone` = ?, `facebook` = ?, `twitter` = ?, `instagram` = ?, `whatsapp` = ?";

                            $sql =	[
                                $mail,$about,$address,$phone,$facebook,$twitter,$instagram,$whatsapp,1
                            ];

                            $updateinformation = update("`information`",$data,"`id` = ?",$sql);

                            if(!empty($updateinformation)) {
                                redirect('info/');
                            }
                            else {
                                $error['error'] = 'Problem baş verdi, informasiya dəyişilmədi !';
                                session_create(['error'=>$error]);
                                redirect('info/edit/');
                            }

                        }else{
                            $informationfetch = select("*","`information`")->fetch(PDO::FETCH_ASSOC);
                            ?>
                            <h1 class="page-header">Informasiya düzəliş et</h1>
                            <div class="row">
                                <div class="col-lg-12 p10 round_border_goster">
                                    <form action="" id="information_add_submit" method="POST">

                                        <?php
                                        if (!empty($_SESSION['success'])) {
                                            echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';

                                            unset($_SESSION['success']);
                                        }
                                        if (!empty($_SESSION['error'])) {
                                            echo '<div class="alert alert-warning">';
                                            echo '<ul class="list-group">';
                                            foreach ($_SESSION['error'] as $key=>$value) {
                                                echo '<li class="list-group-item">' . $value . '</li>';
                                            }
                                            echo '</ul>';
                                            unset($_SESSION['error']);
                                            echo '</div>';
                                        }
                                        ?>


                                        <div class="col-lg-12 p10">
                                            <div class="col-lg-4">
                                                <label for="mail"><span>Mail</span></label><br>
                                                <input type="text" class="form-control" name="mail" maxlength="100" id="mail" value="<?= $informationfetch['mail'];?>"/>
                                            </div>
                                            <div class="col-lg-8">
                                                <label for="address"><span>Ünvan</span></label><br>
                                                <input type="text" id="address" name="address" maxlength="200" class="form-control" value="<?= $informationfetch['address'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 p10">
                                            <div class="col-lg-4">
                                                <label for="phone"><span>Telefon</span></label><br>
                                                <input type="text" class="form-control" name="phone" id="phone" maxlength="100" value="<?= $informationfetch['phone'];?>"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="facebook"><span>Facebook</span></label><br>
                                                <input type="text" class="form-control" name="facebook" id="facebook" maxlength="100" value="<?= $informationfetch['facebook'];?>"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="twitter"><span>Twitter</span></label><br>
                                                <input type="text" class="form-control" name="twitter" id="twitter" maxlength="100" value="<?= $informationfetch['twitter'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 p10">
                                            <div class="col-lg-4">
                                                <label for="instagram"><span>Instagram</span></label><br>
                                                <input type="text" class="form-control" name="instagram" id="instagram" maxlength="100" value="<?= $informationfetch['instagram'];?>"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="whatsapp"><span>Whatsapp</span></label><br>
                                                <input type="text" class="form-control" name="whatsapp" id="whatsapp" maxlength="100" value="<?= $informationfetch['whatsapp'];?>"/>
                                            </div>
                                            <div class="col-lg-4">
                                                <label for="about"><span>Haqqında</span></label><br>
                                                <input type="text" id="about" name="about" maxlength="200" class="form-control" value="<?= $informationfetch['about'];?>"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 p10">
                                            <input type="submit" id="submit" name="submit" value="Dəyiş" class="btn btn-primary"/>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?PHP }
                    }
                }else{
                    ?>
                    <h1 class="page-header" style="float:left;"> Saytın məlumatları  | </h1><a type="button" href="info/edit/" class="btn btn-primary" style="position: relative;top: 10px;left: 12px;">Dəyişiklik Et</a>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Mövzu</th>
                                    <th>Məlumat</th>
                                </tr>
                                </thead>
                                <tbody>
                                <form action="" method="POST">
                                    <?PHP
                                    $informationquery=$db->query("SELECT * FROM information");
                                    $informationfetch=$informationquery->fetch(PDO::FETCH_ASSOC);

                                    echo    '<tr>'
                                        . '<td>Elektron Poçt</td>'
                                        . '<td>'.$informationfetch['mail'].'</td>'
                                        . '</tr>'
                                        . '<tr>'
                                        . '<td>Telefon</td>'
                                        . '<td>'.$informationfetch['phone'].'</td>'
                                        . '</tr>'
                                        . '<tr>'
                                        . '<td>Ünvan</td>'
                                        . '<td>'.$informationfetch['address'].'</td>'
                                        . '</tr>'
                                        . '<tr>'
                                        . '<td>Haqqında</td>'
                                        . '<td>'.$informationfetch['about'].'</td>'
                                        . '</tr>'
                                        . '<tr>'
                                        . '<td>Facebook</td>'
                                        . '<td>'.$informationfetch['facebook'].'</td>'
                                        . '</tr>'
                                        . '<tr>'
                                        . '<td>Twitter</td>'
                                        . '<td>'.$informationfetch['twitter'].'</td>'
                                        . '</tr>'
                                        . '<tr>'
                                        . '<td>Whatsapp</td>'
                                        . '<td>'.$informationfetch['whatsapp'].'</td>'
                                        . '</tr>'
                                        . '<tr>'
                                        . '<td>Instagram</td>'
                                        . '<td>'.$informationfetch['instagram'].'</td>'
                                        . '</tr>';
                                    ?>

                                </form>
                                </tbody>
                            </table>

                        </div>
                        <!-- /.col-lg-12 -->
                    </div>
                <?PHP } ?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<?PHP
include 'pages/html_end.php';
ob_end_flush();
?>