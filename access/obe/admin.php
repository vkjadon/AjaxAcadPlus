<?php
session_start();
include('openObeDb.php');
require('../php_function.php');
include('../phpFunction/onlineFunction.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Outcome Based Education : ClassConnect</title>
	<?php require("../css.php"); ?>
</head>

<body>
<?php require("obeAdminTopBar.php"); ?>
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-2 m-0 p-0">
				<a href="#" class="btn btn-danger btn-block btn-square">Institution</a>
			</div>
			<div class="col-2 p-0">
				<a href="#" class="btn btn-danger btn-block btn-square btn-lg">Courses</a>
			</div>
			<div class="col-2"></div>
			<div class="col-2"></div>
			<div class="col-2"></div>
		</div>
		<div class="row mt-2">
			<div class="col-2">
				<div class="list-group list-group-mine ud-2" id="list-tab" role="tablist">
					<a class="list-group-item list-group-item-action active ud" id="list-ud-list" data-toggle="list" href="#list-ud" role="tab" aria-controls="ud"> Upload Data </a>
					<a class="list-group-item list-group-item-action coas" id="list-coas-list" data-toggle="list" href="#list-coas" role="tab" aria-controls="coas"> COA Strategy </a>
					<a class="list-group-item list-group-item-action coa" id="list-coa-list" data-toggle="list" href="#list-coa" role="tab" aria-controls="coa"> CO Attainment </a>
				</div>
			</div>
			<div class="col-10">
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane show active" id="list-ud" role="tabpanel" aria-labelledby="list-ud-list">
						<div class="row">
							<div class="col-3">
								<input type="hidden" id="action" name="action">
								<button type="submit" class="btn btn-danger btn-block btn-sm submitAddTestForm">Upload Program</button>
								<button class="btn-warning btn-sm uploadSubject"><i class="fa fa-upload"></i></button>
								<button type="submit" class="btn btn-danger btn-block btn-sm submitAddTestForm">Upload Subject</button>
								<button type="submit" class="btn btn-danger btn-block btn-sm submitAddTestForm">Upload PO </button>
								<button type="submit" class="btn btn-danger btn-block btn-sm submitAddTestForm">Upload CO</button>
								<button type="submit" class="btn btn-danger btn-block btn-sm submitAddTestForm">Upload CO-PO Map</button>
							</div>
							<div class="col-9 mt-1 mb-1" id="programList">
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="list-coas" role="tabpanel" aria-labelledby="list-coas-list">
						<div class="row">
							<div class="col-5 mt-1 mb-1">
								<div class="card">
									<div class="card-body mt-2 py-1">
										<p id="questionHeading"></p>
										<!-- <h5>Section : <span id="selectedSection">1</span></h5> -->
										<textarea rows="4" class="content" id="question" name="question"></textarea>
										<input type="hidden" id="actionCode" name="actionCode">
										<button class="btn btn-secondary btn-square-sm addQuestion">Add New Question</button>
										<button class="btn btn-warning btn-square-sm showQuestionLibrary">Question Library</button>
										<button class="btn btn-info btn-square-sm showTestQuestion"> Test Question</button>
									</div>
								</div>
							</div>
							<div class="col-7 mt-1 mb-1">
								<p class="showActiveQuestion"></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
<!-- MDB -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.tiny.cloud/1/xjvk0d07c7h90fry9yq9z0ljb019ujam91eo2jk8uhlun307/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
	tinymce.init({
		selector: 'vkj',
		plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		toolbar_mode: 'floating',
		height: "320",
	});

	$(document).ready(function() {
		$('[data-toggle="popover"]').popover();
		$('[data-toggle="tooltip"]').tooltip();

		$(document).on('click', '.uploadSubject', function() {
			//$.alert("Session From");
			var program = $(this).attr("data-program");
			var batch = $(this).attr("data-batch");
			$('#modal_title').text('Upload Subject');
			$('#program').val(program);
			$('#batch').val(batch);
			$('#button_action').show().val('Update Subject');
			$('#action').val('uploadSubject');
			$('#formModal').modal('show');
		});

		$(document).on('submit', '#upload_csv', function(event) {
			event.preventDefault();
			var formData = $(this).serialize();
			$('#subjectList').hide();
			$.alert(formData);
			// action and test_id are passed as hidden
			$.ajax({
				url: "uploadSubjectSql.php",
				method: "POST",
				data: new FormData(this),
				contentType: false, // The content type used when sending data to the server.  
				cache: false, // To unable request pages to be cached  
				processData: false, // To send DOMDocument or non processed data file it is set to false  
				success: function(data) {
					//alert("List "+data);
					$("#subjectList").hide();
					$('#uploaded_data').html(data);
					var y = $("#batch").val();
					var z = $("#specialization_name").val();

					subjectList(x, y, z);
				}
			})
		});


	});
</script>
<!-- Modal Section-->

<div class="modal" id="formModal">
	<div class="modal-dialog modal-md">
		<form id="upload_csv">
			<div class="modal-content">

				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title" id="modal_title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div> <!-- Modal Header Closed-->

				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<div class="row">
							<input type="file" name="csv_upload" />
						</div>
					</div>
				</div> <!-- Modal Body Closed-->
				<!-- Modal footer -->
				<div class="modal-footer">
					<input type="hidden" name="program_id" id="program_id" />
					<input type="hidden" name="batch_id" id="batch_id" />
					<input type="hidden" name="inst_id" id="inst_id" />
					<input type="hidden" name="action" id="action" />
					<input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" />
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div> <!-- Modal Footer Closed-->
			</div> <!-- Modal Conent Closed-->
		</form>
	</div> <!-- Modal Dialog Closed-->
</div> <!-- Modal Closed-->

</html>