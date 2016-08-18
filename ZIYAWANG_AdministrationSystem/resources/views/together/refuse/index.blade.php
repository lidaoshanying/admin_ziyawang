@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="{{asset('css/news.css ')}}"/>
    <div id="breadcrumb" style="position:relative">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>退单</a>
        <a href="#" class="current">退单列表</a>
        <a href="#"  class="pull-right" id="export"> <div class="btn btn-primary" >导出</div></a>
    </div>
    <div class="widget-content nopadding">
        <form class="form-horizontal" method="post" action="{{asset('refuse/index')}}" name="basic_validate"  novalidate="novalidate" />
        <table  class="table table-bordered table-striped">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <td>
                <div class="control-group">
                    <label class="control-label">服务类型</label>
                    <div class="controls" >
                        <select  name="typeName" id="typeName"/>
                        <option value="0">---全部---</option>
                        @foreach($results as $result)
                            <option value="{{$result->TypeID}}" @if(!empty($typeName) && $typeName==$result->TypeID) selected="selected" @endif>{{$result->TypeName}}</option>
                            @endforeach
                            </select>
                    </div>
                </div>
            </td>
            <td>
                <div class="form-actions">
                    <input type="submit" value="搜索" class="btn btn-success" />
                </div>
            </td>
        </table>
        </form>
    </div>
    <script>
        $(function(){
            var type = $('#typeName').val();
            var url = 'http://admin.ziyawang.com/refuse/export?type='+type;
            $('#export').attr('href',url);
        });
    </script>
    <div  class="container-fluid">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>订单号</th>
                    <th>服务类型</th>
                    <th>发布方</th>
                    <th>处置方名称</th>
                    <th>退单申请时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td>{{$data->RushProID}}</td>
                        <td>{{$data->TypeName}}</td>
                        <td>{{$data->phonenumber}}</td>
                        <td>{{$data->ServiceName}}</td>
                        <td>{{$data->updated_at}}</td>
                        <td><a href="{{url('refuse/detail/'.$data->RushProID)}}">查看</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination alternate">
            {!! $datas->render() !!}
        </div>
    </div>
@endsection
