<?php

namespace App\Repositories\Options;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface OptionRepositoryInterface extends RepositoryInterface
{
    /**
     * @return array | Collection
     */
    public function getBanners();

    /**
     * @return array | Collection
     */
    public function getNavMenu();

    /**
     * @return array | Collection
     */
    public function getSale();

    /**
     * @return array | Collection
     */
    public function getHomeCollection();

    /**
     * @return array | Collection
     */
    public function getTrendingKeywords();
}
