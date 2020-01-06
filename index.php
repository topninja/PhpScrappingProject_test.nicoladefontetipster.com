<html>
<head>
<title>Football | Home</title>
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" href="bootstrap/css/font-awesome.css" />
<link rel="stylesheet" href="css/style.css" />
<link rel="icon" href="images/football-icon1.png" />
<script type="text/javascript">/* 
	document.addEventListener('scroll', function(event) {
		if (document.body.scrollHeight == document.body.scrollTop
				+ window.innerHeight) {
			getData(true);
		}
	}); */
</script>
</head>
<body onload="">
	<div class="header">
		<a href="index.php"><img src="images/logo3.png" alt="Logo" /></a>
	</div>
	<!-- Navbar Start-->
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed"
					data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
					aria-expanded="false">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse"
				id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="index.jsp"><img
							src="images/football-icon1.png" alt=""> Football</a></li>
				</ul>

			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav>
	<!-- Navbar End-->

	<div class="body">
		<div class="row betting">
			<div class="col-sm-3 football-title">
				<!-- <img src="images/football-icon1.png" alt="" class="football-image">
				Football -->
			</div>
			<div class="col-sm-9" style="padding-right: 0px;">
				<select style="width:200px;float: right;font-size:13px;height: 25px;" id="filter">
					<option value="0">All</option>
				 	<option value="1">Match Odds</option>
				  	<option value="2">Under/Over 1.5</option>
				  	<option value="3">Under/Over 2.5</option>
				  	<option value="4">Under/Over 3.5</option>
				  	<option value="5">Under/Over 4.5</option>
				</select>
			</div>
		</div>
		<div class="table-responsive">
			<table
				class="table table-resonsive table-bordered table-striped table-hover"
				id="betting-data-table" style="width: 1800px">
				<thead>
					<tr class="table-header1" style="line-height: 2px;">
						<th colspan="4"></th>
						<th colspan="7" id="match_odds">Match Odds</th>
						<th colspan="5" id="under1">Under/Over 1.5</th>
						<th colspan="5" id="under2">Under/Over 2.5</th>
						<th colspan="5" id="under3">Under/Over 3.5</th>
						<th colspan="5" id="under4">Under/Over 4.5</th>
					</tr>
					<tr class="table-header1">
						<th rowspan="2" colspan="2">Start Time</th>
						<th rowspan="2">Score</th>
						<th rowspan="2">Match Name</th>

						<th rowspan="2" id="match_odds_money">Matched Money</th>
						<th colspan="2" id="match_odds_1">1</th>
						<th colspan="2" id="match_odds_x">x</th>
						<th colspan="2" id="match_odds_2">2</th>
						
						<th rowspan="2" id="under1_money">Matched Money</th>
						<th colspan="2" id="under1_meno">Meno 1.5</th>
						<th colspan="2" id="under1_piu">Piu 1.5</th>
						
						<th rowspan="2" id="under2_money">Matched Money</th>
						<th colspan="2" id="under2_meno">Meno 2.5</th>
						<th colspan="2" id="under2_piu">Piu 2.5</th>
						
						<th rowspan="2" id="under3_money">Matched Money</th>
						<th colspan="2" id="under3_meno">Meno 3.5</th>
						<th colspan="2" id="under3_piu">Piu 3.5</th>
						
						<th rowspan="2" id="under4_money">Matched Money</th>
						<th colspan="2" id="under4_meno">Meno 4.5</th>
						<th colspan="2" id="under4_piu">Piu 4.5</th>
					</tr>
					<tr class="table-header2">

						<th class="heading-back" id="match_odds_back1">Back</th>
						<th class="heading-lay" id="match_odds_lay1">Lay</th>
						<th class="heading-back" id="match_odds_back2">Back</th>
						<th class="heading-lay" id="match_odds_lay2">Lay</th>
						<th class="heading-back" id="match_odds_back3">Back</th>
						<th class="heading-lay" id="match_odds_lay3">Lay</th>

						<th class="heading-back" id="under1_back1">Back</th>
						<th class="heading-lay" id="under1_lay1">Lay</th>
						<th class="heading-back" id="under1_back2">Back</th>
						<th class="heading-lay" id="under1_lay2">Lay</th>

						<th class="heading-back" id="under2_back1">Back</th>
						<th class="heading-lay" id="under2_lay1">Lay</th>
						<th class="heading-back" id="under2_back2">Back</th>
						<th class="heading-lay" id="under2_lay2">Lay</th>

						<th class="heading-back" id="under3_back1">Back</th>
						<th class="heading-lay" id="under3_lay1">Lay</th>
						<th class="heading-back" id="under3_back2">Back</th>
						<th class="heading-lay" id="under3_lay2">Lay</th>

						<th class="heading-back" id="under4_back1">Back</th>
						<th class="heading-lay" id="under4_lay1">Lay</th>
						<th class="heading-back" id="under4_back2">Back</th>
						<th class="heading-lay" id="under4_lay2">Lay</th>
					</tr>
				</thead>
			</table>
		</div>
	<div id="loading" style="text-align: center;">
				<img src="images/loading.gif" alt="Loading" height="100px" />
	</div>
		<footer>
			<p class="text">Match Odds | Under/Over 1.5 | Under/Over 2.5 |
				Under/Over 3.5 | Under/Over 4.5</p>

			<p>&copy; Copyright 2018. | betfairliveodds All Rights are
				Reserved. www.betfairliveodds.com</p>
		</footer>
	</div>
	<script src="bootstrap/js/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="js/custom.js"></script>
	<script>
		getData();
		// $(document).ready(function() {
			setInterval(function() {
				getData1();
			}, 3000);
		// });
		$('#filter').change(function(){
			switch($('#filter').val()){
				case '0': 
					showMatchOdds();
					showUnder1();
					showUnder2();
					showUnder3();
					showUnder4();
					$('#betting-data-table').css('width', '1900px');
					break;
				case '1': 
					showMatchOdds();
					removeUnder1();
					removeUnder2();
					removeUnder3();
					removeUnder4();
					$('#betting-data-table').css('width', 'auto');
					break;
				case '2':
					removeMatchOdds();
					showUnder1();
					removeUnder2();
					removeUnder3();
					removeUnder4();
					$('#betting-data-table').css('width', 'auto');
					break;
				case '3':
					removeMatchOdds();
					removeUnder1();
					showUnder2();
					removeUnder3();
					removeUnder4();
					$('#betting-data-table').css('width', 'auto');
					break;
				case '4':
					removeMatchOdds();
					removeUnder1();
					removeUnder2();
					showUnder3();
					removeUnder4();
					$('#betting-data-table').css('width', 'auto');
					break;
				case '5':
					removeMatchOdds();
					removeUnder1();
					removeUnder2();
					removeUnder3();
					showUnder4();
					$('#betting-data-table').css('width', 'auto');
					break;
			}
			getData1();
		});


		function removeMatchOdds(){
			
			$('#match_odds').css('display', 'none');
			
			$('#match_odds_money').css('display', 'none');
			$('#match_odds_1').css('display', 'none');
			$('#match_odds_x').css('display', 'none');
			$('#match_odds_2').css('display', 'none');

			$('#match_odds_back1').css('display', 'none');
			$('#match_odds_lay1').css('display', 'none');
			$('#match_odds_back2').css('display', 'none');
			$('#match_odds_lay2').css('display', 'none');
			$('#match_odds_back3').css('display', 'none');
			$('#match_odds_lay3').css('display', 'none');
		}
		function showMatchOdds(){
			
			$('#match_odds').css('display', 'table-cell');
			
			$('#match_odds_money').css('display', 'table-cell');
			$('#match_odds_1').css('display', 'table-cell');
			$('#match_odds_x').css('display', 'table-cell');
			$('#match_odds_2').css('display', 'table-cell');

			$('#match_odds_back1').css('display', 'table-cell');
			$('#match_odds_lay1').css('display', 'table-cell');
			$('#match_odds_back2').css('display', 'table-cell');
			$('#match_odds_lay2').css('display', 'table-cell');
			$('#match_odds_back3').css('display', 'table-cell');
			$('#match_odds_lay3').css('display', 'table-cell');
		}

		function removeUnder1(){
			
			$('#under1').css('display', 'none');
			
			$('#under1_money').css('display', 'none');
			$('#under1_meno').css('display', 'none');
			$('#under1_piu').css('display', 'none');

			$('#under1_back1').css('display', 'none');
			$('#under1_lay1').css('display', 'none');
			$('#under1_back2').css('display', 'none');
			$('#under1_lay2').css('display', 'none');
		}
		function showUnder1(){
			
			$('#under1').css('display', 'table-cell');
			
			$('#under1_money').css('display', 'table-cell');
			$('#under1_meno').css('display', 'table-cell');
			$('#under1_piu').css('display', 'table-cell');

			$('#under1_back1').css('display', 'table-cell');
			$('#under1_lay1').css('display', 'table-cell');
			$('#under1_back2').css('display', 'table-cell');
			$('#under1_lay2').css('display', 'table-cell');
		}

		function removeUnder2(){
			
			$('#under2').css('display', 'none');
			
			$('#under2_money').css('display', 'none');
			$('#under2_meno').css('display', 'none');
			$('#under2_piu').css('display', 'none');

			$('#under2_back1').css('display', 'none');
			$('#under2_lay1').css('display', 'none');
			$('#under2_back2').css('display', 'none');
			$('#under2_lay2').css('display', 'none');
		}

		function showUnder2(){
			
			$('#under2').css('display', 'table-cell');
			
			$('#under2_money').css('display', 'table-cell');
			$('#under2_meno').css('display', 'table-cell');
			$('#under2_piu').css('display', 'table-cell');

			$('#under2_back1').css('display', 'table-cell');
			$('#under2_lay1').css('display', 'table-cell');
			$('#under2_back2').css('display', 'table-cell');
			$('#under2_lay2').css('display', 'table-cell');
		}

		function removeUnder3(){
			
			$('#under3').css('display', 'none');
			
			$('#under3_money').css('display', 'none');
			$('#under3_meno').css('display', 'none');
			$('#under3_piu').css('display', 'none');

			$('#under3_back1').css('display', 'none');
			$('#under3_lay1').css('display', 'none');
			$('#under3_back2').css('display', 'none');
			$('#under3_lay2').css('display', 'none');
		}

		function showUnder3(){
			
			$('#under3').css('display', 'table-cell');
			
			$('#under3_money').css('display', 'table-cell');
			$('#under3_meno').css('display', 'table-cell');
			$('#under3_piu').css('display', 'table-cell');

			$('#under3_back1').css('display', 'table-cell');
			$('#under3_lay1').css('display', 'table-cell');
			$('#under3_back2').css('display', 'table-cell');
			$('#under3_lay2').css('display', 'table-cell');
		}


		function removeUnder4(){
			
			$('#under4').css('display', 'none');
			
			$('#under4_money').css('display', 'none');
			$('#under4_meno').css('display', 'none');
			$('#under4_piu').css('display', 'none');

			$('#under4_back1').css('display', 'none');
			$('#under4_lay1').css('display', 'none');
			$('#under4_back2').css('display', 'none');
			$('#under4_lay2').css('display', 'none');
		}

		function showUnder4(){
			
			$('#under4').css('display', 'table-cell');
			
			$('#under4_money').css('display', 'table-cell');
			$('#under4_meno').css('display', 'table-cell');
			$('#under4_piu').css('display', 'table-cell');

			$('#under4_back1').css('display', 'table-cell');
			$('#under4_lay1').css('display', 'table-cell');
			$('#under4_back2').css('display', 'table-cell');
			$('#under4_lay2').css('display', 'table-cell');
		}


	</script>
</body>
</html>