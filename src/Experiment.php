<?php

namespace Scientist;

use Scientist\Chances\Chance;
use Scientist\Chances\StandardChance;
use Scientist\Matchers\Matcher;
use Scientist\Matchers\StandardMatcher;

/**
 * Class Experiment
 *
 * An experiment allows us to implement our code in a new way without
 * risking the introduction of bugs or regressions.
 *
 * @package Scientist
 */
class Experiment
{
    /**
     * Experiment name.
     *
     * @var string
     */
    protected $name;

    /**
     * The control callback.
     *
     * @var callable
     */
    protected $control;

    /**
     * Context for the control.
     *
     * @var mixed
     */
    protected $controlContext;

    /**
     * Trial callbacks.
     *
     * @var array
     */
    protected $trials = [];

    /**
     * Parameters for our callbacks.
     *
     * @var array
     */
    protected $params = [];

    /**
     * Laboratory instance.
     *
     * @var Laboratory
     */
    protected $laboratory;

    /**
     * Matcher for experiment values.
     *
     * @var Matcher
     */
    protected $matcher;

    /**
     * Execution chance.
     *
     * @var Chance
     */
    protected $chance;

    /**
     * Create a new experiment.
     *
     * @param string     $name
     * @param Laboratory $laboratory
     */
    public function __construct($name, Laboratory $laboratory)
    {
        $this->name = $name;
        $this->laboratory = $laboratory;
        $this->matcher = new StandardMatcher;
        $this->chance = new StandardChance;
    }

    /**
     * Fetch the experiment name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Retrieve the laboratory instance.
     *
     * @return Laboratory|null
     */
    public function getLaboratory()
    {
        return $this->laboratory;
    }

    /**
     * Register a control callback.
     *
     * @param callable $callback
     * @param mixed $context
     *
     * @return $this
     */
    public function control(callable $callback, $context = null)
    {
        $this->control = $callback;
        $this->controlContext = $context;

        return $this;
    }

    /**
     * Fetch the control callback.
     *
     * @return callable
     */
    public function getControl()
    {
        return $this->control;
    }

    public function getControlContext()
    {
        return $this->controlContext;
    }
	
	/**
	 * Register a trial callback.
	 *
	 * @param string   $name
	 * @param callable $callback
	 * @param null     $context
	 * @return Experiment
	 */
    public function trial($name, callable $callback, $context = null)
    {
        $this->trials[$name] = new Trial($name, $callback, $context);

        return $this;
    }

    /**
     * Fetch a trial callback by name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getTrial($name)
    {
        return $this->trials[$name]->getCallback();
    }

    /**
     * Fetch an array of trial callbacks.
     *
     * @return array
     */
    public function getTrials()
    {
        return $this->trials;
    }

    /**
     * Set a matcher for this experiment.
     *
     * @param Matcher $matcher
     *
     * @return $this
     */
    public function matcher(Matcher $matcher)
    {
        $this->matcher = $matcher;

        return $this;
    }

    /**
     * Get the matcher for this experiment.
     *
     * @return Matcher
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * Set the execution chance.
     *
     * @param Chances\Chance $chance
     *
     * @return $this
     */
    public function chance(Chance $chance)
    {
        $this->chance = $chance;

        return $this;
    }

    /**
     * Get the execution chance.
     *
     * @return Chances\Chance
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * Determine whether an experiment should run based on chance.
     *
     * @return boolean
     */
    public function shouldRun()
    {
        return $this->chance
            ->shouldRun();
    }

    /**
     * Get the experiment parameters.
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Execute the experiment within the laboratory.
     *
     * @return mixed
     */
    public function run()
    {
        $this->params = func_get_args();

        return $this->laboratory->runExperiment($this);
    }

    /**
     * Execute the experiment and return a report.
     *
     * @return Report
     */
    public function report()
    {
        $this->params = func_get_args();

        return $this->laboratory->getReport($this);
    }
}
