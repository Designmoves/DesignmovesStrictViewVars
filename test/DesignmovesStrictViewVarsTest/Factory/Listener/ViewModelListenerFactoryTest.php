<?php
/**
 * Copyright (c) 2014, Designmoves http://www.designmoves.nl
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

namespace DesignmovesStrictViewVarsTest\Factory\Listener;

use DesignmovesStrictViewVars\Factory\Listener\ViewModelListenerFactory;
use DesignmovesStrictViewVars\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;

/**
 * @coversDefaultClass DesignmovesStrictViewVars\Factory\Listener\ViewModelListenerFactory
 * @uses               DesignmovesStrictViewVars\Listener\ViewModelListener
 * @uses               DesignmovesStrictViewVars\Options\ModuleOptions
 */
class ViewModelListenerFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var ViewModelListenerFactory
     */
    protected $factory;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $this->factory        = new ViewModelListenerFactory;
        $this->serviceManager = new ServiceManager;
    }

    /**
     * @covers ::createService
     */
    public function testCanCreateService()
    {
        $this->serviceManager->setService('DesignmovesStrictViewVars\Options\ModuleOptions', new ModuleOptions);
        $listener = $this->factory->createService($this->serviceManager);

        $this->assertInstanceOf('DesignmovesStrictViewVars\Listener\ViewModelListener', $listener);
    }
}
