<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>主页 - 白泽答疑团</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <script type="application/javascript" src="/js/jquery-3.6.0.min.js"></script>
    <script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="/css/home.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@latest/font/bootstrap-icons.css">
</head>
<body>
<div class="container-fluid" id="mainContainer">
	<div id="bgCover"></div>
	<img src="/storage/img/background/84479094_p0.jpg" class="bg-0" />
	<div class="row justify-content-center" id="logo">
		<img src="/storage/img/Logo-light.png" class="col-9 col-md-6 col-lg-4 col-xl-3 mb-2" id="logoImg" />
		<div class="w-100 d-none d-md-block"></div>
		<a class="btn btn-lg btn-outline-primary col-4" href="/Login">现在加入</a>
	</div>
	<div class="row justify-content-center" id="pullUp">
		<p class="text-center col-3" onclick="window.location.href='#Content';"><i class="bi bi-arrow-bar-up"></i></p>
	</div>
</div>
<div class="container-fluid shadow-lg py-5 bg-body" id="Content">
	<div class="container">
		<h1 class="text-center my-4">白泽答疑团</h1>
		<p class="my-4">北京市第一六一中学白泽答疑团旨在帮助高中生更好地准备高考，提升高中生学习体验并帮助教师减轻答疑压力。同时白泽答疑团也希望帮助高中生进行生涯规划，增进对大学和专业的了解，使高中阶段的学习方向更加明确。白泽答疑团还将不定期举办科研经历分享、学术讲座等活动，丰富高中生的学习内容。</p>
		<p class="my-4">白泽答疑团是有北京市第一六一中学各届优秀毕业生自发组织的学术组织，与学校保持紧密合作但不存在隶属关系，其运营亦保持独立。</p>
	</div>
</div>
<div class="container-fluid p-0" id="bg-1">
	<div class="bgCover-1"></div>
</div>
<div class="container-fluid shadow-lg py-5 bg-body">
	<div class="container">
		<h1 class="text-center my-4">答疑团成员</h1>
		<p class="my-4">白泽答疑团成员均为非常优秀的毕业生，其至少满足下列三个要求之一：</p>
		<ul>
			<li>高考分数21/22届分别达到622/628（市5000名内）；</li>
			<li>任意一科单科分数：语数英达到135分以上，等级考科目达到A5等级以上（88+）（可担任相关科目答疑）；</li>
			<li>就读于世界一流大学建设高校A类.</li>
		</ul>
	</div>
</div>
<div class="container-fluid p-0" id="bg-2">
	<div class="bgCover-1"></div>
</div>
<div class="container-fluid shadow-lg py-5 bg-body">
	<div class="container">
		<h1 class="text-center my-4">学生要求</h1>
		<p class="my-4">答疑团坚持“宁缺毋滥”的理念，对希望参与答疑团的学生采取审核制，学生应满足下述要求：</p>
		<ul>
			<li>遵守《北京市中小学生日常行为规范》；</li>
			<li>学习意愿强，学习态度端正；</li>
			<li>尊重科学，尊重事实，能妥善控制自己的情绪和言论；</li>
			<li>有自我管理能力，不沉迷娱乐活动。</li>
		</ul>
	</div>
</div>
<div class="container-fluid p-0" id="bg-3">
	<div class="bgCover-1"></div>
</div>
<div class="container-fluid shadow-lg py-5 bg-body">
	<div class="container">
		<h1 class="text-center my-4">答疑团负责人（临时）</h1>
		<ul class="mb-4">
			<li>荣誉团长：李伯森（北京大学）</li>
		</ul>
		<ul>
			<li>执行团长：曹峰（北京航空航天大学）
				<ul>
					<li>微信: KohakuV</li>
					<li>QQ: 1848790911</li>
				</ul>
			</li>
			<li>执行团长：张锴睿（北京航空航天大学）
				<ul>
					<li>微信: zkr20030621</li>
					<li>QQ: 2843004375</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
<button onclick="playAudio();" class="d-none" id="play"></button>
<script type="application/javascript">

		var isPlaying=false;
		// 播放
		async function playAudio() {
			if(isPlaying==false){
				window.AudioContext = window.AudioContext || window.webkitAudioContext || window.mozAudioContext || window.msAudioContext;
				ctx = new window.AudioContext();
				source = ctx.createBufferSource(); // 创建音频源头姐点
				const audioBuffer = await loadAudio();
				isPlaying=true;
				playSound(audioBuffer);
			}

	}
		// 暂停
		async function resumeAudio() {
		if (ctx.state === "running") {
		ctx.suspend();
	} else if (ctx.state === "suspended") {
		ctx.resume();
	}
	}
		// 停止
		async function stopAudio() {
		source.stop();
	}
		async function loadAudio() {
		const audioUrl = "https://upload.thwiki.cc/5/55/th08_07_SC88Pro.mp3";
		const res = await fetch(audioUrl);
		const arrayBuffer = await res.arrayBuffer(); // byte array字节数组
		const audioBuffer = await ctx.decodeAudioData(arrayBuffer, function(
		decodeData
		) {
		return decodeData;
	});
		return audioBuffer;
	}
		async function playSound(audioBuffer) {
		source.buffer = audioBuffer; // 设置数据
		source.loop = true; //设置，循环播放
		source.connect(ctx.destination); // 头尾相连
		// 可以对音频做任何控制
		source.start(0); //立即播放
	}
		$("#mainContainer").mousedown(playAudio);
		$("#mainContainer").on("touchstart",playAudio);
</script>
</body>
</html>