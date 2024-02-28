<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?=ucwords($title_module)?></h4>
          <div class="pull-right">
                          <a href="<?=url("balita/add")?>" class="btn btn-secondary btn-flat"><i class="fa fa-file btn-icon-prepend"></i> Add</a>
                          <button class="btn btn-success btn-flat" type="button" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file btn-icon-prepend"></i> Export</button>
                          <button type="button" id="filter-show" class="btn btn-primary btn-flat"><i class="mdi mdi-backup-restore btn-icon-prepend"></i> Filter</button>
                      </div>
        </div>
        <div class="card-content">
          <div class="card-body card-dashboard">
            <form autocomplete="off" class="content-filter">
              <div class="row">
                                  <div class="form-group col-md-6">
                                          <input type="text" id="nama" class="form-control form-control-sm" placeholder="Nama" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="tempat_lahir" class="form-control form-control-sm" placeholder="Tempat lahir" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="date" id="tgl_lahir" class="form-control form-control-sm" placeholder="Tgl lahir" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="nama_ayah" class="form-control form-control-sm" placeholder="Nama ayah" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="nama_ibu" class="form-control form-control-sm" placeholder="Nama ibu" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="catatan" class="form-control form-control-sm" placeholder="Catatan" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="berat_badan" class="form-control form-control-sm" placeholder="Berat badan" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="tinggi_badan" class="form-control form-control-sm" placeholder="Tinggi badan" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="datetime-local" id="createdAt" class="form-control form-control-sm" placeholder="CreatedAt" />
                                      </div>

                              </div>
              <div class="pull-right">
                <button type='button' class='btn btn-default btn-sm' id="filter-cancel"><?=cclang("cancel")?></button>
                <button type="button" class="btn btn-primary btn-sm" id="filter">Filter</button>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table display" name="table" id="table" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                  <tr>
							<th>Id</th>
							<th>Nama</th>
							<th>Tempat lahir</th>
							<th>Tgl lahir</th>
							<th>Jenis Kelamin</th>
							<th>Umur</th>
							<th>Nama ayah</th>
							<th>Nama ibu</th>
							<th>Catatan</th>
							<th>Berat badan</th>
							<th>Tinggi badan</th>
							<th>CreatedAt</th>
							<th>UpdatedAt</th>
                    <th>#</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('cpanel/balita/export/')?>" method="post" accept-charset="utf-8">
                <div class="modal-body">

                        <div class="row form-group">
                            <label class="col-lg-3 text-lg-right" for="tanggal">Tanggal :</label>
                            <div class="col-lg-8">
                                <div class="input-group">
                                    <input value="" name="tanggal" id="tanggalrange" type="text"
                                        class="form-control" placeholder="Periode Tanggal">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-fw fa-calendar"></i></span>
                                    </div>
                                </div>
                                <br>
                                <p style="color : #ea5455 !important; font-size: smaller;">Note : Di Anjurkan mendownload
                                    file laporan pada PC / Laptop</p>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Download</button>
                </div>
            </form>

        </div>
    </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
    var table;
    //datatables
    table = $('#table').DataTable({

      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      "ordering": true,
      "searching": false,
      "info": true,
      "bLengthChange": false,
      oLanguage: {
        sProcessing: '<i class="fa fa-spinner fa-spin fa-fw"></i> Loading...'
      },

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?= url("balita/json")?>",
        "type": "POST",
         "data": function(data) {
                                          data.nama = $("#nama").val();
                                                        data.tempat_lahir = $("#tempat_lahir").val();
                                                        data.tgl_lahir = $("#tgl_lahir").val();
                                                        data.jenis_kelamin = $("#jenis_kelamin").val();
                                                        data.nama_ayah = $("#nama_ayah").val();
                                                        data.nama_ibu = $("#nama_ibu").val();
                                                        data.catatan = $("#catatan").val();
                                                        data.berat_badan = $("#berat_badan").val();
                                                        data.tinggi_badan = $("#tinggi_badan").val();
                                                        data.createdAt = $("#createdAt").val();
                                    }
              },

      //Set column definition initialisation properties.
      "columnDefs": [
        
					{
            "targets": 0,
            "orderable": false
          },

					{
            "targets": 1,
            "orderable": false
          },

					{
            "targets": 2,
            "orderable": false
          },

					{
            "targets": 3,
            "orderable": false
          },

					{
            "targets": 4,
            "orderable": false
          },

					{
            "targets": 5,
            "orderable": false
          },

					{
            "targets": 6,
            "orderable": false
          },

					{
            "targets": 7,
            "orderable": false
          },

					{
            "targets": 8,
            "orderable": false
          },

					{
            "targets": 9,
            "orderable": false
          },

					{
            "targets": 10,
            "orderable": false
          },

        {
          "className": "text-center",
          "orderable": false,
          "targets": 11
        },
      ],
    });

    $("#reload").click(function() {
                        $("#nama").val("");
                  $("#tempat_lahir").val("");
                  $("#tgl_lahir").val("");
                  $("#jenis_kelamin").val("");
                  $("#nama_ayah").val("");
                  $("#nama_ibu").val("");
                  $("#catatan").val("");
                  $("#berat_badan").val("");
                  $("#tinggi_badan").val("");
                  $("#createdAt").val("");
                    table.ajax.reload();
    });

          $(document).on("click", "#filter-show", function(e) {
        e.preventDefault();
        $(".content-filter").slideDown();
      });

      $(document).on("click", "#filter", function(e) {
        e.preventDefault();
        $("#table").DataTable().ajax.reload();
      })

      $(document).on("click", "#filter-cancel", function(e) {
        e.preventDefault();
        $(".content-filter").slideUp();
      });
    
    $(document).on("click", "#delete", function(e) {
      e.preventDefault();
      $('.modal-dialog').addClass('modal-sm');
      $("#modalTitle").text('<?=cclang("confirm")?>');
      $('#modalContent').html(`<p class="mb-4"><?=cclang("delete_description")?></p>
                              <div class="pull-right">
  														<button type='button' class='btn btn-default btn-sm' data-dismiss='modal'><?=cclang("cancel")?></button>
  	                          <button type='button' class='btn btn-primary btn-sm' id='ya-hapus' data-id=` + $(this).attr('alt') + `  data-url=` + $(this).attr('href') + `><?=cclang("delete_action")?></button>
  														</div>`);
      $("#modalGue").modal('show');
    });


    $(document).on('click', '#ya-hapus', function(e) {
      $(this).prop('disabled', true)
        .text('Processing...');
      $.ajax({
        url: $(this).data('url'),
        type: 'POST',
        cache: false,
        dataType: 'json',
        success: function(json) {
          $('#modalGue').modal('hide');
          swal(json.msg, {
            icon: json.type_msg
          });
          $('#table').DataTable().ajax.reload();
        }
      });
    });


  });
</script>