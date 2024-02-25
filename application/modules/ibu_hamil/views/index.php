<!-- Zero configuration table -->
<section id="basic-datatable">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?=ucwords($title_module)?></h4>
          <div class="pull-right">
                          <a href="<?=url("ibu_hamil/add")?>" class="btn btn-success btn-flat"><i class="fa fa-file btn-icon-prepend"></i> Add</a>
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
                                          <input type="text" id="nama_suami" class="form-control form-control-sm" placeholder="Nama suami" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="umur_kandungan" class="form-control form-control-sm" placeholder="Umur kandungan" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="vitamin" class="form-control form-control-sm" placeholder="Vitamin" />
                                      </div>

                                  <div class="form-group col-md-6">
                                          <input type="text" id="berat_badan" class="form-control form-control-sm" placeholder="Berat badan" />
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
							<th>Umur</th>
							<th>Nama suami</th>
							<th>Umur kandungan</th>
							<th>Vitamin</th>
							<th>Berat badan</th>
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
        "url": "<?= url("ibu_hamil/json")?>",
        "type": "POST",
         "data": function(data) {
                                          data.nama = $("#nama").val();
                                                        data.tempat_lahir = $("#tempat_lahir").val();
                                                        data.tgl_lahir = $("#tgl_lahir").val();
                                                        data.nama_suami = $("#nama_suami").val();
                                                        data.umur_kandungan = $("#umur_kandungan").val();
                                                        data.vitamin = $("#vitamin").val();
                                                        data.berat_badan = $("#berat_badan").val();
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
          "className": "text-center",
          "orderable": false,
          "targets": 10
        },
      ],
    });

    $("#reload").click(function() {
                        $("#nama").val("");
                  $("#tempat_lahir").val("");
                  $("#tgl_lahir").val("");
                  $("#nama_suami").val("");
                  $("#umur_kandungan").val("");
                  $("#vitamin").val("");
                  $("#berat_badan").val("");
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