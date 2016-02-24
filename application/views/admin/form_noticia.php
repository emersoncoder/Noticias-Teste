
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
			<input type="text" class="form-control" value="<?php echo (isset($noticias[0]->data) ? $noticias[0]->data : '');?>" id="data" name="data" placeholder="__/__/__">
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
			<?php
				if(isset($noticias[0]->imagem))
				{?>
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

tinyMCE.init({
        mode : "textareas",
                
        file_browser_callback : elFinderBrowser,
                
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
});


function elFinderBrowser (field_name, url, type, win) {
  var elfinder_url = 'http://localhost/noticias/assets/js/elfinder/elfinder.html';    // use an absolute path!
  tinyMCE.activeEditor.windowManager.open({
    file: elfinder_url,
    title: 'elFinder 2.0',
    width: 900,  
    height: 450,
    resizable: 'yes',
    inline: 'yes',    // This parameter only has an effect if you use the inlinepopups plugin!
    popup_css: false, // Disable TinyMCE's default popup CSS
    close_previous: 'no'
  }, {
    window: win,
    input: field_name
  });
  return false;
}


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