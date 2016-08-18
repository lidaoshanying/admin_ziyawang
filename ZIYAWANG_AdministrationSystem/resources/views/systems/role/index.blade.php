@extends('layouts.master')
@section('content')
    <div id="breadcrumb" style="position: relative">
        <a href="{{asset('role/index')}}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>角色</a>
        <a href="#" class="current">角色列表</a>
        <a href="{{url('role/add')}}" class="pull-right"> <button class="btn btn-success">添加角色</button></a>
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
                    <th>ID</th>
                    <th>角色名称</th>

                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{$data->id}}</td>
                        <td>{{$data->RoleName}}</td>

                        <td>
                            <a class="btn btn-primary" href="{{url('role/update/'.$data->id)}}"><i class="icon-pencil icon-white"></i></a>&nbsp&nbsp&nbsp
                            <a class="btn btn-danger"  href="{{url('role/delete/'.$data->id)}}"onclick="return confirm('确定将此记录删除?')"><i class="icon-remove icon-white"></i></a>
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
