@extends('layouts.master')
@section('content')
    <div id="breadcrumb" style="position:relative">
        <a href="{{asset('order/index')}}" title="订单列表" class="tip-bottom"><i class="icon-home"></i>订单</a>
        <a href="#" class="current">订单详情</a>
    </div>
    <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                        <h5>订单详情</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{asset('order/update')}}" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{$id}}">
                        @foreach($datas as $data)
                            <div class="control-group">
                                <label class="control-label">订单号</label>
                                <div class="controls">
                                    <input type="text" name="name" id="required" value="{{$data->RushProID}}" readonly />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">服务类型</label>
                                <div class="controls">
                                    <input type="text" name="email" id="email"  value="{{$data->TypeName}}" readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">发布方名称</label>
                                <div class="controls">
                                    <input type="text" name="number" id="date" value="{{$data->phonenumber}}" readonly/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">处置方名称</label>
                                <div class="controls">
                                    <input type="text" name="password" id="url" value="{{$data->ServiceName}}" readonly/>
                                </div>
                            </div>
                        <div class="control-group">
                                <label class="control-label">下单时间</label>
                                <div class="controls">
                                    <input type="text" name="password" id="url" value="{{$data->RushTime}}" readonly/>
                                </div>
                            </div>
                        @endforeach
                        <div class="form-actions">
                            <a href="{{url('order/index')}}"><input type=button value="返回" class="btn btn-primary"/></a>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection