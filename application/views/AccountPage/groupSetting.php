	<div id="main" class="col-sm-9 bg-danger">
		<p>メンバー編集</p>

          <form method="POST" id="form1">
            <div class="form-group">
              <div class="form-group">
                
                <div class="form-group">
                  <p>
                    <table id="emailTable" border="1">
                        <thead>
                            <tr>
                                <th>メールアドレス</th>
                                <th>名前</th>
                                <th>権限</th>
                                <th>選択</th>
                            </tr>
                        </thead>
                            <tbody>
                                
                                <?php foreach ($data as $value): ?>
                                    <tr>
                                        <td><?=$value['email']?></td>
                                        <td><?=$value['name']?></td>
                                        <td>
                                            <select name="selectBox[]">
                                                <?php
                                                $selectBox = array("選手", "管理者", "マネージャ");
                                                
                                                foreach($selectBox as $key =>$select){
                                                    
                                                    if(($key + 1) == $value['authorityNo']){
                                                        echo '<option value="'.($key + 1).'|'.$value['userNo'].'" selected>'. $select. '</option>';
                                                    }else{
                                                        echo '<option value="'.($key + 1).'|'.$value['userNo'].'">'. $select. '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="chk[]" value="<?=$value['userNo']?>">
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                  </table>
                  </p>
                </div>
              </div>
            </div>
            <input type="submit" class="btn btn-success pull-right" name="submitButton" value="メンバー削除"/>
            <input type="submit" class="btn btn-success pull-right" name="submitButton" value="メンバー権限変更"/>
          </form>
          
		</div>
	</div>
	
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
	
	<script>
        $(document).ready(function(){
            $('#emailTable').DataTable({
                responsive: true,
                autoFill: true,
                lengthChange: false,
                scrollY: 300,
                info: false,
                paging: false,
            });
        });
    </script>