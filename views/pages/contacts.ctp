<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('Contacts'); ?>

<div class="row">
	
	<div class="col-lg-6 col-lg-offset-1">
		<a href="javascript:void(0)" title="View Location" data-toggle="tooltip" class="red-tooltip">
			<image src="http://placehold.it/600x250" class="img-responsive" />
		</a>
		<address>
			<h2 style="color: #a62424;">Balloon Nation</h2>
			Quezon Avenue <br>
			Quezon City, Philippines
		</address>
		<address>
			<strong>Email Address</strong><br>
			<a href="mailto:balloon_nation@gmail.com">balloon_nation@gmail.com</a>
		</address>
		<address>
			<strong>Telephone No.</strong><br>
			(000) 000-0000<br/>
		</address>
		<address>
			<strong>Fax No.</strong><br>
			00-000-00000000
		</address>

	</div>
	<div class="col-lg-4 alert alert-danger box-shadow" id="FORM">
		<?php echo $this->Form->create('Inquiry',array('enctype' => 'multipart/form-data','action'=>'send_via_contactus'));?>
		<h4 class="alert alert-danger">Send Us A Message</h4>
		<div class="row">
			<div class="col-md-12">
				<div class="input text">
					<label for="InquiryFrom">From</label>
					<input name="data[Inquiry][from]" type="email" class="form-control" placeholder="Enter your email address" required="required" id="InquiryFrom">
				</div>
				<label>To</label>
				<div class="like-input-box">
					Balloon Nation
				</div>
				<?php
					echo $this->Form->input('subject',array('class'=>'form-control','required'=>'required'));
					echo $this->Form->input('content',array('type'=>'textarea','class'=>'form-control','required'=>'required'));
				?>
			</div>
		</div><br/>
		<div class="row">
			<div class="col-md-12 text-right">
				<button class="btn btn-danger" id="SendButton"><i class="fa fa-paper-plane-o"></i> Send</button>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>
