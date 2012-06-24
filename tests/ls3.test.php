<?php

class Test_ls3 extends \PHPUnit_Framework_TestCase {

	var $s3;
	var $hash;

	protected function setUp() {
		\Bundle::start('ls3');
		$this->hash = sprintf( '%u', crc32( getmypid() ) );
		if( !( $this->s3 = new ls3\ls3() ) ) {
			$this->fail();
		}
	}

	public function test_connect() {
		$this->assertInternalType( 'array', $this->s3->listBuckets() );
	}

	public function test_bucket_create() {
		$this->assertTrue( $this->s3->putBucket( 'PHPUnitTest'.$this->hash, S3::ACL_PUBLIC_READ ) );
		$this->assertContains( 'PHPUnitTest'.$this->hash, $this->s3->listBuckets() );
	}

	public function test_object_create() {
		$this->assertTrue(
			$this->s3->putObject(
				'Laravel rocks!',
				'PHPUnitTest'.$this->hash,
				'PHPUnitTestFile'.$this->hash,
				S3::ACL_PUBLIC_READ
			)
		);
		$this->assertArrayHasKey(
			'PHPUnitTestFile'.$this->hash,
			$this->s3->getBucket( 'PHPUnitTest'.$this->hash )
		);
	}

	public function test_object_delete() {
		$this->assertTrue(
			$this->s3->deleteObject(
				'PHPUnitTest'.$this->hash,
				'PHPUnitTestFile'.$this->hash
			)
		);
		$this->assertCount( 0, $this->s3->getBucket( 'PHPUnitTest'.$this->hash ) );
	}

	public function test_bucket_delete() {
		$this->assertTrue( $this->s3->deleteBucket( 'PHPUnitTest'.$this->hash ) );
		$this->assertNotContains( 'PHPUnitTest'.$this->hash, $this->s3->listBuckets() );
	}

}
