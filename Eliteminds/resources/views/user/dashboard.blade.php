@extends('layouts.layoutV2')

@section('content')
    <div class="container">
        <!-- Title and Top Buttons Start -->
        <div class="page-title-container">
            <div class="row">
                <!-- Title Start -->
                <div class="col-12 col-md-7">
                    <h1 class="mb-0 pb-0 display-4" id="title">Dashboard</h1>
                    <nav class="breadcrumb-container d-inline-block" aria-label="breadcrumb">
                        <ul class="breadcrumb pt-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Dashboards</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Title End -->
            </div>
        </div>
        <!-- Title and Top Buttons End -->

        <!-- Content Start -->
        <div class="row">
            <!-- Continue Learning Start -->
            <div class="col-xl-6 mb-5">
                <h2 class="small-title">Continue Learning</h2>
                <div class="scroll-out">
                    <div class="scroll-by-count" data-count="3">
                        <div class="card mb-2">
                            @foreach($userPackagesList as $i)
                            <div class="row g-0 sh-14 mb-2" style="overflow:hidden;">
                                <div class="col-auto">
                                    <a href="{{route('package.details', $i['package']->package_id)}}" class="d-block position-relative h-100">
                                        <img src="{{ url('storage/package/imgs/'.basename($i['package']->img))}}" alt="alternate text" class="card-img card-img-horizontal sw-14 sw-lg-18" />
                                        <button class="btn btn-icon-only btn-icon-start btn-foreground btn-sm px-3 position-absolute absolute-center opacity-75" type="button">
                                            <i data-cs-icon="play" data-cs-size="16" data-cs-fill="var(--primary)"></i>
                                        </button>
                                    </a>
                                </div>
                                <div class="col">
                                    <div class="card-body pt-0 pb-0 h-100 d-flex align-items-center">
                                        <div class="w-100">
                                            <div class="d-flex flex-row justify-content-between mb-2">
                                                <a href="{{route('package.details', $i['package']->package_id)}}" style=" text-overflow: ellipsis;overflow: hidden; white-space: nowrap;">{{$i['package']->name}}</a>
                                                <div class="text-muted">{{$i['progress']}}%</div>
                                            </div>
                                            <div class="progress mb-2">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="{{$i['progress']}}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Continue Learning End -->

            <!-- Related Subjects Start -->
            <div class="col-xl-3 mb-5">
                <h2 class="small-title">Statistics</h2>
                <div class="row g-3">
                    <div class="col-12 col-xl-12 sh-19">
                        <div class="card h-100 hover-scale-up">
                            <a class="card-body text-center" href="{{route('my.package.view')}}">
                                <i data-cs-icon="cupcake" class="text-primary"></i>
                                <p class="heading mt-3 text-body">Packages</p>
                                <div class="text-extra-small fw-medium text-muted">{{$total_package_number}} PACKAGE</div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-xl-12 sh-19">
                        <div class="card h-100 hover-scale-up">
                            <a class="card-body text-center" href="javascript:;">
                                <i data-cs-icon="graduation" class="text-primary"></i>
                                <p class="heading mt-3 text-body">Certifications</p>
                                <div class="text-extra-small fw-medium text-muted">{{$user_certifications_number}} CERTIFICATES</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Related Subjects End -->

            <!-- Your Time Start -->
            <div class="col-xl-3 mb-5">
                <h2 class="small-title">Results</h2>
                <div class="card sh-40 h-xl-100-card">
                    <div class="card-body h-100">
                        <div class="h-100">
                            <canvas id="timeChart"></canvas>
                            <div class="custom-tooltip position-absolute bg-foreground rounded-md border border-separator pe-none p-3 d-flex flex-column z-index-1 align-items-center opacity-0 basic-transform-transition">
                                <div class="icon-container border d-flex align-items-center justify-content-center align-self-center rounded-xl sh-5 sw-5 rounded-xl mb-3">
                                    <span class="icon"></span>
                                </div>
                                <span class="text d-flex align-middle text-alternate align-items-center text-small">Bread</span>
                                <span class="value d-flex align-middle text-body align-items-center cta-4">300</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Your Time End -->
        </div>

        <div class="row">
            <!-- Exam Results Start -->
            <div class="col-lg-6 mb-5">
                <div class="d-flex justify-content-between">
                    <h2 class="small-title">Exam Results</h2>
                    <a href="javascript:;" class="btn btn-icon btn-icon-end btn-xs btn-background-alternate p-0 text-small">
                        <span class="align-bottom">View All</span>
                        <i data-cs-icon="chevron-right" class="align-middle" data-cs-size="12"></i>
                    </a>
                </div>
                <div class="scroll-out">
                    <div class="scroll-by-count" data-count="{{count($quizzes)}}">
                        @foreach($quizzes as $quiz_z)
                        <div class="card mb-2 sh-11 sh-md-8">
                            <div class="card-body pt-0 pb-0 h-100">

                                <div class="row g-0 h-100 align-content-center">
                                    <div class="col-12 col-md-3 d-flex align-items-center mb-2 mb-md-0">
                                        <a href="javascript:;" class="body-link text-truncate">
                                            @if($quiz_z->topic_type == 'chapter')
                                                {{Transcode::evaluate(\App\Chapters::find($quiz_z->topic_id))['name'] }}
                                            @else
                                                {{Transcode::evaluate(\App\Exam::find($quiz_z->topic_id))['name']}}
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-5 col-md-4 d-flex align-items-center text-medium justify-content-start justify-content-md-center text-muted">
                                        @if($quiz_z->score >= 75)
                                            <b style="color:darkgreen">{{__('User/quizHistory.success')}}</b>
                                        @else
                                            <b style="color:darkred">{{__('User/quizHistory.failed')}}</b>
                                        @endif
                                    </div>
                                    <div class="col-5 col-md-3 d-flex align-items-center justify-content-center text-muted">{{\Carbon\Carbon::parse($quiz_z->created_at)->diffForHumans()}}</div>
                                    <div class="col-2 col-md-2 d-flex align-items-center text-muted text-medium mb-1 mb-md-0 justify-content-end">
                                        <span class="badge bg-outline-primary py-1 px-3 text-small lh-1-5">{{round($quiz_z->score) }} %</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Exam Results End -->

            <!-- Materials Start -->
            <div class="col-lg-6 mb-5">
                <div class="d-flex justify-content-between">
                    <h2 class="small-title">Materials</h2>
                </div>
                <div class="scroll-out">
                    <div class="scroll-by-count" data-count="5">
                        @foreach($userCourses as $c)
                        <div class="card mb-2 sh-17 sh-sm-8">
                            <div class="card-body py-0">
                                <div class="row h-100 align-content-center">
                                    <div class="col-12 col-sm-auto mb-2 mb-sm-0 text-center text-sm-start">
                                        <i data-cs-icon="book-open" class="text-primary"></i>
                                    </div>
                                    <div class="col-12 col-sm mb-3 mb-sm-0 text-center text-sm-start">
                                        <div class="text-alternate">{{$c->title}}</div>
                                    </div>
                                    <div class="col-12 col-sm d-flex justify-content-center justify-content-sm-end align-items-center">
                                        <a href="{{ route('material.show', $c->id) }}" class="btn btn-outline-primary py-1 px-3 text-small lh-1-5 me-1">Open</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <!-- Materials End -->
        </div>



        <!-- Trending Courses Start -->
        <h2 class="small-title">Trending Courses</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-5 g-2">
            @foreach($packages_arr as $i)
            <div class="col">
                <div class="card h-100">
                    @if($i->popular)
                    <span class="badge rounded-pill bg-primary me-1 position-absolute e-3 t-3 z-index-1">POPULAR</span>
                    @endif
                    <img src="{{ url('storage/package/imgs/'.basename($i->img))}}" class="card-img-top sh-22" alt="card image" />
                    <div class="card-body">
                        <h5 class="heading mb-0"><a href="Course.Detail.html" class="body-link stretched-link">{{$i->name}}</a></h5>
                    </div>
                    <div class="card-footer border-0 pt-0">
                        <div class="mb-2">
                            <div class="br-wrapper br-theme-cs-icon d-inline-block">
                                <select class="rating" name="rating" autocomplete="off" data-readonly="true" data-initial-rating="{{$i->total_rating}}">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-text mb-0">
                            <div class="text-muted text-overline text-small">
                                <del>{{ round($i->pricing['localized_price'] - $i->pricing['localized_coupon_discount'], 2)}} {{$i->pricing['currency_code']}}</del>
                            </div>
                            <div>{{ round($i->pricing['localized_original_price'], 2) }} {{$i->pricing['currency_code']}}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <!-- Trending Courses End -->

        <!-- Content End -->
    </div>
