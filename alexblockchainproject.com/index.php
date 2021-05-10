<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="css/toastr.min.css" />
	<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>



	<title>Alex's Blockchain Project</title>

	<style>
	.white {
	color: white;
	}

	td {
	max-width: 70px;
	text-overflow: ellipsis;
	white-space: nowrap;
	overflow: hidden;
	}

	.td-min{
	width: 10px
	}

	</style>

</head>

<body>


<nav class="navbar navbar-expand-lg navbar-light bg-dark">
 

	<a class="white" href="http://alexblockchainproject.com">Alexblockchain.com</a>


</nav>

	<div class="container" style="margin-top:75px">
		<div class="row">
			<div class="col-lg-3">
	

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

			<div class="col-lg-9">
			
				<div class="card">
				  <h5 class="card-header">Data stored on blockchain <a href="raw.php" class="btn btn-success" style="float:right">View Raw Data</a></h5>
				  <div class="card-body overflow-scroll" id="bc-data-container">
					<table class="table table-striped table-bordered table-hover" id="example" border="1">
					  <thead>
					    <tr>
					      <th class="td-min">Index</th>
					      <th>Message</th>
					      <th>Previous Hash</th>
					      <th>Timestamp</th>
					    </tr>
					  </thead>

					  <tbody>

					  </tbody>

					</table>
				  </div>
				</div>


			</div>
		</div>
	</div>

</body>

<script type="text/javascript"  src="js/jquery-3.6.0.min.js"></script>
<script type="text/javascript"  src="js/bootstrap.min.js"></script>
<script type="text/javascript"  src="js/toastr.min.js"></script>
<script type="text/javascript" src="js/datatables.min.js"></script>

<script>

$( document ).ready(function() {


toastr.options = {
    positionClass: 'toast-top-center'
};

let dt = $('#example').DataTable({paging: false, order:"0 desc"});


	let prev_json = false
	setInterval(function(){ 


		$.getJSON( "http://alexblockchainproject.com:8885/chain", function( chain_data ) {



			// chain_data.forEach(block => $('#example').DataTable().row.add([
			//   block.index, block.message, block.prev_hash, block.timestamp
			// ]).draw());


			let json_data = JSON.stringify(chain_data, null, 4)

			if(json_data != prev_json){

				dt.clear();

				const reversed = chain_data.reverse();
				console.log(reversed)

				function formatDate(date){
					var dt = new Date(date*1000);
					return dt
				}
				//Date(unix_timestamp * 1000).format('h:i:s')

				reversed.forEach(block => $('#example').DataTable().row.add([
				  block.index, block.message, block.prev_hash, formatDate(block.timestamp)
				]).draw());	
			}

			if(json_data != prev_json && prev_json != false){
				let id = chain_data[0]['index']
				toastr.info(`Block #${id} found.`)
			}

			//$( "#bc-data-container" ).html( `<pre>${json_data}</pre>` );

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
