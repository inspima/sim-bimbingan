$(function () {
	$('.datatable').each(function(_){
		$(this).DataTable();
	});
	$('.datatable-report').each(function(_){
		$(this).DataTable({
			'paging': true,
			'lengthChange': true,
			"lengthMenu": [[50, 100, -1], [ 50,100, "All"]],
			'searching': true,
			'ordering': true,
			'info': true,
			'autoWidth': true,
		});
	});
	$('#example1').DataTable();
	$('#example2').DataTable({
		'paging': true,
		'lengthChange': false,
		'searching': false,
		'ordering': true,
		'info': true,
		'autoWidth': false
	});

	$('#datatable-export').DataTable({
		'paging': true,
		'ordering': true,
		'info': true,
		'dom': 'Bfrtip',
		'buttons': [
			'excel'
		]

	});

	//Date picker
	$('#datepicker').datepicker({
		format: 'dd/mm/yyyy',
		autoclose: true
	})
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true
	})


	//Timepicker
	$('.timepicker').timepicker({
		showMeridian: false,
		defaultTime:false
	})

	//Initialize Select2 Elements
	$('.select2').select2({
		allowClear: true
	});

	$("#btn-submit-confirm-persetujuan").click(function (event) {
		event.preventDefault();
		var r = confirm("Apakah anda yakin melakukan ini!");
		if (r == true) {
			if($('#nilai').val()!=''&&$('#hasil').val()!=''){
				$("form").submit();
			}else{
				swal("Gagal", "Mohon Periksa isian anda, nilai dan hasil wajib diisi", "error");
			}

		} else {
			return false;
		}
	});

	$("#btn-submit-confirm").click(function (event) {
		event.preventDefault();
		var r = confirm("Apakah anda yakin melakukan ini!");
		if (r == true) {
			$("form").submit();
		} else {
			return false;
		}
	});
	$('form').submit(function (e) {
		if ($(':submit').text().trim() == 'Simpan') {
			$(':submit').attr('disabled', true);
		}
	});
	$('.text-editor-bootstrap').wysihtml5({
		toolbar: {
			"font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
			"emphasis": true, //Italics, bold, etc. Default true
			"link": false, //Button to insert a link. Default true
			"lists": {
				"outdent":false,
				"indent":false
			}, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
			"image": false, //Button to insert an image. Default true,
			"color": false
		}//Button to change color of font
	});
});


function hanyaAngka(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}
