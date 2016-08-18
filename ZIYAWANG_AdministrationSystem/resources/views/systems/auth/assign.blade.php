@extends('layouts.master')
@section('content')
    <style>
        .authentic tr td .checker span .checker span{background-position: -76px -240px;}
    </style>
    <div id="breadcrumb" style="position:relative">
        <a href="{{asset("auth/index")}}" title="角色列表" class="tip-bottom"><i class="icon-home"></i>权限</a>
        <a href="#" class="current">分配权限</a>
    </div>
    @if(session("msg"))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>{{session("msg")}}</strong>
        </div>
    @endif
    <div  class="container-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title">
                            <span class="icon">
                                <i class="icon-align-justify"></i>
                            </span>
                    <h5>分配权限</h5>
                </div>
        <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{asset('auth/edit')}}" name="basic_validate"  novalidate="novalidate" />
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{$id}}">
            <table class="table table-bordered table-striped with-check authentic">
                <thead>
                <tr>
                    <th>一级权限</th>
                    <th>二级权限</th>

                </tr>
                </thead>
                <tbody>
                @if(!empty($authId))
                            @foreach($tpAuths as $tpAuth)
                                <tr>
                                    <td><input type="checkbox"  name="ids[]" value="{{$tpAuth->Auth_ID}}" @if(in_array($tpAuth->Auth_ID,$authId)) checked="checked" @endif/>{{$tpAuth->AuthName}}</td>
                                    <td>
                                        @foreach($tAuths as $tAuth)
                                            @if($tAuth->PID==$tpAuth->Auth_ID)
                                       <input type="checkbox"  name="ids[]" value="{{$tAuth->Auth_ID}}"  @if(in_array($tAuth->Auth_ID,$authId)) checked="checked" @endif/> {{$tAuth->AuthName}}
                                            @endif
                                       @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                @if(empty($authId))
                        @foreach($tpAuths as $tpAuth)
                            <tr>
                                <td><input type="checkbox"  name="ids[]" value="{{$tpAuth->Auth_ID}}" />{{$tpAuth->AuthName}}</td>
                                <td>
                                    @foreach($tAuths as $tAuth)
                                        @if($tAuth->PID==$tpAuth->Auth_ID)
                                            <input type="checkbox"  name="ids[]" value="{{$tAuth->Auth_ID}}" /> {{$tAuth->AuthName}}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="form-actions">
            <input type="submit"  id="submit" value="确认" class="btn btn-primary" />
        </div>
        </form>
                <style>
                    .table.with-check tr td:first-child {
                        width: 100px;
                    }
                </style>
    </div>
@endsection
            <!-- TODO: Current Tasks -->