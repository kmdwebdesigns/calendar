<?php

namespace spec\Carvefx\Calendar;

use Carbon\Carbon;
use Carvefx\Calendar\Day;
use PhpSpec\ObjectBehavior;

class DaySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Day::class);
    }

    public function let()
    {
        $this->beConstructedWith(2014, 7, 27);
    }

    public function it_forwards_property_gets_to_carbon()
    {
        $this->day->shouldBe(27);
    }

    public function it_forwards_method_calls_to_carbon()
    {
        $expected = Carbon::create(2014, 7, 27, 0)->toDateString();
        $this->toDateString()->shouldBe($expected);
    }

    public function it_defaults_to_a_normal_day()
    {
        $this->isBlankDay()->shouldReturn(false);
    }

    public function it_can_be_set_as_a_blank_day()
    {
        $this->setBlankDay(true);
        $this->isBlankDay()->shouldReturn(true);
    }

    public function it_throws_an_exception_when_attempting_to_set_blank_day_status_as_non_boolean()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringSetBlankDay('party like it\'s 1999');
        $this->shouldThrow('\InvalidArgumentException')->duringSetBlankDay(1999);
        $this->shouldThrow('\InvalidArgumentException')->duringSetBlankDay('1');
    }

    public function it_returns_true_if_today()
    {
        $today = Carbon::now();
        $this->beConstructedWith($today->year, $today->month, $today->day);
        $this->isToday()->shouldReturn(true);
    }

    public function it_does_not_return_the_carbon_object_when_applying_modifiers()
    {
        $this->addDays(3)->shouldReturnAnInstanceOf(Day::class);
        $this->toDateString()->shouldBe('2014-07-30');
    }
}
