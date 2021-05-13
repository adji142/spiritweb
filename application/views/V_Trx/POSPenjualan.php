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
<input type="hidden" name="LevelingPrice" id="LevelingPrice">
<input type="hidden" name="beratStandar" id="beratStandar" value="0">
<input type="hidden" name="ServiceXPDC" id="ServiceXPDC" value="0">
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>TRANSAKSI PENJUALAN - POS</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="row">
              <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Point Of Sales</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Transaction History</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="Print-tab" data-toggle="tab" href="#Print_format" role="tab" aria-controls="profile" aria-selected="false">Cetak Format Kirim</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                  <div class="form-label-left input_mask">

                    <div class="row col-md-12 col-sm-12">
                      <div class="col-md-2 col-sm-12 form-group">
                        <label class="col-form-label label-align" for="first-name">Trx Date <span class="required">*</span>
                        </label>
                      </div>
                      <div class="col-md-5 col-sm-12 form-group">
                        <input type="date" name="TglTransaksi" id="TglTransaksi" class="form-control" value="<?php echo date("Y-m-d") ?>">
                      </div>
                      <div class="col-md-5 col-sm-12 form-group">
                        <select class="js-states form-control" id="KodeSales" name="KodeSales" >
                          <option value = ''>Sales / Agen</option>
                          <?php
                            $rs = $this->db->query("select * from tsales where isActive = 1")->result();
                            foreach ($rs as $key) {
                              echo "<option value = '".$key->KodeSales."'>".$key->NamaSales."</option>";
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="row col-md-12 col-sm-12">
                      <div class="col-md-2 col-sm-12 form-group">
                        <label class="col-form-label label-align" for="first-name">Customer <span class="required">*</span>
                        </label>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="KodeCustomerPOS" name="KodeCustomerPOS" >
                          <option value = ''>Customer</option>
                        </select>
                        <a href="#" id="AddCust">Customer Baru</a>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="TransactionType" name="TransactionType" >
                          <option value = ''>Pilih Tipe Transaksi</option>
                          <option value="1">Shoppe</option>
                          <option value="2">Direct Sales</option>
                          <!-- <option value="3">Dropship</option> -->
                          <option value="4">Reseller</option>
                        </select>
                        <br><br>
                        <div id="ClassNumTrx">
                          
                        </div>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="PaymentTerm" name="PaymentTerm" >
                          <option value = ''>Jenis Pembayaran</option>
                          <?php
                            $rs = $this->db->query("select * from tpayment")->result();
                            foreach ($rs as $key) {
                              echo "<option value = '".$key->id."'>".$key->PaymentTerm."</option>";
                            }
                          ?>
                        </select>
                        <br><br>
                        <div id="ClassNumPayment"></div>
                      </div>
                    </div>
                    <center><h3>Origin Paket</h3></center>
                    <div class="row col-md-12 col-sm-12">
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="provinsi_ori" name="provinsi_ori" disabled="" >
                          <option value = ''>Provinsi</option>
                          <?php
                            $rs = $this->db->query("select * from ro_provinces")->result();
                            foreach ($rs as $key) {
                              echo "<option value = '".$key->id."'>".$key->name."</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="Kota_ori" name="Kota_ori" disabled="" >
                          
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="Kecamatan_ori" name="Kecamatan_ori" disabled="" >
                          
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="Kelurahan_ori" name="Kelurahan_ori" disabled="" >
                          
                        </select>
                      </div>
                    </div>
                    <div class="row col-md-12 col-sm-12">
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="KodePOS_ori" id="KodePOS_ori" class="form-control" readonly="">
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <!-- <input type="text" name="Alamat_ori" id="Alamat_ori"> -->
                        <textarea name="Alamat_ori" id="Alamat_ori" class="form-control" rows="1" readonly=""></textarea>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="Nama_ori" id="Nama_ori" class="form-control" placeholder="Nama Pengirim">
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="Notlp_Ori" id="Notlp_Ori" class="form-control" placeholder="No Telepon">
                      </div>
                    </div>

                    <center><h3>Destination Paket</h3></center>
                    <div class="row col-md-12 col-sm-12">
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="provinsi_dest" name="provinsi_dest">
                          <option value = ''>Provinsi</option>
                          <?php
                            $rs = $this->db->query("select * from ro_provinces")->result();
                            foreach ($rs as $key) {
                              echo "<option value = '".$key->id."'>".$key->name."</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="Kota_dest" name="Kota_dest">
                          
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="Kecamatan_dest" name="Kecamatan_dest">
                          
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="Kelurahan_dest" name="Kelurahan_dest">
                          
                        </select>
                      </div>
                    </div>
                    <div class="row col-md-12 col-sm-12">
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="KodePOS_dest" id="KodePOS_dest" class="form-control" placeholder="Kode POS">
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <!-- <input type="text" name="Alamat_ori" id="Alamat_ori"> -->
                        <textarea name="Alamat_dest" id="Alamat_dest" class="form-control" rows="1" placeholder="Alamat Lengkp"></textarea>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="Nama_dest" id="Nama_dest" class="form-control" placeholder="Nama Penerima">
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="Notlp_dest" id="Notlp_dest" class="form-control" placeholder="No Tlp Penerima">
                      </div>
                    </div>

                    <div class="row col-md-12 col-sm-12">
                      <label class="col-md-2 col-sm-12 form-group" for="first-name">Expedisi <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select class="js-states form-control" id="Expedisi" name="Expedisi">
                          <option value = ''>Expedisi</option>
                          <?php
                            $rs = $this->db->query("select * from texpdc")->result();
                            foreach ($rs as $key) {
                              echo "<option value = '".$key->KodeExpdc."'>".$key->NamaExpdc."</option>";
                            }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <select id="cekongkir_TableInfo" name="cekongkir_TableInfo" class="js-states form-control">
                          <option value="0">Pilih Service Pengiriman</option>
                          ?>
                        </select>
                      </div>
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="NoResi" id="NoResi" placeholder="No Resi" class="form-control">
                      </div>
                    </div>
                    <br><br><br><br>
                    <div class="row col-md-12 col-sm-12">
                      <label class="col-md-2 col-sm-12 form-group" for="first-name">Item Barang <span class="required">*</span>
                      </label>
                      <div class="col-md-3 col-sm-12 form-group">
                        <input type="text" name="Barcode" id="Barcode" class="form-control">
                      </div>
                      <div class="col-md-2 col-sm-12 form-group">
                        <button class="form-control btb btn-primary" id="FindItem">Search</button>
                      </div>
                      <div class="col-md-2 col-sm-12 form-group">
                        <button class="form-control btb btn-default" id="FindKeep">Copy Keep</button>
                      </div>
                      <label class="col-md-1 col-sm-12 form-group" for="first-name">DropShip <span class="required">*</span>
                      </label>
                      <div class="col-md-1 col-sm-12 form-group">
                        <input type="checkbox" name="chkdropship" id="chkdropship" class="form-control">
                      </div>
                      <div class="dx-viewport demo-container">
                        <div id="data-grid-demo">
                          <div id="gridContainerItem">
                          </div>
                        </div>
                      </div>
                      <label><center>_______</center></label>
                      <div class="row col-md-12 col-sm-12">
                        <div class="col-md-7 col-sm-12 form-group">
                          <button class="btn btn-app" id="amt1" disabled="">
                            <h4>5.000</h4>
                          </button>
                          <button class="btn btn-app" id="amt2" disabled="">
                            <h4>10.000</h4>
                          </button>
                          <button class="btn btn-app" id="amt3" disabled="">
                            <h4>20.000</h4>
                          </button>
                          <button class="btn btn-app" id="amt4" disabled="">
                            <h4>50.000</h4>
                          </button>
                          <button class="btn btn-app" id="amt5" disabled="">
                            <h4>100.000</h4>
                          </button>
                          <button class="btn btn-app" id="amt6" disabled="">
                            <h4>LUNAS</h4>
                          </button>
                        </div>
                        <div class="col-md-4 col-sm-12">
                          <div class="col-md-5 col-sm-12 form-group">
                            <label class="col-form-label label-align" for="first-name">Bayar Sekarang
                            </label>
                          </div>
                          <div class="col-md-7 col-sm-12 form-group">
                            <input type="checkbox" name="T_Paynow" id="T_Paynow" class="form-control"value="1"  checked="">
                          </div>

                          <div class="col-md-5 col-sm-12 form-group">
                            <label class="col-form-label label-align" for="first-name">Sub Total
                            </label>
                          </div>
                          <div class="col-md-7 col-sm-12 form-group">
                            <input type="text" name="T_SubTotal" id="T_SubTotal" class="form-control" readonly="" value="0">
                          </div>

                          <div class="col-md-5 col-sm-12 form-group">
                            <label class="col-form-label label-align" for="first-name">Total Diskon
                            </label>
                          </div>
                          <div class="col-md-7 col-sm-12 form-group">
                            <input type="text" name="T_DiskTotal" id="T_DiskTotal" class="form-control" readonly="" value="0">
                          </div>

                          <div class="col-md-5 col-sm-12 form-group">
                            <label class="col-form-label label-align" for="first-name">Ongkir
                            </label>
                          </div>
                          <div class="col-md-7 col-sm-12 form-group">
                            <input type="text" name="T_Ongkir" id="T_Ongkir" class="form-control" value="0">
                          </div>

                          <div class="col-md-5 col-sm-12 form-group">
                            <label class="col-form-label label-align" for="first-name">Grand Total
                            </label>
                          </div>
                          <div class="col-md-7 col-sm-12 form-group">
                            <input type="text" name="T_GrandTotal" id="T_GrandTotal" class="form-control" readonly="" value="0">
                          </div>

                          <div class="col-md-5 col-sm-12 form-group">
                            <label class="col-form-label label-align" for="first-name">Bayar
                            </label>
                          </div>
                          <div class="col-md-7 col-sm-12 form-group">
                            <input type="text" name="T_Bayar" id="T_Bayar" class="form-control" value="0" onclick="this.select()">
                          </div>

                          <div class="col-md-5 col-sm-12 form-group">
                            <label class="col-form-label label-align" for="first-name">Kembalian
                            </label>
                          </div>
                          <div class="col-md-7 col-sm-12 form-group">
                            <input type="text" name="T_Kembali" id="T_Kembali" class="form-control" readonly="" value="0">
                          </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                          <button class="btn btn-primary" id="SubmitPOS" disabled="">Proses [F9]</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="row col-md-12 col-sm-12">
                      <label class="col-md-2 col-sm-12 form-group" for="first-name">Tanggal <span class="required">*</span>
                      </label>
                      <div class="col-md-4 col-sm-12 form-group">
                        <input type="date" name="TglAwal" id="TglAwal" class="form-control"  value="<?php echo date("Y-m-d");?>">
                      </div>
                      <div class="col-md-4 col-sm-12 form-group">
                        <input type="date" name="TglAkhir" id="TglAkhir" class="form-control"  value="<?php echo date("Y-m-d");?>">
                      </div>
                      <div class="col-md-2 col-sm-12 form-group">
                        <button class="form-control btb btn-primary" id="filterbutton">Search</button>
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
                <div class="tab-pane fade" id="Print_format" role="tabpanel" aria-labelledby="profile-tab">
                  <div class="row col-md-12 col-sm-12">
                    <label class="col-md-2 col-sm-12 form-group" for="first-name">NoPenjualan <span class="required">*</span>
                    </label>
                    <div class="col-md-4 col-sm-12 form-group">
                      <input type="text" name="NoAwal" id="NoAwal" class="form-control">
                    </div>
                    <div class="col-md-4 col-sm-12 form-group">
                      <input type="text" name="NoAkhir" id="NoAkhir" class="form-control">
                    </div>
                    <div class="col-md-2 col-sm-12 form-group">
                      <button class="form-control btb btn-primary" id="Print_">Search</button>
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
</div>
<!-- /page content -->

<!-- Modal Customer -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_AddCust">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Customer</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_Cust" data-parsley-validate class="form-horizontal form-label-left">
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
              <input type="text" name="KodePos" id="KodePos" class="form-control" placeholder="Kode Pos" required="">
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
            <button class="btn btn-primary" id="btn_Save_Cust">Save</button>
          </div>
        </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div> -->

    </div>
  </div>
</div>

<!-- Modal Lookup -->

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
                <th>#</th>
                <th>Nama Item</th>
                <th>Article</th>
                <th>Stok Akhir</th>
                <th>Default Price</th>
                <th>Satuan</th>
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


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_Lookup_keep">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Daftar Keep Barang</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dx-viewport demo-container">
          <div id="data-grid-demo">
            <div id="gridContainerKeepBarang">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="choseKeep">Chose</button>
      </div>

    </div>
  </div>
</div>

<!-- Modal Payment -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="modal_Payment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Bayar Tagihan Customer</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="post_Bayar" data-parsley-validate class="form-horizontal form-label-left">
          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nomor Transaksi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="NoTransaksiPay" id="NoTransaksiPay" required="" placeholder="No Transaksi" class="form-control " readonly="">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tgl Transaksi <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="date" name="TglTransaksiPay" id="TglTransaksiPay" required="" placeholder="No Transaksi" class="form-control " readonly="">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Customer <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="NamaCustomerPay" id="NamaCustomerPay" required="" placeholder="Nama Customer" class="form-control " readonly="">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Total Tagihan <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="TotalTagihanPay" id="TotalTagihanPay" required="" placeholder="Total Tagihan" class="form-control " readonly="" value="0">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jenis Pembayaran <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <select class="js-states form-control" id="PaymentTermPay" name="PaymentTermPay" >
                <option value = ''>Jenis Pembayaran</option>
                <?php
                  $rs = $this->db->query("select * from tpayment")->result();
                  foreach ($rs as $key) {
                    echo "<option value = '".$key->id."'>".$key->PaymentTerm."</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">No. Ref <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="NoRefPay" id="NoRefPay" placeholder="No Ref" class="form-control ">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Bayar <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="BayarPay" id="BayarPay" required="" placeholder="Bayar" class="form-control " value="0" onclick="this.select()">
            </div>
          </div>

          <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Kembalian <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 ">
              <input type="text" name="KembalianPay" id="KembalianPay" required="" placeholder="Kembalian" class="form-control " readonly="" value="0">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-warning" id="btnBayar">Bayar</button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  var isLevelingPrice = 0;
  var NoTransaksiBooking = '';
  var TotalBerat = 0;
  var barcodeScan = 1;

  var $field = $('#TglTransaksi, #KodeSales, #KodeCustomerPOS, #TransactionType ,#PaymentTerm, #provinsi_ori, #Kota_ori,#Kecamatan_ori, #Kelurahan_ori, #KodePOS_ori, #Alamat_ori,#Nama_ori, #Notlp_Ori, #provinsi_dest, #Kota_dest, #Kecamatan_dest, #Kelurahan_dest, #KodePOS_dest, #Alamat_dest, #Nama_dest, #Notlp_dest, #T_Bayar')
  $(function () {
    var items_data;
    $(document).ready(function () {
      // Initialize Select 2
      $('#KodeSales').select2({
        width : 'resolve',
        placeholder: 'Sales / Agen'
      });

      $('#KodeCustomerPOS').select2({
        width : 'resolve',
        placeholder: 'Customer'
      });

      $('#TransactionType').select2({
        width : 'resolve',
        placeholder: 'Pilih Tipe Transaksi'
      });

      $('#PaymentTerm').select2({
        width : 'resolve',
        placeholder: 'Jenis Pembayaran'
      });

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

      $('#provinsi_dest').select2({
        width : 'resolve',
        placeholder: 'Pilih Provinsi'
      });

      $('#Kota_dest').select2({
        width : 'resolve',
        placeholder: 'Pilih Kota'
      });

      $('#Kecamatan_dest').select2({
        width : 'resolve',
        placeholder: 'Pilih Kecamatan'
      });

      $('#Kelurahan_dest').select2({
        width : 'resolve',
        placeholder: 'Pilih Kecamatan'
      });

      $('#Expedisi').select2({
        width : 'resolve',
        placeholder: 'Expedisi'
      });

      $.ajax({
        type    :'post',
        url     : '<?=base_url()?>C_General/getDummy',
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
      var button = $('#filterbutton');
      button.click();
      $("#mySearch").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#load_Lookup tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
      // Call Function Form Load
      GetCustomer();
    });
    $('#Print_').click(function () {
      window.open('<?php echo base_url(); ?>print/formatkirim.php?NoAwal='+$('#NoAwal').val()+'&NoAkhir='+$('#NoAkhir').val(),'_blank');
      location.reload();
    })
    $('#TransactionType').change(function () {
      GetOrigin($('#TransactionType').val());
      GetDestination($('#TransactionType').val());
      if ($('#TransactionType').val() == "1") {
        $('#ClassNumTrx').empty();
        $('#ClassNumTrx').append(""+
          "<input type = 'text' name = 'RefNumberTrx' id = 'RefNumberTrx' class = 'form-control' placeholder='Ref Number'>"
        );
      }
      else{
        $('#ClassNumTrx').empty();        
      }
    });
    $('#PaymentTerm').change(function () {
      if ($('#PaymentTerm').val() == "3" || $('#PaymentTerm').val() == "4") {
        $('#ClassNumPayment').empty();
        $('#ClassNumPayment').append(""+
          "<input type = 'text' name = 'RefNumberPayment' id = 'RefNumberPayment' class = 'form-control' placeholder='Ref Number'>"
        );
      }
      else{
        $('#ClassNumPayment').empty();
      }

      if ($('#PaymentTerm').val() == "1") {
        $("#Expedisi").attr("disabled", false);
        $("#T_Bayar").attr("disabled", false);
        // $("#T_Paynow").prop("checked", true);
        
        $('#amt1').attr('disabled',false);
        $('#amt2').attr('disabled',false);
        $('#amt3').attr('disabled',false);
        $('#amt4').attr('disabled',false);
        $('#amt5').attr('disabled',false);
        $('#amt6').attr('disabled',false);
      }
      else{
        $("#Expedisi").attr("disabled", false);
        $("#T_Bayar").attr("disabled", true);
        // $("#T_Paynow").prop("checked", false);

        $('#amt1').attr('disabled',true);
        $('#amt2').attr('disabled',true);
        $('#amt3').attr('disabled',true);
        $('#amt4').attr('disabled',true);
        $('#amt5').attr('disabled',true);
        $('#amt6').attr('disabled',true);
      }
    });
    $('#KodeSales').change(function () {
      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_Sales/Read",
        data: {'KodeSales':$('KodeSales').val()},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            isLevelingPrice = response.data[0]['LevelingPrice'];
          }
        }
      });
      var harga = 0;
    });
    $('#KodeCustomerPOS').change(function () {
      var KodeCustomer = $('#KodeCustomerPOS').val();
      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_Customer/Read",
        data: {'KodeCustomer':KodeCustomer},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#TransactionType').val(response.data[0]['CustGroup']).change();
          }
        }
      });
      $("#chkdropship").prop("checked", false);
    });

    $('#KodeSales').change(function () {
      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_Sales/Read",
        data: {'KodeSales':$('#KodeSales').val()},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            // console.log(response.data[0].NamaSales);
            $('#Nama_ori').val(response.data[0].NamaSales);
            $('#Notlp_Ori').val(response.data[0].NoTlp);
          }
        }
      });
    })
    // Origin
    $('#provinsi_ori').change(function () {
      var idaddr = $('#provinsi_ori').val();
      var link = 'kota';


      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kota_ori').empty();
            $('#Kota_ori').append(""+
              "<option value='0'>Pilih Kota</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kota_ori').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
          }
        }
      });
    });

    $('#Kota_ori').change(function () {
      var idaddr = $('#Kota_ori').val();
      var link = 'kec';

      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kecamatan_ori').empty();
            $('#Kecamatan_ori').append(""+
              "<option value='0'>Pilih Kecamatan</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kecamatan_ori').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
            
          }
        }
      });
    });

    $('#Kecamatan_ori').change(function () {
      var idaddr = $('#Kecamatan_ori').val();
      var link = 'kel';

      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kelurahan_ori').empty();
            $('#Kelurahan_ori').append(""+
              "<option value='0'>Pilih Kelurahan</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kelurahan_ori').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
          }
        }
      });
    });

    // Destination

    $('#provinsi_dest').change(function () {
      var idaddr = $('#provinsi_dest').val();
      var link = 'kota';


      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kota_dest').empty();
            $('#Kota_dest').append(""+
              "<option value='0'>Pilih Kota</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kota_dest').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
          }
        }
      });
    });

    $('#Kota_dest').change(function () {
      var idaddr = $('#Kota_dest').val();
      var link = 'kec';

      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kecamatan_dest').empty();
            $('#Kecamatan_dest').append(""+
              "<option value='0'>Pilih Kecamatan</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kecamatan_dest').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
            
          }
        }
      });
    });

    $('#Kecamatan_dest').change(function () {
      var idaddr = $('#Kecamatan_dest').val();
      var link = 'kel';

      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/GetInfoAddr",
        data: {link:link,idaddr:idaddr},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#Kelurahan_dest').empty();
            $('#Kelurahan_dest').append(""+
              "<option value='0'>Pilih Kelurahan</option>"
            );
            $.each(response.data,function (k,v) {
              $('#Kelurahan_dest').append(""+
                "<option value='"+v.id+"'>"+v.name+"</option>"
              );
            });
          }
        }
      });
    });

    // Customer
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

    $('#AddCust').click(function () {
      // $('#post_Cust').reset();
      console.log($('#KodeCustomerPOS').val());
      document.getElementById("post_Cust").reset();
      $('#modal_AddCust').modal('show');
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
    $('.close').click(function() {
      console.log($('#KodeCustomerPOS').val());
      if ($('#KodeCustomerPOS').val() == "") {
        GetCustomer();
      }
    });
    $('#post_Cust').submit(function (e) {
      $('#btn_Save_Cust').text('Tunggu Sebentar.....');
      $('#btn_Save_Cust').attr('disabled',true);

      e.preventDefault();
      var me = $(this);

      $.ajax({
        async   : false,
        type    :'post',
        url     : '<?=base_url()?>C_Customer/CRUD',
        data    : me.serialize(),
        dataType: 'json',
        success : function (response) {
          if(response.success == true){
            $('#modal_AddCust').modal('toggle');
            Swal.fire({
              type: 'success',
              title: 'Horay..',
              text: 'Data Berhasil disimpan!',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              GetCustomer();
              $('#KodeCustomerPOS').val($('#KodeCustomer').val()).change();
              $('#post_Cust').reset();
              document.getElementById("post_Cust").reset();
            });
          }
          else{
            $('#modal_AddCust').modal('toggle');
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $('#modal_AddCust').modal('show');
              $('#btn_Save_Cust').text('Save');
              $('#btn_Save_Cust').attr('disabled',false);
            });
          }
        }
      });
    });

    $('#Barcode').keyup(function (x) {
      if (x.keyCode === 13) {
        if (barcodeScan == 1) {
          console.log(barcodeScan);
          barcodeScan = 0;
        }
        else{
          setTimeout(GetItemRow(),1000);
          console.log(barcodeScan);
        }
        // items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
        // console.log(items_data);
      }
    });

    $('#ItemLookup').on('click','tr',function () {
      var ItemCode = $(this).find("#ItemCode").text();
      var ItemName = $(this).find("#ItemName").text();
      var Stok = $(this).find("#Stok").text();
      var dflt = $(this).find("#dflt").text();
      var Satuan = $(this).find("#Satuan").text();
      var KodeItemLama = $(this).find("#KodeItemLama").text();

      var prevQty = 0;
      var akumulasiQty = 1;
      items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
      // var xdata = $("#gridContainerItem").dxDataGrid("getDataSource").items();
      var listDataSource = $("#gridContainerItem").dxDataGrid("getDataSource").items();
      console.log(listDataSource);
      for (var i = 0; i < items_data.length; i++) {
        akumulasiQty += parseInt(items_data[i]["Qty"]);
      }
      for (var i = 0; i < items_data.length; i++) {
        if (items_data[i]["ItemCode"] == ItemCode && items_data[i]["BaseRef"] == '') {
          console.log(items_data[i]["Qty"]);
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
          $('#modal_Lookup').modal('show');
        });
      }
      else{
        // if (isLevelingPrice == 1) {
        //   console.log(akumulasiQty)
        //   GetLevelingHarga(parseInt(akumulasiQty));
        //   dflt = $('#LevelingPrice').val();

        //   items_data.push({
        //     ItemCode : ItemCode,
        //     ItemName : ItemName,
        //     Qty : parseInt(prevQty) + 1,
        //     Satuan : Satuan,
        //     Price: dflt,
        //     OnHand:Stok,
        //     Diskon : 0,
        //     Total : (parseInt(prevQty) + 1) * dflt,
        //     __KEY__:create_UUID(),
        //     BaseRef : ''
        //   });
        //   // console.log(items_data.length);
        //   for (var i = 0 ; i<items_data.length; i++) {
        //     // items_data.splice(i, dflt);
        //     items_data[i].Price = dflt;
        //     console.log(items_data[i].Price);
        //   }
        //   // console.log(items_data);
        //   bindGridItem(items_data);
        //   addSubTotal();
        // }
        // else{
          
        //   // GetBeratStandar();
        // }
        items_data.push({
            ItemCode : ItemCode,
            KodeItemLama : KodeItemLama,
            ItemName : ItemName,
            Qty : parseInt(prevQty) + 1,
            Price:dflt,
            OnHand:Stok,
            Satuan:Satuan,
            Diskon : 0,
            Total : (parseInt(prevQty) + 1) * dflt,
            __KEY__:create_UUID(),
            BaseRef : ''
          });
          bindGridItem(items_data);
          addSubTotal();
      }
    });
    $('#FindItem').click(function () {
      GetItemRow();
      // console.log(items_data)
    });
    $('#EditQty').click(function function_name(argument) {
      var button = $('.dx-link-edit');
      button.click();
    });
    $('#T_SubTotal').focus(function () {
      $('#T_SubTotal').val($('#T_SubTotal').val().replace(',',''));
    })
    $('#T_SubTotal').focusout(function () {
      $('#T_SubTotal').val(addCommas($('#T_SubTotal').val()));
    });

    $('#T_DiskTotal').focus(function () {
      $('#T_DiskTotal').val($('#T_DiskTotal').val().replace(',',''));
    })
    $('#T_DiskTotal').focusout(function () {
      $('#T_DiskTotal').val(addCommas($('#T_DiskTotal').val()));
    });

    $('#T_Ongkir').focus(function () {
      $('#T_Ongkir').val($('#T_Ongkir').val().replace(',',''));
    })
    $('#T_Ongkir').focusout(function () {
      $('#T_Ongkir').val(addCommas($('#T_Ongkir').val()));
    });

    $('#T_GrandTotal').focus(function () {
      $('#T_GrandTotal').val($('#T_GrandTotal').val().replace(',',''));
    })
    $('#T_GrandTotal').focusout(function () {
      $('#T_GrandTotal').val(addCommas($('#T_GrandTotal').val()));
    });

    $('#T_Bayar').focus(function () {
      $('#T_Bayar').val($('#T_Bayar').val().replace(',',''));
    })
    $('#T_Bayar').focusout(function () {
      $('#T_Bayar').val(addCommas($('#T_Bayar').val()));
    });

    $('#T_Kembali').focus(function () {
      $('#T_Kembali').val($('#T_Kembali').val().replace(',',''));
    })
    $('#T_Kembali').focusout(function () {
      $('#T_Kembali').val(addCommas($('#T_Kembali').val()));
    });

    $('#T_Ongkir').on("keyup",function () {
      addSubTotal();
    })

    $("#T_Bayar").on("keyup", function() {
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val()) - parseFloat($('#T_GrandTotal').val().replace(',',''))) );
      if ($('#T_Bayar').val() == '') {
        $('#T_Bayar').val(0);
      }
    });


    $('#TotalTagihanPay').focus(function () {
      $('#TotalTagihanPay').val($('#TotalTagihanPay').val().replace(',',''));
    })
    $('#TotalTagihanPay').focusout(function () {
      $('#TotalTagihanPay').val(addCommas($('#TotalTagihanPay').val()));
    });

    $('#BayarPay').focus(function () {
      $('#BayarPay').val($('#BayarPay').val().replace(',',''));
    })
    $('#BayarPay').focusout(function () {
      $('#BayarPay').val(addCommas($('#BayarPay').val()));
    });

    $('#KembalianPay').focus(function () {
      $('#KembalianPay').val($('#KembalianPay').val().replace(',',''));
    })
    $('#KembalianPay').focusout(function () {
      $('#KembalianPay').val(addCommas($('#KembalianPay').val()));
    });

    $("#BayarPay").on("keyup", function() {
      $('#KembalianPay').val(addCommas(parseFloat($('#BayarPay').val()) - parseFloat($('#TotalTagihanPay').val().replace(',',''))) );
      if ($('#BayarPay').val() == '') {
        $('#BayarPay').val(0);
      }
    });

    $('#amt1').click(function () {
      $('#T_Bayar').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) + 5000));
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) - parseFloat($('#T_GrandTotal').val().replace(',','') ) ));
      if (parseFloat($('#T_Kembali').val().replace(',','')) >= 0) {
        $('#SubmitPOS').attr('disabled',false);
      }
      else{
        $('#SubmitPOS').attr('disabled',true);
      }
    });

    $('#amt2').click(function () {
      $('#T_Bayar').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) + 10000));
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) - parseFloat($('#T_GrandTotal').val().replace(',','') ) ));
      if (parseFloat($('#T_Kembali').val().replace(',','')) >= 0) {
        $('#SubmitPOS').attr('disabled',false);
      }
      else{
        $('#SubmitPOS').attr('disabled',true);
      }
    });

    $('#amt3').click(function () {
      $('#T_Bayar').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) + 20000));
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) - parseFloat($('#T_GrandTotal').val().replace(',','') ) ));
      if (parseFloat($('#T_Kembali').val().replace(',','')) >= 0) {
        $('#SubmitPOS').attr('disabled',false);
      }
      else{
        $('#SubmitPOS').attr('disabled',true);
      }
    });

    $('#amt4').click(function () {
      $('#T_Bayar').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) + 50000));
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) - parseFloat($('#T_GrandTotal').val().replace(',','') ) ));
      if (parseFloat($('#T_Kembali').val().replace(',','')) >= 0) {
        $('#SubmitPOS').attr('disabled',false);
      }
      else{
        $('#SubmitPOS').attr('disabled',true);
      }
    });

    $('#amt5').click(function () {
      $('#T_Bayar').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) + 100000));
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) - parseFloat($('#T_GrandTotal').val().replace(',','') ) ));
      if (parseFloat($('#T_Kembali').val().replace(',','')) >= 0) {
        $('#SubmitPOS').attr('disabled',false);
      }
      else{
        $('#SubmitPOS').attr('disabled',true);
      }
    });

    $('#amt6').click(function () {
      $('#T_Bayar').val(addCommas(parseFloat($('#T_GrandTotal').val().replace(',',''))));
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) - parseFloat($('#T_GrandTotal').val().replace(',','') ) ));
      if (parseFloat($('#T_Kembali').val().replace(',','')) >= 0) {
        $('#SubmitPOS').attr('disabled',false);
      }
      else{
        $('#SubmitPOS').attr('disabled',true);
      }
    });

    $('#FindKeep').click(function () {
      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_Booking/GetLookup",
        data: {'KodeSales':$('#KodeSales').val()},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            bindGridItemBooking(response.data);
            $('#modal_Lookup_keep').modal('show');
          }
          else{
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: response.message,
              // footer: '<a href>Why do I have this issue?</a>'
            });
          }
        }
      });
    });
    $("#choseKeep").click(function () {
      if (NoTransaksiBooking != "") {
        $.ajax({
          type    :'post',
          url     : '<?=base_url()?>C_Booking/ReadDetail',
          data    : {'HeaderID':NoTransaksiBooking},
          dataType: 'json',
          success:function (response) {
            if(response.success == true){
              var dflt = 0;
              var akumulasiQty = 0;
              $.each(response.data,function (j,z) {
                akumulasiQty += parseInt(z.Qty);
              });
              $.each(response.data,function (k,v) {
                // if (isLevelingPrice == 1) {
                //   GetLevelingHarga(parseInt(akumulasiQty));
                //   dflt = $('#LevelingPrice').val();
                // }
                // else{
                //   dflt = v.Price
                // }
                if ($('#TransactionType').val() ==  "1") {
                  dflt = v.EcomPrice;
                }
                else{
                  dflt = v.Price 
                }
                items_data.push({
                  ItemCode : v.KodeItem,
                  KodeItemLama : v.KodeItemLama,
                  ItemName : v.ItemName,
                  Qty : parseInt(v.Qty),
                  Price:dflt,
                  OnHand:v.Stok,
                  Satuan:v.Satuan,
                  Diskon : 0,
                  Total : parseInt(v.Qty) * dflt,
                  __KEY__:create_UUID(),
                  BaseRef : v.NoTransaksi
                });
                bindGridItem(items_data);
                addSubTotal();
              });
              $('#modal_Lookup_keep').modal('toggle');
            }
          }
        });
      }
    });
    $field.on('key change',function () {
      // console.log(parseFloat($('#T_Kembali').val().replace(',','')));
      if (allFilled($field) && parseFloat($('#T_Kembali').val().replace(',','')) <= 0) {
        $('#SubmitPOS').attr('disabled',false);
      }
      else{
        $('#SubmitPOS').attr('disabled',true);
      }
    });
    $('#SubmitPOS').click(function () {
      $('#SubmitPOS').text('Tunggu Sebentar');
      $('#SubmitPOS').attr('disabled',true);
      var reftrx = '';
      var refpay = '';

      if ($('#TransactionType').val() == '1') {
        reftrx = $('#RefNumberTrx').val();
      }

      if ($('#PaymentTerm').val() == "3" || $('#PaymentTerm').val() == "4") {
        refpay = $('#RefNumberPayment').val();
      }
      if (parseFloat($('#T_Kembali').val().replace(',','')) < 0) {
        Swal.fire({
          type: 'error',
          title: 'Woops...',
          text: 'Belum ada Nominal Bayar',
          // footer: '<a href>Why do I have this issue?</a>'
        }).then((result)=>{
          $('#SubmitPOS').text('Tunggu Sebentar');
          $('#SubmitPOS').attr('disabled',false);
        });
      }
      else{
        var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
        var array_detail  = JSON.stringify(gridItems);
        var arrx = [];
        var PayNow = 0;
        if ($("#T_Paynow").is(":checked")) {
          PayNow = 1;
        }
        var arr = {
          'TglTransaksi' : $('#TglTransaksi').val(),
          'TglPencatatan' : $('#TglPencatatan').val(),
          'KodeSales' : $('#KodeSales').val(),
          'TransactionType' : $('#TransactionType').val(),
          'RefNumberTrx' : reftrx,
          'KodeCustomerPOS' : $('#KodeCustomerPOS').val(),
          'PaymentTerm' : $('#PaymentTerm').val(),
          'RefNumberPayment' : refpay,
          'Createdby' : $('#Createdby').val(),
          'Createdon' : $('#Createdon').val(),
          'provinsi_dest' : $('#provinsi_dest').val(),
          'Kota_dest' : $('#Kota_dest').val(),
          'Kelurahan_dest' : $('#Kelurahan_dest').val(),
          'Kecamatan_dest' : $('#Kecamatan_dest').val(),
          'KodePOS_dest' : $('#KodePOS_dest').val(),
          'Alamat_dest' : $('#Alamat_dest').val(),
          'Nama_dest' : $('#Nama_dest').val(),
          'Notlp_dest' : $('#Notlp_dest').val(),
          'provinsi_ori' : $('#provinsi_ori').val(),
          'Kota_ori' : $('#Kota_ori').val(),
          'Kelurahan_ori' : $('#Kelurahan_ori').val(),
          'Kecamatan_ori' : $('#Kecamatan_ori').val(),
          'KodePOS_ori' : $('#KodePOS_ori').val(),
          'Alamat_ori' : $('#Alamat_ori').val(),
          'Nama_ori' : $('#Nama_ori').val(),
          'Notlp_Ori' : $('#Notlp_Ori').val(),
          'Expedisi' : $('#Expedisi').val(),
          'PayNow' : PayNow,
          'T_SubTotal' : $('#T_SubTotal').val().replace(',',''),
          'T_DiskTotal' : $('#T_DiskTotal').val().replace(',',''),
          'T_GrandTotal' : $('#T_GrandTotal').val().replace(',',''),
          'T_Bayar' : $('#T_Bayar').val().replace(',',''),
          'T_Kembali' : $('#T_Kembali').val().replace(',',''),
          'T_Ongkir' : $('#T_Ongkir').val().replace(',',''),
          'Servicexpdc' : $('#cekongkir_TableInfo').val(),
          'NoResi' : $('#NoResi').val()
        }
        arrx.push(arr);
        var array_header  = JSON.stringify(arrx);

        // console.log(arr);
        $.ajax({
          async: false,
          type: "post",
          url: "<?=base_url()?>C_POS/CRUD",
          data: {'array_header':array_header,'array_detail':array_detail},
          dataType: "json",
          success: function (response) {
            if(response.success == true){
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
                $('#SubmitPOS').text('Save');
                $('#SubmitPOS').attr('disabled',false);
              });
            }
          }
        });
      }
    });

    // Generate Ongkir

    $('#Expedisi').change(function () {
      // getberat
      GetBeratStandar();
    });
    $('#cekongkir_TableInfo').change(function () {
      var srv = $('#cekongkir_TableInfo').val();

      var exploded = srv.split('|');

      var jnssrv = exploded[0];
      var value = exploded[1];

      $('#ServiceXPDC').val(jnssrv);

      $('#T_Ongkir').val(addCommas(value));
      addSubTotal();
    });

    $('#filterbutton').click(function () {
      var TglAwal = $('#TglAwal').val();
      var TglAkhir = $('#TglAkhir').val();

      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_POS/ReadHeader",
        data: {'TglAwal':TglAwal,'TglAkhir':TglAkhir},
        dataType: "json",
        success: function (response) {
          bindGridHeader(response.data);
          // bindGridDetail(response.data);
        }
      });
    });

    $('#PaymentTermPay').change(function () {
      if ($('#PaymentTermPay').val() == 3 || $('#PaymentTermPay').val() == 4) {
        $('#BayarPay').val($('#TotalTagihanPay').val());
      }
      else{
        $('#BayarPay').val("0");
      }
    });

    $('#post_Bayar').submit(function (e) {
      $('#btnBayar').text('Tunggu Sebentar.....');
      $('#btnBayar').attr('disabled',true);

      if ($('#KembalianPay').val() >= 0) {
        e.preventDefault();
        var me = $(this);

        $.ajax({
          async   : false,
          type    :'post',
          url     : '<?=base_url()?>C_POS/Bayar',
          data    : me.serialize(),
          dataType: 'json',
          success : function (response) {
            if(response.success == true){
              $('#modal_Payment').modal('toggle');
              Swal.fire({
                type: 'success',
                title: 'Horay..',
                text: 'Data Berhasil disimpan!',
                // footer: '<a href>Why do I have this issue?</a>'
              }).then((result)=>{
                // location.reload();
                $('#modal_Payment').modal('toggle');
              });
            }
            else{
              $('#modal_Payment').modal('toggle');
              Swal.fire({
                type: 'error',
                title: 'Woops...',
                text: response.message,
                // footer: '<a href>Why do I have this issue?</a>'
              }).then((result)=>{
                $('#modal_Payment').modal('show');
                $('#btnBayar').text('Save');
                $('#btnBayar').attr('disabled',false);
              });
            }
          }
        });
      }
      else{
        $('#modal_Payment').modal('toggle');
          Swal.fire({
            type: 'error',
            title: 'Woops...',
            text: 'Nilai Bayar tidak boleh kurang dari Nilai Tagihan',
            // footer: '<a href>Why do I have this issue?</a>'
          }).then((result)=>{
            $('#modal_Payment').modal('show');
            $('#btnBayar').text('Save');
            $('#btnBayar').attr('disabled',false);
          });
          return false;
      }
    });
    $('#chkdropship').click(function () {
      if($('#chkdropship').is(":checked")) // "this" refers to the element that fired the event
      {
          // alert('home is checked');
          // $("#chkdropship").prop("checked", true);
          if ($('#KodeCustomerPOS').val() == '') {
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: 'Pilih Customer Terlebih dahulu',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              $("#chkdropship").prop("checked", true);
            });
          }
          else {
            // $.ajax({
            //   async: false,
            //   type: "post",
            //   url: "<?=base_url()?>C_Customer/Read",
            //   data: {'KodeCustomer':$('#KodeCustomerPOS').val()},
            //   dataType: "json",
            //   success: function (response) {
            //     if(response.success == true){
            //       $('#provinsi_ori').val(response.data[0]['provinsi']).change();
            //       $('#Kota_ori').val(response.data[0]['Kota']).change();
            //       $('#Kecamatan_ori').val(response.data[0]['Kecamatan']).change();
            //       $('#Kelurahan_ori').val(response.data[0]['Kelurahan']).change();
            //       $('#KodePOS_ori').val(response.data[0]['KodePos']);
            //       $('#Alamat_ori').val(response.data[0]['AlamatCustomer']);
            //       $('#Nama_ori').val(response.data[0]['NamaCustomer']);
            //       $('#Notlp_Ori').val(response.data[0]['NoTlp']);

            //       $('#provinsi_dest').val('').change();
            //       $('#Kota_dest').val('').change();
            //       $('#Kecamatan_dest').val('').change();
            //       $('#Kelurahan_dest').val('').change();
            //       $('#KodePOS_dest').val('');
            //       $('#Alamat_dest').val('');
            //       $('#Nama_dest').val('');
            //       $('#Notlp_dest').val('');
            //     }
            //   }
            // });
            // $('#Nama_ori').attr('readonly',false);
            // $('#Notlp_Ori').attr('readonly',false);

            // $('#provinsi_dest').val('').change();
            // $('#Kota_dest').val('').change();
            // $('#Kecamatan_dest').val('').change();
            // $('#Kelurahan_dest').val('').change();
            // $('#KodePOS_dest').val('');
            // $('#Alamat_dest').val('');
            // $('#Nama_dest').val('');
            // $('#Notlp_dest').val('');
          }
      }
      else{
        GetOrigin();
        GetDestination($('#TransactionType').val());
        // $('#Nama_ori').attr('readonly',true);
        // $('#Notlp_Ori').attr('readonly',true);
      }
    })
    // ================================= FUNCTION =================================
    function useReturnData(data){
      items_data = data;
      console.log(items_data);
    };
    function GetBeratStandar() {
      var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
      // console.log(items_data);
      // $('#beratStandar').val("0");
      for (var i = 0; i < items_data.length; i++) {
        $.ajax({
          async: false,
          type: "post",
          url: "<?=base_url()?>C_General/GetBerat",
          data: {'KodeItem':items_data[i]['ItemCode']},
          dataType: "json",
          success: function (response) {
            var TotalBerat = $('#beratStandar').val();
            console.log(TotalBerat);
            if(response.Berat > 0){
              $('#beratStandar').val((parseFloat(response.Berat) * parseFloat(items_data[i]['Qty'])));
            }
          }
        });
      }
      // console.log(TotalBerat);
      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_General/cekongkir",
        data: {'Kota_origin':$('#Kota_ori').val(),'Kota_Destination':$('#Kota_dest').val(),'xpdc':$('#Expedisi').val(),'berat':$('#beratStandar').val()},
        dataType: "json",
        success: function (response) {
          if (response.data.length > 0) {
            console.log(response.data.length);
            for (i =0; i< response.data.length ;i++) {
              // console.log(response.data[i]);
              $('#cekongkir_TableInfo').empty();
              $('#cekongkir_TableInfo').append("<option value='0'>Pilih Service Pengiriman</option>")
              var j;
              for (j =0;j< response.data[i]['costs'].length;j++) {
                // console.log(response.data[i]['costs'][j]);
                // $('#cekongkir_TableInfo').append(""+
                //   "<option value='"+response.data[i]['costs'][j].service+"|'>"+response.data[i]['costs'][j].service+" | "+response.data[i]['costs'][j].description+"</option>"
                //   );
                // info service
                var k;
                for (k=0;k< response.data[i]['costs'][j]['cost'].length;k++) {
                  // console.log(response.data[i]['costs'][j]['cost'][k].value);
                  $('#cekongkir_TableInfo').append(""+
                  "<option value='"+response.data[i]['costs'][j].service+"|"+response.data[i]['costs'][j]['cost'][k].value+"'>"+response.data[i]['costs'][j].service+" | "+response.data[i]['costs'][j].description+" | "+addCommas(response.data[i]['costs'][j]['cost'][k].value)+"</option>"
                  );
                  // info harga
                }

              }
            }
          }
          else{
            console.log('IN');
            $.ajax({
              async: false,
              type: "post",
              url: "<?=base_url()?>C_expdc/ReadDetail",
              data: {'KodeExpdc':$('#Expedisi').val()},
              dataType: "json",
              success: function (response2) {
                var TotalBerat = $('#beratStandar').val();
                console.log(TotalBerat);
                if(response2.data.length > 0){
                  $('#cekongkir_TableInfo').empty();
                  $('#cekongkir_TableInfo').append("<option value='0'>Pilih Service Pengiriman</option>");

                  for (var i = 0; i < response2.data.length; i++) {
                    console.log(response2.data[i]['NamaService']);
                    $('#cekongkir_TableInfo').append("<option value='"+response2.data[i].NamaService+"|0'>"+response2.data[i].NamaService+"</option>");                    
                  }
                }
              }
            });

            // $.ajax({
            //   async: false,
            //   type: "post",
            //   url: "<?=base_url()?>C_General/GetBerat",
            //   data: {'KodeItem':items_data[i]['ItemCode']},
            //   dataType: "json",
            //   success: function (response) {
            //     var TotalBerat = $('#beratStandar').val();
            //     console.log(TotalBerat);
            //     if(response.Berat > 0){
            //       $('#beratStandar').val((parseFloat(response.Berat) * parseFloat(items_data[i]['Qty'])));
            //     }
            //   }
            // });
          }

        }
      });
    }
    function UpdateHarga(harga) {
      var arr = {"ItemCode":"","KodeItemLama":"","ItemName":"","Satuan":0,"Price":0,"Qty":0,"Diskon":0,"Total":0,"__KEY__":"","BaseRef":''}
      var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
      for (var i = 0; i < gridItems.length; i++) {
        arr["ItemCode"] = gridItems[i]["ItemCode"];
        arr["KodeItemLama"] = gridItems[i]["KodeItemLama"];
        arr["ItemName"] = gridItems[i]["ItemName"];
        arr["Satuan"]   = gridItems[i]["Satuan"];
        arr["Price"]    = harga;
        arr["Qty"]      = parseInt(gridItems[i]["Qty"]);
        arr["Diskon"]   = gridItems[i]['Diskon'],
        arr['Total']    = (harga * parseInt(gridItems[i]['Qty'])) - parseFloat(gridItems[i]['Diskon']);
        arr["__KEY__"]  = gridItems[i]["__KEY__"];
        arr["BaseRef"]  = gridItems[i]["BaseRef"];
        
        gridItems.update(gridItems[i],arr)
        grid.refresh();
      }
    }
    function allFilled($fields) 
    {
      return $fields.filter(function() {
        return this.value === ''; 
      }).length == 0;
    }
    function GetCustomer() {
      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_Customer/Read",
        data: {'id':''},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            $('#KodeCustomerPOS').empty();
            $('#KodeCustomerPOS').append(""+
              "<option value=''>Customer</option>"
            );
            $.each(response.data,function (k,v) {
              $('#KodeCustomerPOS').append(""+
                "<option value='"+v.KodeCustomer+"'>"+v.NamaCustomer+"</option>"
              );
            });
          }
        }
      });

    }

    function GetOrigin(Type) {
      if (Type != 3) {
        $.ajax({
          async: false,
          type: "post",
          url: "<?=base_url()?>C_Perusahaan/Read",
          data: {'id':''},
          dataType: "json",
          success: function (response) {
            if(response.success == true){
              $('#provinsi_ori').val(response.data[0]['provinsi']).change();
              $('#Kota_ori').val(response.data[0]['Kota']).change();
              $('#Kecamatan_ori').val(response.data[0]['Kecamatan']).change();
              $('#Kelurahan_ori').val(response.data[0]['Kelurahan']).change();
              $('#KodePOS_ori').val(response.data[0]['KodePos']);
              $('#Alamat_ori').val(response.data[0]['Alamat1']);
              // $('#Nama_ori').val(response.data[0]['NamaPerusahaan']);
              // $('#Notlp_Ori').val(response.data[0]['NoTlp']);
            }
          }
        });
      }
      else{
        $.ajax({
          async: false,
          type: "post",
          url: "<?=base_url()?>C_Customer/Read",
          data: {'KodeCustomer':$('#KodeCustomerPOS').val()},
          dataType: "json",
          success: function (response) {
            if(response.success == true){
              $('#provinsi_ori').val(response.data[0]['provinsi']).change();
              $('#Kota_ori').val(response.data[0]['Kota']).change();
              $('#Kecamatan_ori').val(response.data[0]['Kecamatan']).change();
              $('#Kelurahan_ori').val(response.data[0]['Kelurahan']).change();
              $('#KodePOS_ori').val(response.data[0]['KodePos']);
              $('#Alamat_ori').val(response.data[0]['AlamatCustomer']);
              $('#Nama_ori').val(response.data[0]['NamaCustomer']);
              $('#Notlp_Ori').val(response.data[0]['NoTlp']);
            }
          }
        });
      }
    }

    function GetDestination(Type) {
      if (Type != 3) {
        $.ajax({
          async: false,
          type: "post",
          url: "<?=base_url()?>C_Customer/Read",
          data: {'KodeCustomer':$('#KodeCustomerPOS').val()},
          dataType: "json",
          success: function (response) {
            if(response.success == true){
              $('#provinsi_dest').val(response.data[0]['provinsi']).change();
              $('#Kota_dest').val(response.data[0]['Kota']).change();
              $('#Kecamatan_dest').val(response.data[0]['Kecamatan']).change();
              $('#Kelurahan_dest').val(response.data[0]['Kelurahan']).change();
              $('#KodePOS_dest').val(response.data[0]['KodePos']);
              $('#Alamat_dest').val(response.data[0]['AlamatCustomer']);
              $('#Nama_dest').val(response.data[0]['NamaCustomer']);
              $('#Notlp_dest').val(response.data[0]['NoTlp']);
            }
          }
        });
      }
      else{
        $('#provinsi_dest').val('').change();
        $('#Kota_dest').val('').change();
        $('#Kecamatan_dest').val('').change();
        $('#Kelurahan_dest').val('').change();
        $('#KodePOS_dest').val('');
        $('#Alamat_dest').val('');
        $('#Nama_dest').val('');
        $('#Notlp_dest').val('');
      }
    }

    function GetItemRow() {
      // items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
      items_data = $("#gridContainerItem").dxDataGrid("getDataSource").items();
      // console.log(items_data);
      var id = '';
      if ($('#Barcode').val() != '') {
        id = '1';
      }
      $.ajax({
        async: false,
        type: "post",
        url: "<?=base_url()?>C_ItemMasterData/Read",
        data: {'kriteria':$('#Barcode').val(),'id':id},
        dataType: "json",
        success: function (response) {
          if(response.success == true){
            var html = '';
            var dflt = 0;
            var akumulasiQty = 1;
            for (var i = 0; i < items_data.length; i++) {
              akumulasiQty += parseInt(items_data[i]["Qty"]);
            }
            $.each(response.data,function (k,v) {
              var prevQty = 0;
              
              // console.log(items_data);
              for (var i = 0; i < items_data.length; i++) {
                if (items_data[i]["ItemCode"] == v.ItemCode && items_data[i]["BaseRef"] == '') {
                  prevQty = items_data[i]["Qty"];
                  // items_data.remove(i);
                  items_data.splice(i, 1);
                }
                else{
                  prevQty = 0;
                }
                // console.log(items_data[i]);
              }
              if (response.data.length == 1) {
                if (parseInt(prevQty) + 1 > v.Stok) {
                  Swal.fire({
                    type: 'error',
                    title: 'Woops...',
                    text: 'Jumlah Tersedia Lebih kecil dari jumlah yang di Keluarkan',
                    // footer: '<a href>Why do I have this issue?</a>'
                  });
                }
                else{
                  // var dflt;
                  // dflt = GetLevelingHarga(parseInt(prevQty) + 1,function (output) {
                  //   return output;
                  // });
                  // console.log(akumulasiQty);
                  // if (isLevelingPrice == 1)  {
                  //   GetLevelingHarga(parseInt(akumulasiQty));
                  //   dflt = $('#LevelingPrice').val();
                  //   // UpdateHarga(dflt);
                  //   items_data.push({
                  //     ItemCode : v.ItemCode,
                  //     ItemName : v.ItemName,
                  //     Qty : parseInt(prevQty) + 1,
                  //     Satuan : v.Satuan,
                  //     Price: dflt,
                  //     Diskon : 0,
                  //     Total : (parseInt(prevQty) + 1) * dflt,
                  //     __KEY__:create_UUID(),
                  //     BaseRef : ''
                  //   });
                  //   // console.log(items_data.length);
                  //   for (var i = 0 ; i<items_data.length; i++) {
                  //     // items_data.splice(i, dflt);
                  //     items_data[i].Price = dflt;
                  //     // console.log(items_data[i].Price);
                  //   }
                  //   // console.log(items_data);
                  //   bindGridItem(items_data);
                  //   addSubTotal();
                  // }
                  // else{
                    
                  // }
                  // console.log($('#TransactionType').val());
                  if ($('#TransactionType').val() == "1") {
                    dflt = v.EcomPrice;
                  }
                  else{
                    dflt = v.DefaultPrice;
                  }
                    items_data.push({
                      ItemCode : v.ItemCode,
                      KodeItemLama : v.KodeItemLama,
                      ItemName : v.ItemName,
                      Qty : parseInt(prevQty) + 1,
                      Satuan : v.Satuan,
                      Price: dflt,
                      Diskon : 0,
                      Total : (parseInt(prevQty) + 1) * dflt,
                      __KEY__:create_UUID(),
                      BaseRef : ''
                    });
                    bindGridItem(items_data);
                    addSubTotal();

                  // items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items; 
                  // useReturnData(items_data);
                  // console.log(items_data);
                  // GetBeratStandar();
                }
              }
              else{
                html += '<tr>' +
                          '<td id = "ItemCode">' + v.ItemCode+'</td>' +
                          '<td id = "KodeItemLama">' + v.KodeItemLama+'</td>' +
                          '<td id = "ItemName">' + v.ItemName + '</td>' +
                          '<td id = "Article">' + v.Article + '</td>' +
                          '<td id = "Stok">' + v.Stok + '</td>'
                if ($('#TransactionType').val() == "1") {
                  html += '<td id = "dflt">' + v.EcomPrice + '</td>'
                }
                else{
                  html += '<td id = "dflt">' + v.DefaultPrice + '</td>'
                }
                
                html += '<td id = "Satuan">' + v.Satuan + '</td>' +
                        '<tr>';
                $('#load_Lookup').html(html);
                // items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
                // useReturnData(items_data);
                $('#modal_Lookup').modal('show');
              }
            });
          }
          else{
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: 'Item '+ $('#Barcode').val() + ' Tidak ditemukan. ',
              // footer: '<a href>Why do I have this issue?</a>'
            });
          }
          $('#Barcode').val('');
        }
      });
      
      // items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
      items_data = $("#gridContainerItem").dxDataGrid("getDataSource").items();
      barcodeScan = 1;
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
                    allowEditing:false,
                    allowSorting: false
                },
                {
                    dataField: "KodeItemLama",
                    caption: "#",
                    allowEditing:false,
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
                    dataField: "Satuan",
                    caption: "Satuan",
                    allowEditing:false,
                    allowSorting: false
                },
                {
                    dataField: "Price",
                    caption: "Price",
                    allowEditing:false,
                    allowSorting: false
                },
                {
                    dataField: "Diskon",
                    caption: "Diskon",
                    allowEditing:true,
                    allowSorting: false
                },
                {
                    dataField: "Total",
                    caption: "Total",
                    allowEditing:false,
                    allowSorting: false
                },
                {
                    dataField: "BaseRef",
                    caption: "BaseRef",
                    allowEditing:false,
                    allowSorting: false
                },
            ],
            summary:{
              totalItems: [
                {
                  column : "ItemCode",
                  summaryType : "count"
                },
                {
                  column : "Qty",
                  summaryType : "sum"
                },
                {
                  column : "Price",
                  summaryType : "sum"
                },
                {
                  column : "Diskon",
                  summaryType : "sum"
                },
                {
                  column : "Total",
                  summaryType : "sum"
                }

              ]
            },
            onEditingStart: function(e) {
            },
            onInitNewRow: function(e) {
            },
            onRowInserting: function(e) {
            },
            onRowInserted: function(e) {
              // if (isLevelingPrice == 1) {
              //   GetLevelingHarga(parseInt(akumulasiQty));
              //   dflt = $('#LevelingPrice').val();
              //   // UpdateHarga(dflt);
                
              // }
              var arr = {"ItemCode":"","KodeItemLama":"","ItemName":"","Satuan":0,"Price":0,"Qty":0,"Diskon":0,"Total":0,"__KEY__":"","BaseRef":''}

                var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;

                for (var i = 0; i < gridItems.length; i++) {
                  arr["ItemCode"] = gridItems[i]["ItemCode"];
                  arr["KodeItemLama"] = gridItems[i]["KodeItemLama"];
                  arr["ItemName"] = gridItems[i]["ItemName"];
                  arr["Satuan"]   = gridItems[i]["Satuan"];
                  arr["Price"]    = gridItems[i]["Price"];
                  arr["Qty"]      = parseInt(gridItems[i]["Qty"]);
                  arr["Diskon"]   = gridItems[i]['Diskon'],
                  arr['Total']    = (parseFloat(gridItems[i]["Price"]) * parseInt(gridItems[i]['Qty'])) - parseFloat(gridItems[i]['Diskon']);
                  arr["__KEY__"]  = gridItems[i]["__KEY__"];
                  arr["BaseRef"]  = gridItems[i]["BaseRef"];
                  
                  store.update(gridItems[i],arr)
                  grid.refresh();
                }
            },
            onRowUpdating: function(e) {
            },
            onRowUpdated: function(e) {
              var grid = $("#gridContainerItem").dxDataGrid("instance");
              var gridItems = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
              console.log(gridItems);
              var arr = {"ItemCode":"","KodeItemLama":"","ItemName":"","Satuan":0,"Price":0,"Qty":0,"Diskon":0,"Total":0,"__KEY__":"","BaseRef":''}
            
              var dflt = 0;
              var akumulasiQty = 0;
              for (var i = 0; i < gridItems.length; i++) {
                akumulasiQty += parseInt(gridItems[i]["Qty"]);
              }
              for (var i = 0; i < gridItems.length; i++) {
                // console.log(isLevelingPrice);
                // if (isLevelingPrice == 1) {
                //   GetLevelingHarga(akumulasiQty);
                //   dflt = $('#LevelingPrice').val();
                // }
                // else{
                //   dflt = gridItems[i]["Price"];
                // }
                console.log(dflt);
                arr["ItemCode"] = gridItems[i]["ItemCode"];
                arr["KodeItemLama"] = gridItems[i]["KodeItemLama"];
                arr["ItemName"] = gridItems[i]["ItemName"];
                arr["Satuan"]   = gridItems[i]["Satuan"];
                arr["Price"]    = gridItems[i]["Price"];
                arr["Qty"]      = parseInt(gridItems[i]["Qty"]);
                arr["Diskon"]   = gridItems[i]['Diskon'],
                arr['Total']    = (parseFloat(gridItems[i]["Price"]) * parseInt(gridItems[i]['Qty'])) - parseFloat(gridItems[i]['Diskon']);
                arr["__KEY__"]  = gridItems[i]["__KEY__"];
                arr["BaseRef"]  = gridItems[i]["BaseRef"];
                
                store.update(gridItems[i],arr)
                grid.refresh();
              }
              items_data = $("#gridContainerItem").dxDataGrid('instance')._controllers.data._dataSource._items;
              addSubTotal();
              // GetBeratStandar();
            },
            onRowRemoving: function(e) {
            },
            onRowRemoved: function(e) {
              addSubTotal();
              // GetBeratStandar();
            },
            onEditorPrepared: function (e) {
            },
            onRowValidating:function(e) {
            },
            onCellPrepared:function (e) {
            }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
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
    function addCommas(nStr)
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
    function addSubTotal() {

      var subtotal = 0;
      var Diskon = 0;
      var grandTotal = 0;
      var changeDue = 0;

      for (var i = 0; i < items_data.length; i++) {
        subtotal = subtotal + (parseFloat(items_data[i]["Price"]) * parseInt(items_data[i]["Qty"]));
        Diskon = Diskon + parseFloat(items_data[i]['Diskon'])
      }
      $('#T_SubTotal').val(addCommas(subtotal));
      $('#T_DiskTotal').val(addCommas(Diskon));
      $('#T_GrandTotal').val(addCommas((subtotal + parseFloat($('#T_Ongkir').val().replace(',',''))) - Diskon));
      if ($('#PaymentTerm').val() != '1') {
        $('#T_Bayar').val(addCommas((subtotal + parseFloat($('#T_Ongkir').val().replace(',',''))) - Diskon));
      }
      $('#T_Kembali').val(addCommas(parseFloat($('#T_Bayar').val().replace(',','')) - parseFloat($('#T_GrandTotal').val().replace(',',''))) );
    }
    function GetLevelingHarga(Qty) {
      var hasil = [];
      var arr = {};
      var rs;
      $.ajax({
        async:false,
        type: "post",
        url: "<?=base_url()?>C_General/GetLevelingHarga",
        data: {'Qty':Qty},
        dataType: "json",
        success: function (response) {
          if (response.success == true) {
            // handleData(response.data[0]['Harga']);
            $('#LevelingPrice').val(response.data[0]['Harga']);
          }
        }
      });
    }

    function bindGridItemBooking(data) {
      $("#gridContainerKeepBarang").dxDataGrid({
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
              'KodeSales',
              'NamaSales'
            ]
          },
          showBorders: true,
          allowColumnReordering: true,
          allowColumnResizing: true,
          columnAutoWidth: true,
          showBorders: true,
          focusedRowEnabled: true,
          paging: {
              pageSize: 10,
              enabled: true
          },
          searchPanel: {
              visible: true,
              width: 240,
              placeholder: "Search..."
          },
          columns: [
              {
                  dataField: "NoTransaksi",
                  caption: "No Booking",
                  allowEditing:false,
                  allowSorting: false
              },
              {
                  dataField: "TglTransaksi",
                  caption: "Tanggal Booking",
                  allowEditing:false,
                  allowSorting: false
              },
              {
                  dataField: "KodeSales",
                  caption: "Kode Item",
                  allowEditing:false,
                  allowSorting: false
              },
              {
                  dataField: "NamaSales",
                  caption: "Nama Item",
                  allowEditing:false,
                  allowSorting: false
              }
          ],
          onEditingStart: function(e) {
          },
          onInitNewRow: function(e) {
          },
          onRowInserting: function(e) {
          },
          onRowInserted: function(e) {
          },
          onRowUpdating: function(e) {  
          },
          onRowUpdated: function(e) {
          },
          onRowRemoving: function(e) {
          },
          onRowRemoved: function(e) {
          },
          onEditorPrepared: function (e) {
          },
          onRowValidating:function(e) {
          },
          onCellPrepared:function (e) {
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

            NoTransaksiBooking = xdata;
          }
      }).dxDataGrid("instance");

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }

    // header
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
                'Sales',
                'Createdby',
                'TransactionType',
                'PaymentTerm',
                'PayNow',
                'T_GrandTotal',
                'Action'
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
                    dataField: "Sales",
                    caption: "Nama Sales",
                    allowEditing:false
                },
                {
                    dataField: "Createdby",
                    caption: "Cashier",
                    allowEditing:false
                },
                {
                    dataField: "TransactionType",
                    caption: "Tipe Transaksi",
                    allowEditing:false
                },
                {
                    dataField: "PaymentTerm",
                    caption: "Jenis Pembayaran",
                    allowEditing:false
                },
                {
                    dataField: "PayNow",
                    caption: "PayNow",
                    allowEditing:false
                },
                {
                  dataField: "T_GrandTotal",
                  caption: "Total",
                  allowEditing:false
                },
                {
                    dataField: "Action",
                    caption: "Action",
                    allowEditing:false,
                    cellTemplate: function(cellElement, cellInfo) {
                      var LinkAccess = "<button class='badge badge-primary' onClick =Reprint('"+cellInfo.data.NoTransaksi+"')>Reprint</button><br>";
                      
                      if (cellInfo.data.PayNow == 0) {
                        LinkAccess += "<button class='badge badge-danger StartPay' id='"+cellInfo.data.NoTransaksi+"' onClick =Payment('"+cellInfo.data.NoTransaksi+"')>Bayar Sekarang</button>";
                      }
                      cellElement.append(LinkAccess);
                  }
                },
            ],
            focusedRowEnabled: true,
            focusedRowKey: 1,
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
                url     : '<?=base_url()?>C_POS/ReadDetail',
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

    // Detail

    function bindGridDetail(data) {

      $("#gridContainerDetail").dxDataGrid({
        allowColumnResizing: true,
            dataSource: data,
            keyExpr: "KodeItem",
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
                    dataField: "Qty",
                    caption: "Qty",
                    allowEditing:false
                },
                {
                    dataField: "QtyRetur",
                    caption: "Qty Retur",
                    allowEditing:false
                },
                {
                    dataField: "Harga",
                    caption: "Harga",
                    allowEditing:false
                },
                {
                    dataField: "Pot",
                    caption: "Potongan",
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

function Reprint(NoTransaksi) {
  $.ajax({
    type    :'post',
    url     : '<?=base_url()?>C_General/Reprint',
    data    : {'NoTransaksi':NoTransaksi},
    dataType: 'json',
    success:function (response) {
      if(response.success == true){
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
          location.reload();
        });
      }
    }
  });
}
function Payment(NoTransaksi) {
  // modal_Payment
  $.ajax({
    type    :'post',
    url     : '<?=base_url()?>C_POS/ReadTagihan',
    data    : {'NoTransaksi':NoTransaksi},
    dataType: 'json',
    success:function (response) {
      if(response.success == true){
        $('#NoTransaksiPay') .val(response.data[0]['NoTransaksi']);
        $('#NamaCustomerPay') .val(response.data[0]['NamaCustomer']);
        $('#TglTransaksiPay') .val(response.data[0]['TglTransaksi']);
        $('#TotalTagihanPay') .val(addCommasOuter(response.data[0]['T_GrandTotal']));
        $('#modal_Payment').modal('show');
      }
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