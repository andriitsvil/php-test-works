<html>
  <head>
    <title>test check</title>
  </head>
  <body>
  <form method="post" class="form">
    <?php
      $n = 35;
      $percentage = 100/$n;
      $array = $_POST;
      $checked = '';
      for ($i = 1; $i <= $n; $i++){
          if(isset($array[$i])){
            $checked = 'checked';
          }else{
            $checked = '';
          }
          ?>
          <label>
              <input type="checkbox"
                     name="<?=$i?>"
                     <?=$checked?>>
              задание №<?=$i ?>
          </label>
       <?php
      }
      $count = count($array);
      $width = round($count * $percentage,1);
    ?>
  </form>
  <form action="" method="get" class="reset">
      <input type="hidden" name="reset" value="true">
      <input type='submit' value="clear">
  </form>
  <pre>percents: <?=$width?>%</pre>
  <div class="wrt">
    <div class="inside" style="width: <?=$width?>%"></div>
  </div>
  <style>
      body{
          font-family: monospace, monospace;
      }
      .wrt{
          width: 200px;
          height: 20px;
          border: 2px solid #000;
      }
      .inside{
          height: 100%;
          background-color: #0d152a;
      }
      label{
          width: 200px;
          display: inline-block;
          padding: 10px;
          border: 1px solid #2ecc71;
          margin: 2px;
      }
  </style>
  <script
      src="https://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous">
  </script>
  <script>
       $("input[type='checkbox']").click(function() {
           $(".form").submit();
       });
       $(".form").submit(function() {
           event.preventDefault();
           var o = $(".form").serialize();
           $.ajax({
               type: "POST",
               url: "/",
               data: o
           })
      });
       $('.reset').submit(function () {
           $(".form")[0].reset()
           //event.preventDefault();
           var r = $(".reset").serialize();
           $.ajax({
               type: "GET",
               url: "/",
               data: r
           })
       })
  </script>
  </body>
</html>


