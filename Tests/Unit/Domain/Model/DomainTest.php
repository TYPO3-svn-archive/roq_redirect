<?php

namespace ROQUIN\RoqRedirect\Tests;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Test case for class \ROQUIN\RoqRedirect\Domain\Model\Domain.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Redirect
 *
 */
class DomainTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase {
	/**
	 * @var \ROQUIN\RoqRedirect\Domain\Model\Domain
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new \ROQUIN\RoqRedirect\Domain\Model\Domain();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getRedirectsReturnsInitialValueForRedirect() { 
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->fixture->getRedirects()
		);
	}

	/**
	 * @test
	 */
	public function setRedirectsForObjectStorageContainingRedirectSetsRedirects() { 
		$redirect = new \ROQUIN\RoqRedirect\Domain\Model\Redirect();
		$objectStorageHoldingExactlyOneRedirects = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneRedirects->attach($redirect);
		$this->fixture->setRedirects($objectStorageHoldingExactlyOneRedirects);

		$this->assertSame(
			$objectStorageHoldingExactlyOneRedirects,
			$this->fixture->getRedirects()
		);
	}
	
	/**
	 * @test
	 */
	public function addRedirectToObjectStorageHoldingRedirects() {
		$redirect = new \ROQUIN\RoqRedirect\Domain\Model\Redirect();
		$objectStorageHoldingExactlyOneRedirect = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$objectStorageHoldingExactlyOneRedirect->attach($redirect);
		$this->fixture->addRedirect($redirect);

		$this->assertEquals(
			$objectStorageHoldingExactlyOneRedirect,
			$this->fixture->getRedirects()
		);
	}

	/**
	 * @test
	 */
	public function removeRedirectFromObjectStorageHoldingRedirects() {
		$redirect = new \ROQUIN\RoqRedirect\Domain\Model\Redirect();
		$localObjectStorage = new \TYPO3\CMS\Extbase\Persistence\Generic\ObjectStorage();
		$localObjectStorage->attach($redirect);
		$localObjectStorage->detach($redirect);
		$this->fixture->addRedirect($redirect);
		$this->fixture->removeRedirect($redirect);

		$this->assertEquals(
			$localObjectStorage,
			$this->fixture->getRedirects()
		);
	}
	
}
?>