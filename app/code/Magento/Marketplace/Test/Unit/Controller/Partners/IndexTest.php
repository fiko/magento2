<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Marketplace\Test\Unit\Controller\Partners;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Magento\Marketplace\Controller\Adminhtml\Partners\Index;
use Magento\Framework\View\LayoutFactory;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\HTTP\PhpEnvironment\Response;
use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Element\BlockInterface;

class IndexTest extends TestCase
{
    /**
     * @var MockObject|Index
     */
    private $partnersControllerMock;

    protected function setUp(): void
    {
        $this->partnersControllerMock = $this->getControllerIndexMock(
            [
                'getRequest',
                'getResponse',
                'getLayoutFactory'
            ]
        );
    }

    /**
     * @covers \Magento\Marketplace\Controller\Adminhtml\Partners\Index::execute
     */
    public function testExecute()
    {
        $requestMock = $this->getRequestMock(['isAjax']);
        $requestMock->expects($this->once())
            ->method('isAjax')
            ->will($this->returnValue(true));

        $this->partnersControllerMock->expects($this->once())
            ->method('getRequest')
            ->will($this->returnValue($requestMock));

        $layoutMock = $this->getLayoutMock();
        $blockMock = $this->getBlockInterfaceMock();
        $blockMock->expects($this->once())
            ->method('toHtml')
            ->will($this->returnValue(''));

        $layoutMock->expects($this->once())
            ->method('createBlock')
            ->will($this->returnValue($blockMock));

        $layoutMockFactory = $this->getLayoutFactoryMock(['create']);
        $layoutMockFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($layoutMock));

        $this->partnersControllerMock->expects($this->once())
            ->method('getLayoutFactory')
            ->will($this->returnValue($layoutMockFactory));

        $responseMock = $this->getResponseMock(['appendBody']);
        $responseMock->expects($this->once())
            ->method('appendBody')
            ->will($this->returnValue(''));
        $this->partnersControllerMock->expects($this->once())
            ->method('getResponse')
            ->will($this->returnValue($responseMock));

        $this->partnersControllerMock->execute();
    }

    /**
     * Gets partners controller mock
     *
     * @return MockObject|Index
     */
    public function getControllerIndexMock($methods = null)
    {
        return $this->createPartialMock(Index::class, $methods);
    }

    /**
     * @return MockObject|LayoutFactory
     */
    public function getLayoutFactoryMock($methods = null)
    {
        return $this->createPartialMock(LayoutFactory::class, $methods, []);
    }

    /**
     * @return MockObject|LayoutInterface
     */
    public function getLayoutMock()
    {
        return $this->getMockForAbstractClass(LayoutInterface::class);
    }

    /**
     * @return MockObject|Response
     */
    public function getResponseMock($methods = null)
    {
        return $this->createPartialMock(Response::class, $methods, []);
    }

    /**
     * @return MockObject|Http
     */
    public function getRequestMock($methods = null)
    {
        return $this->createPartialMock(Http::class, $methods, []);
    }

    /**
     * @return MockObject|BlockInterface
     */
    public function getBlockInterfaceMock()
    {
        return $this->getMockForAbstractClass(BlockInterface::class);
    }
}
