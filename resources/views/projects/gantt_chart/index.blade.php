@push('title', get_phrase('Gantt Chart'))
@php
    $tasks = DB::table('project_tasks')->get();
@endphp

<div id="chart_div"></div>

@push('js')
    <script type="text/javascript">
        "use strict";
        google.charts.load('current', {
            'packages': ['gantt']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Task ID');
            data.addColumn('string', 'Task Name');
            data.addColumn('string', 'Resource');
            data.addColumn('date', 'Start Date');
            data.addColumn('date', 'End Date');
            data.addColumn('number', 'Duration');
            data.addColumn('number', 'Percent Complete');
            data.addColumn('string', 'Dependencies');

            data.addRows([
                @foreach ($tasks as $task)
                    [
                        'Task{{ $task->id }}',
                        '{{ $task->title }}',
                        null,
                        new Date({{ date('Y', $task->start_date) }},
                            {{ date('m', $task->start_date) - 1 }},
                            {{ date('d', $task->start_date) }}),
                        new Date({{ date('Y', $task->end_date) }},
                            {{ date('m', $task->end_date) - 1 }},
                            {{ date('d', $task->end_date) }}),
                        null,
                        0,
                        null
                    ]
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            ]);

            var options = {
                height: 500,
                gantt: {
                    palette: [{
                            "color": "#42a5f5", // Light blue for task bars
                            "dark": "#1e88e5", // Dark blue for critical paths
                            "light": "#bbdefb" // Lighter blue for non-critical tasks
                        },
                        {
                            "color": "#ef5350", // Red for another task group
                            "dark": "#e53935",
                            "light": "#ffcdd2"
                        }
                    ],
                    trackHeight: 40,
                    barHeight: 30,
                    criticalPathEnabled: true,
                    criticalPathStyle: {
                        stroke: '#ff7043',
                        strokeWidth: 6 //
                    },
                    arrow: {
                        angle: 45,
                        width: 2,
                        color: '#ff5722',
                        radius: 0
                    },
                    labelStyle: {
                        fontName: 'Arial',
                        fontSize: 13,
                        color: '#333'
                    }
                },
                backgroundColor: '#f0f4f8',
                hAxis: {
                    textStyle: {
                        color: '#333',
                        fontName: 'Arial',
                        fontSize: 12
                    }
                },
                vAxis: {
                    textStyle: {
                        color: '#333',
                        fontName: 'Arial',
                        fontSize: 12
                    }
                }
            };

            var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
@endpush
