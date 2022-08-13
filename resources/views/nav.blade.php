<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-lg">
	<div class="container-fluid">
		<a class="navbar-brand" href="/"><img src="/storage/img/Logo-light.png" height="64px"></a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="#">Dashboard</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/Helpers">答疑官</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Mentor</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarQA" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						问答
					</a>
					<ul class="dropdown-menu" aria-labelledby="navbarQA">
						<li><a class="dropdown-item" href="/Question/New">提问</a></li>
						<li><a class="dropdown-item" href="/Question">问题列表</a></li>
						<li><hr class="dropdown-divider" /></li>
						<li><a class="dropdown-item" href="#">我的问题</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">周报</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">关于</a>
				</li>
			</ul>
			<div class="d-flex">
				@if(\Illuminate\Support\Facades\Auth::guest())
				<a class="btn btn-outline-light mx-1">登录</a>
				<a class="btn btn-outline-light mx-1">注册</a>
				@else
					<div class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-white" href="#" id="user" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img class="rounded-circle mx-2" src="{{\App\Http\Controllers\UserController::getAvatar()}}" height="64px" />{{$user->name}}
						</a>
						<ul class="dropdown-menu" aria-labelledby="user">
							<li><a class="dropdown-item" href="/User">个人资料</a></li>
							<li><a class="dropdown-item" href="#">我的问题</a></li>
							<li><hr class="dropdown-divider" /></li>
							<li><a class="dropdown-item" href="/Action/Logout">退出</a></li>
						</ul>
					</div>
				@endif
			</div>
		</div>
	</div>
</nav>