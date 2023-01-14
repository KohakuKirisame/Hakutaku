function searchAll(){
	var csrf=$('meta[name="csrf-token"]').attr('content');
	$.post("/Action/SearchQuestion",{
		_token:csrf,
	},function (data,status) {
		$("#questionsCards").html(data);
	});
}

function searchBySS(){
	var csrf=$('meta[name="csrf-token"]').attr('content');
	var content=$("#searchString").val();
	var subject=$("#searchSubject").val();
	$.post("/Action/SearchQuestion",{
		_token:csrf,
		type:'string',
		content:content,
		subject:subject
	},function (data,status) {
		$("#questionsCards").html(data);
	});
}

function searchByUser(){
	var csrf=$('meta[name="csrf-token"]').attr('content');
	$.post("/Action/SearchQuestion",{
		_token:csrf,
		type:'user',
	},function (data,status) {
		$("#questionsCards").html(data);
	});
}