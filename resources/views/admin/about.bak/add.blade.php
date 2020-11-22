@extends('admin.public.base')

@section('content')
@include('admin.public.content_header')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <!-- 表单头部 -->
                <div class="box-header with-border">
                    <div class="btn-group">
                        <a class="btn flat btn-sm btn-default BackButton">
                            <i class="fa fa-arrow-left"></i>
                            返回
                        </a>
                    </div>
                </div>
                <!-- 表单 -->
                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.about.create')}}" method="post"
                      enctype="multipart/form-data">
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">简介</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="content" name="title" value="{{isset($data['content']) ? $data['content'] : ''}}" placeholder="请输入简介"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="title" name="title" value="{{isset($data['title']) ? $data['title'] : ''}}" placeholder="请输入标题"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="manager_content" class="col-sm-2 control-label">管理人员简介</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="manager_content" name="title" value="{{isset($data['manager_content']) ? $data['manager_content'] : ''}}" placeholder="请输入管理人员标题"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="manager_title" class="col-sm-2 control-label">管理人员标题</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="manager_title" name="title" value="{{isset($data['manager_title']) ? $data['manager_title'] : ''}}" placeholder="请输入管理人员标题"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="is_show" class="col-sm-2 control-label">是否显示</label>
                            <div class="col-sm-10 col-md-4">
                                <input class="input-switch" id="is_show" value="1"
                                       @if(!isset($data) || $data['is_show'] == 1)checked @endif type="checkbox"/>
                                <input class="switch" name="is_show" value="{{isset($data['is_show']) ? $data['is_show'] : '1'}}"
                                       placeholder="" hidden/>
                            </div>
                        </div>
                        <script>
                            $('#is_show').bootstrapSwitch({
                                onText: "是",
                                offText: "否",
                                onColor: "success",
                                offColor: "danger",
                                onSwitchChange: function (event, state) {
                                    $(event.target).closest('.bootstrap-switch').next().val(state ? '1' : '0').change();
                                }
                            });
                        </script>

                    </div>
                    <!-- 表单底部 -->
                    <div class="box-footer">
                        @csrf
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10 col-md-4">
                            @if(!isset($data))
                            <div class="btn-group pull-right">
                                <label class="createContinue">
                                    <input type="checkbox" value="1" id="_create" name="_create"
                                           title="继续添加数据">继续添加</label>
                            </div>
                            @endif
                            <div class="btn-group">
                                <button type="submit" class="btn flat btn-info dataFormSubmit">
                                    保存
                                </button>
                            </div>
                            <div class="btn-group">
                                <button type="reset" class="btn flat btn-default dataFormReset">
                                    重置
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    /** 表单验证 **/
    $('#dataForm').validate({
        rules: {
            'title': {
                required: true,
            },
            'content': {
                required: true,
            },
            'manager_content': {
                required: true,
            },
            'manager_title': {
                required: true,
            }

        },
        messages: {
            'content': {
                required: "简介不能为空",
            },
            'title': {
                required: "标题不能为空",
            },
            'manager_content': {
                required: "管理人员简介不能为空",
            },
            'manager_title': {
                required: "管理人员标题不能为空",
            }
        }
    });


    function addNew(obj, type) {
        var template = $('#data-template').html();
        if (obj == null) {
            $("#dataBody").append(template);
        } else {
            if (type === 1) {
                $(obj).parent().parent().before(template);
            } else {
                $(obj).parent().parent().after(template);
            }
        }

        $('#dataBody select').select2();
    }
</script>

@endsection
