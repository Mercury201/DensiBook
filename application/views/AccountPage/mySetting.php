<div id="main" class="col-sm-9 bg-danger">
    <div class="container">
    		<?php 
    			if(isset($update)){
    				echo '更新完了';
    			}
            ?>
    		<form  name="form1" action="" method="POST">
        		<div class="form-group">
            		<label>name</label>
            		<input type="text" name="name" class="form-control"  value=<?=$name?>>
        		</div>
        		<div class="form-group">
            		<label>birthday</label>
            		<input type="date" name="birthday" class="form-control"value=<?=$birthday?>>
        		</div>

        		<div class="form-group">
            		<label>email</label>
            		<?php 
            			if(isset($mailError)){
            				echo '<label>'. $mailError .'</label>';
            			}
            		?>
            		<input type="email" name="email" class="form-control"value=<?=$email?>>
        		</div>

        		<div class="form-group">
            		<label>password</label>
            		<input type="password" name="password" class="form-control"value=<?=$password?>>
        		</div>

        		<div class="form-group">
            		<label>school</label>
            		<input type="text" name="schoolName" class="form-control" value=<?=$schoolName?>>
        		</div>

        		<div class="form-group">
	            <label>
	              利き投げを選択:
	            </label>
	            <select class="form-control" name="throwHanded">
	              <option value="右">
	                右投げ
	              </option>
	              <option value="左" <?php if($throwHanded == "左") echo 'selected';?>>
	                左投げ
	              </option>
	            </select>
	          	</div>

        		<div class="form-group">
	            <label>
	              利き打ちを選択:
	            </label>
	            	<select class="form-control" name="battingHanded">
		              <option value="右">
		                右打ち
		              </option>
		              <option value="左" <?php if($battingHanded == "左") echo 'selected';?> >
		                左打ち
		              </option>
	            	</select>
	         	</div>
	         	
	         	<div type="hidden"
				    id="php-val"
				    style="display:none;"
				    data-val="<?=htmlspecialchars($password, ENT_QUOTES, 'UTF-8')?>">
	         	</div>

        		<button type="submit" class="btn btn-success btn-sm" onclick="return submitClick();">変更</button>
    		</form>
		</div>
	</div>		
</div>

				<script type="text/javascript">
	         	
	         	function submitClick(){
	         		var result = prompt("変更前のパスワードを入力してください","");
	         		var pass = document.getElementById('php-val');
					if(result){
						
						console.log(" OK が押された:" + result);
						
						if(document.container.form1.password.value == pass){
							
							return true;
						}else{
							return false;
						}
						
					}else{
					console.log(" CANCEL");
					return false;
					}
	         	}
				</script>
