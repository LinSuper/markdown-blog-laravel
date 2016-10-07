@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{URL::current()}}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">标题</label>

                                <div class="col-md-6">
                                    @if($article)
                                        <input id="title" type="text" class="form-control" name="title" value="{{$article->title}}">
                                    @else
                                        <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">
                                    @endif
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                                <label for="content" class="col-md-4 control-label">正文</label>

                                <div class="col-md-6">
                                    @if($article)
                                        <textarea id="content" type="text" class="form-control" name="content" value="">{{$article->content}}</textarea>
                                    @else
                                    <textarea id="content" type="text" class="form-control" name="content" value="{{ old('content') }}"></textarea>
                                    @endif
                                    @if ($errors->has('content'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn glyphicon glyphicon-plus"></i>
                                        @if($article)
                                            修改
                                        @else
                                            发布
                                        @endif
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection