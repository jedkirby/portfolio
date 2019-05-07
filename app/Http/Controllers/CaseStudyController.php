<?php

namespace App\Http\Controllers;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Domain;
use App\Domain\Study\Repository\StudyRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CaseStudyController extends AbstractController
{
    /**
     * @var Domain
     */
    protected $domain;

    /**
     * @var StudyRepository
     */
    private $studyRepository;

    /**
     * @param Domain $domain
     * @param StudyRepository $studyRepository
     */
    public function __construct(
        Domain $domain,
        StudyRepository $studyRepository
    ) {
        $this->domain = $domain;
        $this->studyRepository = $studyRepository;
    }

    /**
     * @codeCoverageIgnore
     *
     * @return RedirectResponse
     */
    public function all()
    {
        return redirect()->route('home');
    }

    /**
     * @param string $id
     *
     * @return View
     */
    public function single($id)
    {
        try {
            $study = $this->studyRepository->getById($id);
        } catch (EntityNotFoundException $e) {
            throw new NotFoundHttpException();
        }

        $this->domain->setTitle($study->getTitle());
        $this->domain->setKeywords($study->getKeywordsForMeta());
        $this->domain->setDescription($study->getIntro());

        return view(
            'pages.studies.study',
            $this->getViewParams(compact('study'))
        );
    }
}
