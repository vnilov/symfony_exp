<?php
/**
 * User: vnilov
 * Date: 8/15/16
 */

namespace AppBundle\Tests\API;


use AppBundle\API\PhraseGenerator;

class PhraseGeneratorTest extends \PHPUnit_Framework_TestCase
{
    private $id = 1;
    private $generator;
    private $bad_id = 777;
    private $test_data = ['phrase'=>'ololo'];
    
    function setUp()
    {
        $this->generator = PhraseGenerator::i();
        $this->generator->entities = [
            ['phrase'=>"qwerty"],
            ['phrase'=>"test"],
            ['phrase'=>"oops"],
        ];
    }
    
    function testGet()
    {
        $res = $this->generator->get($this->id);
        $this->assertEquals(200, $res['code']);
        $this->assertEquals("test", $res['response'][$this->id]['phrase']);

        $res = $this->generator->get($this->bad_id);
        $this->assertEquals(404, $res['code']);
        
        $res = $this->generator->get();
        $this->assertEquals(500, $res['code']);
    }
    
    function testGetAll()
    {
        $res = $this->generator->getAll();
        $this->assertEquals(200, $res['code']);
        $this->assertEquals(3, count($res['response']));

        $this->generator->delete(0);
        $this->generator->delete(1);
        $this->generator->delete(2);

        $res = $this->generator->getAll();
        $this->assertEquals(404, $res['code']);
        
    }
    
    function testCreate() {
        $res = $this->generator->create($this->test_data['phrase']);
        $this->assertEquals(201, $res['code']);
        $this->assertCount(4, $this->generator->entities);

        $res = $this->generator->create('');
        $this->assertEquals(422, $res['code']);
    }
    
    function testUpdate() {
        $this->test_data['id'] = 1;
        $res = $this->generator->update($this->test_data);
        $this->assertEquals(202, $res['code']);
        $this->assertEquals($this->test_data['phrase'], $this->generator->entities[1]['phrase']);
        $this->assertTrue($res['response']);
        
        unset($this->test_data['id']);
        $res = $this->generator->update($this->test_data);
        $this->assertEquals(422, $res['code']);

        $this->test_data['id'] = $this->bad_id;
        $res = $this->generator->update($this->test_data);
        $this->assertEquals(404, $res['code']);
    }
    
    function testDelete()
    {
        $res = $this->generator->delete($this->id);
        $this->assertTrue($res['response']);
        $this->assertCount(2, $this->generator->entities);

        $res = $this->generator->delete($this->bad_id);
        $this->assertEquals(500, $res['code']);
    }
}
