<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('Products','/products/'); ?>
<?php echo $this->Html->addCrumb('Send Inquiry'); ?>
<div class="row">
	<?php echo $this->Form->create('Inquiry',array('enctype' => 'multipart/form-data'));?>
	<div class="col-md-8 col-md-offset-2">
		<h4>SEND INQUIRY</h4>
		<div class="row">
			<div class="col-md-12">
				<div class="input text">
					<label for="InquiryFrom">From</label>
					<input name="data[Inquiry][from]" type="email" class="form-control" placeholder="Enter your email address" required="required" id="InquiryFrom">
				</div>
				<label>To</label>
				<div class="like-input-box">
					<p>South East Star Enterprises (SESEPHIL)</p>
					<?php if(!empty($product['ProductImage'])):?>
					<ul>
						<li>
							<p class="image-box">
								<a href="#">
									<img title="<?php echo $product['Product']['name'];?>" alt="<?php echo $product['Product']['name'];?>" src="<?php echo $this->base;?>/img/product images/<?php echo $product['ProductImage'][0]['img_file'];?>"   width="50" height="50">
								</a>
							</p>
						</li>
					</ul>
					<?php endif;?>
				</div>
				<?php
					echo $this->Form->input('subject',array('class'=>'form-control','value'=>'Inquiry about '.$product['Product']['name'],'required'=>'required'));
					echo $this->Form->input('content',array('class'=>'form-control','required'=>'required'));
				?>
			</div>
		</div><br/>
		<div class="row">
			<div class="col-md-6">
				<?php echo $this->Form->input('InquiryFile.file_name', array('type'=>'file'));?>
			</div>
			<ul class="col-md-6">
				<li>Supports jpg, jpeg, png, gif, pdf, doc, docx, xls, xlsx, txt, rar and zip</li>
				<li>Max. total size: 3MB</li>
			</ul>
		</div>
		<div class="text-right row">
			<button class="btn btn-danger" type="submit"><i class="fa fa-paper-plane-o"></i> Send Inquiry</button>
		</div>
	</div>
	<?php echo $this->Form->end();?>
</div>
