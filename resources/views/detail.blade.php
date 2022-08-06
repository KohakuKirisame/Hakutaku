<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{$mentor->name}} - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
	<link rel="stylesheet" href="/css/detail.css" />
</head>
<body>
@include("nav")
<div class="container my-5">
	<div class="card text-white mb-4" onmouseover="addNb();" onmouseout="delNb();">
		<img src="{{$mentor->image}}" class="card-img bg-img" id="bg-img" />
		<div class="card-img-overlay">
			<div class="row justify-content-center">
				<img src="{{$mentor->avatar}}" class="rounded-circle avatar p-0 d-shadow my-3">
				<div class="w-100 m-0"></div>
				<h4 class="card-title col d-shadow mb-3 text-center">{{$mentor->name}}</h4>
				<div class="w-100 m-0"></div>
				<h6 class="card-title col d-shadow text-center mb-3">@if($mentor->sex==1)<i class="bi bi-gender-male"></i>@else<i class="bi bi-gender-female"></i>@endif {{$mentor->school}}</h6>
				<div class="w-100 m-0"></div>
				<h6 class="card-title col d-shadow text-center">{{$mentor->major}}</h6>
			</div>
		</div>
	</div>
	@if($mentor->subjects!=["None"])
	<h4 class="mt-4">答疑科目</h4>
	<hr class="my-1" />
	<ul>
		@foreach($mentor->subjects as $sub)
			<li class="d-inline">{{$subjects[$sub]["subject"]}}</li>
		@endforeach
	</ul>
	@endif
	<h4 class="mt-4">联系方式</h4>
	<hr class="my-1" />
	<ul>
		<li>微信：{{$mentor->wechat}}</li>
		<li>QQ：{{$mentor->qq}}</li>
	</ul>
	<h4 class="mt-4">个人介绍</h4>
	<hr class="my-1" />
	<p>{!!str_replace("\n","</p><p>",htmlspecialchars_decode($mentor->introduction))!!}</p>
</div>
@include("footer")
<script type="application/javascript">
	function addNb(){
		$("#bg-img").addClass("Nb");
	}
	function delNb(){
		$("#bg-img").removeClass("Nb");
	}
</script>
</body>
</html>