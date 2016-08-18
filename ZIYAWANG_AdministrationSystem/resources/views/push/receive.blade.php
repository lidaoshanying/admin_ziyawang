@extends('layouts.master')
@section('content')
    <link rel="stylesheet" href="{{asset('css/push.css ')}}"/>
    <div id="breadcrumb" style="position:relative">
        <a href="#" title="Go to Home" class="tip-bottom"><i class="icon-home"></i>收信人</a>
        <a href="#" class="current">收信人列表</a>
    </div>
    <div class="widget-content nopadding">
        <form class="form-horizontal" method="post" action="{{asset('push/receive')}}" name="basic_validate"  novalidate="novalidate" />
        <table  class="table table-bordered table-striped pushMessage">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <td>
                <div class="control-group">
                    <label class="control-label">公司名称</label>
                    <div class="controls" >
                        <input name="serviceName" value="">
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <label class="control-label">联系电话</label>
                    <div class="controls" >
                        <input name="conectPhone" value="">
                    </div>
                </div>
            </td>
            <td>
                <div class="form-actions searchBox">
                    <input type="submit" value="搜索" class="btn btn-success" />
                </div>
            </td>
        </table>
        </form>
    </div>
    <div  class="container-fluid">
        <div class="widget-content nopadding">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>公司名称</th>
                    <th>联系电话</th>
                </tr>
                </thead>
                <tbody>
                @foreach($datas as $data)
                    <tr>
                        <td> <input type="radio" class="service" name="serviceID" value="{{$data->ServiceID}}"></td>
                        <td>{{$data->ServiceName}}</td>
                        <td>{{$data->ConnectPhone}}</td>
                        @if($data->State==2)
                            <td><p style="color: #149bdf">拒审核</p></td>
                        @elseif($data->State==0)
                            <td><p style="color: #149bdf">待审核</p></td>
                        @else
                            <td><p style="color: #149bdf">已审核</p></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination alternate">
            {!! $datas->render() !!}
        </div>
    <script type="text/javascript">
        $(".service").on("click",function(){
            var value= $(this).val();

            window.location.href="{{asset("push/index")}}?id="+value

        });
    </script>
    </div>
    @endsection
            <!-- TODO: Current Tasks -->