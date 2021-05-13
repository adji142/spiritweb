<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Perusahaan</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Perusahaan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="NamaPerusahaan" id="NamaPerusahaan" required="" placeholder="Nama Perusahaan" class="form-control ">
                  <input type="hidden" name="formtype" id="formtype" value="add">
                  <input type="hidden" name="id" id="id" value="">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Provinsi <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <select class="js-states form-control" id="provinsi" name="provinsi" >
                    <option value = ''>Pilih Provinsi</option>
                    <?php
                      $rs = $this->db->query("select * from ro_provinces")->result();
                      foreach ($rs as $key) {
                        echo "<option value = '".$key->id."'>".$key->name."</option>";
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kota <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <select class="js-states form-control" id="Kota" name="Kota" >
                    <option value = ''>Pilih Kota</option>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kecamatan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <select class="js-states form-control" id="Kecamatan" name="Kecamatan" >
                    <option value = ''>Pilih Kecamatan</option>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kelurahan <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <select class="js-states form-control" id="Kelurahan" name="Kelurahan" >
                    <option value = ''>Pilih Kelurahan</option>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode POS <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="KodePos" id="KodePos" class="form-control" placeholder="Kode Pos" required="">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat Line 1 <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="Alamat1" id="Alamat1" required="" placeholder="Alamat Line 1" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat Line 2 <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="Alamat2" id="Alamat2" placeholder="Alamat Line 2" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. Tlp <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="NoTlp" id="NoTlp" placeholder="NoTlp" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">NPWP <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="NPWP" id="NPWP" placeholder="NPWP" class="form-control ">
                </div>
              </div>
              <div class="item" form-group>
                <button class="btn btn-primary" id="btn_Save">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  $(function () {
    $(document).ready(function () {

      $('#provinsi').select2({
        width : 'resolve',
        placeholder: 'Pilih Provinsi'
      });

      $('#Kota').select2({
        width : 'resolve',
        placeholder: 'Pilih Kota'
      });

      $('#Kecamatan').select2({
        width : 'resolve',
        placeholder: 'Pilih Kecamatan'
      });

      $('#Kelurahan').select2({
        width : 'resolve',
        placeholder: 'Pilih Kecamatan'
      });

      var id = $('#id').val();

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Perusahaan/Read",
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            $('#formtype').val('edit');
            console.log(response.data[0]['NamaPerusahaan']);
            $('#id').val(response.data[0]['id']);
            $('#NamaPerusahaan').val(response.data[0]['NamaPerusahaan']);
            $('#Alamat1').val(response.data[0]['Alamat1']);
            $('#Alamat2').val(response.data[0]['Alamat2']);
            $('#NoTlp').val(response.data[0]['NoTlp']);
            $('#NPWP').val(response.data[0]['NPWP']);

            $('#provinsi').val(response.data[0]['provinsi']).change();
            $('#Kota').val(response.data[0]['Kota']).change();
            $('#Kecamatan').val(response.data[0]['Kecamatan']).change();
            $('#Kelurahan').val(response.data[0]['Kelurahan']).change();
            $('#KodePos').val(response.data[0]['KodePos']);
          }
          else{
            $('#formtype').val('add');
          }
        }
      });
    });
    $('#provinsi').change(function () {
      var idaddr = $('#provinsi').val();
      var link = 'kota';

      var exploded = idaddr.split('|');

      // var x = exploded[1];
      cekongkir_provinsi = exploded[1];
      idaddr = exploded[0];


      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kota').empty();
            $('#Kota').append(""+
              "<option value='0'>Pilih Kota</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kota').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
          }
        }
      });
    });

    $('#Kota').change(function () {
      var idaddr = $('#Kota').val();
      var link = 'kec';

      var exploded = idaddr.split('|');

      cekongkir_kota = exploded[1];
      idaddr = exploded[0];

      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kecamatan').empty();
            $('#Kecamatan').append(""+
              "<option value='0'>Pilih Kecamatan</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kecamatan').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
            
          }
        }
      });
    });

    $('#Kecamatan').change(function () {
      var idaddr = $('#Kecamatan').val();
      var link = 'kel';

      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kelurahan').empty();
            $('#Kelurahan').append(""+
              "<option value='0'>Pilih Kelurahan</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kelurahan').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
          }
        }
      });
    });

    $('#post_').submit(function (e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>C_Perusahaan/CRUD',
        data    : me.serialize(),
        dataType: 'json',
        success : function (response) {
          if(response.success == true){
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'success',
              title: 'Horay..',
              text: 'Data Berhasil disimpan!',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              location.reload();
            });
          }
          else{
            $('#modal_').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_').modal('show');
              $('#btn_Save').text('Save');
              $('#btn_Save').attr('disabled',false);
            });
          }
        }
      });
    });
  });
</script>