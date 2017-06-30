<form id="form" method="post" >
  <input type="submit" name="submit" />
</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>

<script>
         $("#form").submit(function(event) {
             
            //var form = $('#form');
            event.preventDefault();
            
            var hostUrl = "https://ci-crud-mercury201.c9users.io/index.php/TestKojima/TestPost";
            var ary = [  [92, 88, 64, 86],   [78, 92, 96, 81],  [68, 56, 84, 70] ];
            var aryJson = JSON.stringify(ary);
            
            $.ajax({
                url: hostUrl,
                dataType: 'html',
                data: aryJson,
                timeout:10000,
                success: function(data) {
                              alert('ok');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                             //alert("error");
                             alert(textStatus + " ||| " + errorThrown.message);
                }
              });
    });
</script>

