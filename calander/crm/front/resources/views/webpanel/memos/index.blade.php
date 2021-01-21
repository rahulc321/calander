@extends('webpanel.layouts.base')
@section('title')
    Memos
    @parent
@stop
@section('body')

    <div class="page-header">
        <div class="page-title">
            <h3>Memo</h3>
        </div>
    </div>

    @include('webpanel.includes.notifications')

    <div class="content">

        <div class="panel panel-default">
            <div class="panel-heading"><h6 class="panel-title"><i class="icon-pencil"></i> Memo: Last Updated At {{ $memo->updated_at }}</h6></div>
            <div class="panel-body">
                <form method="post" action="{{ sysUrl('memo') }}">
                    <div class="block-inner">
                        <textarea class="editor" name="memo" style="height:400px;">{{ $memo->memo }}</textarea>
                    </div>
                    <div class="form-actions text-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@stop