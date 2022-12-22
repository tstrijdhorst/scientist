<?php

namespace Scientist\Journals;

use Scientist\Report;
use Scientist\Experiment;

/**
 * Class StandardJournal
 *
 * @package \Scientist\Journals
 */
class StandardJournal implements Journal
{
    /**
     * The executed experiment.
     *
     * @var Experiment
     */
    protected $experiment;

    /**
     * The experiment report.
     *
     * @var Report
     */
    protected $report;

    /**
     * Dispatch a report to storage.
     *
     * @param Experiment $experiment
     * @param Report     $report
     */
    public function report(Experiment $experiment, Report $report)
    {
        $this->experiment = $experiment;
        $this->report     = $report;
    }

    /**
     * Get the experiment.
     *
     * @return Experiment
     */
    public function getExperiment()
    {
        return $this->experiment;
    }

    /**
     * Get the experiment report.
     *
     * @return Report
     */
    public function getReport()
    {
        return $this->report;
    }
}
