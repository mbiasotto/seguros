<?php

namespace App\Policies;

use App\Models\Establishment;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstablishmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the vendor can view the establishment.
     *
     * @param  \App\Models\Vendor  $vendor
     * @param  \App\Models\Establishment  $establishment
     * @return bool
     */
    public function view(Vendor $vendor, Establishment $establishment)
    {
        return $vendor->id === $establishment->vendor_id;
    }

    /**
     * Determine whether the vendor can update the establishment.
     *
     * @param  \App\Models\Vendor  $vendor
     * @param  \App\Models\Establishment  $establishment
     * @return bool
     */
    public function update(Vendor $vendor, Establishment $establishment)
    {
        return $vendor->id === $establishment->vendor_id;
    }

    /**
     * Determine whether the vendor can delete the establishment.
     *
     * @param  \App\Models\Vendor  $vendor
     * @param  \App\Models\Establishment  $establishment
     * @return bool
     */
    public function delete(Vendor $vendor, Establishment $establishment)
    {
        return $vendor->id === $establishment->vendor_id;
    }
}