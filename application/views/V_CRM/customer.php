<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<style type="text/css">
  .select2-container {
  width: 100% !important;
  }
</style>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Customer</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="dx-viewport demo-container">
                        <div id="data-grid-demo">
                          <div id="gridContainer">
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Customer</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Customer <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="KodeCustomer" id="KodeCustomer" required="" placeholder="Kode Customer" class="form-control " readonly="">
                      <input type="hidden" name="formtype" id="formtype" value="add">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Customer <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="NamaCustomer" id="NamaCustomer" required="" placeholder="Nama Customer" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Email <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="mail" name="Email" id="Email" placeholder="Email" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">NoTlp <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="NoTlp" id="NoTlp" required="" placeholder="NoTlp" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">NoWA <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="NoWA" id="NoWA" placeholder="NoWA" class="form-control ">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Customer Group <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select name="CustGroup" id="CustGroup" class="form-control">
                        <option value="">Pilih Group</option>
                        <option value="1">Ecommerce</option>
                        <option value="2">Direct Sales</option>
                        <option value="3">Dropship</option>
                        <option value="4">Reseller</option>
                      </select>
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
                      <input type="text" name="KodePos" id="KodePos" class="form-control" placeholder="Kode Pos">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat Lengkap <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <textarea id="AlamatCustomer" name="AlamatCustomer" class="form-control"></textarea>
                    </div>
                  </div>
                  <div class="item" form-group>
                    <button class="btn btn-primary" id="btn_Save">Save</button>
                  </div>
                </form>
              </div>
              <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
              </div> -->

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


      var where_field = '';
      var where_value = '';
      var table = 'users';

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Customer/Read",
        data: {'KodeCustomer':''},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Customer/Getindex",
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            $('#KodeCustomer').val(response.Nomor);
          }
        }
      });
    });

    $('#provinsi').change(function () {
      var idaddr = $('#provinsi').val();
      var link = 'kota';


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
            url     : '<?=base_url()?>C_Customer/CRUD',
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
    $('.close').click(function() {
      location.reload();
    });
    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
            type: "post",
            url: "<?=base_url()?>C_Customer/read",
            data: {'KodeCustomer':id},
            dataType: "json",
            success: function (response) {
              $('#KodeCustomer').val(response.data[0]['KodeCustomer']);
              $('#NamaCustomer').val(response.data[0]['NamaCustomer']);
              $('#AlamatCustomer').val(response.data[0]['AlamatCustomer']);
              $('#provinsi').val(response.data[0]['provinsi']).change();
              $('#Kota').val(response.data[0]['Kota']).change();
              $('#Kecamatan').val(response.data[0]['Kecamatan']).change();
              $('#Kelurahan').val(response.data[0]['Kelurahan']).change();
              $('#KodePos').val(response.data[0]['KodePos']);
              $('#Email').val(response.data[0]['Email']);
              $('#NoTlp').val(response.data[0]['NoTlp']);
              $('#NoWA').val(response.data[0]['NoWA']);
              $('#CustGroup').val(response.data[0]['CustGroup']).change();

              $('#formtype').val("edit");

              $('#modal_').modal('show');
            }
          });
    }
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeCustomer",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: false
            },
            editing: {
                mode: "row",
                allowAdding:true,
                allowUpdating: true,
                allowDeleting: true,
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            export: {
                enabled: true,
                fileName: "Daftar Penyakit"
            },
            columns: [
                {
                    dataField: "KodeCustomer",
                    caption: "Kode Customer",
                    allowEditing:false
                },
                {
                    dataField: "NamaCustomer",
                    caption: "Nama Customer",
                    allowEditing:false
                },
                {
                    dataField: "GroupCustomer",
                    caption: "Group Customer",
                    allowEditing:false
                },
                {
                    dataField: "AlamatCustomer",
                    caption: "Alamat Customer",
                    allowEditing:false
                },
                {
                    dataField: "KodePos",
                    caption: "Kode Pos",
                    allowEditing:false
                },
                {
                    dataField: "Email",
                    caption: "Email",
                    allowEditing:false
                },
                {
                    dataField: "NoTlp",
                    caption: "NoTlp",
                    allowEditing:false
                },
                {
                    dataField: "NoWA",
                    caption: "NoWA",
                    allowEditing:false
                },
            ],
            onEditingStart: function(e) {
                GetData(e.data.KodeCustomer);
            },
            onInitNewRow: function(e) {
                // logEvent("InitNewRow");
                $('#modal_').modal('show');
            },
            onRowInserting: function(e) {
                // logEvent("RowInserting");
            },
            onRowInserted: function(e) {
                // logEvent("RowInserted");
                // alert('');
                // console.log(e.data.onhand);
                // var index = e.row.rowIndex;
            },
            onRowUpdating: function(e) {
                // logEvent("RowUpdating");
                
            },
            onRowUpdated: function(e) {
                // logEvent(e);
            },
            onRowRemoving: function(e) {
              id = e.data.KodeCustomer;
              Swal.fire({
                title: 'Apakah anda yakin?',
                text: "anda akan menghapus data di baris ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  var table = 'app_setting';
                  var field = 'id';
                  var value = id;

                  $.ajax({
                      type    :'post',
                      url     : '<?=base_url()?>C_Customer/CRUD',
                      data    : {'KodeCustomer':id,'formtype':'delete'},
                      dataType: 'json',
                      success : function (response) {
                        if(response.success == true){
                          Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      ).then((result)=>{
                            location.reload();
                          });
                        }
                        else{
                          Swal.fire({
                            type: 'error',
                            title: 'Woops...',
                            text: response.message,
                            // footer: '<a href>Why do I have this issue?</a>'
                          }).then((result)=>{
                            location.reload();
                          });
                        }
                      }
                    });
                  
                }
                else{
                  location.reload();
                }
              })
            },
            onRowRemoved: function(e) {
              // console.log(e);
            },
        onEditorPrepared: function (e) {
          // console.log(e);
        }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>