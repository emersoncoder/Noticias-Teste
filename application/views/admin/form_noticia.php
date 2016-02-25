<form id="form_noticias" action="<?php echo base_url();?>admin/noticias/gravar" method="post">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Noticias</h4>
	</div>
	<div class="modal-body">
		<input type="hidden" value="<?php echo (isset($noticias[0]->id_noticias) ? $noticias[0]->id_noticias : '');?>" name="id_noticias"/>
		<div id="erro"></div>
		<div class="form-group">
			<label for="titulo">Titulo</label>
			<input type="text" class="form-control" id="titulo" value="<?php echo (isset($noticias[0]->titulo) ? $noticias[0]->titulo : '');?>" name="titulo" placeholder="Titulo">
		</div>
		<div class="form-group">
			<label for="resumo">Resumo</label>
			<input type="text" class="form-control" value="<?php echo (isset($noticias[0]->resumo) ? $noticias[0]->resumo : '');?>"id="resumo" name="resumo" placeholder="Resumo">
		</div>
		<div class="form-group">
			<label for="data">Data</label>
			<?php
				if(isset($noticias[0]->data))
				{
					$data = explode(' ', $noticias[0]->data);
					$data = $data[0];
					$data = explode('-', $data);
					$data = $data[2] . '/' . $data[1] . '/' . $data[0];
				}
				else
					$data = '';
			?>
			<input type="text" class="form-control" value="<?php echo $data;?>" id="data" name="data" placeholder="__/__/__">
		</div>										
		<div class="form-group">
			<label for="descricao">Descrição</label>
			<textarea class="form-control" name="descricao" id="descricao" rows="3"><?php echo (isset($noticias[0]->descricao) ? $noticias[0]->descricao : '');?></textarea>
		</div>										
		<div class="form-group">
			<label for="imagem">Imagem da Notícia</label>
			<input type="file" id="imagem" name="userfile">
		</div>
		<div class="form-group">
			<?php if(isset($noticias[0]->imagem)){?>
				<img src="<?php echo base_url('assets/imagem_noticias/thumb_' . $noticias[0]->imagem);?>" class="img-responsive" alt="Responsive image">
			<?php }	?>
		</div>
		<div class="checkbox">
			<label>
				<input type="checkbox" name="publicar">Publicar
			</label>
		</div>
	</div>
	<div class="modal-footer">
		<button type="reset" class="btn btn-default" data-dismiss="modal">Fechar</button>
		<button type="submit" class="btn btn-primary">Salvar</button>
	</div>
</form>
<script>
	

		function elFinderBrowser (callback, value, meta) {
			tinymce.activeEditor.windowManager.open({
				file: 'http://localhost/noticias/assets/elFinder-2.1/elfinder.html',// use an absolute path!
				title: 'elFinder 2.1',
				width: 900,	
				height: 450,
				resizable: 'yes'
			}, {
				oninsert: function (file, fm) {
					var url, reg, info;

					// URL normalization
					url = file.url;
					reg = /\/[^/]+?\/\.\.\//;
					while(url.match(reg)) {
						url = url.replace(reg, '/');
					}
					
					// Make file info
					info = file.name + ' (' + fm.formatSize(file.size) + ')';

					// Provide file and text for the link dialog
					if (meta.filetype == 'file') {
						callback(url, {text: info, title: info});
					}

					// Provide image and alt text for the image dialog
					if (meta.filetype == 'image') {
						callback(url, {alt: info});
					}

					// Provide alternative source and posted for the media dialog
					if (meta.filetype == 'media') {
						callback(url);
					}
				}
			});
			return false;
		}
		// TinyMCE init
		tinymce.init({
			selector: "textarea",
			height : 400,
			plugins: "image, link, media",
			relative_urls: false,
			remove_script_host: false,
			toolbar: "undo redo | styleselect | link image media",
			file_picker_callback : elFinderBrowser
		});

	
	$(function(){

		$("#data").inputmask("99/99/9999",{ "placeholder": "__/__/___" });

		$('#form_noticias').submit(function(e){
			var formData = new FormData($(this)[0]);
			$.ajax({
				url: site_url('admin/noticias/gravar'),
				type: 'POST',
				data: formData,
				async: false,
				success: function (data) {
					if(data.message != 'ok')
					{
						$('#erro').html(data);
					}
					else
					{
						window.location = site_url('admin/noticias');
					}
				},
				cache: false,
				contentType: false,
				processData: false,
			});
			return false;
		});		
	});

</script>