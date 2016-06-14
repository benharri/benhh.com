<?php include_once "ben_header.php"; ?>


  <div class="container" role="main">
  <!-- main content -->
    <div class="jumbotron"><h1>Ben Harris</h1></div>

    <div id="homecarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#homecarousel" data-slide-to="0" class="active"></li>
        <li data-target="#homecarousel" data-slide-to="1"></li>
        <li data-target="#homecarousel" data-slide-to="2"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="<?=$dir?>inc/img/mackinac.jpg" alt="Mackinac">
          <div class="carousel-caption">
            <h3>Mackinac</h3>
            <p>Mackinac Island, Michigan</p>
          </div>
        </div>

        <div class="item">
          <img src="<?=$dir?>inc/img/deadriver.jpg" alt="Dead River">
          <div class="carousel-caption">
            <h3>Dead River</h3>
            <p>Marquette, Michigan</p>
          </div>
        </div>

        <div class="item">
          <img src="<?=$dir?>inc/img/lighthouse.jpg" alt="Lighthouse">
          <div class="carousel-caption">
            <h3>Lighthouse</h3>
            <p>Marquette, Michigan</p>
          </div>
        </div>

      </div>

      <!-- Left and right controls -->
      <a class="left carousel-control" href="#homecarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#homecarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>


  </div>

  <?php
  
  include_once "ben_footer.php";