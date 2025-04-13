<div class="page-header">
	<div class="row align-items-center">
		<div class="col">
			<h3 class="page-title">Profile</h3>
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?=base_url()?>">Dashboard</a> </li>
				<li class="breadcrumb-item active">Profile</li>
			</ul>
		</div>
	</div>
</div>

<div class="col-md-7 mb-3">
	<div class="card filter-card">
		<div class="card-body pb-0">
			<div class="row">
				<h5>Update Profile</h5>
				<form id="updateProfile">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Firstname</label>
								<input value="<?=$user->firstname?>" type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" required>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Middlename</label>
								<input value="<?=$user->middlename?>" type="text" class="form-control" id="middlename" name="middlename" placeholder="Middlename">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Lastname</label>
								<input value="<?=$user->lastname?>" type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Username</label>
								<input value="<?=$user->username?>" type="text" class="form-control" id="username" name="username" placeholder="Username" required>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Email</label>
								<input value="<?=$user->email?>" type="email" class="form-control" id="email" name="email" placeholder="Email Address">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
								<label>Phone</label>
								<input value="<?=$user->phone?>" type="number" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="form-group">
								<button class="btn btn-primary" id="add_btn" type="submit"> Save Changes </button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="col-md-7 mb-4">
	<div class="card filter-card">
		<div class="card-body pb-0">
			<div class="row">
				<h5>Update Password</h5>
				<form id="passwordForm">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Current Password</label>
								<input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password" required>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label>New Password</label>
								<input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label>Confirm New Password</label>
								<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" required>
							</div>
						</div>
						
						<div class="col-sm-12">
							<div class="form-group">
								<button class="btn btn-primary" id="pass_btn" type="submit"> Change Password </button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>