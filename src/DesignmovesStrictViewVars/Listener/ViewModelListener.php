<?php
/**
 * Copyright (c) 2014 - 2015, Designmoves (http://www.designmoves.nl)
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * * Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 *
 * * Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * * Neither the name of Designmoves nor the names of its
 *   contributors may be used to endorse or promote products derived from
 *   this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 * FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 * DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace DesignmovesStrictViewVars\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Variables as ViewVariables;
use Zend\View\ViewEvent;

class ViewModelListener extends AbstractListenerAggregate
{
    /**
     * Whether to use strict vars
     *
     * @var bool
     */
    protected $useStrictVars;

    /**
     * @param bool $useStrictVars
     */
    public function __construct($useStrictVars)
    {
        $this->useStrictVars = $useStrictVars;
    }

    /**
     * @param EventManagerInterface $eventManager
     */
    public function attach(EventManagerInterface $eventManager)
    {
        $identifier = 'Zend\View\View';
        $event      = ViewEvent::EVENT_RENDERER;
        $callback   = array($this, 'setStrictVars');
        $priority   = 100;

        $eventManager->getSharedManager()->attach($identifier, $event, $callback, $priority);
    }

    /**
     * Set strict vars on ViewModel
     *
     * @param EventInterface $event
     */
    public function setStrictVars(EventInterface $event)
    {
        $viewModel = $event->getModel();

        /**
         * If $variables is not instance of ViewVariables,
         * convert it to ViewVariables and overwrite $viewModel variables
         */
        $variables = $viewModel->getVariables();
        if (!$variables instanceof ViewVariables) {
            $viewVariables = new ViewVariables($variables);
            $viewModel->setVariables($viewVariables, true);
        }

        $useStrictVars = $this->getUseStrictVars();
        $viewModel->getVariables()->setStrictVars($useStrictVars);
    }

    /**
     * @return bool
     */
    protected function getUseStrictVars()
    {
        return $this->useStrictVars;
    }
}
