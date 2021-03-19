<div id='loading'>loading...</div>
<div class="row">
	<div class="col-xs-12">
		<div id="script-error" class="callout callout-danger">
			<h4>Error</h4>
			<p>Gagal Mendapatkan data Jadwal</p>
		</div>
		<div class="box">
			<div class="box-header">
				<h3 class="box-title"><?= $title ?> - <?= $subtitle ?></h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body no-padding">
				<!-- THE CALENDAR -->
				<div id="calendar"></div>
			</div>
			<!-- /.box-body-->
		</div>
	</div>
	<div class="modal fade" id="modal-ujian">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-gray">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span></button>
					<h3 class="modal-title">Info Ujian</h3>
				</div>
				<div class="modal-body" id="modal-ujian-content">
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</div>
<style>
	#script-error {
		display: none;
	}

	#loading {
		display: none;
		position: absolute;
		top: 10px;
		right: 10px;
	}
</style>
<!-- fullCalendar -->
<link rel="stylesheet" href="<?php echo base_url() ?>assets/template/backend/bower_components/fullcalendar/dist/fullcalendar.min.css">
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url() ?>assets/template/backend/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/template/backend/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
<script src="<?php echo base_url() ?>assets/template/backend/bower_components/moment/moment.js"></script>
<script src="<?php echo base_url() ?>assets/template/backend/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
<script>
	$(function () {


		/* initialize the calendar
		 -----------------------------------------------------------------*/
		//Date for the calendar events (dummy data)
		var date = new Date()
		var d = date.getDate(),
				m = date.getMonth(),
				y = date.getFullYear()
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			buttonText: {
				today: 'today',
				month: 'month',
				week: 'week',
				day: 'day'
			},
			//Random default events
			events: {
				url: '/api/jadwal/get-data-kalender',
				failure: function () {
					document.getElementById('script-warning').style.display = 'block'
				}
			},
			eventClick: function (info) {
				$('#modal-ujian').modal('show');
				$.ajax({
					url: "/api/jadwal/get-detail/" + info.id+'/'+ info.type,
					beforeSend: function () {
						$('#modal-ujian-content').html('<p><b>Loading Data....</b></p>');
					},
					success: function (data) {
						var html='Kegiatan : <br/><b>'+data.kegiatan+'</b><hr class="divider-line-semi-bold"/>Nama : <br/><b>'+data.nama+'</b><hr class="divider-line-semi-bold"/>Nim : <br/><b>'+data.nim+'</b><hr class="divider-line-semi-bold"/>Judul : <br/><b>'+data.judul+'</b><hr class="divider-line-semi-bold"/>Tanggal : <br/><b>'+data.tanggal+'</b><hr class="divider-line-semi-bold"/>Waktu : <br/><b>'+data.waktu+'</b><hr class="divider-line-semi-bold"/>Tempat : <br/><b>'+data.ruang+'</b><hr class="divider-line-semi-bold"/>Penguji : <br/><b>'+data.penguji+'</b><br/>';
						$('#modal-ujian-content').html(html);
					}
				})
			},
			loading: function (bool) {
				document.getElementById('loading').style.display =
						bool ? 'block' : 'none';
			},
			editable: true,
			droppable: false,

		})


	})
</script>
