<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<style type="text/css">
  .select2-container {
  width: 100% !important;
  }
  .dx-datagrid-text-content {  
    text-align: center!important;  
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
            <h2>Laporan Stok</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
                <label class="col-form-label label-align" for="first-name">Periode <span class="required">*</span>
                </label>
                <div class="col-md-3 col-sm-3  form-group">
                    <select id="Bulan" name="Bulan" class="js-states form-control">
                      <option value = ''>Bulan</option>
                      <option value="01">Januari</option>
                      <option value="02">Februari</option>
                      <option value="03">Maret</option>
                      <option value="04">April</option>
                      <option value="05">Mei</option>
                      <option value="06">Juni</option>
                      <option value="07">Juli</option>
                      <option value="08">Agustus</option>
                      <option value="09">September</option>
                      <option value="10">Oktober</option>
                      <option value="11">November</option>
                      <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-3  form-group">
                    <select id="Tahun" name="Tahun" class="js-states form-control">
                      <option value = ''>Tahun</option>
                      <option value="2020">2020</option>
                      <option value="2021">2021</option>
                      <option value="2022">2022</option>
                      <option value="2023">2023</option>
                      <option value="2024">2024</option>
                      <option value="2025">2025</option>
                      <option value="2026">2026</option>
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
      $('#Bulan').select2({
        width : 'resolve',
        placeholder: 'Bulan'
      });
      $('#Tahun').select2({
        width : 'resolve',
        placeholder: 'Tahun'
      });

      var button = $('#filterbutton');
      button.click();
    });
    $('#filterbutton').click(function () {
        $.ajax({
            type: "post",
            url: "<?=base_url()?>C_Laporan/LaporanStok",
            data: {'Periode':$('#Tahun').val() +'-'+ $('#Bulan').val()},
            dataType: "json",
            success: function (response) {
              bindGrid_A(response.data);  
            }
        });
    })
    function bindGrid_A(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeItem",
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
                fileName: "Laporan Stok"
            },
            columnFixing: {
                enabled: true
            },
            columns: [
                {
                    dataField: "KodeItem",
                    caption: "#",
                    allowEditing:false,
                    fixed: true,
                },
                {
                    dataField: "KodeItemLama",
                    caption: "Kode Item",
                    allowEditing:false,
                    fixed: true,
                },
                {
                    dataField: "Article",
                    caption: "Article",
                    allowEditing:false,
                    fixed: true,
                },
                {
                    dataField: "Warna",
                    caption: "Warna",
                    allowEditing:false,
                    fixed: true,
                },
                {
                    dataField: "SaldoAwal",
                    caption: "Saldo Awal",
                    allowEditing:false,
                    fixed: true,
                },

                {
                    caption : '01/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN1",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT1",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO1",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL1",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET1",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC1",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '02/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN2",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT2",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO2",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL2",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET2",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC2",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '03/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN3",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT3",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO3",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL3",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET3",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC3",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '04/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN4",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT4",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO4",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL4",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET4",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC4",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '05/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN5",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT5",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO5",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL5",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET5",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC5",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '06/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN6",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT6",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO6",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL6",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET6",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC6",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '07/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN7",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT7",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO7",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL7",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET7",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC7",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '08/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN8",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT8",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO8",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL8",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET8",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC8",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '09/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN9",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT9",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO9",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL9",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET9",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC9",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '10/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN10",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT10",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO10",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL10",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET10",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC10",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '11/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN11",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT11",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO11",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL11",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET11",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC11",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '12/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN12",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT12",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO12",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL12",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET12",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC12",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '13/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN13",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT13",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO13",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL13",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET13",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC13",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '14/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN14",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT14",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO14",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL14",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET14",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC14",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '15/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN15",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT15",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO15",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL15",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET15",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC15",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '16/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN16",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT16",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO16",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL16",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET16",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC16",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '17/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN17",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT17",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO17",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL17",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET17",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC17",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '18/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN18",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT18",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO18",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL18",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET18",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC18",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '19/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN19",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT19",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO19",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL19",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET19",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC19",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '20/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN20",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT20",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO20",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL20",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET20",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC20",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '21/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN21",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT21",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO21",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL21",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET21",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC21",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '22/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN22",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT22",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO22",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL22",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET22",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC22",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '23/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN23",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT23",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO23",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL23",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET23",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC23",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '24/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN24",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT24",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO24",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL24",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET24",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC24",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '25/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN25",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT25",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO25",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL25",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET25",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC25",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '26/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN26",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT26",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO26",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL26",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET26",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC26",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '27/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN27",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT27",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO27",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL27",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET27",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC27",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '28/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN28",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT28",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO28",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL28",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET28",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC28",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '29/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN29",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT29",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO29",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL29",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET29",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC29",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '30/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN30",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT30",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO30",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL30",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET30",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC30",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    caption : '31/'+$('#Bulan').val()+'/'+$('#Tahun').val(),
                    HorizontalAlignment : 'center',
                    columns : [
                        {
                            dataField: "IN31",
                            caption: "Adj IN",
                            allowEditing:false
                        },
                        {
                            dataField: "OUT31",
                            caption: "Adj OUT",
                            allowEditing:false
                        },
                        {
                            dataField: "BOO31",
                            caption: "Booking",
                            allowEditing:false
                        },
                        {
                            dataField: "PJL31",
                            caption: "Penjualan",
                            allowEditing:false
                        },
                        {
                            dataField: "RET31",
                            caption: "Retur",
                            allowEditing:false
                        },
                        {
                            dataField: "EXC31",
                            caption: "Retur",
                            allowEditing:false
                        },
                    ]
                },

                {
                    dataField: "SaldoAkhir",
                    caption: "Saldo Akhir",
                    allowEditing:false
                },
            ],
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>