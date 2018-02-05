@php
    $featured = get_featured_posts(5);
    $featuredList = [];
    if (!empty($featured)) {
        $featured->pluck('id')->all();
    }
@endphp

@if (!empty($featured))
    <section class="section">
        <div class="container" style="padding-left: 0px; padding-right: 0px;">
            <div class="post-group post-group--hero">


                            <!-- Carousel
            ================================================== -->
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <!--<ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                </ol>-->
                                <div class="carousel-inner" role="listbox">


                                    @foreach ($featured as $index => $feature_item)
                                    <div class="item @if($index == 0) {{ 'active' }} @endif">
                                        <img class="post__overlay" src="{{ get_object_image($feature_item->image, 'featured') }}" alt="{{ $feature_item->name }}"><a href="{{ route('public.single', $feature_item->slug) }}" class="post__overlay"></a>
                                        <div class="container">
                                            <div class="carousel-caption">
                                                <header class="post__header">
                                                    <h3 class="post__title sam__bold"><a href="{{ route('public.single', $feature_item->slug) }}">{{ $feature_item->name }}</a></h3>
                                                </header>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div><!-- /.carousel -->


            </div>
        </div>
    </section>
@endif

@if (function_exists('render_galleries'))
    {!! render_galleries(8) !!}
@endif


<!--<section class="section pt-50 pb-50 bg-lightgray">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="page-content">
                    <div class="post-group post-group--single">
                        <div class="post-group__header">
                            <h3 class="post-group__title">{{ __('Best for you') }}</h3>
                        </div>
                        <div class="post-group__content">
                            <div class="row">
                                @foreach (get_featured_categories(2) as $category)
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        @foreach ($category->posts()->limit(3)->get() as $post)
                                            @if ($loop->first)
                                                <article class="post post__vertical post__vertical--single post__vertical--simple">
                                                    <div class="post__thumbnail">
                                                        <img src="{{ get_object_image($post->image, 'medium') }}" alt="{{ $post->name }}"><a href="{{ route('public.single', $post->slug) }}" class="post__overlay"></a>
                                                    </div>
                                                    <div class="post__content-wrap">
                                                        <header class="post__header">
                                                            <h3 class="post__title"><a href="{{ route('public.single', $post->slug) }}">{{ $post->name }}</a></h3>
                                                            <div class="post__meta"><span class="created__month">{{ date_from_database($post->created_at, 'M') }}</span><span class="created__date">{{ date_from_database($post->created_at, 'd') }}</span><span class="created__year">{{ date_from_database($post->created_at, 'Y') }}</span></div>
                                                        </header>
                                                        <div class="post__content">
                                                            <p data-number-line="2">{{ $post->description }}</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            @else
                                                <article class="post post__horizontal post__horizontal--single mb-20 clearfix">
                                                    <div class="post__thumbnail">
                                                        <img src="{{ get_object_image($post->image, 'medium') }}" alt="{{ $post->name }}"><a href="{{ route('public.single', $post->slug) }}" class="post__overlay"></a>
                                                    </div>
                                                    <div class="post__content-wrap">
                                                        <header class="post__header">
                                                            <h3 class="post__title"><a href="{{ route('public.single', $post->slug) }}">{{ $post->name }}</a></h3>
                                                            <div class="post__meta"><span class="post__created-at"><a href="#">{{ date_from_database($post->created_at, 'M d, Y') }}</a></span></div>
                                                        </header>
                                                    </div>
                                                </article>
                                            @endif
                                            @if ($loop->last)
                                    </div>
                                    @endif
                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                {!! Theme::partial('sidebar') !!}
            </div>
        </div>
    </div>
</section>-->

<!--<section class="section pt-50 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-content">
                    <div class="post-group post-group--single">
                        <div class="post-group__header">
                            <h3 class="post-group__title">{{ __("What's new ?") }}</h3>
                        </div>
                        <div class="post-group__content">
                            <div class="row">
                                @foreach (get_latest_posts(7, $featuredList) as $post)
                                    @if ($loop->first)
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <article class="post post__vertical post__vertical--single">
                                                <div class="post__thumbnail">
                                                    <img src="{{ get_object_image($post->image, 'medium') }}" alt="{{ $post->name }}"><a href="{{ route('public.single', $post->slug) }}" class="post__overlay"></a>
                                                </div>
                                                <div class="post__content-wrap">
                                                    <header class="post__header">
                                                        <h3 class="post__title"><a href="{{ route('public.single', $post->slug) }}">{{ $post->name }}</a></h3>
                                                        <div class="post__meta"><span class="created__month">{{ date_from_database($post->created_at, 'M') }}</span><span class="created__date">{{ date_from_database($post->created_at, 'd') }}</span><span class="created__year">{{ date_from_database($post->created_at, 'Y') }}</span></div>
                                                    </header>
                                                    <div class="post__content">
                                                        <p data-number-line="4">{{ $post->description }}</p>
                                                    </div>
                                                    <div class="post__footer"><a href="{{ route('public.single', $post->slug) }}" class="post__readmore">{{ __('Read more') }}</a></div>
                                                </div>
                                            </article>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                    @else
                                        <article class="post post__horizontal post__horizontal--single mb-20 clearfix">
                                            <div class="post__thumbnail">
                                                <img src="{{ get_object_image($post->image, 'medium') }}" alt="{{ $post->name }}"><a href="{{ route('public.single', $post->slug) }}" class="post__overlay"></a>
                                            </div>
                                            <div class="post__content-wrap">
                                                <header class="post__header">
                                                    <h3 class="post__title"><a href="{{ route('public.single', $post->slug) }}">{{ $post->name }}</a></h3>
                                                    <div class="post__meta"><span class="post__created-at"><a href="#">{{ date_from_database($post->created_at, 'M d, Y') }}</a></span></div>
                                                </header>
                                            </div>
                                        </article>
                                    @endif
                                    @if ($loop->last)
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->

