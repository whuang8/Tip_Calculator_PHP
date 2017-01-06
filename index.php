<html>
    <head>
    	<title>Tip Calculator</title>
    	<link rel="stylesheet" href="css/bootstrap.min.css">
    </head>
    <body>
    	<?php 
    		$subtotal = $percentage = $numPeople = 0.0;
   			$subtotalErr = $percentageErr = $savedSubtotal = $savedPercentage = $savedCustomPercentage = $savedNumPeople = "";

			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$savedSubtotal = $_POST["subtotal"];
				$savedPercentage = $_POST["percentage"];
				$savedCustomPercentage = $_POST["customPercentage"];
				$savedNumPeople = $_POST["numPeople"];

				if (empty($_POST["subtotal"])) {
					$subtotalErr = "Subtotal required";
				} elseif (floatval($_POST["subtotal"]) < 1) {
					$subtotalErr = "Subtotal must be numeric and greater than 0";
				} else {
					$subtotal = floatval($_POST["subtotal"]);
				}

				if (empty($_POST["percentage"])) {
					$percentageErr = "Tip percentage required";
				} else {
					if($_POST["percentage"] != "custom"){
						$percentage = floatval($_POST["percentage"]) * 0.01;
					}
					
				}

				if (empty($_POST["numPeople"])) {
					$peopleErr = "There should be at least 1 person paying for the bill";
				} else {
					$numPeople = floatval($_POST["numPeople"]);
				}

				if ($_POST["percentage"] == "custom") {
					if (empty($_POST["customPercentage"])) {
						$customErr = "Please specify a custom percentage";
					} else {
						$percentage = floatval($_POST["customPercentage"]) * 0.01;
					}
				}

			}
    	?>
    	<nav class="navbar navbar-inverse">
					  <div class="container-fluid">
					    <div class="navbar-header">
					      <a class="navbar-brand" href="#">Tip Calculator</a>
					    </div>
					  </div>
					</nav>
    	<div class="container">
    		<div class="row">
    			<?php if (!empty($subtotalErr) || !empty($percentageErr)) { ?>
    			<div class="col-lg-12">
    				<div class="alert alert-dismissible alert-danger">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Oh snap!</strong>
					  <ul>
					  	<?php if (!empty($subtotalErr)){ echo "<li>$subtotalErr</li>"; } ?>
					  	<?php if (!empty($percentageErr)){ echo "<li>$percentageErr</li>"; } ?>
					  	<?php if (!empty($peopleErr)){ echo "<li>$peopleErr</li>"; } ?>
					  	<?php if (!empty($customErr)){ echo "<li>$customErr</li>"; } ?>
					  </ul>
					</div>
    			</div>
    			<?php } ?>
    			<div class="col-lg-12">
    				<div class="well well-lg">
	    				<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					    	<div class="form-group <?php if (!empty($subtotalErr)) { echo "has-error"; } ?>">
						      <label for="subtotal" class="col-lg-2 control-label">Bill Subtotal $</label>
						      <div class="input-group">
							    
							    <input type="text" class="form-control" name="subtotal" value="<?php echo $savedSubtotal;?>">
							  </div>
						    </div>

						    <div class="form-group <?php if (!empty($percentageErr)) { echo "has-error"; } ?>">
						      <label class="col-lg-2 control-label">Tip Percentage</label>
						      <div class="col-lg-10">
						        <?php 
						    		$percentages = array('10', '15', '20', 'custom');
						    		foreach ($percentages as $chosenPercentage) {
						    			echo "<div class=\"radio\"><label>";
						    			if ($savedPercentage == $chosenPercentage) {
						    				echo "<input id=\"$chosenPercentage\" type=\"radio\" name=\"percentage\" value=\"$chosenPercentage\" checked> $chosenPercentage %  ";
						    			} else {
						    				echo "<input id=\"$chosenPercentage\" type=\"radio\" name=\"percentage\" value=\"$chosenPercentage\"> $chosenPercentage %  ";
						    			}
						    			echo "</label></div>";
						    		}
						    	?>
						      </div>
						    </div>
						    <div class="form-group <?php if (!empty($customErr)) { echo "has-error"; } ?>">
						      <label for="customPercentage" class="col-lg-2 control-label">Custom Percentage</label>
						      <div class="input-group">
							    <input type="number" min="0" max="100" class="form-control" name="customPercentage" value="<?php if($savedPercentage == "custom") {echo $savedCustomPercentage;}?>">
							  </div>
						    </div>
						    <div class="form-group <?php if (!empty($peopleErr)) { echo "has-error"; } ?>">
						      <label for="numPeople" class="col-lg-2 control-label">Number of People</label>
						      <div class="input-group">
							    <input type="number" min="1" class="form-control" name="numPeople" value="<?php if(empty($savedNumPeople)){echo "1";} else {echo $savedNumPeople;}?>">
							  </div>
						    </div>
						    <div class="form-group">
						      <div class="col-lg-10 col-lg-offset-2">
						        <button type="submit" class="btn btn-primary">Submit</button>
						      </div>
						    </div>
					    </form>
				    </div>
    			</div>
    		</div>
    		<?php 
    			if($subtotal != 0 && $percentage != 0) { 
	    			$tip = round($subtotal * $percentage, 2);
					$total = round($tip + $subtotal, 2);
					$tipPerPerson = round($tip / $numPeople, 2);
					$totalPerPerson = round($total / $numPeople, 2);
    		?>
    		<div class="row">
    			<div class="col-lg-6">
    				<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Tip</h3>
					  </div>
					  <div class="panel-body">
					    <h5><?php echo "\$$tip"; ?></h5>
					  </div>
					</div>
    			</div>
    			<div class="col-lg-6">
    				<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Total</h3>
					  </div>
					  <div class="panel-body">
					    <h5><?php echo "\$$total"; ?></h5>
					  </div>
					</div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-lg-6">
    				<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Tip per person</h3>
					  </div>
					  <div class="panel-body">
					    <h5><?php echo "\$$tipPerPerson"; ?></h5>
					  </div>
					</div>
    			</div>
    			<div class="col-lg-6">
    				<div class="panel panel-primary">
					  <div class="panel-heading">
					    <h3 class="panel-title">Total per person</h3>
					  </div>
					  <div class="panel-body">
					    <h5><?php echo "\$$totalPerPerson"; ?></h5>
					  </div>
					</div>
    			</div>
    		</div>
    		<?php } ?>
    	</div>
    	<script src="https://code.jquery.com/jquery-3.1.1.min.js"
  				integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
  				crossorigin="anonymous">
  		</script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
    </body>
</html>