<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<style type="text/css">
  .select2-container {
  width: 100% !important;
  }
  ::ng-deep .dx-row.dx-data-row.dx-column-lines.dx-state-hover td {  
    background: red!important;  
  }  
</style>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Booking Barang</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No Transaksi <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 ">
                          <input type="text" name="NoTransaksi" id="NoTransaksi" required="" placeholder="Kode Item" class="form-control" readonly="" value="<AUTO>">
                          <input type="hidden" name="Mutasi" id="Mutasi" value="2">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tanggal Transaksi <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 ">
                          <input type="date" name="TglTransaksi" id="TglTransaksi" required="" placeholder="Tanggal Transaksi" class="form-control ">
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Sales <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 ">
                          <select class="js-states form-control" id="KodeSales" name="KodeSales" >
                            <option value = ''>Pilih Sales</option>
                            <?php
                              $rs = $this->db->query("select * from tsales where isActive = 1")->result();
                              foreach ($rs as $key) {
                                echo "<option value = '".$key->KodeSales."'>".$key->NamaSales."</option>";
                              }
                            ?>
                          </select>
                        </div>
                      </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Keterangan <span class="required">*</span>
                        </label>
                        <div class="col-md-8 col-sm-8 ">
                          <textarea class="form-control" id="Keterangan" name="Keterangan"></textarea>
                          <!-- <input type="date" name="TglTransaksi" id="TglTransaksi" required="" placeholder="Tanggal Transaksi" class="form-control "> -->
                        </div>
                      </div>
                      <div class="dx-viewport demo-container">
                        <div id="data-grid-demo">
                          <div id="gridContainerItem">
                          </div>
                        </div>
                      </div>
                      <br>
                    </form>
                    <div class="item" form-group>
                      <button class="btn btn-primary" id="btn_Save">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12  ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar Booking Barang</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                      <div class="row">
                        <label class="col-form-label label-align" for="first-name">Tanggal <span class="required">*</span>
                        </label>
                        <div class="col-md-3 col-sm-3  form-group">
                          <input type="date" id="TglAwal" name="TglAwal" placeholder="dd-mm-yyyy" dateformat="dd-mm-yyyy" class="form-control" value="<?php echo date("Y-m-d");?>">
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
                          <div id="gridContainerHeader">
                          </div>
                        </div>
                      </div>
                      <br>
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

        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_Lookup">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Item Master Data</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="item form-group">
                  <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Search <span class="required">*</span>
                  </label>
                  <div class="col-md-8 col-sm-8 ">
                    <input type="text" name="mySearch" id="mySearch" placeholder="Search" class="form-control ">
                  </div>
                </div>
                <table class="table table-striped table-bordered" id="ItemLookup">
                  <thead>
                      <tr>
                        <th>Kode Item</th>
                        <th>Nama Item</th>
                        <th>Article</th>
                        <th>Stok Akhir</th>
                        <th>Default Price</th>
                      </tr>
                    </thead>
                    <tbody id="load_Lookup">
                      
                    </tbody>
                </table>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>

            </div>
          </div>
        </div>
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  var row_validate = 0;
  var items_data;
  var itemJson = "";
  // constanta
  var _ItemCode = 0;
  var _ItemName = 1;
  var _OnHand = 2;
  var _Price = 3;
  var _Qty = 4;
  $(function () {
    $(document).ready(function () {
      // Auto Search
      $("#mySearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#load_Lookup tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      // End Auto Search

      $('#KodeSales').select2({
        width : 'resolve',
        placeholder: 'Pilih Sales'
      });
      

      var TglAwal = $('#TglAwal').val();
      var TglAkhir = $('#TglAkhir').val();

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Booking/ReadHeader",
        data: {'TglAwal':TglAwal,'TglAkhir':TglAkhir},
        dataType: "json",
        success: function (response) {
          console.log(response.data)
          bindGridHeader(response.data);
          bindGridDetail(response.data);
        }
      });
      // dummy

      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>C_Booking/getDummy',
        dataType: 'json',
        success:function (response) {
          if(response.success == true){
          // console.log(response);
            // returnjson = response.data;
            items_data = response.data;
            bindGridItem(items_data);
          }
        }
      });
    });
    $('#ItemLookup').on('click','tr',function () {
      var ItemCode = $(this).find("#ItemCode").text();
      var ItemName = $(this).find("#ItemName").text();
      var Stok = $(this).find("#Stok").text();
      var dflt = $(this).find("#dflt").text();

      var prevQty = 0;
      // console.log(items_data);
      for (var i = 0; i < items_data.length; i++) {
        if (items_data[i]["ItemCode"] == ItemCode) {
          prevQty = items_data[i]["Qty"];
          // items_data.remove(i);
          items_data.splice(i, 1);
        }
        else{
          prevQty = 0;
        }
      }

      if (parseInt(prevQty) + 1 > Stok) {
        $('#modal_Lookup').modal('toggle');
        Swal.fire({
          type: 'error',
          title: 'Woops...',
          text: 'Jumlah Tersedia Lebih kecil dari jumlah yang di Keluarkan',
          // footer: '<a href>Why do I have this issue?</a>'
        }).then((result)=>{
          row_validate = 0
          $('#modal_Lookup').modal('show');
        });
      }
      else{
        items_data.push({
          ItemCode : ItemCode,
          ItemName : ItemName,
          Qty : parseInt(prevQty) + 1,
          Price:dflt,
          OnHand:Stok,
          __KEY__:create_UUID()
        });
        row_validate +=1;
        bindGridItem(items_data);
      }
      
      validation(row_validate);
    });

    $('#btn_Save').click(function () {
      $('#btn_Save').text('Tunggu Sebentar');
      $('#btn_Save').attr('disabled',true);

      var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
      // console.log(gridItems);
      var TglTransaksi    = $('#TglTransaksi').val();
      var StatusTransaksi = $('#StatusTransaksi').val();
      var KodeSales       = $('#KodeSales').val();
      var Keterangan      = $('#Keterangan').val();
      var array_detail    = JSON.stringify(gridItems)

      $.ajax({
        async : false,
        type: "post",
        url: "<?=base_url()?>C_Booking/CRUD",
        data: {'TglTransaksi':TglTransaksi,'StatusTransaksi':StatusTransaksi,'KodeSales':KodeSales,'Keterangan':Keterangan,'array_detail':array_detail},
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            Swal.fire({
              type: 'success',
              title: 'Woops...',
              text: 'Data Berhasil diproses',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
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
              $('#modal_').modal('show');
              $('#btn_Save').text('Save');
              $('#btn_Save').attr('disabled',false);
            });
          }
        }
      });
    });

    $('#filterbutton').click(function () {
      var TglAwal = $('#TglAwal').val();
      var TglAkhir = $('#TglAkhir').val();
      
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Booking/ReadHeader",
        data: {'TglAwal':TglAwal,'TglAkhir':TglAkhir,'Mutasi':2},
        dataType: "json",
        success: function (response) {
          bindGridHeader(response.data);
          bindGridDetail(response.data);
        }
      });
    });
    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_ItemMasterData/read",
        data: {'id':id},
        dataType: "json",
        success: function (response) {
          $.each(response.data,function (k,v) {
            $('#ItemCode').val(v.ItemCode);
            $('#KodeItemLama').val(v.KodeItemLama);
            $('#ItemName').val(v.ItemName);
            $('#A_Warna').val(v.A_Warna).change();
            $('#A_Motif').val(v.A_Motif).change();
            $('#A_Size').val(v.A_Size).change();
            $('#A_Sex').val(v.A_Sex).change();
            $('#DefaultPrice').val(v.DefaultPrice);
            $('#ItemGroup').val(v.ItemGroup).change();
            // $('#Nilai').val(v.Nilai);

            $('#formtype').val("edit");

            // $(window).scrollTop(0);
            $('html').animate({scrollTop:0}, 'slow');//IE, FF
            $('body').animate({scrollTop:0}, 'slow');//chrome, don't know if Safari works
            $('.popupPeriod').fadeIn(1000, function(){
                setTimeout(function(){$('.popupPeriod').fadeOut(2000);}, 3000);
            });
          });
        }
      });
    }

    function bindGridItem(data) {
      var store = new DevExpress.data.ArrayStore(data);
      $("#gridContainerItem").dxDataGrid({
            dataSource: store,
            showBorders: true,
            allowColumnReordering: false,
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
            columns: [
                {
                    dataField: "ItemCode",
                    caption: "Kode Item",
                    allowEditing:true,
                    allowSorting: false
                },
                {
                    dataField: "ItemName",
                    caption: "Nama Item",
                    allowEditing:false,
                    allowSorting: false
                },
                {
                    dataField: "Qty",
                    caption: "Jumlah",
                    allowEditing:true,
                    allowSorting: false
                },
                {
                    dataField: "Price",
                    caption: "Price",
                    allowEditing:true,
                    allowSorting: false
                },
                {
                    dataField: "OnHand",
                    caption: "OnHand",
                    allowEditing:false,
                    allowSorting: false
                },
            ],
            onEditingStart: function(e) {
                GetData(e.data.ItemCode);
            },
            onInitNewRow: function(e) {
            },
            onRowInserting: function(e) {
                // logEvent("RowInserting");
            },
            onRowInserted: function(e) {
              console.log();
              var grid = $("#gridContainerItem").dxDataGrid("instance");
                if (parseInt(e.data.OnHand) >= parseInt(e.data.Qty) && parseInt(e.data.Qty) > 0) {
                  var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
                  // console.log(gridItems);
                  // console.log(gridItems[0]["__KEY__"]);
                  var arr = {"ItemCode":"","ItemName":"","OnHand":0,"Price":0,"Qty":0,"__KEY__":""}

                  for (var i = 0; i < gridItems.length; i++) {
                    if (gridItems[i]["ItemCode"] == e.data.ItemCode && gridItems.length > 1 && e.key.__KEY__ != gridItems[i]["__KEY__"]) {
                      // console.log("Edit array nya dong"+i);
                      arr["ItemCode"] = gridItems[i]["ItemCode"];
                      arr["ItemName"] = gridItems[i]["ItemName"];
                      arr["OnHand"]   = gridItems[i]["OnHand"];
                      arr["Price"]    = gridItems[i]["Price"];
                      arr["Qty"]      = parseInt(gridItems[i]["Qty"])+parseInt(e.data.Qty);
                      arr["__KEY__"]  = gridItems[i]["__KEY__"];

                      store.remove(e.data);
                      store.update(gridItems[i],arr)
                      grid.refresh();
                      // console.log(gridItems[i]);
                    }
                    // console.log(gridItems[i]["ItemName"]);

                  }
                  if (e.data.Qty > 0) {
                    row_validate += 1;
                    validation(row_validate);
                  }
                }
                else{
                Swal.fire({
                    type: 'error',
                    title: 'Woops...',
                    text: 'Jumlah Tersedia Lebih kecil dari jumlah yang di Keluarkan',
                    // footer: '<a href>Why do I have this issue?</a>'
                  }).then((result)=>{
                    var button = $('.dx-link-edit');
                    button.click();
                    row_validate = 0
                    validation(row_validate);
                  });
                }
                // $('#array_detail').val('');
                // $('#array_detail').val(itemJson);
            },
            onRowUpdating: function(e) {
                // logEvent("RowUpdating");
                
            },
            onRowUpdated: function(e) {
                // logEvent(e);
                var grid = $("#gridContainerItem").dxDataGrid("instance");
                if (e.data.OnHand >= e.data.Qty && e.data.Qty > 0) {
                  var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
                  // console.log(gridItems);
                  // console.log(gridItems[0]["__KEY__"]);
                  var arr = {"ItemCode":"","ItemName":"","OnHand":0,"Price":0,"Qty":0,"__KEY__":""}

                  for (var i = 0; i < gridItems.length; i++) {
                    if (gridItems[i]["ItemCode"] == e.data.ItemCode && gridItems.length > 1 && e.key.__KEY__ != gridItems[i]["__KEY__"]) {
                      // console.log("Edit array nya dong"+i);
                      arr["ItemCode"] = gridItems[i]["ItemCode"];
                      arr["ItemName"] = gridItems[i]["ItemName"];
                      arr["OnHand"]   = gridItems[i]["OnHand"];
                      arr["Price"]    = gridItems[i]["Price"];
                      arr["Qty"]      = parseInt(gridItems[i]["Qty"])+parseInt(e.data.Qty);
                      arr["__KEY__"]  = gridItems[i]["__KEY__"];

                      store.remove(e.data);
                      store.update(gridItems[i],arr)
                      grid.refresh();
                      // console.log(gridItems[i]);
                    }
                    // console.log(gridItems[i]["ItemName"]);

                  }
                  if (e.data.Qty > 0) {
                    row_validate += 1;
                    validation(row_validate);
                  }
                }
                else{
                Swal.fire({
                    type: 'error',
                    title: 'Woops...',
                    text: 'Jumlah Tersedia Lebih kecil dari jumlah yang di Keluarkan',
                    // footer: '<a href>Why do I have this issue?</a>'
                  }).then((result)=>{
                    var button = $('.dx-link-edit');
                    button.click();

                    row_validate = 0
                    validation(row_validate);
                  });
                }
            },
            onRowRemoving: function(e) {
            },
            onRowRemoved: function(e) {
              row_validate = row_validate - 1;
              validation(row_validate);
              // console.log(e);
            },
            onEditorPrepared: function (e) {
              if (e.dataField == "ItemCode") {
                $(e.editorElement).dxTextBox("instance").on("valueChanged", function (args) {                           
                  var grid = $("#gridContainerItem").dxDataGrid("instance");
                  var index = e.row.rowIndex;
                  var result = "new description ";

                  var length = 0;

                  var kode = args.value;
                  $.ajax({
                      type    :'post',
                      url     : '<?=base_url()?>C_ItemMasterData/Read',
                      data    : {'kriteria':kode,'id':'1'},
                      dataType: 'json',
                      success:function (response) {
                        if(response.success == true){
                          length = response.data.length;
                          if (length == 1) {
                            $.each(response.data,function (k,v) {
                              //ClmID
                              grid.cellValue(index, "ItemCode", v.ItemCode);
                              grid.cellValue(index, "ItemName", v.ItemName);
                              grid.cellValue(index, "OnHand", v.Stok);
                              grid.cellValue(index, "Price", v.DefaultPrice);
                            });
                            grid.cellValue(index, "Qty", 1);
                          }
                          else{
                            var html = '';
                            var i;
                            var j = 1;
                            for (i = 0; i < response.data.length; i++) {
                              html += '<tr>' +
                                      '<td id = "ItemCode">' + response.data[i].ItemCode+'</td>' +
                                      '<td id = "ItemName">' + response.data[i].ItemName + '</td>' +
                                      '<td id = "Article">' + response.data[i].Article + '</td>' +
                                      '<td id = "Stok">' + response.data[i].Stok + '</td>' +
                                      '<td id = "dflt">' + response.data[i].DefaultPrice + '</td>' +
                                      '<tr>';
                               j++;
                            }
                            $('#load_Lookup').html(html);
                            items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
                            console.log(items_data);
                            $('#modal_Lookup').modal('show');
                          }
                        }
                        else{
                          Swal.fire({
                              type: 'error',
                              title: 'Woops...',
                              text: response.message,
                              // footer: '<a href>Why do I have this issue?</a>'
                            })
                        }
                      }
                    });
                });
              }
            },
            onRowValidating:function(e) {
            },
            onCellPrepared:function (e) {
              // console.log(e.row)
              if(e.rowType === "data" && e.column.command === "edit") {  
                  var isEditing = e.row.isEditing,  
                      $links = e.cellElement.find(".dx-link");  
                  if(isEditing){  

                      $links.filter(".dx-link-cancel").on("click", function(args) {  console.log("cancel_clicked");  });  
                  }  
              }
            }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    function bindGridHeader(data) {

      $("#gridContainerHeader").dxDataGrid({
        allowColumnResizing: true,
            dataSource: {
                store: {
                  type: "array",
                  key: "NoTransaksi",
                  data: data
                  // Other LocalStore options go here
              },
              select: [
                'NoTransaksi',
                'TglTransaksi',
                'NamaSales',
                'Keterangan'
              ]
            },
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            paging: {
                pageSize: 10,
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
            columns: [
                {
                    dataField: "NoTransaksi",
                    caption: "#",
                    allowEditing:false
                },
                {
                    dataField: "TglTransaksi",
                    caption: "Tanggal Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "NamaSales",
                    caption: "Sales",
                    allowEditing:false
                },
                {
                    dataField: "Keterangan",
                    caption: "Keterangan",
                    allowEditing:false
                },
                {
                      dataField: "FileItem",
                      caption: "Action",
                      allowEditing:false,
                      cellTemplate: function(cellElement, cellInfo) {
                        var LinkAccess = "";
                        // console.log(cellElement.data.NoTransaksi);
                        LinkAccess = "<button class='badge badge-warning' id='close_trx' onClick =ChangeTransactionStatus('"+cellInfo.data.NoTransaksi+"','C')>Close</button>&nbsp;&nbsp;<button class='badge badge-danger' id = 'cancel_trx' onClick =ChangeTransactionStatus('"+cellInfo.data.NoTransaksi+"','D')>Cancel</button>";
                        cellElement.append(LinkAccess);
                    }
                  },
            ],
            focusedRowEnabled: true,
            focusedRowKey: 0,
            onEditingStart: function(e) {
                GetData(e.data.ItemCode);
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
            const xdata = rowData && rowData.NoTransaksi
            
            if (xdata != "") {
              $.ajax({
                type    :'post',
                url     : '<?=base_url()?>C_Booking/ReadDetail',
                data    : {'HeaderID':xdata},
                dataType: 'json',
                success:function (response) {
                  if(response.success == true){
                    bindGridDetail(response.data);
                  }
                }
              });
            }
          }
        }).dxDataGrid("instance");

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    function bindGridDetail(data) {

      $("#gridContainerDetail").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "LineNum",
            showBorders: true,
            allowColumnReordering: true,
            allowColumnResizing: true,
            columnAutoWidth: true,
            showBorders: true,
            editing: {
                mode: "row",
                texts: {
                    confirmDeleteMessage: ''  
                }
            },
            columns: [
                {
                    dataField: "LineNum",
                    caption: "#",
                    allowEditing:false,
                    visible:false,
                },
                {
                    dataField: "KodeItem",
                    caption: "Kode Item",
                    allowEditing:false
                },
                {
                    dataField: "Article",
                    caption: "Article",
                    allowEditing:false
                },
                {
                    dataField: "ItemName",
                    caption: "Nama Item",
                    allowEditing:false
                },
                {
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:false
                },
                {
                    dataField: "Price",
                    caption: "Harga",
                    allowEditing:false
                },
                {
                    dataField: "LineTotal",
                    caption: "Total",
                    allowEditing:false
                }
            ],
            onEditingStart: function(e) {
                GetData(e.data.ItemCode);
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
            onEditorPrepared: function (e) {
              // console.log(e);
            }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

  });
function validation(rowvalidate) {
  if (rowvalidate == 0) {
    $('#btn_Save').attr('disabled',true);
  }
  else{
    $('#btn_Save').attr('disabled',false);  
  }
}
function create_UUID(){
    var dt = new Date().getTime();
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (dt + Math.random()*16)%16 | 0;
        dt = Math.floor(dt/16);
        return (c=='x' ? r :(r&0x3|0x8)).toString(16);
    });
    return uuid;
}
function GetRowData(row) {
    const rowData = row && row.data;
    console.log(rowData);
    const taskItem = {
        HeaderID: ""
    };
    if(rowData) {
        taskItem.HeaderID = rowData.NoTransaksi;
    }
    return taskItem;
}
function ChangeTransactionStatus(NoTransaksi,Status) {
  // alert(NoTransaksi+' - '+Status);
  var StringStatus = '';
  if (Status == 'C') {
    StringStatus = 'Close';
  }
  else if(Status == 'D'){
    StringStatus = 'Cancel'; 
  }
  Swal.fire({
    title: 'Apakah anda yakin?',
    text: "anda akan "+StringStatus+" Dokumen No "+NoTransaksi+" ?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then((result) => {
    if (result.value) {

      $.ajax({
          type    :'post',
          url     : '<?=base_url()?>C_General/ChangeStatus',
          data    : {'NoTransaksi':NoTransaksi,'TableName':'bookheader','Value':Status},
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
}
</script>