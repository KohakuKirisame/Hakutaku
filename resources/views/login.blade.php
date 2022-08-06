<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>登录 - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
	<link rel="stylesheet" href="/css/login.css" />
	<script type="application/javascript" src="/js/login.js"></script>
</head>
<body>
<div id="bgCover"></div>
@include("nav")
<div class="container my-5" id="mainContainer">
	<div class="row justify-content-center">
		<div class="card shadow-lg col-12 col-md-9 col-lg-6 opacity-75">
			<div class="card-body">
				<h4 class="card-title my-4 text-center">登录</h4>
				<form method="post" id="loginForm">
					@csrf
					<div class="form-floating mb-3">
						<input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" onkeydown="sub(event);">
						<label for="phone">手机</label>
					</div>
					<div class="form-floating mb-3">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" onkeydown="sub(event);">
						<label for="password">密码</label>
					</div>
					<div class="mb-3 form-check">
						<input type="checkbox" class="form-check-input" id="remember" name="remember">
						<label class="form-check-label" for="remember">记住我</label>
					</div>
				</form>
				<div class="row justify-content-around px-2 mt-4">
					<a href="/Register" class="btn btn-outline-success col-4">注册</a>
					<button onclick="login();" class="btn btn-outline-primary col-4">登录</button>
				</div>
				<div class="px-2 my-4">
					<p class="text-center text-danger" id="warning"></p>
				</div>
			</div>
		</div>
	</div>
</div>
@include("footer")
</body>
</html>