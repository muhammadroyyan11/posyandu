<div class="row">
  <div class="col-md-12 col-xl-10 mx-auto animated fadeIn delay-2s">
    <div class="card m-b-30">
      <div class="card-header bg-primary text-white">
        <?=ucwords($title_module)?>
      </div>
      <div class="card-body">
          <form action="<?=$action?>" id="form" autocomplete="off">
          
          <div class="form-group">
            <label>Nama</label>
            <input type="text" class="form-control form-control-sm" placeholder="Nama" name="nama" id="nama" value="<?=$nama?>">
          </div>
        
          <div class="form-group">
            <label>Tempat lahir</label>
            <input type="text" class="form-control form-control-sm" placeholder="Tempat lahir" name="tempat_lahir" id="tempat_lahir" value="<?=$tempat_lahir?>">
          </div>
        
          <div class="form-group">
            <label>Tgl lahir</label>
            <input type="date" class="form-control form-control-sm" placeholder="Tgl lahir" name="tgl_lahir" id="tgl_lahir" value="<?=$tgl_lahir?>">
          </div>
        
          <div class="form-group">
            <label>Nama ayah</label>
            <input type="text" class="form-control form-control-sm" placeholder="Nama ayah" name="nama_ayah" id="nama_ayah" value="<?=$nama_ayah?>">
          </div>
        
          <div class="form-group">
            <label>Nama ibu</label>
            <input type="text" class="form-control form-control-sm" placeholder="Nama ibu" name="nama_ibu" id="nama_ibu" value="<?=$nama_ibu?>">
          </div>
        
          <div class="form-group">
            <label>Catatan</label>
            <textarea class="form-control text-editor" rows="3" data-original-label="catatan" name="catatan" id="catatan"><?=$catatan?></textarea>
          </div>
        
          <div class="form-group">
            <label>Berat badan</label>
            <input type="number" class="form-control form-control-sm" placeholder="Berat badan" name="berat_badan" id="berat_badan" value="<?=$berat_badan?>">
          </div>
        
          <div class="form-group">
            <label>Tinggi badan</label>
            <input type="number" class="form-control form-control-sm" placeholder="Tinggi badan" name="tinggi_badan" id="tinggi_badan" value="<?=$tinggi_badan?>">
          </div>
        
          <input type="hidden" name="submit" value="update">

          <div class="text-right">
            <a href="<?=url($this->uri->segment(2))?>" class="btn btn-sm btn-danger"><?=cclang("cancel")?></a>
            <button type="submit" id="submit"  class="btn btn-sm btn-primary"><?=cclang("update")?></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
$("#form").submit(function(e){
e.preventDefault();
var me = $(this);
$("#submit").prop('disabled',true).html('Loading...');
$(".form-group").find('.text-danger').remove();
$.ajax({
      url             : me.attr('action'),
      type            : 'post',
      data            :  new FormData(this),
      contentType     : false,
      cache           : false,
      dataType        : 'JSON',
      processData     :false,
      success:function(json){
        if (json.success==true) {
          location.href = json.redirect;
          return;
        }else {
          $("#submit").prop('disabled',false)
                      .html('<?=cclang("save")?>');
          $.each(json.alert, function(key, value) {
            var element = $('#' + key);
            $(element)
            .closest('.form-group')
            .find('.text-danger').remove();
            $(element).after(value);
          });
        }
      }
    });
});
</script>
