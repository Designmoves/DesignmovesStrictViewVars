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

namespace DesignmovesStrictViewVarsTest\Listener;

use DesignmovesStrictViewVars\Listener\ViewModelListener;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;
use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\SharedEventManager;
use Zend\View\Model\ViewModel;
use Zend\View\ViewEvent;

/**
 * @coversDefaultClass DesignmovesStrictViewVars\Listener\ViewModelListener
 * @uses               DesignmovesStrictViewVars\Listener\ViewModelListener
 */
class ViewModelListenerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Event
     */
    protected $event;

    /**
     * @var ViewModelListener
     */
    protected $listener;

    public function setUp()
    {
        $this->event    = new ViewEvent();
        $this->listener = new ViewModelListener(true);
    }

    /**
     * @covers ::__construct
     */
    public function testUseStrictModeIsSetOnConstruct()
    {
        $this->assertTrue(self::readAttribute($this->listener, 'useStrictVars'));
    }

    /**
     * @covers ::attach
     */
    public function testAttachesSetStrictVarsListener()
    {
        $eventManager = new EventManager();
        $eventManager->setSharedManager(new SharedEventManager());
        $eventManager->attach($this->listener);

        $id               = 'Zend\View\View';
        $event            = ViewEvent::EVENT_RENDERER;
        $listeners        = $eventManager->getSharedManager()->getListeners($id, $event);
        $expectedCallback = array($this->listener, 'setStrictVars');
        $expectedPriority = 100;

        $found = false;
        foreach ($listeners as $listener) {
            $callback = $listener->getCallback();
            if ($callback === $expectedCallback) {
                if ($listener->getMetadatum('priority') == $expectedPriority) {
                    $found = true;
                    break;
                }
            }
        }

        $this->assertTrue($found, 'Listener not found');
    }

    /**
     * @covers ::setStrictVars
     */
    public function testSetStrictVarsConvertsArrayOfViewVariablesToViewVariablesObject()
    {
        $viewModel = new ViewModel(array());
        $this->event->setModel($viewModel);
        $this->listener->setStrictVars($this->event);

        $this->assertInstanceOf('Zend\View\Variables', $viewModel->getVariables());
    }

    /**
     * @covers ::getUseStrictVars
     */
    public function testCanGetUseStrictVars()
    {
        $method = new ReflectionMethod($this->listener, 'getUseStrictVars');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($this->listener));
    }
}
