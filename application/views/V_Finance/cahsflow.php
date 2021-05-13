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
            <h2>Cash Flow</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <label class="col-form-label label-align" for="first-name">Tanggal <span class="required">*</span>
              </label>
              <div class="col-md-3 col-sm-3  form-group">
                <input type="date" id="TglAwal" name="TglAwal" placeholder="dd-mm-yyyy" dateformat="dd-mm-yyyy" class="form-control" value="<?php echo date("Y-m-01");?>">
              </div>
               <label class="col-form-label label-align" for="first-name">s/d </label>
               <!-- end -->
              <div class="col-md-3 col-sm-3  form-group">
                <input type="date" id="TglAkhir" name="TglAkhir" placeholder=".col-md-12" class="form-control" value="<?php echo date("Y-m-d");?>">
              </div>
              <div class="form-group">
                <!-- <input type="date" placeholder=".col-md-12" class="form-control"> -->
                <button name="filterbutton" id="filterbutton" class="form-control btn btn-primary">Search</button>
              </div>
            </div>
            <div class="dx-viewport demo-container">
              <div id="data-grid-demo">
                <div id="gridContainer">
                </div>
              </div>
            </div>

            <div class="dx-viewport demo-container">
              <div id="data-grid-demo">
                <div id="gridContainerDetail">
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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_adj">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Adjustment</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_adj" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Tanggal <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-12 ">
                <input type="date" name="TglTransaksi" id="TglTransaksi" required="" class="form-control " value="<?php echo date("Y-m-d"); ?>">
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">No. Refrensi <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-12 ">
                <input type="text" name="BaseRef" id="BaseRef" required="" class="form-control " readonly="">
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Mutasi <span class="required">*</span>
              </label>
              <div class="col-md-4 col-sm-12 ">
                <input type="text" name="Debet" id="Debet" required="" class="form-control " placeholder="Debet">
              </div>
              <div class="col-md-4 col-sm-12 ">
                <input type="text" name="Credit" id="Credit" required="" class="form-control " placeholder="Credit">
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Keterangan <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-12 ">
                <input type="text" name="ExternalNote" id="ExternalNote" required="" class="form-control " placeholder="Keterangan">
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Jenis Pencatatan <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-12 ">
                <select class="js-states form-control" id="JenisPencatatan" name="JenisPencatatan" >
                  <option value = ''>Pilih Pencatatan</option>
                  <option value="1">Koreksi Ongkir</option>
                  <option value="2">Koreksi Penjualan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="item form-group">
            <button class="btn btn-primary" id="btn_Save_adj">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_pencairan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Pencairan</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_pencairan" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Penjualan <span class="required">*</span>
              </label>
              <div class="col-md-3 col-sm-12 ">
                <input type="text" name="NoPenjualan" id="NoPenjualan" required="" placeholder="NoPenjualan" class="form-control " readonly="">
                <input type="hidden" name="NoCashFlow" id="NoCashFlow" required="" placeholder="NoPenjualan" class="form-control " readonly="">
              </div>
              <div class="col-md-3 col-sm-12 ">
                <input type="text" name="TotalPenjualan" id="TotalPenjualan" required="" placeholder="TotalPenjualan" class="form-control " readonly="">
              </div>
              <div class="col-md-3 col-sm-12 ">
                <input type="date" name="TglPenjualan" id="TglPenjualan" required="" placeholder="TotalPenjualan" class="form-control " readonly="">
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">No Ref Ecommerce <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-12 ">
                <input type="text" name="NoRefPenjualan" id="NoRefPenjualan" required="" placeholder="NoRefPenjualan" class="form-control " readonly="">
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Nama Ecommerce <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-12 ">
                <select class="js-states form-control" id="NamaEcommerce" name="NamaEcommerce" >
                  <option value = ''>Pilih Ecommerce</option>
                  <option value="1">Shopee</option>
                  <option value="2">Tokopedia</option>
                  <option value="3">Bukalapak</option>
                  <option value="4">Lazada</option>
                  <option value="5">bli bli</option>
                </select>
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Nominal Cair <span class="required">*</span>
              </label>
              <div class="col-md-4 col-sm-12 ">
                <input type="text" name="NominalCair" id="NominalCair" required="" placeholder="NominalCair" class="form-control " value="0">
              </div>
              <div class="col-md-4 col-sm-12 ">
                <input type="text" name="Selisih" id="Selisih" required="" placeholder="Selisih" class="form-control " readonly="">
              </div>
            </div>
          </div>
          <div class="item form-group">
            <div class="row col-md-12 col-sm-12">
              <label class="col-md-3 col-sm-12" for="first-name">Keterangan <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-12 ">
                <input type="text" name="Keterangan" id="Keterangan" required="" placeholder="Keterangan" class="form-control ">
              </div>
            </div>
          </div>
          <div class="item" form-group>
            <button class="btn btn-primary" id="btn_Save_pencairan">Save</button>
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
    var NoRefcashflow = '';
    $(document).ready(function () {
      var button = $('#filterbutton');
      button.click();

      $('#NamaEcommerce').select2({
        width : 'resolve',
        placeholder: 'Pilih Ecommerce'
      });
    });
    $('#post_pencairan').submit(function (e) {
      $('#btn_Save_pencairan').text('Tunggu Sebentar.....');
      $('#btn_Save_pencairan').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>C_CashFlow/pencairan',
        data    : me.serialize(),
        dataType: 'json',
        success : function (response) {
          if(response.success == true){
            $('#modal_pencairan').modal('toggle');
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
            $('#modal_pencairan').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_pencairan').modal('show');
              $('#btn_Save_pencairan').text('Save');
              $('#btn_Save_pencairan').attr('disabled',false);
            });
          }
        }
      });
    });

    $('#post_adj').submit(function (e) {
      $('#btn_Save_adj').text('Tunggu Sebentar.....');
      $('#btn_Save_adj').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>C_CashFlow/Adjustment',
        data    : me.serialize(),
        dataType: 'json',
        success : function (response) {
          if(response.success == true){
            $('#modal_adj').modal('toggle');
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
            $('#modal_adj').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_adj').modal('show');
              $('#btn_Save_adj').text('Save');
              $('#btn_Save_adj').attr('disabled',false);
            });
          }
        }
      });
    });

    $('#NominalCair').on("keyup",function () {
      var Penjualan = parseFloat($('#TotalPenjualan').val().replace(',',''));

      $('#Selisih').val(Penjualan - parseFloat($('#NominalCair').val()) );
    })
    $('.close').click(function() {
      location.reload();
    });
    $('#filterbutton').click(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_CashFlow/Read",
        data: {'TglAwal':$('#TglAwal').val(),'TglAkhir':$('#TglAkhir').val()},
        dataType: "json",
        success: function (response) {
          bindGrid(response.data);
        }
      });
    });
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NoTransaksi",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            focusedRowEnabled: true,
            focusedRowKey: 0,
            paging: {
                enabled: true
            },
            editing: {
                mode: "row",
                allowAdding:true,
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
                fileName: "Cash Flow"
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tgl Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "NoPenjualan",
                    caption: "No Ref",
                    allowEditing:false
                },
                {
                    dataField: "ExternalNote",
                    caption: "Keterangan",
                    allowEditing:false
                },
                {
                    dataField: "NamaEcommerce",
                    caption: "Ecommerce",
                    allowEditing:false
                },
                {
                    dataField: "Refrensicair",
                    caption: "Refrensi cair",
                    allowEditing:false
                },
                {
                    dataField: "SaldoAkhir",
                    caption: "Saldo",
                    allowEditing:false
                },
                {
                    dataField: "TransactionType",
                    caption: "TransactionType",
                    allowEditing:false,
                    visible: true
                },
                {
                    dataField: "Action",
                    caption: "Action",
                    allowEditing:false,
                    cellTemplate: function(cellElement, cellInfo) {
                      var LinkAccess = "";
                      console.log(cellInfo.data.Refrensicair)
                      if (cellInfo.data.TransactionType == "1" && cellInfo.data.Refrensicair == '') {
                        console.log("masuk")
                        LinkAccess += "<button class='badge badge-danger StartPay' onClick =Pencairan('"+cellInfo.data.NoTransaksi+"','"+cellInfo.data.NoPenjualan+"')>Pencairan</button>";
                      }
                      cellElement.append(LinkAccess);
                  }
                },
            ],
            onEditingStart: function(e) {
            },
            onInitNewRow: function(e) {
                // logEvent("InitNewRow");
                console.log(NoRefcashflow)
                if (typeof NoRefcashflow == 'undefined' || NoRefcashflow =='') {
                  Swal.fire({
                    type: 'error',
                    title: 'Woops...',
                    text: 'Pilih Item Cash Flow terlebih dahulu',
                    // footer: '<a href>Why do I have this issue?</a>'
                  });
                }
                else{
                  $('#BaseRef').val(NoRefcashflow);
                  $('#modal_adj').modal('show');
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
            },
            onRowRemoved: function(e) {
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
            const xdata = rowData && rowData.NoPenjualan;
            NoRefcashflow = xdata

            $.ajax({
              type: "post",
              url: "<?=base_url()?>C_CashFlow/ReadDetail",
              data: {'NoTransaksi':xdata},
              dataType: "json",
              success: function (response) {
                bindGridDetail(response.data);
              }
            });
          }
        }).dxDataGrid("instance");

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    function bindGridDetail(data) {

      $("#gridContainerDetail").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NoTransaksi",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            focusedRowEnabled: true,
            focusedRowKey: 0,
            paging: {
                enabled: true
            },
            editing: {
                mode: "row",
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
                fileName: "Cash Flow"
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tgl Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "BaseRef",
                    caption: "No Ref",
                    allowEditing:false
                },
                {
                    dataField: "Debet",
                    caption: "Debet",
                    allowEditing:false,
                    format:"0:#,#.00"
                },
                {
                    dataField: "Credit",
                    caption: "Credit",
                    allowEditing:false,
                    type: "fixedPoint",  
                    precision: 0
                },
                {
                    dataField: "ExternalNote",
                    caption: "Keterangan",
                    allowEditing:false
                },
            ],
            onEditingStart: function(e) {
            },
            onInitNewRow: function(e) {
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
            },
            onRowRemoved: function(e) {
              // console.log(e);
            },
            onFocusedRowChanging: function(e) {
          },
          onFocusedRowChanged: function(e) {
          }
        }).dxDataGrid("instance");

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
function Pencairan(NoTransaksi,NoPenjualan) {
  $.ajax({
    type: "post",
    url: "<?=base_url()?>C_POS/ReadTagihan",
    data: {'NoTransaksi':NoPenjualan},
    dataType: "json",
    success: function (response) {
      $('#NoCashFlow').val(NoTransaksi);
      $('#NoPenjualan').val(response.data[0]['NoTransaksi']);
      $('#TotalPenjualan').val(addCommasOuter(response.data[0]['T_GrandTotal']));
      $('#TglPenjualan').val(response.data[0]['TglTransaksi']);
      $('#NoRefPenjualan').val(response.data[0]['RefNumberTrx']);
      $('#Selisih').val(addCommasOuter(parseFloat(response.data[0]['T_GrandTotal']) * -1));
      $('#modal_pencairan').modal('show');
    }
  });
}
function addCommasOuter(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>