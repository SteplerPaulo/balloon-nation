<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('Contacts'); ?>
<div class="row">
	<div class="col-lg-6 col-lg-offset-1">
		<a href="https://www.google.com/maps/place/Balloon+Republic/@14.6331122,120.9957273,17z/data=!3m1!4b1!4m5!3m4!1s0x3397b672169e07fd:0x22dcaa2dc61664d7!8m2!3d14.633107!4d120.997916" title="View Location" data-toggle="tooltip" class="red-tooltip">
			<image src="img/map.png" target="_blank" class="img-responsive" />
		</a>
		<address>
			<h2 style="color: #6920b0;">Balloon Nation</h2>
			187 - B D. Tuazon, Santa Mesa Heights, <br>
			Quezon City, 1114 Metro Manila , Philippines
		</address>
		<address>
			<strong>Email Address</strong><br>
			<a href="mailto:getinfo@balloonrep.com">getinfo@balloonrep.com</a>
			<a href="mailto:balloonation187@gmail.com">balloonation187@gmail.com</a>
			<a href="mailto:balloonation187@yahoo.com">balloonation187@yahoo.com</a>
		</address>
		<address>
			<strong>Telephone No.</strong><br>
			(02) 416-0671<br/>
		</address>
		<address>
			<strong>Mobile No.</strong><br>
			0933-1629-960 <br/>
		</address>
	</div>
	<div class="col-lg-4 alert alert-default box-shadow" id="FORM">
		<?php echo $this->Form->create('Inquiry',array('enctype' => 'multipart/form-data','action'=>'send_via_contactus'));?>
		<h4>Send Us A Message</h4>
		<div class="row">
			<div class="col-md-12">
				<div class="input text">
					<input name="data[Inquiry][from]" type="email" class="form-control" placeholder="Your email address" required="required" id="InquiryFrom">
				</div>
				<label class="hide" >To</label>
				<div class="like-input-box hide">
					Balloon Nation
				</div>
				<?php
					echo $this->Form->input('subject',array('value'=>'From Balloon Republic Website','class'=>'hide form-control','required'=>'required','label'=>false));
				?>
				<br/>
				<?php
					echo $this->Form->input('content',array('placeholder'=>'Your message','type'=>'textarea','class'=>'form-control','required'=>'required','label'=>false));
				?>
			</div>
		</div><br/>
		<div class="row">
			<div class="col-md-12 text-right">
				<button class="btn btn-success" id="SendButton">Send Mail <i class="fa fa-envelope"></i></button>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>
