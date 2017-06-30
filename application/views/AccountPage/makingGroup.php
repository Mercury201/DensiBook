
	<div id="main" class="col-sm-9 bg-danger">
		<p>グループ作成</p>

          <form method="POST" id="form1">
            <div class="form-group">
              <label>
                グループ名を指定してください
              </label>
              <input type="text" class="form-control" name="groupName" id="groupName" required/>
              <div class="form-group">
                <label>
                  招待する人のemailアドレスを入力してください。
                </label>
                <input type="text" class="form-control" name="email" id= "email"/>
                
                <p>
                  <input type="button" class="btn btn-info" value="追加" id="insertButton"/>
                  <input type="button" class="btn btn-info" value="削除" id="removeButton"/>
                </p>
                
                <div class="form-group">
                  
                  <table id="emailTable">
                    <tr>
                       <th>招待するメールアドレス</th>
                    </tr>
                    
                  </table>
                </div>
              </div>
            </div>
            <input type="submit" class="btn btn-success pull-right" />
          </form>
          
		</div>
	</div>
	
	 <script type="text/javascript" src="<?=base_url('js/jquery.validate.js')?>"></script>
	 <script>
 
      //jquery準備
      $(document).ready(function(){
        
        // 最後の行に追加
        $( "#insertButton" ).click(function () {
          
          //テーブル取得
          var table = $("#emailTable tr");
          
          //メアドが既に登録されているか
          var isEmal = false;
          for(var i=0, k=table.length; i<k; i++){
            if($("#email").val() == $("#emailTable td").eq(i).text() ){
              isEmal = true;
              break;
            }
          }
          
          if(isEmal){
          //ある
          alert('既に同じメールアドレスがあります。');
          
          //ない
          }else{
            
            //リストに登録
            $('#emailTable').append('<tr><td>'+ $('#email').val() +'</td></tr>' );
            
            //hiddenに登録
            $('<input>').attr({
              type: 'hidden',
              id: 'emaiList',
              name: 'emailList[]',
              value: $("#email").val()
            }).appendTo('#form1');
          }
         
        });
        
        // 最後の行を削除
        $( "#removeButton" ).click(function () {
        $("#emailTable td").eq(- 1).remove();
        });
        
        //メールアドレスのvalidation
        $("#form1").validate({
          rules: {
            groupName: {required: true},
            email: {email: true}
          },
          messages: {
            groupName: {required: "※グループ名が空欄です。"},
            email: {required: "※メールアドレスが空欄です。", email: "※正しいメールアドレスを入力してださい。"}
          }
        });
        
        //ここに処理が正しいときボタンが押せるようにする
        // if($('#form1').valid() != true){
        //   $('#insertButton').prop("disabled", true);
        // }else{
        //   $('#insertButton').prop("disabled", false);
        // }
        
        
        //navを取得し、新しく作るグループがダブってないか判別
        //groupNameが変更されたタイミング
        $("#groupName").change(function(){
          
          var navList = $("#navList li");
        
          //メアドが既に登録されているか
          var isGroupName = false;
          for(var i=0, k=navList.length; i<k; i++){
            if($("#groupName").val() == navList.eq(i).text() ){
              isGroupName = true;
              break;
            }
          }
          
          //ある
          if(isGroupName){
          
          alert('既に同じグループがあります。');
          $("#groupName").val("");
          
          //ない
          }else{
            
            //特に処理なし
          }
          
        });
       
        
      });
	  
	  
	 </script>