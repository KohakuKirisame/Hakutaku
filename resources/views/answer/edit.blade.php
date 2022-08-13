<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@if(isset($content))编辑@else添加@endif回答 - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
	<script type="application/javascript" src="/js/layer.js"></script>
	{!! editor_css() !!}
</head>
<body>
@include("nav")
<div class="container my-5">
	<div class="card mb-4 shadow-lg">
		<div class="card-body">
			<p style="position: absolute;right: 16px;top: 12px;" class="text-secondary">问题ID:{{$question->id}}</p>
			<div class="row mx-2 mb-4">
				<img src="{{$questioner->avatar}}" class="rounded-circle p-0 col-3" style="width: 64px;height: 64px" />
				<div class="col-9">
					<h5>{{$questioner->name}}</h5>
					<p class="text-secondary">{{$questioner->sign}}</p>
				</div>
			</div>
			<h5 class="card-title mb-4"><span class="badge bg-primary mx-1">{{$subjects[$question->subject]["subject"]}}</span>{{$question->title}}</h5>
			<p class="card-text mb-4">{{$question->content}}</p>
			<p class="text-secondary text-end mb-2">提问时间：{{$question->created_at}}@if($question->updated_at!=$question->created_at)<br />最后编辑：{{$question->updated_at}}@endif</p>
		</div>
		@if(\Illuminate\Support\Facades\Storage::exists("public/img/answer/".$question->id.".jpg"))
			<img src="{{\Illuminate\Support\Facades\Storage::url("public/img/answer/".$question->id.".jpg")}}" class="rounded card-img-bottom imgView" style="max-height: 160px;object-fit: cover" />
		@endif
	</div>
	<form id="answerForm" method="post" action="/Action/SaveAnswer/{{$question->id}}">@csrf</form>
	<div id="editormd_id">
		<textarea class="d-none" name="answer" form="answerForm">@if(isset($content)){!! $content !!}@endif</textarea>
	</div>
	<div class="my-4 row justify-content-between">
		<a class="btn btn-outline-primary col-3" href="/Question/{{$question->id}}">返回</a>
		<button class="btn btn-success col-3" onclick="$('#answerForm').submit();" >保存</button>
	</div>
</div>
@include("footer")
{!! editor_js() !!}
<script>
	$("body").on("click", ".imgView", function (e) {
		layer.photos({photos: {"data": [{"src": e.target.src}]}});
	});
</script>
</body>
</html>