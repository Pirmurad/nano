<?php
ob_start();
$path = '../';
include "{$path}config/conf.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"):
    postextract(extract($_POST));


    $modal = '';
    $modal .= '            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Yeni dəyər əlavə et</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                      <form action="#" method="post">
                        <div class="modal-body">
                                <div class="form-group">
                                    <label for="name" class="col-form-label">Adı:</label>
                                    <input required type="text" class="form-control" id="valueName" name="name">
                                    <input type="hidden" class="form-control" id="id" name="id" value="'.$id.'">
                                </div>
                          
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary saveNewValue">Yadda saxla</button>
                        </div>
                          </form>';
endif;

echo json_encode(array("modal" => $modal ));
ob_end_flush();