<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>我的提问 - 白泽答疑团</title>
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
	<h4 class="text-center">我的提问</h4>
</div>
<div class="container">
	<div id="questionsCards">

	</div>
</div>
@include("footer")
<script type="application/javascript">
	searchByUser();
</script>
</body>
</html>