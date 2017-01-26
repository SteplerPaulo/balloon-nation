<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php __('Profile');?></h1>
		<div class="media col-lg-12">
			<span class="col-lg-3 vertical-line">
				<a class="pull-left thumbnail " href="#ProfilePictureModal"  role="button" data-toggle="modal">
					<?php 
						if(!empty($user['Document']['id'])){
							echo $this->Html->image('/users/download/'.$user['Document']['id'],array('alt'=>'','class'=>'media-object','style'=>'width:167px;height:200px'));
						}else{
							echo $this->Html->image('/img/200x200.gif',array('alt'=>'','class'=>'media-object','style'=>'width:167px;height:200px'));
						}
					?>
				</a>	
				<?php  
					if($access->check('User') || $user['User']['id'] == $access->getmy('id') ):
						echo $this->element('upload');
					endif;
				?>
			</span>
			<div class="media-body col-lg-9">
				<section>
					<dl>
						<dt><h4>USERNAME: <?php echo $user['User']['username']; ?></h4></dt>
						<dd><b>LAST NAME: </b><?php echo $user['User']['last_name']; ?></dd>
						<dd><b>FIRST NAME: </b><?php echo $user['User']['first_name']; ?></dd>
						<dd><b>MIDDLE NAME: </b><?php echo $user['User']['middle_name']; ?></dd>
					</dl>
				</section><hr>
				<section>
					<?php //echo $this->element('apps'); ?>
				</section>
			</div>
		</div>
	</div>
</div>
