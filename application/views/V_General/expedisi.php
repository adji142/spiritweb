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
            <h2>Expedisi</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="dx-viewport demo-container">
                <div id="data-grid-demo">
                  <div id="gridContainer">
                  </div>
                </div>
              </div>
              <br>
              <div class="dx-viewport demo-container">
                <div id="data-grid-demo">
                  <div id="gridContainer_detail">
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
        <h4 class="modal-title" id="myModalLabel">Expedisi</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Expedisi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="KodeExpdc" id="KodeExpdc" required="" placeholder="Kode Expdc" class="form-control ">
              <input type="hidden" name="formtype" id="formtype" value="add">
            </div>
          </div>
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Expedisi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="NamaExpdc" id="NamaExpdc" required="" placeholder="Nama Expdc" class="form-control ">
            </div>
          </div>
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <textarea name="AlamatKantor" id="AlamatKantor" class="form-control"></textarea>
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
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Email <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="mail" name="Email" id="Email" required="" placeholder="Email" class="form-control ">
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

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_detail">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Service Expedisi</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_detail" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kode Expedisi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="NamaService" id="NamaService" required="" placeholder="Kode Expdc" class="form-control ">
              <input type="hidden" name="formtype_detail" id="formtype_detail" value="add">
              <input type="hidden" name="RowID" id="RowID">
              <input type="hidden" name="KodeExpedisi" id="KodeExpedisi">
            </div>
          </div>

          <div class="item" form-group>
            <button class="btn btn-primary" id="btn_Save_Detail">Save</button>
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
    var xKode = '';
    $(document).ready(function () {
      var where_field = '';
      var where_value = '';
      var table = 'users';

      console.log(xKode);
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_expdc/Read",
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
        url     : '<?=base_url()?>C_expdc/CRUD',
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

    $('#post_detail').submit(function (e) {
      $('#btn_Save_Detail').text('Tunggu Sebentar.....');
      $('#btn_Save_Detail').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>C_expdc/CRUDDetail',
        data    : me.serialize(),
        dataType: 'json',
        success : function (response) {
          if(response.success == true){
            $('#modal_detail').modal('toggle');
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
            $('#modal_detail').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_detail').modal('show');
              $('#btn_Save_Detail').text('Save');
              $('#btn_Save_Detail').attr('disabled',false);
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
            url: "<?=base_url()?>C_expdc/read",
            data: {'KodeExpdc':id},
            dataType: "json",
            success: function (response) {
              $.each(response.data,function (k,v) {
                $('#KodeExpdc').val(v.KodeExpdc);
                $('#NamaExpdc').val(v.NamaExpdc);
                $('#AlamatKantor').val(v.AlamatKantor);
                $('#Email').val(v.Email);
                $('#NoTlp').val(v.NoTlp);

                $('#formtype').val("edit");

                $('#modal_').modal('show');
              });
            }
          });
    }

    function GetDataDetail(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
            type: "post",
            url: "<?=base_url()?>C_expdc/read",
            data: {'RowID':id},
            dataType: "json",
            success: function (response) {
              $.each(response.data,function (k,v) {
                $('#RowID').val(v.RowID);
                $('#NamaService').val(v.NamaService);
                $('#KodeExpedisi').val(v.KodeExpedisi);

                $('#formtype_detail').val("edit");

                $('#modal_detail').modal('show');
              });
            }
          });
    }

    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeExpdc",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            focusedRowEnabled: true,
            focusedRowKey: 0,
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
                fileName: "Harga Bertingkat"
            },
            columns: [
                {
                    dataField: "KodeExpdc",
                    caption: "Kode Expdc",
                    allowEditing:false
                },
                {
                    dataField: "NamaExpdc",
                    caption: "Nama Expdc",
                    allowEditing:false
                },
                {
                    dataField: "AlamatKantor",
                    caption: "Alamat Kantor",
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
            ],
            onEditingStart: function(e) {
                GetData(e.data.KodeExpdc);
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
              id = e.data.KodeExpdc;
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
                      url     : '<?=base_url()?>C_expdc/CRUD',
                      data    : {'KodeExpdc':id,'formtype':'delete'},
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
            },
            onFocusedRowChanging: function(e) {
                var rowsCount = e.component.getVisibleRows().length,
                    pageCount = e.component.pageCount(),
                    pageIndex = e.component.pageIndex(),
                    key = e.event && e.event.key;

                if(key && e.prevRowIndex === e.newRowIndex) {
                    if(e.newRowIndex === rowsCount - 1 && pageIndex < pageCount - 1) {
                        e.component.pageIndex(pageIndex + 1).done(function() {
                            e.component.option("focusedRowIndex", 0);
                        });
                    } else if(e.newRowIndex === 0 && pageIndex > 0) {
                        e.component.pageIndex(pageIndex - 1).done(function() {
                            e.component.option("focusedRowIndex", rowsCount - 1);
                        });
                    }
                }
            },
            onFocusedRowChanged: function(e) {
              const row = e.row;
              const rowData = row && row.data;
              const xdata = rowData && rowData.KodeExpdc

              xKode  = xdata;

              $('#KodeExpedisi').val(xdata);
              if (xdata != "") {
                $.ajax({
                  type    :'post',
                  url     : '<?=base_url()?>C_expdc/ReadDetail',
                  data    : {'KodeExpdc':xdata},
                  dataType: 'json',
                  success:function (response) {
                    bindGriddetail(response.data);
                  }
                });
              }
            }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    function bindGriddetail(data) {

      $("#gridContainer_detail").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "RowID",
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
                fileName: "Harga Bertingkat"
            },
            columns: [
                {
                    dataField: "RowID",
                    caption: "#",
                    allowEditing:false
                },
                {
                    dataField: "NamaService",
                    caption: "Nama Service",
                    allowEditing:false
                }
            ],
            onEditingStart: function(e) {
                GetData(e.data.RowID);
            },
            onInitNewRow: function(e) {
                // logEvent("InitNewRow");
                console.log(xKode);
                if (typeof xKode == 'undefined') {
                  Swal.fire({
                    type: 'error',
                    title: 'Woops...',
                    text: 'Pilih Expedisi terlebih dahulu',
                    // footer: '<a href>Why do I have this issue?</a>'
                  }).then((result)=>{
                    location.reload();
                  });
                }
                else{
                  $('#modal_detail').modal('show');
                }
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
              id = e.data.RowID;
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
                      url     : '<?=base_url()?>C_expdc/CRUD_Detail',
                      data    : {'RowID':id,'formtype':'delete'},
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