@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12 center" style="text-align: center;">
                <ul class="stat-boxes">
                    <li>
                        <div class="left peity_bar_good"><span>{{$data['TsevenUser']}},{{$data['TsixUser']}},{{$data['TfiveUser']}},{{$data['TfourUser']}},{{$data['TthreeUser']}},{{$data['TtwoUser']}},{{$data['ToneUser']}}</span>{{$data['change'].'%'}}</div>
                        <div class="right">
                            <strong>{{$data['users']}}</strong>
                            注册总数
                        </div>
                    </li>
                    <li>
                        <div class="left peity_bar_neutral"><span>{{$data['sevenUser']}},{{$data['sixUser']}},{{$data['fiveUser']}},{{$data['fourUser']}},{{$data['threeUser']}},{{$data['twoUser']}},{{$data['oneUser']}}</span>{{$data['changeUser'].'%'}}</div>
                        <div class="right">
                            <strong>{{$data['lastUser']}}</strong>
                            上周注册数
                        </div>
                    </li>
                    <li>
                        <div class="left peity_bar_bad"><span>{{$data['TsevenSer']}},{{$data['TsixSer']}},{{$data['TfiveSer']}},{{$data['TfourSer']}},{{$data['TthreeSer']}},{{$data['TtwoSer']}},{{$data['ToneSer']}}</span>{{$data['changeSer'].'%'}}</div>
                        <div class="right">
                            <strong>{{$data['services']}}</strong>
                            服务方总数
                        </div>
                    </li>
                    <li>
                        <div class="left peity_line_good"><span>{{$data['sevenSer']}},{{$data['sixSer']}},{{$data['fiveSer']}},{{$data['fourSer']}},{{$data['threeSer']}},{{$data['twoSer']}},{{$data['oneSer']}}</span>{{$data['lchangeSer'].'%'}}</div>
                        <div class="right">
                            <strong>{{$data['lastServices']}}</strong>
                            过去一周
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"><i class="icon-signal"></i></span><h5>数据展示</h5></div></div>
                    <div class="widget-content">
                        <div class="row-fluid">
                            <div class="span4">
                                <ul class="site-stats">
                                    <li><i class="icon-user"></i> <strong>{{$data['projectinfos']}}</strong> <small>信息条数</small></li>
                                    <li><i class="icon-arrow-right"></i> <strong>{{$data['lastOrders']}}</strong> <small>上周发布</small></li>
                                    <li class="divider"></li>
                                    <li><i class="icon-shopping-cart"></i> <strong>{{$data['orders']}}</strong> <small>总订单数</small></li>
                                    <li><i class="icon-tag"></i> <strong>{{$data['hots']}}</strong> <small>抢单中</small></li>
                                    <li><i class="icon-repeat"></i> <strong>{{$data['togethers']}}</strong> <small>已合作</small></li>
                                </ul>
                            </div>
                            @foreach($chart as $val)
                                <input type="hidden" value="{{$val}}">
                            @endforeach
                            @foreach($times as $key=>$time)

                            <input type="hidden" id="A{{$key}}" value="{{$time}}">
                            @endforeach
                            <input type="hidden" id="max" value="{{$max}}">
                            <input type="hidden" id="min" value="{{$min}}">
                            <div class="span8">
                                <div class="chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/excanvas.min.js')}}"></script>
    <script src="{{asset('js/jquery.flot.min.js')}}"></script>
    <script src="{{asset('js/jquery.flot.resize.min.js')}}"></script>
    <script src="{{asset('js/jquery.peity.min.js')}}"></script>
    <script src="{{asset('js/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/unicorn.dashboard.js')}}"></script>
@endsection
    <!-- TODO: Current Tasks -->