@endsection

@section('jscode')
    <script>
        _initTimeChart();
        function _initTimeChart() {

            if (document.getElementById('timeChart')) {
                var ctx = document.getElementById('timeChart').getContext('2d');
                this._timeChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        datasets: [
                            {
                                label: '',
                                data: [{{ ($all_quizzes_number - $success_number) }}, {{$success_number}}],
                                backgroundColor: ['rgba(242, 58, 67,0.1)', 'rgba(79, 197, 240,0.1)'],
                                borderColor: ['rgba(242, 58, 67,1)', 'rgba(79, 197, 240,1)'],
                            },
                        ],
                        labels: ['Failure', 'Success'],
                        icons: ['graduation', 'graduation'],
                    },
                    options: {
                        plugins: {
                            datalabels: {display: false},
                        },
                        cutoutPercentage: 70,
                        responsive: true,
                        maintainAspectRatio: false,
                        title: {
                            display: false,
                        },
                        layout: {
                            padding: {
                                bottom: 20,
                            },
                        },
                        legend: {
                            position: 'bottom',
                            labels: ChartsExtend.LegendLabels(),
                        },
                        tooltips: {
                            enabled: false,
                            custom: function (tooltip) {
                                var tooltipEl = this._chart.canvas.parentElement.querySelector('.custom-tooltip');
                                if (tooltip.opacity === 0) {
                                    tooltipEl.style.opacity = 0;
                                    return;
                                }
                                tooltipEl.classList.remove('above', 'below', 'no-transform');
                                if (tooltip.yAlign) {
                                    tooltipEl.classList.add(tooltip.yAlign);
                                } else {
                                    tooltipEl.classList.add('no-transform');
                                }
                                if (tooltip.body) {
                                    var chart = this;
                                    var index = tooltip.dataPoints[0].index;
                                    var icon = tooltipEl.querySelector('.icon');
                                    icon.style = 'color: ' + tooltip.labelColors[0].borderColor;
                                    icon.setAttribute('data-cs-icon', chart._data.icons[index]);
                                    csicons.replace();
                                    var iconContainer = tooltipEl.querySelector('.icon-container');
                                    iconContainer.style = 'border-color: ' + tooltip.labelColors[0].borderColor + '!important';
                                    tooltipEl.querySelector('.text').innerHTML = chart._data.labels[index].toLocaleUpperCase();
                                    tooltipEl.querySelector('.value').innerHTML = chart._data.datasets[0].data[index];
                                }
                                var positionY = this._chart.canvas.offsetTop;
                                var positionX = this._chart.canvas.offsetLeft;
                                tooltipEl.style.opacity = 1;
                                tooltipEl.style.left = positionX + tooltip.caretX + 'px';
                                tooltipEl.style.top = positionY + tooltip.caretY + 'px';
                            },
                        },
                    },
                });
            }
        }
    </script>
@endsection
