<?php

namespace App\Repositories\Options;

use App\Models\Option;
use App\Repositories\BaseRepository;

class OptionRepository extends BaseRepository implements OptionRepositoryInterface
{
    public function getModel()
    {
        return Option::class;
    }

    public function getBanners()
    {
        return $this->getOptionValue('banners');
    }

    public function getNavMenu()
    {
        return $this->getOptionValue('nav_menu');
    }

    public function getSale()
    {
        return [];
    }

    public function getHomeCollection()
    {
        return [];
    }

    public function getTrendingKeywords()
    {
        return [];
    }

    protected function getOptionValue($name)
    {
        return unserialize($this->model->where('name', $name)->first()->value);
    }
}
