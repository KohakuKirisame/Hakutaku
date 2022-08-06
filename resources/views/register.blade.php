<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>注册 - 白泽答疑团</title>
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
				<h4 class="card-title my-4 text-center">注册</h4>
				<form method="post" id="regForm" action="/Action/Register">
					@csrf
					<div class="form-floating mb-3">
						<input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" placeholder="Name" value="{{old("name")}}">
						<label for="name">姓名</label>
					</div>
					<div class="form-floating mb-3">
						<input type="number" class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="phone" placeholder="Phone" value="{{old("phone")}}">
						<label for="phone">手机</label>
					</div>
					<select class="form-select mb-3" aria-label="Role" name="role" id="role" onchange="if(this.value!='2'){$('#school-div').hide();}else{$('#school-div').show();}">
						<option value="">---选择身份---</option>
						<option value="1" @if(old("role")=="1")selected @endif>学生</option>
						<option value="2" @if(old("role")=="2")selected @endif>答疑官</option>
						<option value="3" @if(old("role")=="3")selected @endif>教师</option>
					</select>
					<div class="form-floating mb-3" id="school-div">
						<input type="text" class="form-control" name="school" id="school" placeholder="School" value="{{old("school")}}">
						<label for="school">学校</label>
					</div>
					<div class="form-floating mb-3">
						<input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Password">
						<label for="password">密码</label>
					</div>
					<div class="form-floating mb-3">
						<input id="captcha" class="form-control {{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" placeholder="Captcha" required>
						<label for="captcha">验证码</label>
						<img class="thumbnail captcha mt-3 mb-2" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
					</div>
				</form>
				<div class="row justify-content-around px-2 mt-4">
					<a href="/Login" class="btn btn-outline-primary col-4">返回登录</a>
					<button onclick="$('#regForm').submit();" class="btn btn-outline-success col-4">注册</button>
				</div>
				<div class="px-2 my-4">
					@foreach($errors->all() as $error) <p class="text-center text-danger" id="warning">{{$error}}</p>@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@include("footer")
</body>
</html>