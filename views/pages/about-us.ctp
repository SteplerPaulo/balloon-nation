<image class="realistic-balloon" src="<?php echo $this->base;?>/img/gif/realistic-balloon.gif"></image>

<?php echo $this->Html->addCrumb('Home Page','/'); ?>
<?php echo $this->Html->addCrumb('About Us'); ?>

<?php echo $this->Html->css('aboutus'); ?>
<div class="row">
	<div class="col-lg-8 col-lg-offset-2">
		<image src="<?php echo $this->base;?>/img/under-construction.jpg" class="img-responsive" />
	</div>
</div>
<!--
<div id="portfolio" ng-controller="AboutUsController" ng-init="initializeController()" class="row">
	<section class="col-lg-6 col-md-6 col-sm-6" ng-if="Default">
		<div class="row">
			<div class="col-lg-12 ">
				<span class="pull-right">
					<a class="label label-info">Balloon Nation</a>
				</span>
			</div>
		</div>
		<h4>Company Overview</h4>
		<hr/>
		<div class="media">
			<div class="media-left">
				<a href="#">
					<image src="<?php echo $this->base;?>/img/about-us/owner-icon.jpg" class="media-object img-rounded img-thumbnail" />
				</a>
			</div>
			<div class="media-body">
				<h4 class="media-heading">Balloon Nation</h4>
				<p class="text-justify"> is owned and managed by <strong>Mr. Edgardo P. Perez</strong> and has established distribution nationwide thru different market channels, such as Medical Sub-distributors, Drugstores, Private and Government Hospitals and specialty clinics.  It is also comprised of 43 personnel.
				</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a href="#">
					<image src="<?php echo $this->base;?>/img/about-us/truck-icon.jpg" class="media-object img-rounded img-thumbnail" />
				</a>
			</div>
			<div class="media-body">
				<h4 class="media-heading">Balloon Nation</h4>
				<p class="text-justify">has the necessary assets and equipment to be able to handle the delivery and marketing of products of our partner/suppliers.
				</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a href="#">
					<image src="<?php echo $this->base;?>/img/about-us/25years-icon.jpg" class="media-object img-rounded img-thumbnail" />
				</a>
			</div>
			<div class="media-body">
				<h4 class="media-heading">Balloon Nation</h4>
				<p class="text-justify">is in the business of Distribution, Importation and Promotion of generic and branded medicines, medical and hospital supplies and equipment for over <strong>25 years</strong>. Other product has expanded and evolved to serve various fields of medicines such as Anesthesia, Radiology, Surgery, and Laboratory Departments.
				</p>
			</div>
		</div>
		<div class="media">
			<div class="media-left">
				<a href="https://www.google.com.ph/maps/place/South+East+Star+Enterprises/@14.080179,121.1519903,17z/data=!3m1!4b1!4m5!3m4!1s0x33bd6f5b56afcecf:0xfcbe7b43ce925acc!8m2!3d14.080179!4d121.154179" target="_blank" title="View Location" data-toggle="tooltip" class="red-tooltip">
					<image src="<?php echo $this->base;?>/img/about-us/map-icon.jpg" class="media-object img-rounded img-thumbnail" />
				</a>
			</div>
			<div class="media-body">
				<h4 class="media-heading">Balloon Nation</h4>
				<p class="text-justify">a local company that operates in Southern Luzon with its main office at Apitong Avenue Mt. View Subdivision, Tanauan City, Batangas.
				</p>
			</div>
		</div>
	</section>
	
	<section class="col-lg-6 col-md-6 col-sm-6" ng-if="VisionMission">
		<div class="row">
			<div class="col-lg-12 ">
				<span class="pull-right">
					<a class="label label-warning" ng-click="viewDefault()">Click me to view company overview</a>
				</span>
			</div>
		</div>
		<div class="row" >
			<div class="col-lg-12">
				<h4>Mission</h4>
				<hr>
				<ol>
					<li class="text-justify">We are entrusted to uphold and alleviate the healthcare services in our country by providing excellent services in the sale and distribution of pharmaceutical products, hospital consumables and equipment. </li>
					<li class="text-justify">We acknowledge our people in the company as our most important resource and we are committed to their personal development and career growth. </li>
					<li class="text-justify">We adhere to the highest ethical standards in handling our business activities, which we trust is the real foundation of true personal and career growth within the organization. </li>
					<li class="text-justify">This is also the basis for the faith   and   honor   we   wish to support always in all our undertakings with our co-workers in the company, our customers and other people, whose concern also pertains to healthcare services to our country. </li>
				</ol>
				<br/>
				<h4>Vision</h4>
				<hr>
				<ul>
					<li class="text-justify">To be the chosen distributor </li>
					<li class="text-justify">To be the worthy distributor</li>
					<li class="text-justify">To be a globally accepted service-oriented organization</li>
				</ul>
			</div>
		</div>
	</section>
	
	<section class="col-lg-6 col-md-6 col-sm-6" ng-if="Accreditation">
		<div class="row">
			<div class="col-lg-12 ">
				<span class="pull-right">
					<a class="label label-success" ng-click="viewDefault()">Click me to view company overview</a>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h4>Accreditations</h4>
				<hr>
				<ul>
					<li class="text-justify">Department of Health Accredited Supplier</li>
					<li class="text-justify">Accredited to all Government Hospital with Region</li>
				</ul>
				<br/>
				<h4>Licenses</h4>
				<hr>
				<ul>
					<li class="text-justify">License to Operate as a Wholesale Drug Importer/Distributor</li>
					<li class="text-justify">License to Operate as a Medical Device Importer/Distributor</li>
				</ul>
				<br/>
				<h4>Food and Drug Administration</h4>
				<hr>
				<ul>
					<li class="text-justify">Committee on Suppliers Accreditation and Region IV Duly Registered to DTI</li>
					<li class="text-justify">Assuring Product Safety, Quality and Efficacy Through Modern Technology</li>
				</ul>
			</div>
		</div>	
	</section>
	
	<section class="col-lg-6 col-md-6 col-sm-6" ng-if="Suppliers">	
		<div class="row">
			<div class="col-lg-12 ">
				<span class="pull-right">
					<a class="label label-primary" ng-click="viewDefault()">Click me to view company overview</a>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">		
				<h4>Suppliers</h4>
				<hr>
				<p class="text-justify">For the past twenty five (25) years, South East Star Enterprises has gained the support and trust of the different suppliers, here in the Philippines and in abroad to fully service the needs of the different market channels of the medical industry.
				</p>
			</div>
		</div><br/>
		<div class="row" style="padding-bottom:5px;">
			<div class="col-lg-3">				
				<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
			</div>
			<div class="col-lg-3">				
				<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
			</div>
			<div class="col-lg-3">				
				<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
			</div>
			<div class="col-lg-3">				
				<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
			</div>
		</div>
		
	</section>
	
	<section class="col-lg-6 col-md-6 col-sm-6" ng-if="Customers">	
		<div class="row">
			<div class="col-lg-12 ">
				<span class="pull-right">
					<a class="label label-danger" ng-click="viewDefault()">Click me to view company overview</a>
				</span>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<h4>Customers</h4>
				<hr>
				<div class="row">
					<div class="col-lg-12 text-justify">	
					The strength of South East Star Enterprises lies not only in the kind of merchandise that we market, but rather in the kind of personnel the organization is made of and most importantly in the people who welcome us in their institutions.
					We believe that our loyal and beloved customers are our key to success.	
					</div>
				</div>
				<br/>
				<h4>Private Hospital</h4>
				<hr>
				<div class="row" style="padding-bottom:5px;">
					
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-circle img-thumbnail" alt="">			
					</div>
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-circle img-thumbnail" alt="">			
					</div>
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-circle img-thumbnail" alt="">			
					</div>
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-circle img-thumbnail" alt="">			
					</div>
				</div>
				<br/>
				<h4>Government Hospital</h4>
				<hr>
				<div class="row" style="padding-bottom:5px;">
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
					</div>
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
					</div>
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
					</div>
					<div class="col-lg-3">				
						<img src="http://placehold.it/320x150" class="img-responsive img-thumbnail" alt="">			
					</div>
				</div>
				
			</div>
		</div>
	</section>
	
	<section class="col-lg-6">
		<div class="row">
			<div class="col-sm-6 portfolio-item">
				<a ng-click="viewVisionMission()" class="portfolio-link">
					<div class="caption">
						<div class="caption-content">
							<i class="fa fa-search-plus fa-3x"></i>
						</div>
					</div>
					<i class="fa fa-creative-commons" aria-hidden="true"></i> Our Vision | Mission
					<img src="<?php echo $this->base;?>/img/about-us/vision-mission.jpg" class="img-responsive img-thumbnail" alt="">
					
				</a>
			</div>
			<div class="col-sm-6 portfolio-item">
				<a ng-click="viewAccreditation()"  class="portfolio-link">
					<div class="caption">
						<div class="caption-content">
							<i class="fa fa-search-plus fa-3x"></i>
						</div>
					</div>
					<i class="fa fa-certificate" aria-hidden="true"></i> Our Licenses & Accreditations
					<img src="<?php echo $this->base;?>/img/about-us/certified.jpg" class="img-responsive img-thumbnail" alt="">
				</a>
			</div>
			<div class="col-sm-6 portfolio-item">
				<a ng-click="viewSuppliers()" class="portfolio-link">
					<div class="caption">
						<div class="caption-content">
							<i class="fa fa-search-plus fa-3x"></i>
						</div>
					</div>
					<i class="fa fa-ship" aria-hidden="true"></i> Our Trusted Suppliers
					<img src="<?php echo $this->base;?>/img/about-us/suppliers.jpg" class="img-responsive img-thumbnail" alt="">
				</a>
			</div>
			<div class="col-sm-6 portfolio-item">
				<a ng-click="viewCustomers()"  class="portfolio-link">
					<div class="caption">
						<div class="caption-content">
							<i class="fa fa-search-plus fa-3x"></i>
						</div>
					</div>
					<i class="fa fa-users" aria-hidden="true"></i> Our Loyal & Beloved Customers
					<img src="<?php echo $this->base;?>/img/about-us/customer.jpg" class="img-responsive img-thumbnail" alt="">
				</a>
			</div>
		</div>
	</section>
</div>

-->
<?php echo $this->Html->script('controllers/aboutus',array('inline'=>false));?>

