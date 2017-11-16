<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HelpersTest extends TestCase
{
    /**
     * Slugify test without randomly generated string.
     *
     * @return void
     */
    public function testSlugify()
    {
        $str = 'My custom String';
        $sluggified = slugify($str);
        $expected = 'my-custom-string';
        $this->assertEquals($expected, $sluggified);
    }

    /**
     * Slugify test with randomly generated string.
     *
     * @return void
     */
    public function testSlugifyWithRandom()
    {
        $str = 'My custom String';
        $sluggified = slugify($str, 5);
        
        $exploded = explode('-', $sluggified);
        $randomString = array_pop($exploded);
        $generatedString = join('-', $exploded);
        $expected = 'my-custom-string';

        $this->assertEquals($expected, $generatedString);
        $this->assertEquals(5, strlen($randomString));
    }
}
