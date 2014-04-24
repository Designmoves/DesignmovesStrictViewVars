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
 * * Neither the name of the {organization} nor the names of its
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

namespace DesignmovesStrictViewVarsTest\View\Renderer;

use DesignmovesStrictViewVars\View\Renderer\PhpRenderer;
use PHPUnit_Framework_TestCase;
use ReflectionMethod;

/**
 * @coversDefaultClass DesignmovesStrictViewVars\View\Renderer\PhpRenderer
 */
class PhpRendererTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var PhpRenderer
     */
    protected $renderer;

    /**
     * Mock object
     *
     * @var Zend\View\Variables
     */
    protected $viewVariablesMock;

    public function setUp()
    {
        $this->renderer           = new PhpRenderer(true);
        $this->viewVariablesMock  = $this->getMock('Zend\View\Variables');
        $this->renderer->setVars($this->viewVariablesMock);
    }

    public function testRendererExtendsZendPhpRenderer()
    {
        $this->assertInstanceOf('Zend\View\Renderer\PhpRenderer', $this->renderer);
    }

    /**
     * @covers ::__construct
     */
    public function testUseStrictVarsIsSetOnConstruct()
    {
        $renderer = new PhpRenderer(false);
        $this->assertFalse(self::readAttribute($renderer, 'useStrictVars'));

        $renderer = new PhpRenderer(true);
        $this->assertTrue(self::readAttribute($renderer, 'useStrictVars'));
    }

    /**
     * @covers ::__get
     */
    public function test__getSetsStrictVarsBeforeCallingParent__get()
    {
        $this->viewVariablesMock
             ->expects($this->atLeastOnce())
             ->method($this->equalTo('setStrictVars'))
             ->with($this->equalTo(true));

        $value = $this->renderer->__get('foo');
        $this->assertNull($value);
    }

    /**
     * @covers ::get
     */
    public function testGetSetsStrictVarsBeforeCallingParentGet()
    {
        $this->viewVariablesMock
             ->expects($this->atLeastOnce())
             ->method($this->equalTo('setStrictVars'))
             ->with($this->equalTo(true));

        $value = $this->renderer->get('foo');
        $this->assertNull($value);
    }

    /**
     * @covers ::vars
     */
    public function testVarsSetsStrictVarsBeforeCallingParentVars()
    {
        $this->viewVariablesMock
             ->expects($this->atLeastOnce())
             ->method($this->equalTo('setStrictVars'))
             ->with($this->equalTo(true));

        $value = $this->renderer->vars('foo');
        $this->assertNull($value);
    }

    /**
     * @covers ::getUseStrictVars
     */
    public function testCanGetUseStrictVars()
    {
        $method = new ReflectionMethod($this->renderer, 'getUseStrictVars');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($this->renderer));
    }
}
