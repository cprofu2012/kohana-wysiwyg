<!-- Modal windows -->
<!-- File upload modal window -->
<div id="upload-modal" class="modal hide fade">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3><?php echo __('Upload files') ?></h3>
	</div>
	<div class="modal-body">
		<p><?php echo __('Select files to upload it to the server') ?></p>
		<ul id="upload"></ul>
	</div>
	<div class="modal-footer">
		<?php echo HTML::anchor("#", __('Attach file'), array('class' => 'btn btn-success attach', 'data-dismiss' => 'modal')) ?>
		<?php echo HTML::anchor("#", __('Attach another file'), array('class' => 'btn btn-success attach-another', 'data-dismiss' => 'modal')) ?>
		<?php echo HTML::anchor('#', __('Cancel'), array('class' => 'btn', 'data-dismiss' => 'modal')) ?>
	</div>
</div>
<!-- /File upload modal window -->

<!-- File rename modal -->
<div id="file-rename-modal" class="modal hide fade">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3><?php echo __('Rename file') ?></h3>
	</div>
	<div class="modal-body">
		<?php echo Form::open(NULL, array('class' => 'form-horizontal')) ?>
		<div class="alert"><strong><?php echo __('Warning!') ?></strong><br /><?php echo __('It action will cause the file is unavailable at the old URL-address.') ?></div>
		<div class="control-group">
			<?php echo Form::label('filename', __('New file name').':') ?>
			<div class="input-append">
				<?php echo Form::input('filename') ?>
				<span class="add-on" id="file-extension">.jpg</span>
			</div>
		</div>
		<?php echo Form::close() ?>
	</div>
	<div class="modal-footer">
		<?php echo HTML::anchor("#", __('Rename file'), array('class' => 'btn btn-success', 'data-dismiss' => 'modal')) ?>
		<?php echo HTML::anchor('#', __('Cancel'), array('class' => 'btn', 'data-dismiss' => 'modal')) ?>
	</div>
</div>
<!-- /File rename modal -->

<!-- File delete modal window -->
<div id="file-delete-modal" class="modal hide fade">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3><?php echo __('Delete file') ?></h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-danger"><strong><?php echo __('Warning!') ?></strong><br /><?php echo __('Restore deleted file will be impossible.') ?></div>
		<div class="alert alert-info"><strong><?php echo __('By the way.') ?></strong><br /><?php echo __('If you are unsure, you can just put this file into a temporary folder. This will help to save the file. All sorts of things.') ?></div>
		<p><?php echo __('Are you sure you want to delete this file without the possibility of his recovery?') ?></p>
		<?php echo Form::open() ?>
		<div class="control-group">
			<?php echo Form::hidden('agree', 1) ?>
		</div>
		<?php echo Form::close() ?>
	</div>
	<div class="modal-footer">
		<?php echo HTML::anchor("#", __('Delete file'), array('class' => 'btn btn-success', 'data-dismiss' => 'modal')) ?>
		<?php echo HTML::anchor('#', __('Cancel'), array('class' => 'btn', 'data-dismiss' => 'modal')) ?>
	</div>
</div>
<!-- /File delete modal window -->

<!-- Directory add/rename modal window -->
<div id="dir-modal" class="modal hide fade">
</div>
<!-- /Directory add/rename modal window -->
<!-- /Modal windows -->

<!-- Navigation bar -->
<div class="navbar">
	<div class="navbar-inner">
		<div class="container-fluid">
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li><?php echo HTML::anchor('#', '<i class="icon-upload icon-white"></i>&nbsp;'.__('Upload files'), array('id' => 'upload-link')) ?></li>
					<li class="divider-vertical"></li>
					<li><?php echo HTML::anchor('#', '<i class="icon-refresh icon-white"></i>&nbsp;'.__('Refresh'), array('id' => 'refresh-link')) ?></li>
				</ul>
		</div>
	</div>
</div>
<!-- /Navigation bar -->

			<div id="dirs" class="well sidebar-nav">
				<!-- Directories tree -->
					<div class="directories">
						<div id="root" class="open">
							<p>
								<a href=""><?php echo Kohana::$config->load('filebrowser.uploads_directory') ?></a>
							</p>
							<?php foreach ($dirs as $dir => $parents): ?>
								<div name="<?php echo $parents ?>">
									<p>
										<i class="icon-chevron-right"></i><a href=""><?php echo $dir ?></a>
										<em></em>
									</p>
								</div>
							<?php endforeach ?>
						</div>
				<!-- /Directories tree -->
			</div>
		</div>
		<div id="files" class="span9">
			<!-- breadcrumb -->
			<div id="breadcrumb"></div>
			<!-- /breadcrumb -->

			<!-- Files list -->
			<div id="files-row"></div>
			<!-- /Files list -->
		</div>



<!-- jQuery.tmpl templates collection -->
<!-- breadcrumb -->
<script id="tpl-breadcrumb" type="text/x-jquery-tmpl">
	<ul class="breadcrumb">
		<li>
			<?php echo Kohana::$config->load('filebrowser.uploads_directory') ?>&nbsp;
			<span class="divider">/</span>
		</li>
		{{each parts}}
		<li>
			${$value}&nbsp;
			<span class="divider">/</span>
		</li>
		{{/each}}
	</ul>
</script>
<!-- /breadcrumb -->

<!-- Files list -->
<script id="tpl-files" type="text/x-jquery-tmpl">
	{{each(key, value) files}}
	<div class="file {{if value.type}}non_{{/if}}picture" title="${key}"{{if value.width && value.height}} rel="{width:${value.width},height:${value.height}}"{{/if}}>
			 <div class="icon{{if value.type}} ${value.type}{{/if}}">
			{{if value.thumb}}<img src="/${value.thumb}" alt="${key}"/>{{/if}}
			<div class="fileOverlay"></div>
		</div>
		<p class="name"><span>${key}</span><i></i></p>
		<p class="size">${value.size}</p>
		{{if value.width && value.height}}<p class="img_size">img. size: ${value.width}×${value.height}</p>{{/if}}
		<!-- File parameters (for easy rename) -->
		<span class="params hide">
			<span class="filename">${value.filename}</span>
			<span class="extension">${value.extension}</span>
		</span>
	</div>
	{{/each}}
</script>
<!-- /Files list -->

<!-- Dir modal -->
<script id="tpl-dir-modal" type="text/x-jquery-tmpl">
	<div class="modal-header">
		<a class="close" data-dismiss="modal">&times;</a>
		<h3>{{if rename}}<?php echo __('Rename directory') ?>{{else}}<?php echo __('Add directory') ?>{{/if}}</h3>
	</div>
	<div class="modal-body">
{{if rename}}
		<div class="alert"><strong><?php echo __('Warning!') ?></strong><br /><?php echo __('It action will cause the file is unavailable at the old URL-address.') ?></div>
{{/if}}
		<?php echo Form::open() ?>
		<div class="control-group">
			<?php echo Form::label('filename', '{{if rename}}'.__('New directory name').'{{else}}'.__('Directory name').'{{/if}}:') ?>
			<?php echo Form::input('filename') ?>
		</div>
		<?php echo Form::close() ?>
	</div>
	<div class="modal-footer">
		<?php echo HTML::anchor("#", '{{if rename}}'.__('Rename directory').'{{else}}'.__('Add directory').'{{/if}}', array('class' => 'btn btn-success', 'data-dismiss' => 'modal')) ?>
		<?php echo HTML::anchor('#', __('Cancel'), array('class' => 'btn', 'data-dismiss' => 'modal')) ?>
	</div>
</script>
<!-- /Dir modal -->
<!-- /jQuery.tmpl templates collection -->