<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>答疑官 - 白泽答疑团</title>
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
			<div class="my-4 mx-3">
				<input class="form-control" type="text" placeholder="输入姓名/学科/学校查询" id="search" onchange="search();" />
			</div>
		</div>
	</div>
	<div class="row g-2 g-lg-4" id="helpers">
		@foreach($mentors as $mentor)
			<div class="col-6 col-md-6 col-lg-4 col-xl-3" data-n="{{$mentor->name}}" data-s="{{$mentor->school}}" data-sub="@foreach($mentor->subjects as $sub){{$subjects[$sub]["subject"]}}  @endforeach">
				<div class="card shadow-lg">
					<div class="card-img-top ratio-1x1 ratio" style="background: url('{{$mentor->image}}') no-repeat center/cover "></div>
					<div class="card-body">
						<h5 class="card-title">{{$mentor->name}}</h5>
						<h6 class="card-subtitle text-secondary">{{$mentor->school}}</h6>
						<ul class="card-text mt-2">
							<li>答疑科目：@foreach($mentor->subjects as $sub){{$subjects[$sub]["subject"]}}  @endforeach</li>
							<li>微信：{{$mentor->wechat}}</li>
							<li>QQ：{{$mentor->qq}}</li>
						</ul>
						<a href="/Mentor/{{$mentor->id}}" class="btn btn-primary">详情</a>
					</div>
				</div>
			</div>

		@endforeach
	</div>
</div>
<script type="application/javascript">
	function search(){
		var search=$("#search").val();
		$("[data-n][data-s][data-sub]").each(function (index,element){element.style.display="none"});
		if(search!=""){
			$("[data-n*='"+search+"'],[data-s*='"+search+"'],[data-sub*='"+search+"']").each(function (index,element){element.style.display="block"});
		}else{
			$("[data-n][data-s][data-sub]").each(function (index,element){element.style.display="block"});
		}
	}
</script>
@include("footer")
</body>
</html>