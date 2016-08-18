@extends('layouts.master')
@section('content')
    <div id="breadcrumb" >
        <a href="{{asset('role/index')}}" title="角色列表" class="tip-bottom"><i class="icon-home"></i>角色</a>
        <a href="#" class="current">编辑角色</a>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                    <h5>编辑角色</h5>
                </div>
                <div class="widget-content nopadding">
                    <form class="form-horizontal" method="post" action="{{asset('systems/role/update')}}" name="basic_validate"  novalidate="novalidate" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="control-group">
                        <label class="control-label">角色名称</label>
                        @foreach($db as $value)
                            <input type="hidden" name="id" value="{{ $value->id }}">
                        <div class="controls">
                            <input type="text" name="roleName" value="{{$value->RoleName}}" />
                            @if(session("msg"))
                                <span class="help-inline"  id= "remark" for="pwd" generated="true" style=" color: red">{{session("msg")}}</span>
                            @endif
                        </div>
                            @endforeach
                    </div>
                    <div class="form-actions">
                        <input type="submit" value="确定" class="btn btn-primary" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
