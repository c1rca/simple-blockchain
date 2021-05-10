<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="css/toastr.min.css" />

	<title>Alex's Blockchain Project</title>

	<style>
		.white {
			color: white;
		}
	</style>

</head>

<body>


<nav class="navbar navbar-expand-lg navbar-light bg-dark">
 

<a class="white" href="http://alexblockchainproject.com">Alexblockchain.com</a>


</nav>

	<div class="container" style="margin-top:75px">
		<div class="row">
			<div class="col-sm">
	

				<div class="card">
				  <h5 class="card-header">Add data to blockchain</h5>
				  <div class="card-body">
				    <h5 class="card-title">Enter message</h5>

					  <div class="form-group">
					    <textarea class="form-control" id="msg" rows="3"></textarea>
					  </div>

				    <a href="#" class="btn btn-primary" id="btnAdd">Add to blockchain</a>
				  </div>
				</div>


			</div>

			<div class="col-sm-9">
			
				<div class="card">
				  <h5 class="card-header">Data stored on blockchain <a href="index.php" class="btn btn-info" style="float:right">Table view</a></h5>
				  <div class="card-body overflow-scroll" id="bc-data-container">
				  	Loading...
				  </div>
				</div>


			</div>
		</div>
	</div>

</body>

<script src="js/jquery-3.6.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/toastr.min.js"></script>

<script>

$( document ).ready(function() {


	toastr.options = {
	    positionClass: 'toast-top-center'
	};


	let prev_json = false
	setInterval(function(){ 


		$.getJSON( "http://alexblockchainproject.com:8885/chain", function( chain_data ) {

			let json_data = JSON.stringify(chain_data, null, 4)


			if(json_data != prev_json && prev_json != false){
				let id = chain_data[chain_data.length-1]['index']
				toastr.info(`Block #${id} found.`)
			}

			$( "#bc-data-container" ).html( `<pre>${json_data}</pre>` );

			prev_json = json_data
		});


	}, 1000);

});


$( "#btnAdd" ).click(function() {

	let input = $('#msg').val();
	let blockData = JSON.stringify({"msg": input})

	$.ajax({
	  type: "POST",
	  contentType: "application/json;",
	  url: "http://alexblockchainproject.com:8885/newblock",
	  data: blockData,
	  dataType: "json",
	  success: toastr.success('Block added successfully.')

	});
  


  alert(msg_json);


});


</script>



</html>
