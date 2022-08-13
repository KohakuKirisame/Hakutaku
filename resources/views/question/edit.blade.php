<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@if($edit)编辑@else新@endif问题 - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
</head>
<body>
@include("nav")
<div class="container my-5">
<div class="card shadow-lg px-4">
	<h4 class="my-4 text-center">@if($edit)编辑@else新@endif问题</h4>
	<form action="/Action/EditQuestion" method="post" id="questionForm">
		@csrf
		@if($edit)
			<input name="qid" value="{{$question->id}}" type="hidden" />
		@endif
		<div class="mb-4">
			<label for="title" class="form-label">标题*</label>
			<input class="form-control" id="title" name="title" type="text" placeholder="尽可能详细描述问题" @if($edit)value="{{$question->title}}" @endif />
		</div>
		<div class="mb-4">
			<label for="subject" class="form-label">科目*</label>
			<select form="questionForm" class="form-select" name="subject" id="subject">
				<option value="">---请选择---</option>
				@foreach($subjects as $subject)
					<option value="{{$subject["id"]}}" @if($edit) @if($question->subject==$subject["id"])selected @endif @endif>{{$subject["subject"]}}</option>
				@endforeach
			</select>
		</div>
		<div class="mb-4">
			<label for="content" class="form-label">内容*</label>
			<textarea form="questionForm" id="content" name="content" class="form-control" rows="5" placeholder="请尽量用文字详细描述问题，如确无法用文字描述再上传图片。详细描述不理解的地方有助于针对性地解答。">@if($edit){{$question->content}} @endif</textarea>
		</div>
		<div class="mb-4">
			<label for="image" class="form-label">附图</label>
			<input class="form-control" name="image" id="image" type="file" accept="image/jpeg,image/png,image/gif" />
			@if($edit && \Illuminate\Support\Facades\Storage::exists("public/img/question/".$question->id.".jpg"))
				<img src="{{\Illuminate\Support\Facades\Storage::url("public/img/question/".$question->id.".jpg")}}" style="max-width: 360px" />
			@endif
		</div>
		<div class="mb-4">
			<label for="captcha" class="form-label">验证码</label>
			<input id="captcha" class="form-control {{ $errors->has('captcha') ? ' is-invalid' : '' }}" name="captcha" placeholder="验证码" required>
			<img class="thumbnail captcha mt-3 mb-2" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
		</div>
	</form>
	<div class="row justify-content-around mb-5">
		<a class="btn btn-outline-primary col-3" href="/Question">返回</a>
		<button class="btn btn-success col-3" onclick="$('#questionForm').submit();">@if($edit)保存@else发送@endif</button>
	</div>
	<div class="px-2 my-4">
		@foreach($errors->all() as $error) <p class="text-center text-danger" id="warning">{{$error}}</p>@endforeach
	</div>
</div>
</div>
@include("footer")
</body>
</html>