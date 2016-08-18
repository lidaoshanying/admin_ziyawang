@extends('layouts.master')
@section('content')
    <div id="breadcrumb" >
        <a href="#" title="go to home" class="tip-bottom"><i class="icon-home"></i>密码</a>
        <a href="#" class="current">修改密码</a>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                    <h5>修改密码</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{asset('login/wordUpdate')}}"   />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     @foreach($datas as $data)
                        <input type="hidden" name="userId" value="{{$data->id}}">
                    <div class="control-group" >
                        <label class="control-label">邮箱</label>
                        <div class="controls">
                            <input type="text" name="mail" id="mail"  value="{{$data->Email}}"readonly />
                        </div>
                    </div>
                    @endforeach
                    <div class="control-group">
                        <label class="control-label">密码</label>
                        <div class="controls">
                            <input type="password" name="pwd" id="pwd"  />
                            @if(session("msg"))
                            <span class="help-inline" for="password" generated="true" style="display:inline-block;color:red;">{{session("msg")}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">确认密码</label>
                        <div class="controls">
                            <input type="password" name="pwd2" id="pwd2"  />
                            @if(session("msg1"))
                            <span class="help-inline" for="password2" generated="true" style="display:inline-block; color:red;">{{session("msg1")}}</span>
                            @endif
                            @if(session("msg2"))
                            <span class="help-inline" for="password2" generated="true" style="display:inline-block;color:red;">{{session("msg2")}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="确认" class="btn btn-primary" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection