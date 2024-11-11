<?php

namespace MediaWiki\Extension\NetworkLink\Tests;

use MediaWiki\Extension\NetworkLink\NetworkLink;
use Parser;
use PHPUnit\Framework\TestCase;
use PPFrame;

/**
 * @group NetworkLink
 * @covers \MediaWiki\Extension\NetworkLink\NetworkLink
 */
class NetworkLinkTest extends TestCase {

	/**
	 * @var Parser Mocked parser object
	 */
	private $parser;

	protected function setUp(): void {
		parent::setUp();

		// Mock the Parser class
		$this->parser = $this->createMock( Parser::class );
	}

	/**
	 * Test <link> tag with path and title attributes.
	 */
	public function testLinkTagWithPathAndTitle() {
		$output = NetworkLink::renderNetworkLink( 'Example Link',
												[ 'path' => 'https://example.com', 'title' => 'Example Site' ],
												$this->parser,
												$this->createMock( PPFrame::class ) );

		$expected = '<a href="https://example.com" target="_blank" title="Example Site">Example Site</a>';
		$this->assertEquals( $expected, $output );
	}

	/**
	 * Test <link> tag without any attributes.
	 */
	public function testLinkTagWithoutAttributes() {
		$output = NetworkLink::renderNetworkLink( 'https://example.com',
												[],
												$this->parser,
												$this->createMock( PPFrame::class ) );

		$expected = '<a href="https://example.com" target="_blank" title="https://example.com">https://example.com</a>';
		$this->assertEquals( $expected, $output );
	}
}
