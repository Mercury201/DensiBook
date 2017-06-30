	<div id="main" class="col-sm-9 bg-danger">
		
		<div class="container">
		    <label>削除するグループを選択してください</label>
    	      <form action="" method="POST">
    	        <div class="form-group">
    	            
        	          <select class="form-control" name="delNo">
                    	<?php foreach ($data as $value): ?>
        				<option value="<?=$value['groupNo']?>"><?=$value['groupName']?></option>
        				<?php endforeach; ?>
        	          </select>
        	          
    	          <input type="submit" class="btn pull-left btn-success" value="削除"/>
    	       </div>
	      </form>
	    </div>
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"
	    >
	    </script>
	    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"
	    >
	    </script>
		
		</div>		
	</div>