<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card-header bg-primary text-white">
      <?=ucwords($title_module)?>
    </div>
    <div class="card">
      <div class="card-body">
        <table class="table table-bordered table-striped">
        <tr>
          <td>Nama</td>
          <td><?=$nama?></td>
        </tr>
        <tr>
          <td>Tempat lahir</td>
          <td><?=$tempat_lahir?></td>
        </tr>
      <tr>
        <td>Tgl lahir</td>
        <td><?=$tgl_lahir != "" ? date('d-m-Y',strtotime($tgl_lahir)):""?></td>
      </tr>
        <tr>
          <td>Nama ayah</td>
          <td><?=$nama_ayah?></td>
        </tr>
        <tr>
          <td>Nama ibu</td>
          <td><?=$nama_ibu?></td>
        </tr>
        <tr>
          <td>Catatan</td>
          <td><?=$catatan?></td>
        </tr>
        <tr>
          <td>Berat badan</td>
          <td><?=$berat_badan?></td>
        </tr>
        <tr>
          <td>Tinggi badan</td>
          <td><?=$tinggi_badan?></td>
        </tr>
        </table>

        <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger mt-3"><?=cclang("back")?></a>
      </div>
    </div>
  </div>
</div>
