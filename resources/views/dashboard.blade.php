@extends('layouts.pages.master')

@section('title', 'Dashboard')

@section('content')
<!-- HEADER -->
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
            <i class="fa fa-refresh"></i>
        </span> 
    </span>
    <ol class="breadcrumb">
        <li>Home</li>
    </ol>
</div>
<!-- END HEADER -->			

<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark">
                <i class="fa-fw fa fa-home"></i> 
                    Home
                <span>>  
                    Dashboard
                </span>
            </h1>
        </div>
    </div>
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="jarviswidget" id="wid-id-6"
                data-widget-colorbutton="false"
                data-widget-fullscreenbutton="false"
                data-widget-editbutton="false"
                data-widget-sortable="false">
                    <header>
                        <h2>Stok Product</h2>
                    </header>
                    <div>
                        <div class="jarviswidget-editbox">
                            <input class="form-control" type="text">	
                        </div>
                        <div class="widget-body">
                            <canvas id="pieChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>
</div>
<!-- END CONTENT -->
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        // Pie Chart
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - types of animation
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - Re-draw chart on page resize
            responsive: true,
            //String - A legend template
            legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };

        var pieData = [
            {
                value: 300,
                color:"rgba(220,220,220,0.9)",
                highlight: "rgba(220,220,220,0.8)",
                label: "Grey"
            },
            {
                value: 50,
                color: "rgba(151,187,205,1)",
                highlight: "rgba(151,187,205,0.8)",
                label: "Blue"
            },
            {
                value: 100,
                color: "rgba(169, 3, 41, 0.7)",
                highlight: "rgba(169, 3, 41, 0.7)",
                label: "Red"
            }
        ];

        // render chart
        var ctx = document.getElementById("pieChart").getContext("2d");
        var myNewChart = new Chart(ctx).Pie(pieData, pieOptions);
        
    });
</script>
@endpush