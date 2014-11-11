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

namespace DesignmovesStrictViewVarsTest\Initializer;

use DesignmovesStrictViewVars\Initializer\ViewHelperInitializer;
use DesignmovesStrictViewVars\View\Renderer\PhpRenderer;
use PHPUnit_Framework_TestCase;
use stdClass;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\ViewModel as ViewModelHelper;
use Zend\View\HelperPluginManager;

/**
 * @coversDefaultClass DesignmovesStrictViewVars\Initializer\ViewHelperInitializer
 * @uses               DesignmovesStrictViewVars\View\Renderer\PhpRenderer
 */
class ViewHelperInitializerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var HelperPluginManager
     */
    protected $helperPluginManager;

    /**
     * @var ViewHelperInitializer
     */
    protected $initializer;

    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $this->initializer = new ViewHelperInitializer();

        $this->serviceManager      = new ServiceManager();
        $this->helperPluginManager = new HelperPluginManager();
        $this->helperPluginManager->setServiceLocator($this->serviceManager);

        $this->renderer = new PhpRenderer(true);
        $this->serviceManager->setService('DesignmovesStrictViewVars\View\Renderer\PhpRenderer', $this->renderer);
    }

    /**
     * @covers ::initialize
     */
    public function testInitializeReturnsEarlyWhenNotInstanceOfAbstractHelper()
    {
        $instance    = new stdClass();
        $returnValue = $this->initializer->initialize($instance, $this->helperPluginManager);

        $this->assertNull($returnValue);
    }

    /**
     * @covers ::initialize
     */
    public function testInitializeInjectsCustomRenderer()
    {
        $helper = new ViewModelHelper();
        $this->initializer->initialize($helper, $this->helperPluginManager);

        $this->assertSame($this->renderer, $helper->getView());
    }
}
