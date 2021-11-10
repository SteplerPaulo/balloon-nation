<style>body{padding-top: 40px;}</style>
<div ng-controller="UserRegistrationController" ng-init="initializeController()">	
	<form name="form" novalidate class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<img src="<?php echo $this->base;?>/img/name.png" class="img-responsive" alt="Contact Tracing App"/>
					<h3>Create your account</h3>
					<small>We value your privacy. Your first name & last name are optional.</small>
					<hr/>
					<div class="ng-cloak">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label class="autolabel">This field is not required.</label>
									<input ng-model="data.User.first_name" placeholder="First Name" class="form-control" />
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label class="autolabel">This field is not required.</label>
									<input ng-model="data.User.last_name" placeholder="Last Name" class="form-control" />
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group">
									<input my-directive ng-blur="validateUsername()" name="username" ng-model="data.User.username" placeholder="Username" class="form-control" required />
									<small ng-show="form.username.$touched && form.username.$invalid" class="text-danger">
										Required field.
									</small>
									<small ng-show="check.result" class="text-danger">
										Username unavailable.
									</small>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<input ng-model="data.User.password" name="password" type="password" placeholder="Password" class="form-control" required />
									<small ng-show="form.password.$touched && form.password.$invalid" class="text-danger">
										Required field.
									</small>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<input ng-model="data.User.confirm_password" name="confirm_password" type="password" placeholder="Confirm" class="form-control" required />
									<small ng-show="form.confirm_password.$touched && form.confirm_password.$invalid" class="text-danger">
										Required field.
									</small>
								</div>
							</div>
						</div>
						<hr/>
						<div class="row">
						<div class="col-lg-6">
							<a href="<?php echo $this->base;?>/users/login">Sign in instead</a>
						</div>
						<div class="col-lg-6 text-right">
							<button class="btn btn-success"
							ng-disabled="form.username.$invalid
							|| form.password.$invalid
							|| form.confirm_password.$invalid
							|| preventDoubleClick"
							ng-click="register()">
								Register
							</button>
						</div>
					</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<?php echo $this->Html->script('controllers/user_registration',array('inline'=>false));?>
