<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">	
					<h4>Add Content</h4>
				</h3>
			</div>
			<?php echo $this->Form->create('Content');?>
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-6">
					<?php
						echo $this->Form->input('id',array('options'=>$contents,'label'=>'Choose Module To Edit','empty'=>'Select','class'=>'form-control','required'=>'required'));
						echo $this->Form->input('content',array('type'=>'hidden','class'=>'form-control'));
					?>
					</div>
				</div>
				<br/>
				<div id="summernote"></div>
			</div>
			<div class="panel-footer">	
				<div class="text-right">
					<button class="btn btn-primary" type="submit">Save</button>
				</div>
			</div>
			<?php echo $this->Form->end();?>
		</div>
	</div>
</div>

<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Contents', true), array('action' => 'index'));?></li>
	</ul>
</div>


<?php echo $this->Html->script('biz/contents',array('inline'=>false));?>