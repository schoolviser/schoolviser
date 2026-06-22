<?php

namespace Modules\Schoolviser\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Company;
use Modules\Schoolviser\Entities\Student;

use Modules\DelxeroMkt\Entities\HotspotUser;
use Modules\DelxeroMkt\Entities\HotspotAction;

class CreateStudentHotspotAccountJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Student $student;
    protected Company $company;
    protected $profile;


    /**
     * Create a new job instance.
     */
    public function __construct(Student $student, Company $company, $profile) {
        $this->student = $student;
        $this->company = $company;
        $this->profile = $profile;
    }

    /**
     * Execute the job.
     */
    public function handle(): void {
       
        $comment = $this->student->first_name.''.$this->student->last_name;

        $user = HotspotUser::create([
            'name' => $this->student->access_number,
            'password' => (string) random_int(100000, 999999),
            'comment' => $this->student->first_name.''.$this->student->last_name,
            'profile' => $this->profile,
            'phone' => $this->student->phone,
            'company_id' => $this->company->id
        ]);

        HotspotAction::create([
            'command' => "ip hotspot user add name={$user->name} password={$user->password} profile=\"{$this->profile}\" comment=\"{$comment}\"",
            'name' => 'add_user',
            'priority' => 'high',
            'company_id' => $this->company->id,
            'related_user_id' => $user->id
        ]);


    }
}
