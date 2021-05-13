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
            <h2>Laporan Penjualan</h2>
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
              <div class="col-md-3 col-sm-3  form-group">
                <select id="TipeLaporan" name="TipeLaporan" class="js-states form-control">
                  <option value = ''>Tipe Laporan</option>
                  <option value="1">Penjualan All</option>
                  <option value="2">Penjualan Per Transaksi</option>
                </select>
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
                <div id="gridContainer_B">
                </div>
              </div>
            </div>
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
    var NoRefcashflow = '';
    $(document).ready(function () {
      var button = $('#filterbutton');
      // button.click();

      $('#TipeLaporan').select2({
        width : 'resolve',
        placeholder: 'Tipe Laporan'
      });
    });
    $('#filterbutton').click(function () {
      $.ajax({
        async : false,
        type: "post",
        url: "<?=base_url()?>C_Laporan/LaporanPenjualan",
        data: {'TglAwal':$('#TglAwal').val(),'TglAkhir':$('#TglAkhir').val()},
        dataType: "json",
        success: function (response) {
          switch($('#TipeLaporan').val()) {
            case "1":
                var items_data = [];
                var ongkir = '';
                var jumlahbayar = '';
                var notrx = '';
                for (var i = 0; i < response.data.length; i++) {
                    console.log(response.data[i].NoTransaksi + " - " + notrx);
                    if (response.data[i].NoTransaksi != notrx) {
                        ongkir = response.data[i].T_Ongkir;
                        jumlahbayar = response.data[i].Pembayaran;
                        console.log(ongkir + " - " + jumlahbayar);
                    }
                    else{
                        ongkir = '0';
                        jumlahbayar = '0';
                    }
                    notrx = response.data[i].NoTransaksi;
                    var arr ={
                        NoTransaksi     : response.data[i].NoTransaksi,
                        TglTransaksi    : response.data[i].TglTransaksi,
                        num             : response.data[i].num,
                        NamaCustomer    : response.data[i].NamaCustomer,
                        NamaSales       : response.data[i].NamaSales,
                        Brand           : response.data[i].Brand,
                        Alamat_dest     : response.data[i].Alamat_dest,
                        Notlp_dest      : response.data[i].Notlp_dest,
                        OldItem         : response.data[i].OldItem,
                        Qty             : response.data[i].Qty,
                        Harga           : response.data[i].Harga,
                        Article         : response.data[i].Article,
                        Warna           : response.data[i].Warna,
                        Expedisi        : response.data[i].Expedisi,
                        noresi          : response.data[i].noresi,
                        T_Ongkir        : ongkir,
                        Total           : response.data[i].Total,
                        PaymentTerm     : response.data[i].PaymentTerm,
                        Pembayaran      : jumlahbayar
                    }
                    items_data.push(arr);
                }
                bindGrid_A(items_data);  
              break;
            case "2":
                bindGrid_B(response.data);
              break;
            default:
              Swal.fire({
                type: 'success',
                title: 'Horay..',
                text: 'Pilih Tipe Laporan',
                // footer: '<a href>Why do I have this issue?</a>'
              })
          }
        }
      });
    });
    function bindGrid_A(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "NoTransaksi",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                enabled: true
            },
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            export: {
                enabled: true,
                fileName: "Laporan Penjualan All"
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
                    dataField: "num",
                    caption: "No",
                    allowEditing:false
                },
                {
                    dataField: "NamaCustomer",
                    caption: "Nama Customer",
                    allowEditing:false
                },
                {
                    dataField: "NamaSales",
                    caption: "Agen",
                    allowEditing:false
                },
                {
                    dataField: "Brand",
                    caption: "Brand",
                    allowEditing:false
                },
                {
                    dataField: "Alamat_dest",
                    caption: "Alamat",
                    allowEditing:false
                },
                {
                    dataField: "Notlp_dest",
                    caption: "No Tlp",
                    allowEditing:false
                },
                {
                    dataField: "OldItem",
                    caption: "Kode Item",
                    allowEditing:false
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:false
                },
                {
                    dataField: "Article",
                    caption: "Article",
                    allowEditing:false
                },
                {
                    dataField: "Warna",
                    caption: "Warna",
                    allowEditing:false
                },
                {
                    dataField: "Expedisi",
                    caption: "Expedisi",
                    allowEditing:false
                },
                {
                    dataField: "noresi",
                    caption: "Resi",
                    allowEditing:false
                },
                {
                    dataField: "T_Ongkir",
                    caption: "Ongkir",
                    allowEditing:false
                },
                {
                    dataField: "Total",
                    caption: "Total",
                    allowEditing:false
                },
                {
                    dataField: "PaymentTerm",
                    caption: "PaymentTerm",
                    allowEditing:false
                },
                {
                    dataField: "Pembayaran",
                    caption: "Jumlah Pembayaran",
                    allowEditing:false
                },
            ],
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
    function bindGrid_B(data) {

      $("#gridContainer_B").dxDataGrid({
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
            searchPanel: {
                visible: true,
                width: 240,
                placeholder: "Search..."
            },
            export: {
                enabled: true,
                fileName: "Laporan Penjualan All"
            },
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "No Transaksi",
                    allowEditing:false,
                    groupIndex: 0
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tgl Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "num",
                    caption: "No",
                    allowEditing:false
                },
                {
                    dataField: "NamaCustomer",
                    caption: "Nama Customer",
                    allowEditing:false
                },
                {
                    dataField: "NamaSales",
                    caption: "Agen",
                    allowEditing:false
                },
                {
                    dataField: "Brand",
                    caption: "Brand",
                    allowEditing:false
                },
                {
                    dataField: "Alamat_dest",
                    caption: "Alamat",
                    allowEditing:false
                },
                {
                    dataField: "Notlp_dest",
                    caption: "No Tlp",
                    allowEditing:false
                },
                {
                    dataField: "OldItem",
                    caption: "Kode Item",
                    allowEditing:false
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:false
                },
                {
                    dataField: "Article",
                    caption: "Article",
                    allowEditing:false
                },
                {
                    dataField: "Warna",
                    caption: "Warna",
                    allowEditing:false
                },
                {
                    dataField: "Expedisi",
                    caption: "Expedisi",
                    allowEditing:false
                },
                {
                    dataField: "noresi",
                    caption: "Resi",
                    allowEditing:false
                },
                {
                    dataField: "T_Ongkir",
                    caption: "Ongkir",
                    allowEditing:false
                },
                {
                    dataField: "Total",
                    caption: "Total",
                    allowEditing:false
                },
                {
                    dataField: "PaymentTerm",
                    caption: "PaymentTerm",
                    allowEditing:false
                },
                {
                    dataField: "Pembayaran",
                    caption: "Jumlah Pembayaran",
                    allowEditing:false
                },
            ],
            summary:{
              groupItems:[
                {
                  column: "OldItem",
                  summaryType: "count",
                  displayFormat: "{0} Items",
                },
                {
                  column: "Qty",
                  summaryType : "sum",
                  showInGroupFooter: false,
                  alignByColumn: true
                },
                {
                  column: "T_Ongkir",
                  summaryType : "max",
                  showInGroupFooter: false,
                  alignByColumn: true
                },
                {
                  column: "Total",
                  summaryType : "sum",
                  showInGroupFooter: false,
                  alignByColumn: true
                },
                {
                  column: "Pembayaran",
                  summaryType : "max",
                  showInGroupFooter: false,
                  alignByColumn: true
                }
              ]
            }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>