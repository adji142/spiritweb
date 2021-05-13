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
                    <h2>Atribut</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <input type="text" name="KodeAtribut" id="KodeAtribut" value="<?php echo $KodeAtribut ?>">
                    <input type="text" name="RowID" id="RowID">
                    <?php
                      $dataQuisioner = $this->ModelsExecuteMaster->FindData(array('KodeAtribut'=>$KodeAtribut),'tquis');
                      $html = '';
                      if ($dataQuisioner->num_rows() > 0) {
                        $noUrut = 1;
                        foreach ($dataQuisioner->result() as $key) {
                          $html .= '
                              <label><b>'.$noUrut.'. '. $key->Description.'</b></label>
                          ';
                          $dataSkala = $this->ModelsExecuteMaster->FindData(array('KodeAtribut'=>$KodeAtribut),'tskala');
                          if ($dataSkala->num_rows() > 0) {
                            $skalaindex = 0;
                            foreach ($dataSkala->result() as $keySkala) {
                              $html .= '
                                  <p>
                                    <input type="radio" name="S'.$noUrut.'" id="S'.$noUrut.'" value = "'.$keySkala->Skala.'" /> '.$keySkala->Skala.' : '.$keySkala->SkalaDesc.'
                                  </p>
                                <br>
                              ';
                              $skalaindex += 1;
                            }
                          }
                          $noUrut += 1;
                        }
                      }
                      echo $html;
                    ?>
                    <div class="item" form-group>
                      <button class="btn btn-primary" id="btn_Save">Save</button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script type="text/javascript">
  $(function () {
    $.ajax({
      type: "post",
      url: "<?=base_url()?>Auth/Getindex",
      data: {'Kolom':'RowID','Table':'tnilai','Prefix':'10'},
      dataType: "json",
      success: function (response) {
        $('#RowID').val(response.nomor);
      }
    });
    $('#btn_Save').click(function () {
      var KodeAtribut = $('#KodeAtribut').val();
      $.ajax({
        async   : false,
        type    : 'post',
        url     : '<?=base_url()?>C_Quis/Read',
        data    : {'KodeAtribut':KodeAtribut},
        dataType: 'json',
        success : function (response) {
          if (response.success == true) {
            var x = 1;
            $.each(response.data,function (k,v) {
              var hasil = $("input[name='S"+x.toString()+"']:checked").val();
              $.ajax({
                async   : false,
                type    : 'post',
                url     : '<?=base_url()?>C_Nilai/CRUD',
                data    : {'RowID':$('#RowID').val(),'NoQuisioner':v.KodeQuis,'KodeAtribut':KodeAtribut,'Nilai':hasil,'formtype':'add'},
                dataType: 'json',
                success : function (responseInput) {
                  if (responseInput.success == true) {
                    Swal.fire({
                      type: 'success',
                      title: 'Horay..',
                      text: 'Data Berhasil disimpan!',
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then((result)=>{
                      location.reload();
                    });
                  }
                }
              });
              x+=1
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
            url     : '<?=base_url()?>C_Atribut/CRUD',
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
  });
</script>