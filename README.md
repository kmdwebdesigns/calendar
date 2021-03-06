[![Code Climate](https://codeclimate.com/github/kmdwebdesigns/calendar.png)](https://codeclimate.com/github/kmdwebdesigns/calendar)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/004f9246-a92c-479a-a0e0-4564fe43eaa5/mini.png)](https://insight.sensiolabs.com/projects/004f9246-a92c-479a-a0e0-4564fe43eaa5)

# Calendar

Calendar Library written in PHP

## Requirements

Calendar requires PHP 7.2+ and [Carbon v2](https://github.com/briannesbitt/carbon).

## Installation

Add the following above the `require` block in your `composer.json`:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/kmdwebdesigns/calendar"
    }
],
```

Then run the following in your terminal:

```bash
composer require "carvefx/calendar:^3.0"
```

Or, add `"carvefx/calendar": "^3.0"` to your `composer.json` and then run `composer update` in your terminal.

## Usage

```php
use Calendar\Calendar;

$calendar = new Calendar(2014, 8);

foreach($calendar->getWeeks() as $week) {
    foreach($week->getDays() as $day) {
        $day->toDateString(); // 2014-07-27
        $day->isBlankDay(); // true
    }
}
```

## Documentation

_Calendar_ comes with 3 main classes:

* `\Calendar\Calendar`: represents a display of the current month, *including* the blank days that belong to the previous or next months
* `\Calendar\Week`: represents 7 days, regardless of the month it belongs to
* `\Calendar\Day`: represents a single day and wraps around the \Carbon\Carbon class

By default, the calendar will start on Monday. You can set which day of the week your calendar starts on by using the `setWeekStart` method:

```php
$calendar = new Calendar(2014, 8);
$calendar->setWeekStart(CarbonInterface:SUNDAY); // First day of the week is now Sunday
```

Also by default, the calendar will display 6 weeks no matter how many weeks the actual month needs. This can be configured with the `setVariableWeeks` method:

```php
$calendar = new Calendar(2017, 8);
$calendar->setVariableWeeks(true);

$calendar->getWeeks(); // returns 5 weeks, instead of the normal 6, because the last week contains all blank days
```

### `Calendar` API

```php
// Create a new Calendar object
$calendar = new Calendar(2014, 8);
// Or create a new Calendar object with a specific timezone
$calendar = new Calendar(2014, 8, 'America/Chicago');
$calendar = new Calendar(2014, 8, new DateTimeZone('America/Chicago'));

$calendar->setYear(2015);
$calendar->setMonth(7);
$calendar->setTimezone($timezone); // where $timezone is either a bare timezone string, or a DateTimeZone object
$calendar->getTimezone(); // returns the currently set timezone of the calendar as a DateTimeZone object
$calendar->setWeekStart(CarbonInterface::SUNDAY); // or you may use the zero-indexed day integer
$calendar->getWeekStart(); // returns the current start of the week zero-indexed day integer
$calendar->getFirstDay(); // returns the first day of the month
$calendar->getLastDay(); // returns the last day of the month
$calendar->getWeeks() // returns an array of Week objects
```

#### :warning: Note! :warning:
Setting the timezone *may* have unintended consequences. Daylight Savings Time may cause duplicate days. To try and work around this, the `hour` component of the day has been set to `5` since it seems to be after most countries have finished changing. If this causes problems, please open an [issue](https://github.com/kmdwebdesigns/calendar/issues).

### `Week` API

```php
$first_day = new Day(2014, 07, 01);
$week = new Week($first_day, int $currentMonth = null, int $weekStart = CarbonInterface::MONDAY); // constructor requires the day the week starts at
$week->getDays(); // returns an array containing 7 Day objects
```

### `Day` API

```php
$day = new Day(2014, 07, 01);
$day->setBlankDay(false);
$day->isBlankDay(); // returns a bool value, shows whether the current day is part of the current month

// Any of the \Carbon\Carbon methods work
$day->getDateString(); // 2014-07-01
$day->month; // 7
```
