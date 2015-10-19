<?php

  require app('path').'/views/theme.php';

  $metadata->page_title = '例2:TODOリスト';
  $metadata->page_description = 'Laravelさんぷる';

?>
@extends('layouts.default')

@section('inline-style')
  @parent
    .todos-list form {
      display: inline-block;
    }
    #todos-incomplete th.title,
    #todos-complete th.title {
      padding-left:48px;
    }
@stop

@section('inline-script')
  @parent
  $('.todos-list .edit').addClass('hidden')

	$('.todos-list .browse button[name="edit"]').on('click', function () {
		var id = $(this).data('id')

		var browseBlock = $('#' + id + ' .browse')
		var editBlock = $('#' + id + ' .edit')

		browseBlock.addClass('hidden')
		editBlock.removeClass('hidden')
	})

	$('.todos-list .edit button[name="update"]').on('click', function () {
		var id = $(this).data('id')
		var updateUrl = $(this).data('url')

		var browseBlock = $('#' + id + ' .browse')
		var editBlock = $('#' + id + ' .edit')

		var title = $('input[name="title"]', editBlock).val()

		if (title.trim() == '') {
			browseBlock.removeClass('hidden')
			editBlock.addClass('hidden')
			return;
		}

		$.ajax({
			type: 'PUT',
			url: updateUrl,
			data: {
				title: title,
				_token: '{{ Session::token() }}',
			},
			success: function () {
				$('[name="title"]', browseBlock).text(title)
				browseBlock.removeClass('hidden')
				editBlock.addClass('hidden')
			},
			error: function (XMLHttpRequest, textStatus, errorThrown) {
				if (XMLHttpRequest.status == 400) {
					response = JSON.parse(XMLHttpRequest.responseText)
					for (var field in response.errors) {
						alert(response.errors[field])
					}
				}
				else {
					alert('タイトル更新時にエラーが発生しました。')
				}
			},
		})
	})
@stop

@section('content')
<header class="jumbotron">
	<div class="container">
		<h1>{{ $metadata->page_title }}</h1>
		<p>{{ $metadata->page_description }}</p>

		<p><a href="{{ $metadata->page_url }}">{{ $metadata->page_url }}</a></p>
	</div>
</header>

<main class="container">
	{{-- 新規TODO入力欄 --}}
@include ('partials.todos.00_input_section')

	<hr>

	{{-- 未完了TODOリスト --}}
@include ('partials.todos.01_incomplete_section')

	{{-- 完了TODOリスト --}}
@include ('partials.todos.02_complete_section')

	{{-- 削除済みTODOリスト --}}
@include ('partials.todos.03_trashed_section')

</main>
@stop
