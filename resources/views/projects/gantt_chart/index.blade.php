@push('title', get_phrase('Gantt Chart'))
@php
    $tasks = App\Models\Task::get();
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

    // Define columns for the Gantt chart
    data.addColumn('string', 'Task ID');
    data.addColumn('string', 'Task Name');
    data.addColumn('string', 'Resource');
    data.addColumn('date', 'Start Date');
    data.addColumn('date', 'End Date');
    data.addColumn('number', 'Duration');
    data.addColumn('number', 'Percent Complete');
    data.addColumn('string', 'Dependencies');
    data.addColumn({ type: 'string', role: 'tooltip', p: { html: true } }); // Tooltip column with HTML support

    // Add rows dynamically
    data.addRows([
        @foreach ($tasks as $task)
            [
                'Task{{ $task->id }}',
                '{{ addslashes($task->title) }}',
                null,
                new Date(
                    {{ (int) date('Y', $task->start_date) }},
                    {{ (int) date('m', $task->start_date) - 1 }}, // Month is 0-indexed
                    {{ (int) date('d', $task->start_date) }}
                ),
                new Date(
                    {{ (int) date('Y', $task->end_date) }},
                    {{ (int) date('m', $task->end_date) - 1 }},
                    {{ (int) date('d', $task->end_date) }}
                ),
                null,
                {{ $task->percent_complete ?? 0 }},
                null,
                `<div style="padding: 10px; text-align: center;">
                    <img src="{{ $task->image_url }}" alt="Staff" style="width: 50px; height: 50px; border-radius: 50%;"><br>
                    <strong>{{ addslashes($task->staff_name) }}</strong>
                </div>`
            ]
            @if (!$loop->last)
                ,
            @endif
        @endforeach
    ]);

    // Chart options
    var options = {
        height: 500,
        backgroundColor: '#f0f4f8',
        gantt: {
            trackHeight: 40,
            barHeight: 30,
            palette: [
                {
                    color: '#42a5f5', // Light blue for task bars
                    dark: '#1e88e5', // Dark blue for critical paths
                    light: '#bbdefb' // Lighter blue for non-critical tasks
                },
                {
                    color: '#ef5350', // Red for another task group
                    dark: '#e53935',
                    light: '#ffcdd2'
                }
            ],
            criticalPathEnabled: true,
            criticalPathStyle: {
                stroke: '#ff7043',
                strokeWidth: 6
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
        },
        tooltip: {
            isHtml: true // Enable HTML tooltips
        }
    };

    // Draw the chart
    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
    chart.draw(data, options);
}

    </script>
    
@endpush
