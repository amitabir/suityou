<?php
	include("header.php");
?>   
<style>
<?php include 'carousel.css'; ?>
</style>
<div class="container">
	<div class="row">
    <div class="col-lg-12" align="center">
        <h4 class="page-header">
            <img src="images/Banner.png"/ height="84" width="228"> 
			<p>Simply Suits You</p>
        </h4>
    </div>
	</div>
	<div class="row">
       <div class="col-lg-12">
		 <!-- Carousel   ================================================== -->
		 
		    <div id="myCarousel" class="carousel slide" data-ride="carousel" style="width: 800px; margin: 15 auto">
		      <!-- Indicators -->
		      <ol class="carousel-indicators">
		        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		        <li data-target="#myCarousel" data-slide-to="1"></li>
		        <li data-target="#myCarousel" data-slide-to="2"></li>
		        <li data-target="#myCarousel" data-slide-to="3"></li>
		      </ol>
		      <div class="carousel-inner" role="listbox">
		        <div class="item active">
		          <img class="first-slide" src="images/indexPage/shopmen.jpg" alt="Shop Men">
		          <div class="container">
		            <div class="carousel-caption">
		              <h1>Shop Men</h1>
		              <p><a class="btn btn-lg btn-primary" href="shop_entrance.php?gender=male" role="button">Enter</a></p>
		            </div>
		          </div>
		        </div>
		        <div class="item">
		          <img class="second-slide" src="images/indexPage/shopwomen.jpg" alt="Shop Women">
		          <div class="container">
		            <div class="carousel-caption">
		              <h1>Shop Women</h1>
		              <p><a class="btn btn-lg btn-primary" href="shop_entrance.php?gender=female" role="button">Enter</a></p>
		            </div>
		          </div>
		        </div>
		        <div class="item">
		          <img class="third-slide" src="images/indexPage/matches.jpg" alt="Matches">
		          <div class="container">
		            <div class="carousel-caption">
		              <h1 style="text-shadow: black 0.2em 0.0em 0.2em;">Match</h1>
		              <p style="text-shadow: black 0.2em 0.0em 0.2em;">Match top to bottom to win coupons</p>
		              <p><a class="btn btn-lg btn-primary" href="matching.php" role="button">Start</a></p>
		            </div>
		          </div>
		        </div>
		        <div class="item">
		          <img class="forth-slide" src="images/indexPage/trends.jpg" alt="Trends">
		          <div class="container">
		            <div class="carousel-caption">
		              <h1 style="text-shadow: black 0.2em 0.0em 0.2em;">Trends</h1>
		              <p style="text-shadow: black 0.2em 0.0em 0.2em;">See the latest best matches that we have found for you</p>
		              <p><a class="btn btn-lg btn-primary" href="trends.php" role="button">Enter</a></p>
		            </div>
		          </div>
		        </div>
		      </div>

		      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
		        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		        <span class="sr-only">Previous</span>
		      </a>
		      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
		        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		        <span class="sr-only">Next</span>
		      </a>
		    </div>
			<!-- /.carousel -->
		</div>
	</div>
	
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-check"></i>Shop</h4>
                </div>
                <div class="panel-body">
                    <p>Come and see our supplies from top designers all around the world, waiting just for you. The clothes available on this site are guaranteed to be of the best possible quality and top standards. </p>
					<p> Found yourself a pair of pants? Well great, you can see all the matching shirts according to our users! Never again have a hard time deciding what to wear. </p>
                    <a href="shop_entrance.php?gender=male" class="btn btn-primary">Men</a> <a href="shop_entrance.php?gender=female" class="btn btn-primary">Women</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-gift"></i> Mathces</h4>
                </div>
                <div class="panel-body">
                    <p>Join our community and help rate the matches to help everyone decide what to wear! All you need to do is to rate the matches you found most appealing, and let our algorithms do the rest of the job. </p>
					<p> The more you rate - the more you earn! Keep on rating and see your coupon meter rise - when it gets to 100 points - you win a discount! So what are you waiting for?</p>
                    <a href="matching.php" class="btn btn-primary">Rate & Earn Coupons</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-compass"></i> Trends</h4>
                </div>
                <div class="panel-body">
                    <p>Our Sophisticated algorithms are working behind the scene to give you the ultimate shopping experience. We constantly seek for new trends according to the users ratings, and find new matches that just fit! </p>
					<p> Come and check the hottest trends waiting just for you, and help us getting even better by rating the new matches. </p>
                    <a href="trends.php" class="btn btn-primary">Check Trends</a>
                </div>
            </div>
        </div>
    </div>
</div>
	
	
  </body>
</html>