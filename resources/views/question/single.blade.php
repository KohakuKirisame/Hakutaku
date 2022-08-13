<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{$question->title}} - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
	<script type="application/javascript" src="/js/layer.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.css" integrity="sha384-Xi8rHCmBmhbuyyhbI88391ZKP2dmfnOl4rT9ZfRI7mLTdk1wblIUnrIq35nqwEvC" crossorigin="anonymous">
	<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/katex.min.js" integrity="sha384-X/XCfMm41VSsqRNQgDerQczD69XqmjOOOwYQvr/uuC+j4OPoNhVgjdGFwhvN02Ja" crossorigin="anonymous"></script>

	<link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/icon.min.css" rel="stylesheet">
	<link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/button.min.css" rel="stylesheet">

	<link href="{{ asset('/vendor/laravelLikeComment/css/style.css') }}" rel="stylesheet">
</head>
<body>
@include("nav")
<div class="container my-5">
	<div class="row mb-4 mx-4">
		<a class="btn btn-primary col-3" href="/Question">返回</a>
	</div>
	<div class="card mb-4 shadow-lg">
		<div class="card-body">
			<p style="position: absolute;right: 16px;top: 12px;" class="text-secondary">问题ID:{{$question->id}}</p>
			<div class="row mx-2 mb-4">
				<img src="{{$questioner->avatar}}" class="rounded-circle p-0 col-3" style="width: 64px;height: 64px" />
				<div class="col-9">
					<h5>{{$questioner->name}}
						@if($questioner->role==1)
							<span class="badge bg-success">学生</span>
						@elseif($questioner->role==2)
							<span class="badge bg-primary">答疑官</span>
						@elseif($questioner->role==3)
							<span class="badge" style="background-color: #9f29b0">教师</span>
						@elseif($questioner->role<0)
							<span class="badge bg-secondary">未激活</span>
						@elseif($questioner->role==0)
							<span class="badge bg-danger">封禁</span>
						@endif
					</h5>
					<p class="text-secondary">{{$questioner->sign}}</p>
				</div>
			</div>
			<h5 class="card-title mb-4"><span class="badge bg-primary mx-1">{{$subjects[$question->subject]["subject"]}}</span>{{$question->title}}</h5>
			<p class="card-text mb-4">{{$question->content}}</p>
			<p class="text-secondary text-end mb-2">提问时间：{{$question->created_at}}@if($question->updated_at!=$question->created_at)<br />最后编辑：{{$question->updated_at}}@endif</p>
			@include("laravelLikeComment::like",['like_item_id'=>"question_".$question->id])
			@if($question->user==$user->id)<a class="btn btn-primary my-4" href="/Question/{{$question->id}}/Edit">编辑问题</a>@endif
		</div>
		@if(\Illuminate\Support\Facades\Storage::exists("public/img/question/".$question->id.".jpg"))
			<img src="{{\Illuminate\Support\Facades\Storage::url("public/img/question/".$question->id.".jpg")}}" class="rounded card-img-bottom imgView" style="max-height: 160px;object-fit: cover" />
		@endif
	</div>
	<a class="btn btn-primary w-100 mb-4" href="/Question/{{$question->id}}/Answer/New">@if(\App\Models\Answer::where(["question"=>$question->id,"user"=>$user->id])->exists())我的回答@else写回答@endif</a>
	@foreach($answers as $answer)
		<div class="card mb-4 shadow-lg">
			<div class="card-body">
				<p style="position: absolute;right: 16px;top: 12px;" class="text-secondary">回答ID:{{$answer->id}}</p>
				<div class="row mx-2">
					<img src="{{$answer->avatar}}" class="rounded-circle p-0 col-3" style="width: 64px;height: 64px" @if($answer->role==2)onclick="window.location='/Mentor/{{$answer->user}}';"@endif />
					<div class="col-9">
						<h5>{{$answer->name}}
							@if($answer->role==1)
								<span class="badge bg-success">学生</span>
							@elseif($answer->role==2)
								<span class="badge bg-primary">答疑官</span>
							@elseif($answer->role==3)
								<span class="badge" style="background-color: #9f29b0">教师</span>
							@elseif($answer->role<0)
								<span class="badge bg-secondary">未激活</span>
							@elseif($answer->role==0)
								<span class="badge bg-danger">封禁</span>
							@endif
						</h5>
						<p class="text-secondary">{{$answer->sign}}</p>
					</div>
				</div>
				<hr class="mt-1 mb-4" />
				<div class="mx-4 mb-4">
					@parsedown($answer->content)
				</div>
				<p class="text-secondary">回答于：{{$answer->created_at}}@if($answer->updated_at!=$answer->created_at)<br />最后编辑于：{{$answer->updated_at}}@endif</p>
				@if($answer->user==$user->id)<a class="btn mb-4 btn-primary" href="/Question/{{$question->id}}/Answer/{{$answer->id}}/Edit">编辑</a> @endif
				@include("laravelLikeComment::like",['like_item_id'=>"answer_".$answer->id])
			</div>
		</div>
	@endforeach

{{$answers->links()}}

</div>
@include("footer")
<script>
	$("body").on("click", ".imgView", function (e) {
		layer.photos({photos: {"data": [{"src": e.target.src}]}});
	});
</script>
<script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.0/dist/contrib/auto-render.min.js" integrity="sha384-+XBljXPPiv+OzfbB3cVmLHf4hdUFHlWNZN5spNQ7rmHTXpd7WvJum6fIACpNNfIR" crossorigin="anonymous"
        onload="renderMathInElement(document.body);"></script>
<script src="{{ asset('/vendor/laravelLikeComment/js/script.js') }}" type="text/javascript"></script>
</body>
</html>