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
                <form id="dataForm" class="form-horizontal dataForm" action="{{route('admin.banner.create')}}" method="post"
                      enctype="multipart/form-data">
                    <!-- 表单字段区域 -->
                    <div class="box-body">
                        <div class="form-group">
                            <label for="parent_id" class="col-sm-2 control-label">所属栏目</label>
                            <div class="col-sm-10 col-md-4">
                                <select name="menu_id" id="parent_id" class="form-control select2">
                                    <option value="0">/</option>
                                    {!! $parents ?? '' !!}
                                </select>
                            </div>
                        </div>
                        <script>
                            $('#parent_id').select2();
                        </script>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">名称</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="name" name="title" value="{{isset($data['title']) ? $data['title'] : ''}}" placeholder="请输入名称"
                                       type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">链接</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="description" name="url" value="{{isset($data['url']) ? $data['url'] : ''}}"
                                       placeholder="请输入链接" type="text" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="col-sm-2 control-label">缩略图</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="code" name="img" value="{{isset($data['img']) ? $data['img'] : ''}}" placeholder="请上传图片"
                                       type="file" class="form-control field-text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">描述</label>
                            <div class="col-sm-10 col-md-4">
                                <input id="description" name="desc" value="{{isset($data['desc']) ? $data['desc'] : ''}}"
                                       placeholder="请输入描述" type="text" class="form-control field-text">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sort_number" class="col-sm-2 control-label">排序</label>
                            <div class="col-sm-10 col-md-4">
                                <div class="input-group">
                                    <input id="sort_number" name="sort"
                                           value="{{isset($data['sort']) ? isset($data['sort']) : '1000'}}" placeholder="请输入排序" type="number"
                                           class="form-control field-number">
                                </div>
                            </div>
                        </div>
                        <script>
                            $('#sort_number')
                                .bootstrapNumber({
                                    upClass: 'success',
                                    downClass: 'primary',
                                    center: true
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
            'desc': {
                required: true,
            },
            'url': {
                required: true,
            },
            'sort': {
                required: true,
            }

        },
        messages: {
            'url': {
                required: "链接不能为空",
            },
            'title': {
                required: "名称不能为空",
            },
            'desc': {
                required: "描述不能为空",
            },
            'sort': {
                required: "排序不能为空",
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
