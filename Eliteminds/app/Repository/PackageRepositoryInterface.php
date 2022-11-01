<?php


namespace App\Repository;


use Illuminate\Support\Collection;

interface PackageRepositoryInterface
{
    /**
     * Generate Full data about Popular Packages displayed in index page
     * - Full Package model, - Rating, - Course title, - Pricing details,
     * - number of users enrolled
     * @param string $country_code
     * @param string $lang
     * @return Collection
     */
    public function getPopularPackages(string $country_code, string $lang): Collection;

    /**
     * Return number of enrolled students in certain package
     * @param int $package_id
     * @return int
     */
    public function enrolledStudentCount(int $package_id): int;

    /**
     * return localized price details of a package
     * @param int $package_id
     * @return Collection
     */
    public function getPackagePriceDetails(int $package_id): Collection;
}
