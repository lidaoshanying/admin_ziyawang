@extends('layouts.master')

@section('content')
    <link rel="stylesheet" href="{{asset('css/news.css ')}}"/>
    <div id="breadcrumb">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> 推送</a>
        <a href="#" class="current">已推送列表</a>
    </div>
    <div  class="container-fluid">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped pushTable">
                <thead>
                <tr>
                    <th>推送人</th>
                    <th>联系电话(收信人)</th>
                    <th>标题</th>
                    <th>推送时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)

                    <tr>
                        <td>{{session("userName")}}</td>
                        <td>{{$data->phonenumber}}</td>
                        <td>{{$data->Title}}</td>
                        <td>{{$data->Time}}</td>
                        <td><a href="{{asset('push/listDetail/'.$data->MessageID)}}">查看</a></td>
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