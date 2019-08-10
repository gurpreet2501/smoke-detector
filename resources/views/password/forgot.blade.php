<?php $data=[
        'page_title' => "Forgot Password",
    ] ; ?>
@include('partials.header',$data);
<body>
<div class="container">
	<div class="row">
		<div class="col-md-4"></div>	
		<div class="col-md-4">   
			<h3 class="text-center">Forgot Password</h3>
			<form action="{{ action('ForgotPasswordController@send_reset_email') }}" accept-charset="UTF-8" method="POST">
				<div class="form-group">
					<label>Enter email</label>
					<input type="text" name="email" class="form-control" />
				</div>
					<input type="submit" class="btn btn-danger" value="Send Reset Email" />
			</form>
		</div>	
		<div class="col-md-4"></div>	
	</div>
</div>
</body>
</html>