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
                    <h2>Kuisioner</h2>
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
                <h4 class="modal-title" id="myModalLabel">Modal Kuisioner</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Skala <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="text" name="KodeQuis" id="KodeQuis" required="" placeholder="Kode Kuisioner" class="form-control ">
                      <input type="hidden" name="formtype" id="formtype" value="add">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Atribut <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <select id="KodeAtribut" name="KodeAtribut" class="form-control" required>
                        <?php
                          $rs = $this->db->query("select * from tatribut order by KodeAtribut")->result();
                          foreach ($rs as $key) {
                            echo "<option value = '".$key->KodeAtribut."'>".$key->NamaAtribut."</option>";
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Deskripsi<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <textarea class="form-control" rows="3" id="Description" name="Description"></textarea>
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
          var where_field = '';
          var where_value = '';
          var table = 'users';

          $.ajax({
            type: "post",
            url: "<?=base_url()?>C_Quis/read",
            data: {'id':''},
            dataType: "json",
            success: function (response) {
              bindGrid(response.data);
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
                url     : '<?=base_url()?>C_Quis/CRUD',
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
            url: "<?=base_url()?>C_Quis/read",
            data: {'id':id},
            dataType: "json",
            success: function (response) {
              $.each(response.data,function (k,v) {
                console.log(v.KelompokUsaha);
                $('#KodeQuis').val(v.KodeQuis);
                $('#KodeAtribut').val(v.KodeAtribut).change();
                $('#Description').val(v.Description);

                $('#formtype').val("edit");

                $('#modal_').modal('show');
              });
            }
          });
    }
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeQuis",
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
                    dataField: "KodeQuis",
                    caption: "Kode Quis",
                    allowEditing:false
                },
                {
                    dataField: "NamaAtribut",
                    caption: "Nama Atribut",
                    allowEditing:false
                },
                {
                    dataField: "Description",
                    caption: "Deskripsi",
                    allowEditing:false
                }
            ],
            onEditingStart: function(e) {
                GetData(e.data.KodeQuis);
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
              id = e.data.KodeQuis;
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
                      url     : '<?=base_url()?>C_Quis/CRUD',
                      data    : {'KodeQuis':id,'formtype':'delete'},
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