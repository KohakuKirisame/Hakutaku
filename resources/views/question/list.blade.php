<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>问答 - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<script type="application/javascript" src="/js/search.js"></script>
	<link rel="stylesheet" href="/css/question.css" />
</head>
<body>
@include("nav")
<div class="container my-5">
	<div class="card shadow-lg mb-4">
		<div class="card-body">
			<div class="row gx-4 mt-4 mb-2">
				<div class="col-8">
					<label for="searchString" class="form-label">搜索</label>
					<input class="form-control" type="text" id="searchString" placeholder="输入标题/内容搜索" />
				</div>
				<div class="mb-4 col-4">
					<label for="searchSubject" class="form-label">科目</label>
					<select class="form-select" id="searchSubject">
						<option value="">全部科目</option>
						@foreach($subjects as $subject)
							<option value="{{$subject["id"]}}">{{$subject["subject"]}}</option>
					    @endforeach
					</select>
				</div>
			</div>
			<button class="btn btn-primary float-end mb-4 me-4" onclick="searchBySS();">搜索</button>
		</div>
	</div>
	<a class="btn btn-primary w-100 shadow" href="/Question/New">新问题</a>
</div>
<div class="container">
	<div id="questionsCards">

	</div>
</div>
@include("footer")
<script type="application/javascript">
	searchAll();
</script>
</body>
</html>