@extends('layouts.master')

@section('content')
    <div id="breadcrumb" style="position:relative">
        <a href="{{url("system/index")}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>用户</a>
        <a href="#" class="current">用户列表</a>
        <a href="{{url('system/add')}}" class="pull-right"> <button class="btn btn-success">添加用户</button></a>
    </div>
    @if(session("msg"))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session("msg")}}</strong>
        </div>
    @endif
    <div  class="container-fluid">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>姓名</th>
                    <th>登录名</th>
                    <th>手机号</th>
                    <th>角色</th>
                    <th>部门</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                <tr>
                    <td>{{$data['Name']}}</td>
                    <td>{{$data['Email']}}</td>
                    <td>{{$data['PhoneNumber']}}</td>
                    <td>{{$data['RoleName']}}</td>
                    <td>{{$data['Department']}}</td>
                    <td>
                        <a class="btn btn-primary" href="{{url('system/update/'.$data['id'])}}"><i class="icon-pencil icon-white"></i></a>&nbsp&nbsp&nbsp
                        <a class="btn btn-danger"  href="{{url('system/delete/'.$data['id'])}}"onclick="return confirm('确定将此记录删除?')"><i class="icon-remove icon-white"></i></a>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                        <a class="btn btn-primary"  href="{{url('system/edit/'.$data['id'])}}"onclick="return confirm('确定将密码恢复到原始值吗?')">重置密码</i></a>
                    </td>
                </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination alternate" style="margin:0 auto">
            {!! $datas->render() !!}
        </div>
    </div>
@endsection
    <!-- TODO: Current Tasks -->

