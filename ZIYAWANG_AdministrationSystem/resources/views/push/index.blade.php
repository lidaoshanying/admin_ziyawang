@extends('layouts.master')
@section('content')
    <div id="breadcrumb" style="position:relative" xmlns="http://www.w3.org/1999/html">
        <a href="{{asset('push/index')}}" title="审核列表" class="tip-bottom"><i class="icon-home"></i>推送</a>
        <a href="#" class="current">推送信息</a>
    </div>
    @if(session("msg"))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session("msg")}}</strong>
        </div>
    @endif
    @if(session("msgReceive"))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session("msgReceive")}}</strong>
        </div>
    @endif
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                    <h5>推送消息</h5>
                </div>
                <div class="widget-content nopadding ">
                    <form class="form-horizontal" method="post" action="{{asset('push/sent')}}" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="receiveId" value="<?php echo  session("receiveId") ?>">
                        <div class="control-group">
                            <label class="control-label">收信人</label>
                            <div class="controls">
                                @if(!empty(session("receiveName")))
                                    <input type="text" name="receive" id="receive"   value="<?php echo  session("receiveName") ?>" />
                                    @elseif(!empty(session("receives")))
                                    <input type="text" name="receives" id="receives"   value="<?php echo  session("receives") ?>" />
                                    @else
                                      <input type="text" name="receives" id="receives"   value="" />
                                @endif
                                    <a href="{{asset('push/receive')}}"><input type="button" value="选择收信人" class="btn btn-success" /></a>
                            </div>
                        </div>
                        <div class="control-group " >
                            <label class="control-label">标题</label>
                            <div class="controls">
                                @if(!empty(session("title")))
                                <input type="text" name="title" id="title" value="<?php echo  session("title") ?>" />
                                @else
                                    <input type="text" name="title" id="title" value="" />
                                @endif
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">内容</label>
                            <div class="controls">
                                @if(!empty(session("con")))
                                <textarea name="con" id="contant" ><?php echo  session("con") ?></textarea>
                                @else
                                    <textarea  name="con"  id="contant"  /> </textarea>
                                @endif
                                    <a href="{{asset('push/message')}}"> <input type="button" value="选择消息" class="btn btn-success"  id="button"/></a>
                            </div>
                        </div>
                    <div class="form-actions">
                        <input type="submit" value="推送" class="btn btn-primary"/>
                       <a href="{{asset('push/clear')}}"> <input type="button" value="取消" class="btn btn-primary"/></a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $("#title").on("blur",function(){
                var title=$("#title").val();
                $.ajax({
                    url:"{{asset('push/title')}}",
                    data:{"title":title,_token:"{{ csrf_token() }}"},
                    dataType:"json",
                    type:"post",
                    success:function(msg){
                        console.log(msg)
                    }
                });
            });
            $("#contant").on("blur",function(){
                var con=$("#contant").val();
                $.ajax({
                    url:"{{asset('push/contant')}}",
                    data:{"con":con,_token:"{{ csrf_token() }}"},
                    dataType:"json",
                    type:"post",
                    success:function(msg){
                        console.log(msg)
                    }
                });
            });
            $("#receives").on("blur",function(){
                var receives=$("#receives").val();
                $.ajax({
                    url:"{{asset('push/receives')}}",
                    data:{"receives":receives,_token:"{{ csrf_token() }}"},
                    dataType:"json",
                    type:"post",
                    success:function(msg){
                        console.log(msg)
                    }
                });
            });

        </script>
    </div>
@endsection