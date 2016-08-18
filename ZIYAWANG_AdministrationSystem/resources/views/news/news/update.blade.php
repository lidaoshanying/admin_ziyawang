@extends('layouts.master')
@section('content')
    <style>
        .newsType .checker span .checker span{background-position: -76px -240px;}
    </style>
    <div id="breadcrumb">
        <a href="{{url('news/index')}}" title="新闻列表" class="tip-bottom"><i class="icon-home"></i> 新闻</a>
        <a href="#" class="current">编辑新闻</a>
    </div>
    @if(session("msg"))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session("msg")}}</strong>
        </div>
    @endif
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                    <span class="icon">
                        <i class="icon-align-justify"></i>
                    </span>
                    <h5>编辑新闻</h5>
                </div>
                <div class="widget-content nopadding" >
                    <form method="post" action="{{asset('news/saveupdate')}}" class="form-horizontal" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="newsid" value="{{$datas->NewsID}}">
                    <div class="control-group">
                        <label class="control-label">新闻标题</label>
                        <div class="controls">
                            <input type="text" name="title" value="{{$datas->NewsTitle}}" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">新闻类型</label>
                        <div class="controls newsType">
                            @foreach($types as $type)
                                <input type="checkbox" name="type[]" value="{{$type->id}}" @if(in_array($type->id,$count)) checked="checked" @endif />{{$type->TypeName}}
                            @endforeach
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">摘要</label>
                        <div class="controls">
                            <textarea name="description"  maxlength="200" placeholder="请您输入200个字数之内">{{$datas->Brief}}</textarea>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">列表图片(比例1:1)</label>
                        <div class="controls">
                            <input type="hidden" id="filepath" name="newslogo" value="{{$datas->NewsLogo}}">
                            <input id="file_upload" name="file_upload"  multiple="true">
                        </div>
                        <div class="controls  span4">
                            <img src="{{'Http://images.ziyawang.com'.$datas->NewsLogo}}" id="thumb" alt=""/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">首页图片(比例3:2)</label>
                        <div class="controls">
                            <input type="hidden" id="filepath1" name="newsThumb" value="{{$datas->NewsThumb}}">
                            <input id="file_upload1" name="file_upload1"  multiple="true">
                        </div>
                        <div class="controls  span4">
                            <img src="{{'Http://images.ziyawang.com'.$datas->NewsThumb}}" id="thumb" alt=""/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">新闻内容</label>
                        <div class="controls">
                            <textarea name="content" class="ckeditor">{{$datas->NewsContent}}</textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" onClick="savenews(0)" >保存</button>
                        <button id="publish" type="submit" class="btn btn-primary" onClick="savenews(1)" >保存并发布</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        <?php $timestamp = time();?>

        function savenews(para){
            var f = document.getElementsByTagName("form")[0];
            f.action=f.action+"/"+para;
        }

        $(function() {
            $("#file_upload").uploadifive({
                'buttonText' : '上传图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}"
                },
                'removeCompleted' : true,
                'fileSizeLimit':1024,
                'uploadScript'     :"{{url('/news/upload')}}",
                'onUploadComplete' : function(file, data) {
                    $('#filepath').val(data);
                    $('#thumb').attr('src', 'Http://images.ziyawang.com'+data);
                }
            });
        });
        $(function() {
            $("#file_upload1").uploadifive({
                'buttonText' : '上传图片',
                'formData'     : {
                    'timestamp' : '<?php echo $timestamp;?>',
                    '_token'     : "{{csrf_token()}}"
                },
                'removeCompleted' : true,
                'fileSizeLimit':1024,
                'uploadScript'     :"{{url('/news/upload')}}",
                'onUploadComplete' : function(file, data) {
                    $('#filepath1').val(data);
                    $('#thumb1').attr('src',"Http://images.ziyawang.com"+data);
                }
            });
        });
    </script>
@endsection