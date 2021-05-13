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
                    <h2>Perhitungan</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <select id="KodeAtribut" name="KodeAtribut" class="form-control" required>
                      <?php
                        $rs = $this->db->query("select * from tatribut order by KodeAtribut")->result();
                        foreach ($rs as $key) {
                          echo "<option value = '".$key->KodeAtribut."'>".$key->NamaAtribut."</option>";
                        }
                      ?>
                    </select>
                    <br>
                    <button class="btn btn-success" id="btn_proses">Proses</button>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>DCO</th>
                            <th>Attribut</th>
                            <th>Nilai Kematangan Atribut</th>
                            <th>Nilai Kematangan CO</th>
                          </tr>
                        </thead>
                        <tbody id="load_data">
                          <!-- <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td rowspan="6">1</td>
                          </tr> -->
                        </tbody>
                      </table>

                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Control</th>
                            <th>Proses</th>
                            <th>Nilai Saat Ini</th>
                            <th>Nilai Harapan</th>
                            <th>Kesenjangan</th>
                          </tr>
                        </thead>
                        <tbody id="load_data_2">
                          <!-- <tr>
                            <td>1</td>
                            <td>1</td>
                            <td>1</td>
                            <td rowspan="6">1</td>
                          </tr> -->
                        </tbody>
                      </table>

                      <!-- chart -->

                      <!-- <canvas id="canvasRadar"></canvas> -->
                      <canvas id="marksChart" width="600" height="400"></canvas>
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
<script src="<?php echo base_url(); ?>Assets/vendors/Chart.js/dist/Chart.min.js"></script>
<script type="text/javascript">
  $(function () {
    $(document).ready(function () {
      
    });
    $('#btn_proses').click(function () {
      $.ajax({
        type: "post",
        url: "<?=base_url()?>C_Nilai/GetNilai",
        data: {'KodeAtribut':$('#KodeAtribut').val()},
        dataType: "json",
        success: function (response) {
          var label = [];
          var datax = [];

          var html = '';
          var i;
          var x = 1;
          var Totalx = 0;
          if (response.success == true) {
            var index = 1;
            for (i = 0; i < response.data.length; i++) {
              if (index == 6) {
                Totalx = parseFloat(Totalx) + parseFloat(response.data[i].Nilai);
                index = 1
              }
              else{
                Totalx = parseFloat(Totalx) + parseFloat(response.data[i].Nilai);
                index = index + 1;
              }
              label.push(response.data[i].NoQuisioner);
              datax.push(parseFloat(response.data[i].Nilai));
            }
            for (i = 0; i < response.data.length; i++) {
              if (x == 1) {
                // console.log(Totalx);
                html += '<tr>' +
                          '<td>'+response.data[i].KodeAtribut+'</td>' + 
                          '<td>'+response.data[i].NoQuisioner+'</td>' +
                          '<td>'+response.data[i].Nilai+'</td>' +
                          '<td rowspan = "6" style ="text-align:center;vertical-align: middle;">'+parseFloat(Totalx)/6+'</td>' +
                        '</tr>';
                x = x + 1;
                // console.log(html);
              }
              else{
                if (x <6) {
                  // console.log(Totalx);
                  html += '<tr>'+
                            '<td>'+response.data[i].KodeAtribut+'</td>' + 
                            '<td>'+response.data[i].NoQuisioner+'</td>' +
                            '<td>'+response.data[i].Nilai+'</td>' +
                          '</tr>';
                  x = x + 1;
                }
                else{
                  html += '<tr>'+
                            '<td>'+response.data[i].KodeAtribut+'</td>' + 
                            '<td>'+response.data[i].NoQuisioner+'</td>' +
                            '<td>'+response.data[i].Nilai+'</td>' +
                          '</tr>';
                  x = 1;
                }
                // console.log(html);
              }
            }
            // console.log(html);
            $('#load_data').html(html);
            // Nilai AKhir
            $.ajax({
              type: "post",
              url: "<?=base_url()?>C_Nilai/NilaiAkhir",
              data: {'KodeAtribut':$('#KodeAtribut').val()},
              dataType: "json",
              success: function (responseAkhir) {
                var html = '';
                var i;
                for (i = 0; i < responseAkhir.data.length; i++) {
                  var gap = 5 - parseFloat(responseAkhir.data[i].NilaiAkhir);
                  console.log(gap);
                  html += '<tr>'+
                            '<td>'+responseAkhir.data[i].KodeAtribut+'</td>' + 
                            '<td>'+responseAkhir.data[i].NamaAtribut+'</td>' +
                            '<td>'+responseAkhir.data[i].NilaiAkhir+'</td>' +
                            '<td>5</td>' +
                            '<td>'+ gap +'</td>' +
                          '</tr>';
                }
                $('#load_data_2').html(html);
              }
            });
            ShowChart(label,datax)
            console.log(label);
            console.log(datax);
          }
        }

      });
    });

    function ShowChart(label,data) {
      var marksCanvas = document.getElementById("marksChart");

      var marksData = {
        labels: label,
        datasets: [{
          label: "Student A",
          backgroundColor: "rgba(200,0,0,0.2)",
          data: data
        }]
      };

      var radarChart = new Chart(marksCanvas, {
        type: 'radar',
        data: marksData
      });

    }
  });
</script>