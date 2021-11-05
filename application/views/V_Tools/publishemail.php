<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
    $active = 'dashboard';
?>
<link href="<?php echo base_url();?>Assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
<div class="right_col" role="main">
	<div class="row">
		<div class="col-md-12">
			<div class="">
				<div class="x_content">
					<div class="col-md-12 col-sm-12 ">
						<div class="x_panel">
							<div class="x_title">
								<h2>Text areas<small>Sessions</small></h2>
								<ul class="nav navbar-right panel_toolbox">
									<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
									</li>
									<li class="dropdown">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="#">Settings 1</a>
											<a class="dropdown-item" href="#">Settings 2</a>
										</div>
									</li>
									<li><a class="close-link"><i class="fa fa-close"></i></a>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="x_content">
                    			<div class="col-md-12 col-sm-12 ">
			                      <input type="text" name="subject" id="subject" required="" placeholder="Subject Email" class="form-control ">
			                    </div>
			                    <br> <br><br>	
								<div id="alerts"></div>
								<div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-one">
									<div class="btn-group">
										<a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
										<ul class="dropdown-menu">
										</ul>
									</div>

									<div class="btn-group">
										<a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
										<ul class="dropdown-menu">
											<li>
												<a data-edit="fontSize 5">
													<p style="font-size:17px">Huge</p>
												</a>
											</li>
											<li>
												<a data-edit="fontSize 3">
													<p style="font-size:14px">Normal</p>
												</a>
											</li>
											<li>
												<a data-edit="fontSize 1">
													<p style="font-size:11px">Small</p>
												</a>
											</li>
										</ul>
									</div>

									<div class="btn-group">
										<a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
										<a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
										<a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
										<a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
									</div>

									<div class="btn-group">
										<a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
										<a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
										<a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
										<a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
									</div>

									<div class="btn-group">
										<a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
										<a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
										<a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
										<a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
									</div>

									<div class="btn-group">
										<a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
										<div class="dropdown-menu input-append">
											<input class="span2" placeholder="URL" type="text" data-edit="createLink" />
											<button class="btn" type="button">Add</button>
										</div>
										<a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
									</div>

									<div class="btn-group">
										<a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
										<input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
									</div>

									<div class="btn-group">
										<a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
										<a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
									</div>
								</div>

								<div id="editor-one" class="editor-wrapper"></div>

								<textarea name="descr" id="descr" style="display:none;"></textarea>
							</div>
						</div>
					</div>

		            <div class="col-md-6 col-sm-12  form-group">
		              <button class="btn btn-success" name="send" id="send">Send</button>
		              <label for="first-name" id="Progress"></label>
		              <div id="labelprogress"></div>
		            </div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<script src="<?php echo base_url();?>Assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script src="<?php echo base_url();?>Assets/vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
<script src="<?php echo base_url();?>Assets/vendors/google-code-prettify/src/prettify.js"></script>

<script type="text/javascript">
	$(function () {
		var html = 'Ready..'
		$(document).ready(function () {
	      $('#searchReport').click();  
	      $('#Progress').append(html);
	    });

	    $('#send').click(function () {
	    	var kriteria = '';
	        var skrip = '';
	        var userid = '';
	        var roleid = 4;

	        $('#send').text('Tunggu Sebentar.....');
          	$('#send').attr('disabled',true);

	    	$.ajax({
	    		async: false,
		        type: "post",
		        url: "<?=base_url()?>Auth/read",
		        data: {kriteria:kriteria,skrip:skrip,userid:userid,roleid:roleid},
		        dataType: "json",
		        success: function (response) {
		        	// console.log(response);
		        	html = 'Prosessing ' + response.data.length + ' data';
		        	var index = 0;
		        	$.each(response.data,function (k,v) {
		        		if (v.email != '') {
		        			var recipt = v.email;
		        			var subject = $('#subject').val();
		        			var body = $('#editor-one').cleanHtml()
		        			$.ajax({
		        				async: false,
					            type: "post",
					            url: "<?=base_url()?>C_Tools/PublishEmail",
					            data: {email:recipt,subject:subject,body:body},
					            dataType: "json",
					            success: function (responseInsert) {
					              // bindGrid(response.data);
					              console.log(responseInsert)
					              html += ' ...... ' + index + " Done";
					              // $('#labelprogress').html(html);
					              console.log(html);
					              index += 1;
					            }
					        });
		        		}
		        	});
		        	console.log(index);
		        	if (index == response.data.length && index != 0 ) {
		        		Swal.fire({
	                      type: 'success',
	                      title: 'Horay..',
	                      text: 'Semua email berhasil di kirim!',
	                      // footer: '<a href>Why do I have this issue?</a>'
	                    }).then((result)=>{
	                      location.reload();
	                    });
		        		$('#send').text('Send');
          				$('#send').attr('disabled',false);
		        	}
		        }
		      });
	    });
	});
</script>