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

namespace DesignmovesStrictViewVarsTest\Factory\View\Renderer;

use DesignmovesStrictViewVars\Factory\View\Renderer\PhpRendererFactory;
use DesignmovesStrictViewVars\Options\ModuleOptions;
use PHPUnit_Framework_TestCase;
use Zend\ServiceManager\ServiceManager;
use Zend\View\HelperPluginManager;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplatePathStack;

/**
 * @coversDefaultClass DesignmovesStrictViewVars\Factory\View\Renderer\PhpRendererFactory
 * @uses               DesignmovesStrictViewVars\Options\ModuleOptions
 * @uses               DesignmovesStrictViewVars\View\Renderer\PhpRenderer
 */
class PhpRendererFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PhpRendererFactory
     */
    protected $factory;

    /**
     * @var HelperPluginManager
     */
    protected $helperPluginManager;

    /**
     * @var TemplatePathStack
     */
    protected $resolver;

    /**
     * @var ServiceManager
     */
    protected $serviceManager;

    public function setUp()
    {
        $this->factory        = new PhpRendererFactory();
        $this->serviceManager = new ServiceManager();

        $this->resolver            = new TemplatePathStack();
        $this->helperPluginManager = new HelperPluginManager();

        $renderer = new PhpRenderer();
        $renderer->setResolver($this->resolver);
        $this->helperPluginManager->setRenderer($renderer);

        $this->serviceManager->setService('ViewHelperManager', $this->helperPluginManager);
        $this->serviceManager->setService('DesignmovesStrictViewVars\Options\ModuleOptions', new ModuleOptions());
    }

    /**
     * @covers ::createService
     */
    public function testCanCreateService()
    {
        $renderer = $this->factory->createService($this->serviceManager);

        $this->assertInstanceOf('DesignmovesStrictViewVars\View\Renderer\PhpRenderer', $renderer);
        $this->assertSame($this->resolver, $renderer->resolver());
        $this->assertSame($this->helperPluginManager, $renderer->getHelperPluginManager());
    }
}
