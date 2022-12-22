<?php

namespace Scientist\Journals;

use Scientist\Report;
use Scientist\Experiment;

/**
 * Class Journal
 *
 * Journals allow the scientist to record experiment results in a
 * variety of different ways.
 *
 * @package \Scientist
 */
interface Journal
{
    /**
     * Dispatch a report to storage.
     *
     * @param Experiment $experiment
     * @param Report     $report
     *
     */
    public function report(Experiment $experiment, Report $report);
}
