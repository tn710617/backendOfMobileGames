<form class="form-signin col-12"  action="/register" method="POST">
@csrf()
<img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
<h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
<label for="inputEmail" class="sr-only">Email address</label>
<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
<label for="inputPassword" class="sr-only">Password</label>
<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

<label for="inputPassword" class="sr-only">Password Confirmation</label>
<input type="password" name="password_confirmation" id="inputPassword" class="form-control" placeholder="Password Confirmation" required>
<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
<p class="mt-5 mb-3 text-muted">&copy; 2018</p>
</form>
