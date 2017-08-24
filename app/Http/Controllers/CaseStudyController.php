<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class CaseStudyController extends AbstractController
{
    /**
     * @return View
     */
    public function all()
    {
        dd(__METHOD__);
    }

    /**
     * @param string $id
     *
     * @return View
     */
    public function single($id)
    {
        dd(__METHOD__, $id);
    }
}
