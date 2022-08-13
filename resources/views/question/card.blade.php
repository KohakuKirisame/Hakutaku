@foreach($questions as $question)
	<div class="card mb-3 shadow-lg question-card" onclick="window.location='/Question/{{$question->id}}';">
		<div class="card-body">
			<p style="position: absolute;right: 16px;top: 12px;" class="text-secondary">问题ID:{{$question->id}}</p>
			<h5 class="card-title mb-4 mt-3"><span class="badge bg-primary mx-1">{{$subjects[$question->subject]["subject"]}}</span>{{$question->title}}</h5>
			<p class="card-text mb-4">{{$question->content}}</p>
			<p class="mb-3 d-inline">回答：{{$question->ansNum}}</p>
			<p class="text-secondary float-end mb-3 d-inline">提问时间：{{$question->created_at}}@if($question->updated_at!=$question->created_at)<br />最后编辑：{{$question->updated_at}}@endif</p>
		</div>
	</div>
@endforeach
{{$questions->links()}}