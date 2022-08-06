function login(){
	var phone=$("#phone").val();
	var password=$("#password").val();
	var remember=$("#remember").is(":checked");
	var _token=$("[name='_token']").val();
	if(phone!=""&&password!=""){
	$.post("/Action/Login",{
		_token:_token,
		phone:phone,
		password:password,
		remember:remember
	},function(data) {
		if (data=="Success"){
			$("#warning").html("登录成功");
			window.location="/Dashboard";
		}else{
			$("#warning").html("密码和手机号不匹配");
		}
	});
	}else{
		$("#warning").html("不可为空");
	}
}

function sub(e){
	var evt = window.event || e;
	if (evt.keyCode == 13){
		login();
	}
}