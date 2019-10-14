<?php

namespace Test\Traits\Model\Revision\get_user_contribution;

class Test extends \PHPUnit\Framework\TestCase
{
    public function test__TwoInsertionAndOneDeletion()
    {
        $revision = new \Model\Revision();
        $revision->opcodes = "c73d22i65:[агиографии](Что такое агиография?), c1178i187:Труды Аббона по логике не удостоились славы, но заложили прочный фундамент для будущий исследований.\n\nc37";

        $this->assertEquals("c73d22i65:[агиографии](Что такое агиография?), c1178i187:Труды Аббона по логике не удостоились славы, но заложили прочный фундамент для будущий исследований.\n\nc37", $revision->opcodes);
        $this->assertEquals(274, $revision->get_user_contribution());
    }

    public function test__OneInsertionAndOneDeletion()
    {
        $revision = new \Model\Revision();
        $revision->opcodes = "c1180d23i166:монастырям. Именно так, в настоящее время, аббатства показываются в современной культуре.\n\nc33";

        $this->assertEquals("c1180d23i166:монастырям. Именно так, в настоящее время, аббатства показываются в современной культуре.\n\nc33", $revision->opcodes);
        $this->assertEquals(189, $revision->get_user_contribution());
    }

    public function test__EmptyOpcodes()
    {
        $revision = new \Model\Revision();
        $revision->opcodes = '';

        $this->assertEquals('', $revision->opcodes);
        $this->assertEquals(0, $revision->get_user_contribution());
    }

    public function test__OpcodesNotSet()
    {
        $revision = new \Model\Revision();

        $this->assertEquals('', $revision->opcodes);
        $this->assertEquals(0, $revision->get_user_contribution());
    }
}
