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
            <h2>Laporan Penjualan Shopee</h2>
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
        type: "post",
        url: "<?=base_url()?>C_Laporan/LaporanPenjualanShoppe",
        data: {'TglAwal':$('#TglAwal').val(),'TglAkhir':$('#TglAkhir').val()},
        dataType: "json",
        success: function (response) {
          bindGrid_A(response.data);
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
                fileName: "Laporan Penjualan Ecomerce"
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
                    dataField: "RefNumberTrx",
                    caption: "No Pemesanan",
                    allowEditing:false
                },
                {
                    dataField: "NmAkun",
                    caption: "Nama Akun",
                    allowEditing:false
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:false
                },
                {
                    dataField: "NominalCair",
                    caption: "Nominal Cair",
                    allowEditing:false
                },
                {
                    dataField: "NoResi",
                    caption: "No Resi",
                    allowEditing:false
                },
                {
                    dataField: "Debet",
                    caption: "Total Penjualan Real",
                    allowEditing:false
                },
                {
                    dataField: "selisih",
                    caption: "Selisih Pencairan",
                    allowEditing:false
                },
                {
                    dataField: "Keterangan",
                    caption: "Keterangan ",
                    allowEditing:false
                },
            ],
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>