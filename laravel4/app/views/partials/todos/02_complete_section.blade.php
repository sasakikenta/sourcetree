{{-- 完了TODOリスト --}}
	<div id="todos-complete" class="todos-list row">
		<div class="col-sm-12 col-md-12">
			<h2>やったこと <span class="badge">{{ count($completeTodos) }}</span></h2>

			<table class="table table-striped">
				<thead>
					<tr>
						<th class="title col-sm-12 col-md-8">タイトル</th>
						<th class="completed_at col-sm-12 col-md-2">完了日</th>
						<th class="col-sm-12 col-md-2">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
@if (count($completeTodos) > 0)
	@foreach ($completeTodos as $todo)
					<tr>
						<td id="todo-{{ $todo->id }}">
							{{ Form::open(['url' => route('todos.update', $todo->id)]) }}
								<input type="hidden" name="title" value="{{{ $todo->title }}}">
								<input type="hidden" name="status" value="{{ Todo::STATUS_INCOMPLETE }}">
								<button class="btn btn-link"><i class="glyphicon glyphicon-check"></i></button>
								{{{ $todo->title }}}
							{{ Form::close() }}
						</td>
						<td>
							{{ $todo->completed_at }}
						</td>
						<td class="btn-group">
							{{ Form::open(['url' => route('todos.delete', $todo->id)]) }}
								<button class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i></button>
							{{ Form::close() }}
						</td>
					</tr>
	@endforeach
@else
					<tr>
						<td colspan="3">まだありません。</td>
					</tr>
@endif
				</tbody>
			</table>
		</div>
	</div>
