<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>

<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-6 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Pembayaran Manual</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          	<div class="col-md-4 col-sm-12  form-group">
				<input type="date" class="form-control" name="tglAwalManual" id="tglAwalManual">
			</div>
			<div class="col-md-4 col-sm-12  form-group">
				<input type="date" class="form-control" name="tglAkhirManual" id="tglAkhirManual">
			</div>
			<div class="col-md-4 col-sm-12  form-group">
				<!-- <input type="date" class="form-control" name="tglAkhirManual" id="tglAkhirManual"> -->
				<button class="btn btn-success" id="searchManual">Search</button>
			</div>
			<div class="col-md-12 col-sm-12  form-group">
				<div class="dx-viewport demo-container">
		          <div id="data-grid-demo">
		            <div id="gridContainerManual">
		            </div>
		          </div>
		        </div>
			</div>
          </div>
        </div>
      </div>

      
      <div class="col-md-6 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Pembayaran Auto</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
          	<div class="col-md-4 col-sm-12  form-group">
				<input type="date" class="form-control" name="tglAwalAuto" id="tglAwalAuto">
			</div>
			<div class="col-md-4 col-sm-12  form-group">
				<input type="date" class="form-control" name="tglAkhirAuto" id="tglAkhirAuto">
			</div>
			<div class="col-md-4 col-sm-12  form-group">
				<!-- <input type="date" class="form-control" name="tglAkhirManual" id="tglAkhirManual"> -->
				<button class="btn btn-success" id="searchAuto">Search</button>
			</div>
			<div class="col-md-12 col-sm-12  form-group">
				<div class="dx-viewport demo-container">
		          <div id="data-grid-demo">
		            <div id="gridContainerAuto">
		            </div>
		          </div>
		        </div>
			</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Bukti Transfer</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      	<center>
      		<img id="BuktiTransfer" name="BuktiTransfer" width="50%" height="50%">
      	</center>
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
			$('#searchManual').click();
			$('#searchAuto').click();
	    });

		$('.close').click(function() {
	      // location.reload();
	      $('#BuktiTransfer').attr('src', '');
	    });

		$('#searchManual').click(function () {
			$.ajax({
		        type: "post",
		        url: "<?=base_url()?>C_Transaksi/GetPembayaranList",
		        data: {'Tglawal':$('#tglAwalManual').val(),'TglAkhir': $('#tglAkhirManual').val(), 'Metode' : 'MANUAL', 'NoTransaksi':''},
		        dataType: "json",
		        success: function (response) {
		          gridContainerManual(response.data);
		        }
		      });
		});

		$('#searchAuto').click(function () {
			$.ajax({
		        type: "post",
		        url: "<?=base_url()?>C_Transaksi/GetPembayaranList",
		        data: {'Tglawal':$('#tglAwalManual').val(),'TglAkhir': $('#tglAwalManual').val(), 'Metode' : 'AUTO','NoTransaksi':''},
		        dataType: "json",
		        success: function (response) {
		          gridContainerAuto(response.data);
		        }
		      });
		});

		function gridContainerManual(data) {
			$("#gridContainerManual").dxDataGrid({
				allowColumnResizing: true,
	            dataSource: data,
	            keyExpr: "NoTransaksi",
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
	                fileName: "Daftar Pembayaran Manual"
	            },
	            columns: [
	            	{
	                	dataField: "FileItem",
		                caption : "Action",
		                allowEditing : false,
		                cellTemplate: function(cellElement, cellInfo) {
		                	var html = "";
		                	html += "<button class='btn btn-round btn-sm btn-success' onClick = 'btAction("+cellInfo.data.NoTransaksi+",1)'>View</button>";
		                	if (cellInfo.data.Mid_TransactionStatus == 'settlement') {
		                		html += "<button class='btn btn-round btn-sm btn-danger' disabled onClick = 'btAction("+cellInfo.data.NoTransaksi+",2)'>Konfirmasi</button>"; 
		                	}
		                	else{
		                		html += "<button class='btn btn-round btn-sm btn-danger' onClick = 'btAction("+cellInfo.data.NoTransaksi+",2)'>Konfirmasi</button>"; 
		                	}
                      		cellElement.append(html);
		                }
	                },
	                {
	                    dataField: "NoTransaksi",
	                    caption: "No Transaksi",
	                    allowEditing:false
	                },
	                {
	                    dataField: "TglTransaksi",
	                    caption: "TanggalTransaksi",
	                    allowEditing:false
	                },
	                {
	                    dataField: "MetodePembayaran",
	                    caption: "Pembayaran",
	                    allowEditing:false
	                },
	                {
	                    dataField: "TotalPembelian",
	                    caption: "Total Pembelian",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Mid_TransactionStatus",
	                    caption: "Status",
	                    allowEditing:false
	                },
	            ],
			});
		}

		function gridContainerAuto(data) {
			$("#gridContainerAuto").dxDataGrid({
				allowColumnResizing: true,
	            dataSource: data,
	            keyExpr: "NoTransaksi",
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
	                fileName: "Daftar Pembayaran Auto"
	            },
	            columns: [
	                {
	                    dataField: "NoTransaksi",
	                    caption: "No Transaksi",
	                    allowEditing:false
	                },
	                {
	                    dataField: "TglTransaksi",
	                    caption: "TanggalTransaksi",
	                    allowEditing:false
	                },
	                {
	                    dataField: "MetodePembayaran",
	                    caption: "Metode Pembayaran",
	                    allowEditing:false
	                },
	                {
	                    dataField: "TotalPembelian",
	                    caption: "Total Pembelian",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Mid_Bank",
	                    caption: "Bank",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Mid_VANumber",
	                    caption: "VA Number",
	                    allowEditing:false
	                },
	                {
	                    dataField: "Mid_TransactionStatus",
	                    caption: "Status",
	                    allowEditing:false
	                },
	            ],
			});
		}
	});
	
	function btAction(id, action) {
		// 1 view
		// 2 Konfirmasi

		switch(action){
			case 1:
	        $.ajax({
		        type: "post",
		        url: "<?=base_url()?>C_Transaksi/GetPembayaranList",
		        data: {'Tglawal':$('#tglAwalManual').val(),'TglAkhir': $('#tglAkhirManual').val(), 'Metode' : 'MANUAL', 'NoTransaksi':id},
		        dataType: "json",
		        success: function (response) {
		          // gridContainerManual(response.data);
		          $.each(response.data,function (k,v) {
		          	$('#BuktiTransfer').attr('src', v.Attachment);
		          });
		          $('#modal_').modal('show');
		        }
		      });
	        break;
	        case 2:
	        Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Konfirmasi Pembayaran ini !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                if (result.value) {
                  $.ajax({
                      type    :'post',
                      url     : '<?=base_url()?>C_Transaksi/konfirmasiPembelian',
                      data    : {'NoTransaksi':id},
                      dataType: 'json',
                      success : function (response) {
                        if(response.success == true){
                          Swal.fire(
	                        'Deleted!',
	                        'Your file has been deleted.',
	                        'success'
	                      ).then((result)=>{
                            // location.reload();
                            $('#searchManual').click();
                          });
	                    }
                        else{
                          Swal.fire({
                            type: 'error',
                            title: 'Woops...',
                            text: response.message,
                            // footer: '<a href>Why do I have this issue?</a>'
                          }).then((result)=>{
                            // location.reload();
                            $('#searchManual').click();
                          });
                        }
                      }
                    });
                  
                }
                else{
                  location.reload();
                }
              });
	        break;
		}
	}
</script>