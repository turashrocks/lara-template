<?php

namespace Botble\Gallery\Listeners;

use SiteMapManager;
use Botble\Gallery\Repositories\Interfaces\GalleryInterface;

class RenderingSiteMapListener
{
    /**
     * @var GalleryInterface
     */
    protected $galleryRepository;

    /**
     * RenderingSiteMapListener constructor.
     * @param GalleryInterface $galleryRepository
     */
    public function __construct(GalleryInterface $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    /**
     * Handle the event.
     *
     * @return void
     * @author Turash Chowdhury
     */
    public function handle()
    {
        SiteMapManager::add(route('public.galleries'), '2016-10-10 00:00', '0.8', 'weekly');

        $galleries = $this->galleryRepository->getDataSiteMap();

        foreach ($galleries as $gallery) {
            SiteMapManager::add(route('public.single', $gallery->slug), $gallery->updated_at, '0.8', 'daily');
        }
    }
}
