<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Admission;
use App\Models\Bill;
use App\Models\Occupancy;
use App\Models\Patient;
use App\Models\Pet;
use App\Policies\AdmissionPolicy;
use App\Policies\BillPolicy;
use App\Policies\OccupancyPolicy;
use App\Policies\PatientPolicy;
use App\Policies\PetPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Bill::class => BillPolicy::class,
        Admission::class => AdmissionPolicy::class,
        Patient::class => PatientPolicy::class,
        Pet::class => PetPolicy::class,
        Occupancy::class => OccupancyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
