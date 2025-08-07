<?php

namespace App\Filament\Admin\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;

class EnrollmentChart extends ChartWidget
{
    protected static ?string $heading = 'Enrollment per Course';
    protected static ?int $sort = 1; // Posisi widget

    protected function getData(): array
    {
        // Query jumlah enrollment per course
        $data = Enrollment::select('courses.title', DB::raw('count(*) as total'))
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->groupBy('courses.title')
            ->pluck('total', 'title');

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Enroll',
                    'data' => $data->values(),
                ],
            ],
            'labels' => $data->keys(),
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Bisa diganti 'pie', 'line', dll
    }
}
