<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>用户 - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
</head>
<body>
@include("nav")
<div class="container my-5">
	<div class="card shadow-lg mb-4">
		<div class="card-body">
			<a data-bs-toggle="modal" data-bs-target="#changeAvatar">
				<img src="{{\App\Http\Controllers\UserController::getAvatar()}}" class="m-2 rounded-circle" height="96px" />
			</a>
			<h4 class="d-inline">{{$user->name}}</h4>
			<p class="d-inline ml-2">
				@if($user->role==1)
				<span class="badge bg-success">学生</span>
				@elseif($user->role==2)
					<span class="badge bg-primary">答疑官</span>
				@elseif($user->role==3)
					<span class="badge" style="background-color: #9f29b0">教师</span>
				@elseif($user->role<0)
					<span class="badge bg-secondary">未激活</span>
				@elseif($user->role==0)
					<span class="badge bg-danger">封禁</span>
				@endif
			</p>
			<hr class="mb-3" />
			<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="pills-info1-tab" data-bs-toggle="pill" data-bs-target="#pills-info1" type="button" role="tab" aria-controls="pills-info1" aria-selected="true">基础资料</button>
				</li>
				@if($user->role==2)
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-info2-tab" data-bs-toggle="pill" data-bs-target="#pills-info2" type="button" role="tab" aria-controls="pills-info2" aria-selected="false">答疑信息</button>
				</li>
				@elseif($user->role==3)
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-info3-tab" data-bs-toggle="pill" data-bs-target="#pills-info3" type="button" role="tab" aria-controls="pills-info3" aria-selected="false">教师信息</button>
				</li>
				@endif
				@if($user->role>=2)
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-pic-tab" data-bs-toggle="pill" data-bs-target="#pills-pic" type="button" role="tab" aria-controls="pills-pic" aria-selected="false">印象图</button>
				</li>
				@endif
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="pills-pass-tab" data-bs-toggle="pill" data-bs-target="#pills-pass" type="button" role="tab" aria-controls="pills-pass" aria-selected="false">修改密码</button>
				</li>
			</ul>
		</div>
	</div>
	<div class="card shadow-lg mb-4">
		<div class="card-body">
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-info1" role="tabpanel" aria-labelledby="pills-info1-tab">
					<form action="/Action/UpdateInfo" method="post" id="info1Form">
						@csrf
						<div class="row my-4 justify-content-center">
							<div class="mb-3 col-12 col-md-9">
								<label for="name" class="form-label">姓名</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="{{$user->name}}" readonly>
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="phone" class="form-label">手机</label>
								<input type="number" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{$user->phone}}" readonly>
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="sex" class="form-label">性别</label>
								<select class="form-select" name="sex" id="sex">
									<option value="">---请选择---</option>
									<option value="1" @if($user->sex==1)selected @endif>男</option>
									<option value="2" @if($user->sex==2)selected @endif>女</option>
								</select>
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="school" class="form-label">学校</label>
								<input type="text" class="form-control" name="school" id="school" placeholder="School" value="{{$user->school}}" @if($user->role!=2)readonly @endif>
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="email" class="form-label">邮箱</label>
								<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{$user->email}}">
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="grade" class="form-label">年级</label>
								<input type="text" class="form-control" name="grade" id="grade" placeholder="Grade" value="{{$user->grade}}">
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="sign" class="form-label">个人签名</label>
								<input type="text" class="form-control" name="sign" id="sign" placeholder="Grade" value="{{$user->sign}}">
							</div>
						</div>
					</form>
					<div class="px-2 my-4">
						@foreach($errors->all() as $error) <p class="text-center text-danger" id="warning">{{$error}}</p>@endforeach
					</div>
					<div class="row justify-content-center mb-4">
						<button class="btn btn-outline-success col-4 col-md-3" onclick="$('#info1Form').submit();">保存</button>
					</div>
				</div>
				@if($user->role==2)
				<div class="tab-pane fade" id="pills-info2" role="tabpanel" aria-labelledby="pills-info2-tab">
					<form action="/Action/UpdateMentor" method="post" id="mentorForm">
						@csrf
						<div class="row my-4 justify-content-center">
							<div class="mb-3 col-12 col-md-9">
								@foreach($subjects as $subject)
									<div class="form-check form-check-inline">
										<input class="form-check-input" type="checkbox" name="s{{$subject["id"]}}" id="s{{$subject["id"]}}" @if(in_array($subject["id"],$i->subjects))checked @endif>
										<label class="form-check-label" for="s{{$subject["id"]}}">{{$subject["subject"]}}</label>
									</div>
								@endforeach
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="wechat" class="form-label">微信</label>
								<input type="text" class="form-control" name="wechat" id="wechat" placeholder="微信号" value="{{$i->wechat}}">
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="qq" class="form-label">QQ</label>
								<input type="text" class="form-control" name="qq" id="qq" placeholder="QQ号" value="{{$i->qq}}">
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="major" class="form-label">专业</label>
								<input type="text" class="form-control" name="major" id="major" placeholder="就读专业" value="{{$i->major}}">
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="introduction" class="form-label">个人介绍</label>
								<textarea form="mentorForm" class="form-control" name="introduction" id="introduction" placeholder="如职业方向，爱好特长，擅长领域，其它职务等……" rows="6">{{htmlspecialchars_decode($i->introduction)}}</textarea>
							</div>
						</div>
					</form>
					<div class="row justify-content-center mb-4">
						<button class="btn btn-outline-success col-4 col-md-3" onclick="$('#introduction').val(htmlCharacters($('#introduction').val()));$('#mentorForm').submit();">保存</button>
					</div>
				</div>
				@elseif($user->role==3)
				<div class="tab-pane fade" id="pills-info3" role="tabpanel" aria-labelledby="pills-info3-tab">
					3
				</div>
				@endif
				@if($user->role>=2)
				<div class="tab-pane fade" id="pills-pic" role="tabpanel" aria-labelledby="pills-pic-tab">
					<div class="row g-2">
						<img class="col-12 col-md-6 mb-4" src="{{\App\Http\Controllers\UserController::getImage()}}" />
						<div class="col-12 col-md-6">
							<form action="/Action/UpdatePicture" method="post" enctype="multipart/form-data" id="picForm">
								@csrf
								<label for="pic" class="form-label">上传新印象图</label>
								<input class="form-control form-control-lg mb-4" id="pic" type="file" name="pic" accept="image/png,image/jpeg,image/gif">
							</form>
							<div class="row justify-content-center mb-4">
								<button class="btn btn-outline-success col-4 col-md-3" onclick="$('#picForm').submit();">保存</button>
							</div>
						</div>
					</div>

				</div>
				@endif
				<div class="tab-pane fade" id="pills-pass" role="tabpanel" aria-labelledby="pills-pass-tab">
					<form action="/Action/UpdatePassword" method="post" id="passForm">
						@csrf
						<div class="row my-4 justify-content-center">
							<div class="mb-3 col-12 col-md-9">
								<label for="curPass" class="form-label">当前密码</label>
								<input type="password" class="form-control" name="curPass" id="curPass" placeholder="当前密码">
							</div>
							<div class="mb-3 col-12 col-md-9">
								<label for="newPass" class="form-label">新密码</label>
								<input type="password" class="form-control" name="newPass" id="newPass" placeholder="新密码">
							</div>
						</div>
					</form>
					<div class="px-2 my-4">
						@foreach($errors->all() as $error) <p class="text-center text-danger" id="warning">{{$error}}</p>@endforeach
					</div>
					<div class="row justify-content-center mb-4">
						<button class="btn btn-outline-success col-4 col-md-3" onclick="$('#passForm').submit();">保存</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="changeAvatar" tabindex="-1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">更换头像</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div>
					<form action="/Action/UpdateAvatar" method="post" enctype="multipart/form-data" id="avaForm">
						@csrf
					<label for="ava" class="form-label">上传新头像</label>
					<input class="form-control form-control-lg" id="ava" type="file" name="ava" accept="image/png,image/jpeg,image/gif">
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary" onclick="$('#avaForm').submit();">保存</button>
			</div>
		</div>
	</div>
</div>
@include("footer")
<script type="application/javascript">
	function htmlCharacters(s){
		s = s.replace(/&/g, "&amp;");
		s = s.replace(/</g, "&lt;");
		s = s.replace(/>/g, "&gt;");
		s = s.replace(/\'/g, "&#39;");
		s = s.replace(/\"/g, "&quot;");
		return s;
	}
</script>
</body>
</html>