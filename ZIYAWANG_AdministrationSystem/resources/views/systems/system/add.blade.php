@extends('layouts.master')
@section('content')
    <div id="breadcrumb" style="position:relative">
        <a href="{{url("system/index")}}" title="用户列表" class="tip-bottom"><i class="icon-home"></i>用户</a>
        <a href="#" class="current">添加用户</a>
    </div>
    <div class="row-fluid">
        <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                        <h5>添加用户</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{asset('systems/system/add')}}" name="basic_validate"  novalidate="novalidate" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="control-group">
                            <label class="control-label">姓名</label>
                            <div class="controls">
                                <input type="text" name="name" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">邮箱</label>
                            <div class="controls">
                                <input type="text" name="email" id="email" />
                                @if(session(("msg0")))
                                 <span class="help-inline"  id= "remark" for="pwd" generated="true" style=" color: red">{{session("msg0")}}</span>
                                @endif
                                @if(session(("msg2")))
                                    <span class="help-inline"  id= "remark" for="pwd" generated="true" style="color: red">{{session("msg2")}}</span>
                                @endif
                                @if(session(("msg5")))
                                    <span class="help-inline"  id= "remark" for="pwd" generated="true" style="color: red">{{session("msg5")}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">手机号</label>
                            <div class="controls">
                                <input type="text" name="number" id="date" />
                                @if(session(("msg3")))
                                    <span class="help-inline"  id= "remark" for="pwd" generated="true" style=" color: red">{{session("msg3")}}</span>
                                @endif
                                @if(session(("msg4")))
                                    <span class="help-inline"  id= "remark" for="pwd" generated="true" style="color: red">{{session("msg4")}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">密码</label>
                            <div class="controls">
                                <input type="password" name="password" id="url" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">部门</label>
                            <div class="controls">
                                <select  name="department" id="url" />
                                        <option value="0">请选择</option>
                                        <option value="技术部">技术部</option>
                                        <option value="产品部">产品部</option>
                                        <option value="销售部">销售部</option>
                                        <option value="人事部">人事部</option>
                                        <option value="客服部">客服部</option>
                                        <option value="视频部">视频部</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">角色</label>
                            <div class="controls">
                                <select  name="roleName" id="url"/>
                                <option value="0">--请选择--</option>
                                @foreach($datas as $data)
                                <option value="{{$data->id}}">{{$data->RoleName}}</option>
                               @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="添加" class="btn btn-primary" />
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>

@endsection