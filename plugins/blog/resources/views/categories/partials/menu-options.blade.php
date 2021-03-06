@if (!empty($categories))
    <div class="widget panel">
        <div class="widget-heading">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseCategories">
                <h4 class="widget-title">
                    <i class="box_img_sale"></i>
                    <span>{{ trans('blog::categories.menu') }}</span>
                    <i class="fa fa-angle-down narrow-icon"></i>
                </h4>
            </a>
        </div>
        <div id="collapseCategories" class="panel-collapse collapse">
            <div class="widget-body">
                <div class="box-links-for-menu">
                    <div class="the-box">
                        {!! $categories !!}
                        <div class="text-right">
                            <div class="btn-group btn-group-devided">
                                <a href="#" class="btn-add-to-menu btn btn-primary">
                                    <span class="text"><i class="fa fa-plus"></i> {{ trans('menu::menu.add_to_menu') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif