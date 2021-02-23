$(function () {
	$('#example1').DataTable()
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

	//Initialize Select2 Elements
	$('.select2').select2({
		allowClear: true
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
});


function hanyaAngka(evt) {
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
	return true;
}
