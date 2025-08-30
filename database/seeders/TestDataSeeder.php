<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WorkSession;
use App\Models\Task;
use App\Models\WeeklyReport;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin System',
            'email' => 'admin@logbook.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'department' => 'IT',
            'position' => 'System Administrator',
            'employee_id' => 'ADM001',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Test Employees
        $employees = [
            [
                'name' => 'John Doe',
                'email' => 'john@logbook.test',
                'department' => 'Engineering',
                'position' => 'Senior Estimator',
                'employee_id' => 'EMP001',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@logbook.test',
                'department' => 'Design',
                'position' => 'Design Estimator',
                'employee_id' => 'EMP002',
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'bob@logbook.test',
                'department' => 'Engineering',
                'position' => 'Junior Estimator',
                'employee_id' => 'EMP003',
            ],
        ];

        foreach ($employees as $emp) {
            $user = User::create([
                'name' => $emp['name'],
                'email' => $emp['email'],
                'password' => Hash::make('password123'),
                'role' => 'estimator',
                'department' => $emp['department'],
                'position' => $emp['position'],
                'employee_id' => $emp['employee_id'],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            // Create Work Sessions for each employee
            for ($i = 0; $i < 5; $i++) {
                $startTime = Carbon::now()->subDays($i)->setTime(9, 0);
                $endTime = Carbon::now()->subDays($i)->setTime(17, 0);
                
                $session = WorkSession::create([
                    'user_id' => $user->id,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'status' => 'completed',
                    'notes' => 'Regular work day',
                ]);

                // Create Tasks for each session
                $taskTitles = [
                    'Review project specifications',
                    'Calculate material costs',
                    'Prepare estimation report',
                    'Client meeting preparation',
                    'Documentation update',
                ];

                foreach ($taskTitles as $index => $title) {
                    Task::create([
                        'user_id' => $user->id,
                        'work_session_id' => $session->id,
                        'title' => $title,
                        'description' => 'Task description for ' . $title,
                        'status' => $index < 3 ? 'completed' : ($index == 3 ? 'in_progress' : 'pending'),
                        'priority' => $index == 0 ? 'high' : ($index == 1 ? 'medium' : 'low'),
                        'due_date' => Carbon::now()->addDays($index + 1),
                    ]);
                }
            }

            // Create Weekly Reports
            for ($week = 0; $week < 3; $week++) {
                $weekStart = Carbon::now()->subWeeks($week)->startOfWeek();
                $weekEnd = Carbon::now()->subWeeks($week)->endOfWeek();
                
                WeeklyReport::create([
                    'user_id' => $user->id,
                    'week_start' => $weekStart,
                    'week_end' => $weekEnd,
                    'total_hours' => 40,
                    'tasks_completed' => 15,
                    'tasks_pending' => 5,
                    'productivity_score' => 75 + ($week * 5),
                    'notes' => 'Weekly report for ' . $weekStart->format('M Y'),
                ]);
            }
        }

        // Create one active session for testing
        WorkSession::create([
            'user_id' => $employees[0]['employee_id'] === 'EMP001' ? User::where('employee_id', 'EMP001')->first()->id : 2,
            'start_time' => Carbon::now()->setTime(9, 0),
            'end_time' => null,
            'status' => 'active',
            'notes' => 'Current active session',
        ]);

        $this->command->info('Test data seeded successfully!');
        $this->command->info('Admin: admin@logbook.test / password123');
        $this->command->info('Employee: john@logbook.test / password123');
    }
}
