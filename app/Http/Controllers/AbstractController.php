<?php

namespace App\Http\Controllers;

use App\Domain\Domain;
use Illuminate\Routing\Controller;

abstract class AbstractController extends Controller
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @param Domain $domain
     */
    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    /**
     * @return array
     */
    public function getDefaultViewParams()
    {
        return [
            'title' => $this->domain->getTitle(),
            'description' => $this->domain->getDescription(),
            'keywords' => $this->domain->getKeywords(),
            'author' => $this->domain->getAuthor(),
        ];
    }

    /**
     * @param array $params
     *
     * @return array
     */
    public function getViewParams(array $params = [])
    {
        return array_merge(
            $this->getDefaultViewParams(),
            $params
        );
    }
}
