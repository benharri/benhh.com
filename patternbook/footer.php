
    </div>
    <br>

    <footer class="footer">
      <div class="container">
        <p class="text-muted"><a href="<?=$dir?>">CS326 Pattern Book</a> - <a href="http://euclid.nmu.edu/~benharri">Ben Harris</a></p>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="../inc/js/bootstrap.min.js"></script>
    <script src="../inc/js/bs3typeahead.js"></script>
    <script>
    $(document).ready(function(){
      $("#searchbox").typeahead({
        source: [<?php foreach($menu as $grp) foreach($grp as $name => $h) echo '{name:"'.$name.'",href:"'.$h.'"},';?>],
        updater: function(item){window.location = item.href;}
      });
    });
    </script>

</body>
</html>