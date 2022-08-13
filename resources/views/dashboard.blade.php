<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Dashboard - 白泽答疑团</title>
	<link rel="stylesheet" href="/css/bootstrap.min.css" />
	<script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
	<script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css" />
</head>
<body>
@include("nav")
<div class="container my-5">
	@if($user->role<0)
		<p class="text-secondary text-center">您的账户尚未激活，请联系执行团长</p>
	@elseif($user->role==0)
		<p class="text-secondary text-center">您的账户已被封禁</p>
	@endif
</div>
@include("footer")
</body>
</html>