<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link rel="stylesheet" href="./assets/style/style.css">
    <title>Regester Page</title>
  </head>
  <body>
    <section class="login-section d-flex flex-column justify-content-center">
		<div class="container">
			<div class="row justify-content-center">
			  <div class="col-md-6 col-lg-4"> 
				<div class="card my-5">
				  <div class="login-card">
					<h3 class="card-title text-center">Login</h3>
					<form>
					  <div class="mb-3">
						<label for="email" class="form-label ">Name</label>
						<input type="email" class="form-control" id="email" placeholder="Enter your name">
					  </div>
					  <div class="mb-3">
					 	<label for="email" class="form-label ">Email address</label>
						<input type="email" class="form-control" id="email" placeholder="Enter email">
					  </div>
					  <div class="mb-3">
						<div class="d-flex justify-content-between">
							<label for="password" class="form-label">Password</label>
						</div>
						<input type="password" class="form-control" id="password" placeholder="Password">
					  </div>
					  <div class="mb-3 form-check">
						<input type="checkbox" class="form-check-input" id="rememberMe">
						<label class="form-check-label" for="rememberMe">Remember me</label>
					  </div>
					  <button type="submit" class="btn w-100">Login</button>
					</form>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
	</section>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    
  </body>
</html>