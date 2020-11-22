<?php
/**
 * 上传单图
 *
 * @author yuxingfei<474949931@qq.com>
 */

namespace App\Libs\Generate\Field;

class Image extends Field
{
    public static $html = <<<EOF
    <div class="form-group">
        <label for="[FIELD_NAME]" class="col-sm-2 control-label">[FORM_NAME]</label>
        <div class="col-sm-10 col-md-4">
            <input id="[FIELD_NAME]" name="[FIELD_NAME]"  placeholder="请上传[FORM_NAME]" data-initial-preview="{{isset(\$data['[FIELD_NAME]']) ? \$data['[FIELD_NAME]'] : ''}}" type="file" class="form-control field-image" >
        </div>
    </div>
    <script>
    $('#[FIELD_NAME]').fileinput({
        language: 'zh',
        overwriteInitial: true,
        browseLabel: '浏览',
        initialPreviewAsData: true,
        dropZoneEnabled: false,
        showUpload:false,
        showRemove: false,
        allowedFileTypes:['image'],
        maxFileSize:102400,
    });
    </script>\n
EOF;

    public static $rules = [
        'required'   => '非空',
        'file_size'  => '文件大小限制',
        'file_image' => '图片类型',
        'regular'    => '自定义正则'
    ];


    //控制器添加上传
    public static $controllerAddCode =
        <<<EOF
//处理[FORM_NAME]上传
\$attachment_[FIELD_NAME] = new \App\Model\Common\Attachment;
\$file_[FIELD_NAME]       = \$attachment_[FIELD_NAME]->upload('[FIELD_NAME]');
if (\$file_[FIELD_NAME]) {
    \$param['[FIELD_NAME]'] = \$file_[FIELD_NAME]->url;
} else {
    return error(\$attachment_[FIELD_NAME]->getError());
}
\n
EOF;


    //控制器修改上传
    public static $controllerEditCode =
        <<<EOF
//处理[FORM_NAME]上传
if (!empty(\$_FILES['[FIELD_NAME]']['name'])) {
    \$attachment_[FIELD_NAME] = new \App\Model\Common\Attachment;
    \$file_[FIELD_NAME]       = \$attachment_[FIELD_NAME]->upload('[FIELD_NAME]');
    if (\$file_[FIELD_NAME]) {
        \$data->[FIELD_NAME] = \$file_[FIELD_NAME]->url;
    }
}
\n
EOF;


    public static function create($data)
    {
        $html = self::$html;
        $html = str_replace('[FORM_NAME]', $data['form_name'], $html);
        $html = str_replace('[FIELD_NAME]', $data['field_name'], $html);
        return $html;
    }
}
