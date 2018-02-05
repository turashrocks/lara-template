<script id="_render_customfield_field_group_template" type="text/x-custom-template">
    <div class="box box-primary meta-boxes">
        <div class="box-header with-border">
            <h3 class="box-title">__title__</h3>
            <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body meta-boxes-body"></div>
    </div>
</script>

<script id="_render_customfield_global_skeleton_template" type="text/x-custom-template">
    <div class="meta-box field-__type__">
        <div class="title">
            <b>__title__</b><br>
            <span class="help-block">__instructions__</span>
        </div>
        <div class="meta-box-wrap"></div>
    </div>
</script>

<script id="_render_customfield_text_template" type="text/x-custom-template">
    <input type="text"
           value="__value__"
           placeholder="__placeholderText__"
           class="form-control">
</script>

<script id="_render_customfield_number_template" type="text/x-custom-template">
    <input type="number"
           value="__value__"
           placeholder="__placeholderText__"
           class="form-control">
</script>

<script id="_render_customfield_email_template" type="text/x-custom-template">
    <input type="email"
           value="__value__"
           placeholder="__placeholderText__"
           class="form-control">
</script>

<script id="_render_customfield_password_template" type="text/x-custom-template">
    <input type="password"
           value="__value__"
           placeholder="__placeholderText__"
           class="form-control">
</script>

<script id="_render_customfield_textarea_template" type="text/x-custom-template">
    <textarea rows="__rows__"
              placeholder="__placeholderText__"
              class="form-control">__value__</textarea>
</script>

<script id="_render_customfield_checkbox_template" type="text/x-custom-template">
    <div class="clearfix">
        <label class="mt-checkbox mt-checkbox-outline">
            <input type="checkbox"
                   __checked__
                   value="__value__">
            <span></span>
            __title__
        </label>
    </div>
</script>

<script id="_render_customfield_radio_template" type="text/x-custom-template">
    <div class="clearfix">
        <label class="mt-radio mt-radio-outline">
            <input type="radio"
                   __checked__
                   name="_custom_field_radio_box__id__"
                   value="__value__">
            <span></span>
            __title__
        </label>
    </div>
</script>

<script id="_render_customfield_select_template" type="text/x-custom-template">
    <select class="form-control">
        <option value=""></option>
    </select>
</script>

<script id="_render_customfield_image_template" type="text/x-custom-template">
    <div class="select-media-box">
        <div class="image-box">
            <input type="hidden"
                   value="__value__"
                   class="image-data">
            <img src="__image__" data-default="{{ get_image_url(config('media.default-img'), 'thumb') }}"
                 alt="preview image" class="preview_image">
            <div class="image-box-actions">
                <a class="btn_gallery" data-action="select-image">
                    {{ trans('bases::forms.choose_image') }}
                </a> |
                <a class="btn_remove_image">
                    {{ trans('bases::forms.remove_image') }}
                </a>
            </div>
        </div>

    </div>
</script>

<script id="_render_customfield_file_template" type="text/x-custom-template">
    <div class="select-media-box">
        <div class="attachment-wrapper">
            <input type="hidden" value="__value__" class="attachment-url">
            <div class="attachment-details">
                <a href="__value__" target="_blank">__value__</a>
            </div>
            <div class="image-box-actions">
                <a class="btn_gallery" data-action="attachment">
                    {{ __('Choose file') }}
                </a> |
                <a class="btn_remove_attachment">
                    {{ __('Remove file') }}
                </a>
            </div>
        </div>
    </div>
</script>

<script id="_render_customfield_wysiswg_template" type="text/x-custom-template">
    <textarea class="form-control wysiwyg-editor" data-height="250px">__value__</textarea>
</script>

<script id="_render_customfield_repeater_template" type="text/x-custom-template">
    <div class="lcf-repeater">
        <ul class="sortable-wrapper field-group-items"></ul>
        <a href="#" class="repeater-add-new-field mt10 btn btn-success"></a>
    </div>
</script>

<script id="_render_customfield_repeater_item_template" type="text/x-custom-template">
    <li class="ui-sortable-handle" data-position="__position__">
        <a href="#" class="remove-field-line" title="Remove this line"><span>&nbsp;</span></a>
        <a href="#" class="collapse-field-line" title="Colapse this line"><i class="fa fa-bars"></i></a>
        <div class="col-xs-12 field-line-wrapper clearfix">
            <ul class="field-group"></ul>
        </div>
        <div class="clearfix"></div>
    </li>
</script>

<script id="_render_customfield_repeater_line_template" type="text/x-custom-template">
    <li>
        <div class="col-xs-3 repeater-item-helper">
            <div class="field-label">__title__</div>
            <div class="field-instructions help-block">__instructions__</div>
        </div>
        <div class="col-xs-9 repeater-item-input"></div>
        <div class="clearfix"></div>
    </li>
</script>